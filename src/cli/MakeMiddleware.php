<?php
// src/cli/MakeMiddleware.php

namespace src\cli;

class MakeMiddleware
{
    /**
     * Genera un nuevo middleware.
     * @param string $name Nombre del middleware (ej: AdminMiddleware)
     */
    public static function generate(string $name): void
    {
        // Asegurar que termina en "Middleware"
        if (!str_ends_with($name, 'Middleware')) {
            $name .= 'Middleware';
        }

        $filePath = __DIR__ . '/../../src/middleware/' . $name . '.php';

        // Verificar si ya existe
        if (file_exists($filePath)) {
            self::error("El middleware {$name} ya existe.");
            return;
        }

        // Template del middleware
        $template = self::getTemplate($name);

        // Crear el archivo
        if (file_put_contents($filePath, $template)) {
            self::success("Middleware creado: src/middleware/{$name}.php");
            self::info("Úsalo en tus controladores: {$name}::handle();");
        } else {
            self::error("Error al crear el middleware.");
        }
    }

    /**
     * Obtiene el template del middleware.
     */
    private static function getTemplate(string $name): string
    {
        return <<<PHP
<?php
// src/middleware/{$name}.php

namespace src\middleware;

class {$name}
{
    /**
     * Maneja la lógica del middleware.
     * Puedes verificar permisos, validar datos, etc.
     * 
     * @param string \$redirectTo URL de redirección si falla (opcional)
     * @return void
     */
    public static function handle(string \$redirectTo = '/'): void
    {
        // Asegurar que la sesión esté iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // TODO: Implementar tu lógica aquí
        // Ejemplo: Verificar si el usuario es administrador
        /*
        if (!isset(\$_SESSION['user_role']) || \$_SESSION['user_role'] !== 'admin') {
            header('Location: ' . \$redirectTo);
            exit;
        }
        */

        // Si todo está bien, el código continúa normalmente
    }

    /**
     * Método alternativo para verificar condiciones sin redirigir.
     * @return bool True si pasa la validación, false si no.
     */
    public static function check(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // TODO: Implementar tu lógica de verificación
        // Ejemplo:
        // return isset(\$_SESSION['user_role']) && \$_SESSION['user_role'] === 'admin';
        
        return true;
    }
}

PHP;
    }

    private static function success(string $msg): void {
        echo "\033[32m✓ {$msg}\033[0m\n";
    }

    private static function error(string $msg): void {
        echo "\033[31m✗ {$msg}\033[0m\n";
    }

    private static function info(string $msg): void {
        echo "\033[33mℹ {$msg}\033[0m\n";
    }
}
