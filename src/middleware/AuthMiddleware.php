<?php
// src/middleware/AuthMiddleware.php

namespace src\middleware;

/**
 * Middleware para proteger rutas que requieren autenticación.
 */
class AuthMiddleware
{
    /**
     * Verifica si el usuario está autenticado.
     * Si no lo está, redirige a la página de login.
     * 
     * @param string $redirectTo URL a la que redirigir si no está autenticado (por defecto /auth/login)
     * @return void
     */
    public static function verificarAutenticacion(string $redirectTo = '/auth/login'): void
    {
        // Asegurar que la sesión esté iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si existe user_id en la sesión
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            // Guardar la URL actual para redirigir después del login
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            
            // Redirigir al login
            header('Location: ' . $redirectTo);
            exit;
        }
    }

    /**
     * Obtiene el ID del usuario autenticado actual.
     * 
     * @return int|null ID del usuario o null si no está autenticado
     */
    public static function getUserId(): ?int
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Cierra la sesión del usuario.
     * 
     * @return void
     */
    public static function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Destruir todas las variables de sesión
        $_SESSION = [];

        // Destruir la cookie de sesión
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }

        // Destruir la sesión
        session_destroy();
    }
}
