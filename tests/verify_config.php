<?php
/**
 * Script de Verificación de Configuración
 * Ejecutar: php tests/verify_config.php
 */

// Cargar el autoloader
require_once __DIR__ . '/../index.php';

use src\config\Database;

echo "\n";
echo "╔════════════════════════════════════════════╗\n";
echo "║   BreezeMVC - Verificación de Config      ║\n";
echo "╚════════════════════════════════════════════╝\n";
echo "\n";

$errors = 0;
$warnings = 0;

// =============================================
// 1. BASE DE DATOS
// =============================================
echo "📦 BASE DE DATOS\n";
echo str_repeat("─", 44) . "\n";

try {
    $conn = Database::getConnection();
    echo "  ✅ Conexión establecida correctamente\n";
    echo "  ℹ️  Charset: " . $conn->character_set_name() . "\n";
    
    // Verificar si hay tablas
    $result = $conn->query("SHOW TABLES");
    $tableCount = $result->num_rows;
    
    if ($tableCount > 0) {
        echo "  ✅ Base de datos tiene $tableCount tabla(s)\n";
    } else {
        echo "  ⚠️  Base de datos vacía - ejecuta: php migrate.php up\n";
        $warnings++;
    }
    
} catch (Exception $e) {
    echo "  ❌ Error de conexión\n";
    echo "  ℹ️  " . $e->getMessage() . "\n";
    echo "  💡 Edita src/config/database.php con tus credenciales\n";
    $errors++;
}

echo "\n";

// =============================================
// 2. SMTP / EMAIL
// =============================================
echo "📧 CONFIGURACIÓN DE EMAIL\n";
echo str_repeat("─", 44) . "\n";

if (Database::SMTP_HOST === 'smtp.tu-proveedor.com') {
    echo "  ⚠️  SMTP no configurado (valores por defecto)\n";
    echo "  💡 Edita src/config/database.php para enviar emails\n";
    $warnings++;
} else {
    echo "  ✅ SMTP Host: " . Database::SMTP_HOST . "\n";
    echo "  ✅ SMTP User: " . Database::SMTP_USERNAME . "\n";
    echo "  💡 Prueba con: php tests/test_email.php\n";
}

echo "\n";

// =============================================
// 3. GOOGLE OAUTH
// =============================================
echo "🔐 GOOGLE OAUTH\n";
echo str_repeat("─", 44) . "\n";

// Verificar si GoogleAuth existe
if (class_exists('src\\integrations\\GoogleAuth')) {
    // Usar reflection para leer constantes privadas
    $reflection = new ReflectionClass('src\\integrations\\GoogleAuth');
    $constants = $reflection->getConstants();
    
    if (isset($constants['GOOGLE_CLIENT_ID']) && 
        strpos($constants['GOOGLE_CLIENT_ID'], 'TU_CLIENT_ID') !== false) {
        echo "  ⚠️  Google OAuth no configurado\n";
        echo "  💡 Ver: docs/GOOGLE_SIGNIN_SETUP.md\n";
        $warnings++;
    } else {
        echo "  ✅ Google Client ID configurado\n";
        echo "  ✅ Google OAuth listo para usar\n";
    }
} else {
    echo "  ℹ️  GoogleAuth no encontrado (opcional)\n";
}

echo "\n";

// =============================================
// 4. GOOGLE MAPS API
// =============================================
echo "🗺️  GOOGLE MAPS API\n";
echo str_repeat("─", 44) . "\n";

if (Database::GOOGLE_MAPS_API_KEY === 'TU_GOOGLE_MAPS_API_KEY') {
    echo "  ⚠️  Google Maps API no configurado\n";
    echo "  💡 Solo necesario si usas mapas/geolocalización\n";
    $warnings++;
} else {
    echo "  ✅ API Key configurado\n";
}

echo "\n";

// =============================================
// 5. ESTRUCTURA DE ARCHIVOS
// =============================================
echo "📁 ESTRUCTURA DE ARCHIVOS\n";
echo str_repeat("─", 44) . "\n";

$requiredDirs = [
    'src/controllers',
    'src/models',
    'src/utils',
    'public/views',
    'database/migrations',
    'storage/cache'
];

foreach ($requiredDirs as $dir) {
    $path = __DIR__ . '/../' . $dir;
    if (is_dir($path)) {
        echo "  ✅ $dir\n";
    } else {
        echo "  ❌ $dir - NO EXISTE\n";
        $errors++;
    }
}

echo "\n";

// =============================================
// 6. PERMISOS
// =============================================
echo "🔒 PERMISOS\n";
echo str_repeat("─", 44) . "\n";

$writableDirs = [
    'storage/cache'
];

foreach ($writableDirs as $dir) {
    $path = __DIR__ . '/../' . $dir;
    if (is_writable($path)) {
        echo "  ✅ $dir - escribible\n";
    } else {
        echo "  ❌ $dir - NO escribible\n";
        echo "  💡 Ejecuta: chmod 755 $dir\n";
        $errors++;
    }
}

echo "\n";

// =============================================
// 7. PHP EXTENSIONS
// =============================================
echo "🔧 EXTENSIONES PHP\n";
echo str_repeat("─", 44) . "\n";

$requiredExtensions = [
    'mysqli' => 'Requerido para base de datos',
    'session' => 'Requerido para autenticación',
    'json' => 'Requerido para APIs',
    'mbstring' => 'Recomendado para strings UTF-8'
];

foreach ($requiredExtensions as $ext => $description) {
    if (extension_loaded($ext)) {
        echo "  ✅ $ext\n";
    } else {
        echo "  ❌ $ext - NO instalado\n";
        echo "  ℹ️  $description\n";
        $errors++;
    }
}

// Extensiones opcionales
$optionalExtensions = [
    'redis' => 'Para caché Redis (opcional)',
    'gd' => 'Para manipulación de imágenes (opcional)'
];

foreach ($optionalExtensions as $ext => $description) {
    if (extension_loaded($ext)) {
        echo "  ✅ $ext (opcional)\n";
    } else {
        echo "  ℹ️  $ext - no instalado ($description)\n";
    }
}

echo "\n";

// =============================================
// RESUMEN
// =============================================
echo "╔════════════════════════════════════════════╗\n";
echo "║              RESUMEN                       ║\n";
echo "╚════════════════════════════════════════════╝\n";
echo "\n";

if ($errors === 0 && $warnings === 0) {
    echo "  🎉 ¡Todo configurado correctamente!\n";
    echo "  ✨ BreezeMVC está listo para usar\n";
} else {
    if ($errors > 0) {
        echo "  ❌ Errores críticos: $errors\n";
        echo "  ⚠️  Debes corregir estos errores antes de continuar\n";
    }
    if ($warnings > 0) {
        echo "  ⚠️  Advertencias: $warnings\n";
        echo "  ℹ️  La aplicación funcionará, pero algunas características\n";
        echo "     pueden no estar disponibles\n";
    }
}

echo "\n";
echo "📖 Documentación: docs/CONFIGURATION.md\n";
echo "🐛 Reportar issues: github.com/mikeoliveradev/breezemvc/issues\n";
echo "\n";

// Exit code
exit($errors > 0 ? 1 : 0);
