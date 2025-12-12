<?php
// src/controllers/AuthController.php

namespace src\controllers;

use src\models\Usuario;
use src\utils\Utils;
use src\utils\Validator;
use src\utils\Mailer;
use src\integrations\GoogleAuth;
use src\middleware\AuthMiddleware;

class AuthController extends BaseController
{
    /**
     * Muestra el formulario de login.
     */
    public function login(): void
    {
        // Si ya está autenticado, redirigir al home
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        $data = [
            'googleAuthUrl' => GoogleAuth::getAuthUrl(),
            'error' => $_SESSION['login_error'] ?? null
        ];

        // Limpiar mensaje de error después de mostrarlo
        unset($_SESSION['login_error']);

        $this->render('views/auth/login', $data);
    }

    /**
     * Procesa el login tradicional (POST).
     */
    public function loginPost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /auth/login');
            exit;
        }

        // Validar datos
        $validator = new Validator($_POST);
        $validator->required(['email', 'password'])
                  ->email('email');

        if ($validator->fails()) {
            $_SESSION['login_error'] = $validator->firstError();
            header('Location: /auth/login');
            exit;
        }

        $email = Utils::sanitizeString($_POST['email']);
        $password = $_POST['password'];

        // Buscar usuario por email
        $usuario = Usuario::findByEmail($email);

        if (!$usuario || !$usuario->password) {
            $_SESSION['login_error'] = 'Credenciales incorrectas.';
            header('Location: /auth/login');
            exit;
        }

        // Verificar contraseña
        if (!Utils::verifyPassword($password, $usuario->password)) {
            $_SESSION['login_error'] = 'Credenciales incorrectas.';
            header('Location: /auth/login');
            exit;
        }

        // Login exitoso - crear sesión
        $_SESSION['user_id'] = $usuario->getId();
        $_SESSION['user_name'] = $usuario->nombre;
        $_SESSION['user_email'] = $usuario->email;

        // Redirigir a la URL guardada o al home
        $redirect = $_SESSION['redirect_after_login'] ?? '/';
        unset($_SESSION['redirect_after_login']);
        
        header('Location: ' . $redirect);
        exit;
    }

    /**
     * Muestra el formulario de registro.
     */
    public function register(): void
    {
        // Si ya está autenticado, redirigir al home
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        $data = [
            'googleAuthUrl' => GoogleAuth::getAuthUrl(),
            'error' => $_SESSION['register_error'] ?? null,
            'success' => $_SESSION['register_success'] ?? null
        ];

        unset($_SESSION['register_error'], $_SESSION['register_success']);

        $this->render('views/auth/register', $data);
    }

    /**
     * Procesa el registro de nuevo usuario (POST).
     */
    public function registerPost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /auth/register');
            exit;
        }

        // Validar datos
        $validator = new Validator($_POST);
        $validator->required(['nombre', 'email', 'password', 'password_confirm'])
                  ->email('email')
                  ->min('password', 6)
                  ->match('password', 'password_confirm')
                  ->unique('email', 'usuarios');

        if ($validator->fails()) {
            $_SESSION['register_error'] = $validator->firstError();
            header('Location: /auth/register');
            exit;
        }

        $nombre = Utils::sanitizeString($_POST['nombre']);
        $email = Utils::sanitizeString($_POST['email']);
        $password = $_POST['password'];

        // Crear nuevo usuario
        $usuario = new Usuario();
        $usuario->nombre = $nombre;
        $usuario->email = $email;
        $usuario->password = Utils::hashPassword($password);

        if ($usuario->save()) {
            // Registro exitoso - iniciar sesión automáticamente
            $_SESSION['user_id'] = $usuario->getId();
            $_SESSION['user_name'] = $usuario->nombre;
            $_SESSION['user_email'] = $usuario->email;

            header('Location: /');
            exit;
        } else {
            $_SESSION['register_error'] = 'Error al crear la cuenta. Inténtalo de nuevo.';
            header('Location: /auth/register');
            exit;
        }
    }

    /**
     * Callback de Google OAuth.
     * Google redirige aquí después de que el usuario autoriza.
     */
    public function googleCallback(): void
    {
        $code = $_GET['code'] ?? null;

        if (!$code) {
            $_SESSION['login_error'] = 'Error de autenticación con Google.';
            header('Location: /auth/login');
            exit;
        }

        // Intercambiar código por token
        $tokenData = GoogleAuth::getAccessToken($code);
        
        if (!$tokenData || !isset($tokenData['access_token'])) {
            $_SESSION['login_error'] = 'Error al obtener token de Google.';
            header('Location: /auth/login');
            exit;
        }

        // Obtener información del usuario
        $userInfo = GoogleAuth::getUserInfo($tokenData['access_token']);

        if (!$userInfo || !isset($userInfo['id'])) {
            $_SESSION['login_error'] = 'Error al obtener información de Google.';
            header('Location: /auth/login');
            exit;
        }

        // Buscar usuario por Google ID
        $usuario = Usuario::findByGoogleId($userInfo['id']);

        if (!$usuario) {
            // Usuario nuevo - crear cuenta
            $usuario = new Usuario();
            $usuario->nombre = $userInfo['name'] ?? 'Usuario';
            $usuario->email = $userInfo['email'];
            $usuario->google_id = $userInfo['id'];
            $usuario->avatar = $userInfo['picture'] ?? null;
            $usuario->password = null; // No tiene contraseña (solo Google)

            if (!$usuario->save()) {
                $_SESSION['login_error'] = 'Error al crear cuenta con Google.';
                header('Location: /auth/login');
                exit;
            }
        } else {
            // Usuario existente - actualizar avatar si cambió
            if (isset($userInfo['picture']) && $usuario->avatar !== $userInfo['picture']) {
                $usuario->avatar = $userInfo['picture'];
                $usuario->save();
            }
        }

        // Login exitoso
        $_SESSION['user_id'] = $usuario->getId();
        $_SESSION['user_name'] = $usuario->nombre;
        $_SESSION['user_email'] = $usuario->email;
        $_SESSION['user_avatar'] = $usuario->avatar;

        header('Location: /');
        exit;
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(): void
    {
        AuthMiddleware::logout();
        header('Location: /auth/login');
        exit;
    }

    /**
     * Muestra el formulario de "Olvidé mi contraseña".
     */
    public function forgotPassword(): void
    {
        $data = [
            'error' => $_SESSION['forgot_error'] ?? null,
            'success' => $_SESSION['forgot_success'] ?? null
        ];

        unset($_SESSION['forgot_error'], $_SESSION['forgot_success']);

        $this->render('views/auth/forgot_password', $data);
    }

    /**
     * Envía el link de recuperación de contraseña.
     */
    public function sendResetLink(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /auth/forgotPassword');
            exit;
        }

        $validator = new Validator($_POST);
        $validator->required(['email'])->email('email');

        if ($validator->fails()) {
            $_SESSION['forgot_error'] = $validator->firstError();
            header('Location: /auth/forgotPassword');
            exit;
        }

        $email = Utils::sanitizeString($_POST['email']);
        $usuario = Usuario::findByEmail($email);

        // Por seguridad, siempre mostramos el mismo mensaje
        $_SESSION['forgot_success'] = 'Si el email existe, recibirás un link de recuperación.';

        if ($usuario) {
            // Generar token
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Guardar token
            $usuario->reset_token = $token;
            $usuario->reset_token_expires = $expires;
            $usuario->save();

            // Enviar email
            $resetUrl = "http://" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . "/auth/resetPassword/{$token}";
            
            $mailer = new Mailer();
            $mailer->sendTemplate($email, 'Recuperar Contraseña', 'password_reset', [
                'nombre' => $usuario->nombre,
                'token' => $token,
                'url' => $resetUrl
            ]);
        }

        header('Location: /auth/forgotPassword');
        exit;
    }

    /**
     * Muestra el formulario de reset de contraseña.
     */
    public function resetPassword(string $token): void
    {
        // Buscar usuario por token
        $conn = \src\config\Database::getConnection();
        $sql = "SELECT * FROM usuarios WHERE reset_token = ? AND reset_token_expires > NOW()";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $userData = $result->fetch_assoc();
        $stmt->close();

        if (!$userData) {
            $_SESSION['login_error'] = 'El link de recuperación es inválido o ha expirado.';
            header('Location: /auth/login');
            exit;
        }

        $data = [
            'token' => $token,
            'error' => $_SESSION['reset_error'] ?? null
        ];

        unset($_SESSION['reset_error']);

        $this->render('views/auth/reset_password', $data);
    }

    /**
     * Actualiza la contraseña.
     */
    public function updatePassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /auth/login');
            exit;
        }

        $token = $_POST['token'] ?? '';
        $validator = new Validator($_POST);
        $validator->required(['password', 'password_confirm'])
                  ->min('password', 6)
                  ->match('password', 'password_confirm');

        if ($validator->fails()) {
            $_SESSION['reset_error'] = $validator->firstError();
            header("Location: /auth/resetPassword/{$token}");
            exit;
        }

        // Buscar usuario por token
        $conn = \src\config\Database::getConnection();
        $sql = "SELECT * FROM usuarios WHERE reset_token = ? AND reset_token_expires > NOW()";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $userData = $result->fetch_assoc();
        $stmt->close();

        if (!$userData) {
            $_SESSION['login_error'] = 'El link de recuperación es inválido o ha expirado.';
            header('Location: /auth/login');
            exit;
        }

        // Actualizar contraseña
        $usuario = new Usuario($userData);
        $usuario->password = Utils::hashPassword($_POST['password']);
        $usuario->reset_token = null;
        $usuario->reset_token_expires = null;
        $usuario->save();

        $_SESSION['login_error'] = null;
        $_SESSION['login_success'] = 'Contraseña actualizada exitosamente. Inicia sesión.';
        header('Location: /auth/login');
        exit;
    }
}
