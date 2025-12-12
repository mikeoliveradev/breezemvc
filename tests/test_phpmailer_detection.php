<?php
// tests/test_phpmailer_detection.php
// Script simple para verificar detección de PHPMailer

// Autoload manual
spl_autoload_register(function ($class) {
    $base_dir = __DIR__ . '/../';
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use src\utils\Mailer;

echo "=== Detección de PHPMailer ===\n\n";

$mailer = new Mailer();
$driver = $mailer->getDriver();

echo "Driver detectado: " . strtoupper($driver) . "\n\n";

if ($driver === 'phpmailer') {
    echo "✅ ¡PHPMailer está funcionando!\n";
    echo "   El sistema usará SMTP para enviar emails.\n";
    echo "   Configura las credenciales en src/config/database.php\n";
} else {
    echo "⚠️  PHPMailer no detectado\n";
    echo "   El sistema usará mail() nativo de PHP.\n";
    echo "   \n";
    echo "   Para habilitar PHPMailer:\n";
    echo "   1. Verifica que exista: vendor/PHPMailer/src/PHPMailer.php\n";
    echo "   2. Verifica que exista: vendor/PHPMailer/src/SMTP.php\n";
    echo "   3. Verifica que exista: vendor/PHPMailer/src/Exception.php\n";
}

echo "\n";
