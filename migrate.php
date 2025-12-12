#!/usr/bin/env php
<?php
// migrate.php - Sistema de migraciones de base de datos

// Colores para la terminal
define('COLOR_GREEN', "\033[32m");
define('COLOR_RED', "\033[31m");
define('COLOR_YELLOW', "\033[33m");
define('COLOR_BLUE', "\033[34m");
define('COLOR_RESET', "\033[0m");

// Autoload
spl_autoload_register(function ($class) {
    $base_dir = __DIR__ . '/';
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use src\utils\Migration;

/**
 * Muestra la ayuda del sistema de migraciones.
 */
function showHelp(): void {
    echo "\n";
    echo COLOR_BLUE . "Sistema de Migraciones de Base de Datos" . COLOR_RESET . "\n";
    echo "========================================\n\n";
    echo "Uso:\n";
    echo "  php migrate.php [comando] [argumentos]\n\n";
    echo "Comandos disponibles:\n";
    echo "  up                Aplica todas las migraciones pendientes\n";
    echo "  down              Revierte la última migración ejecutada\n";
    echo "  status            Muestra el estado de las migraciones\n";
    echo "  create <nombre>   Crea un nuevo archivo de migración\n";
    echo "  help              Muestra esta ayuda\n\n";
    echo "Ejemplos:\n";
    echo "  php migrate.php up\n";
    echo "  php migrate.php down\n";
    echo "  php migrate.php status\n";
    echo "  php migrate.php create add_avatar_to_usuarios\n\n";
}

// Verificar argumentos
if ($argc < 2) {
    echo COLOR_RED . "Error: No se especificó ningún comando.\n" . COLOR_RESET;
    showHelp();
    exit(1);
}

$command = $argv[1];

try {
    $migration = new Migration();
    
    switch ($command) {
        case 'up':
            echo "\n" . COLOR_BLUE . "Aplicando migraciones pendientes...\n" . COLOR_RESET . "\n";
            $pending = $migration->getPending();
            
            if (empty($pending)) {
                echo COLOR_YELLOW . "No hay migraciones pendientes.\n" . COLOR_RESET . "\n";
                exit(0);
            }
            
            foreach ($pending as $file) {
                $migration->up($file);
            }
            
            echo "\n" . COLOR_GREEN . "✓ Todas las migraciones aplicadas correctamente.\n" . COLOR_RESET . "\n";
            break;

        case 'down':
            echo "\n" . COLOR_BLUE . "Revirtiendo última migración...\n" . COLOR_RESET . "\n";
            $executed = $migration->getExecuted();
            
            if (empty($executed)) {
                echo COLOR_YELLOW . "No hay migraciones para revertir.\n" . COLOR_RESET . "\n";
                exit(0);
            }
            
            $last = end($executed);
            $migration->down($last);
            
            echo "\n" . COLOR_GREEN . "✓ Migración revertida correctamente.\n" . COLOR_RESET . "\n";
            break;

        case 'status':
            $migration->status();
            break;

        case 'create':
            if ($argc < 3) {
                echo COLOR_RED . "Error: Debes especificar el nombre de la migración.\n" . COLOR_RESET;
                echo "Uso: php migrate.php create nombre_migracion\n\n";
                exit(1);
            }
            
            $name = $argv[2];
            echo "\n" . COLOR_BLUE . "Creando nueva migración...\n" . COLOR_RESET . "\n";
            $migration->create($name);
            echo "\n" . COLOR_GREEN . "✓ Migración creada. Edita el archivo y luego ejecuta 'php migrate.php up'\n" . COLOR_RESET . "\n";
            break;

        case 'help':
            showHelp();
            break;

        default:
            echo COLOR_RED . "Error: Comando desconocido: {$command}\n" . COLOR_RESET;
            showHelp();
            exit(1);
    }
    
} catch (\Exception $e) {
    echo "\n" . COLOR_RED . "❌ Error: " . $e->getMessage() . "\n" . COLOR_RESET . "\n";
    exit(1);
}
