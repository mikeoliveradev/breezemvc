#!/usr/bin/env php
<?php
// cli.php - Herramienta CLI para generar código automáticamente

// Colores para la terminal
define('COLOR_GREEN', "\033[32m");
define('COLOR_RED', "\033[31m");
define('COLOR_YELLOW', "\033[33m");
define('COLOR_RESET', "\033[0m");

// Autoload
spl_autoload_register(function ($class) {
    $base_dir = __DIR__ . '/';
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use src\cli\MakeController;
use src\cli\MakeModel;
use src\cli\MakeMiddleware;

/**
 * Muestra un mensaje de éxito en verde.
 */
function success(string $message): void {
    echo COLOR_GREEN . "✓ " . $message . COLOR_RESET . "\n";
}

/**
 * Muestra un mensaje de error en rojo.
 */
function error(string $message): void {
    echo COLOR_RED . "✗ " . $message . COLOR_RESET . "\n";
}

/**
 * Muestra un mensaje de advertencia en amarillo.
 */
function warning(string $message): void {
    echo COLOR_YELLOW . "⚠ " . $message . COLOR_RESET . "\n";
}

/**
 * Muestra la ayuda del CLI.
 */
function showHelp(): void {
    echo "\n";
    echo COLOR_GREEN . "CLI Helper - Generador de Código" . COLOR_RESET . "\n";
    echo "=================================\n\n";
    echo "Uso:\n";
    echo "  php cli.php [comando] [argumentos]\n\n";
    echo "Comandos disponibles:\n";
    echo "  make:controller <Nombre>  Genera un nuevo controlador\n";
    echo "  make:model <Nombre>       Genera un nuevo modelo\n";
    echo "  make:middleware <Nombre>  Genera un nuevo middleware\n";
    echo "  list                      Muestra esta ayuda\n";
    echo "  help                      Muestra esta ayuda\n\n";
    echo "Ejemplos:\n";
    echo "  php cli.php make:controller ProductoController\n";
    echo "  php cli.php make:model Producto\n";
    echo "  php cli.php make:middleware AdminMiddleware\n\n";
}

// Verificar argumentos
if ($argc < 2) {
    error("No se especificó ningún comando.");
    showHelp();
    exit(1);
}

$command = $argv[1];
$name = $argv[2] ?? null;

// Procesar comandos
switch ($command) {
    case 'make:controller':
        if (!$name) {
            error("Debes especificar el nombre del controlador.");
            echo "Uso: php cli.php make:controller NombreController\n";
            exit(1);
        }
        MakeController::generate($name);
        break;

    case 'make:model':
        if (!$name) {
            error("Debes especificar el nombre del modelo.");
            echo "Uso: php cli.php make:model NombreModelo\n";
            exit(1);
        }
        MakeModel::generate($name);
        break;

    case 'make:middleware':
        if (!$name) {
            error("Debes especificar el nombre del middleware.");
            echo "Uso: php cli.php make:middleware NombreMiddleware\n";
            exit(1);
        }
        MakeMiddleware::generate($name);
        break;

    case 'list':
    case 'help':
        showHelp();
        break;

    default:
        error("Comando desconocido: {$command}");
        showHelp();
        exit(1);
}
