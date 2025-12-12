<?php
// tests/debug_phpmailer.php
// Script de debug para ver por qué no se detecta PHPMailer

echo "=== Debug PHPMailer ===\n\n";

$phpMailerPath = __DIR__ . '/../vendor/PHPMailer/src/PHPMailer.php';

echo "1. Path esperado:\n";
echo "   {$phpMailerPath}\n\n";

echo "2. ¿Existe el archivo?\n";
echo "   " . (file_exists($phpMailerPath) ? "✅ SÍ" : "❌ NO") . "\n\n";

if (file_exists($phpMailerPath)) {
    echo "3. Intentando cargar PHPMailer...\n";
    
    try {
        require_once $phpMailerPath;
        require_once __DIR__ . '/../vendor/PHPMailer/src/SMTP.php';
        require_once __DIR__ . '/../vendor/PHPMailer/src/Exception.php';
        
        echo "   ✅ Archivos cargados\n\n";
        
        echo "4. ¿Existe la clase?\n";
        $classExists = class_exists('\\PHPMailer\\PHPMailer\\PHPMailer');
        echo "   " . ($classExists ? "✅ SÍ" : "❌ NO") . "\n\n";
        
        if ($classExists) {
            echo "5. Intentando crear instancia...\n";
            $mailer = new \PHPMailer\PHPMailer\PHPMailer(true);
            echo "   ✅ Instancia creada exitosamente\n\n";
            echo "¡PHPMailer está funcionando correctamente!\n";
        } else {
            echo "ERROR: La clase no existe después de cargar los archivos.\n";
            echo "Verifica que los archivos sean de PHPMailer versión 6.x\n";
        }
        
    } catch (\Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n\n";
    }
} else {
    echo "ERROR: El archivo no existe en la ruta esperada.\n";
}
