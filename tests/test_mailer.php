<?php
// tests/test_mailer.php
// Script de prueba para el sistema de emails híbrido

require_once __DIR__ . '/../index.php';

use src\utils\Mailer;

echo "=== Prueba del Sistema de Emails Híbrido ===\n\n";

// Crear instancia
$mailer = new Mailer();

// Verificar qué driver está usando
$driver = $mailer->getDriver();
echo "Driver detectado: " . strtoupper($driver) . "\n";

if ($driver === 'phpmailer') {
    echo "✅ PHPMailer está disponible y configurado\n";
    echo "   Usando SMTP para envío de emails\n\n";
} else {
    echo "⚠️  PHPMailer no encontrado\n";
    echo "   Usando mail() nativo de PHP\n\n";
}

// Ejemplo 1: Email simple
echo "Ejemplo 1: Email HTML simple\n";
echo "Código:\n";
echo <<<'CODE'
$mailer = new Mailer();
$mailer->send('usuario@example.com', 'Asunto', '<h1>Hola</h1>');
CODE;
echo "\n\n";

// Ejemplo 2: Email con template
echo "Ejemplo 2: Email con template\n";
echo "Código:\n";
echo <<<'CODE'
$mailer = new Mailer();
$mailer->sendTemplate('usuario@example.com', 'Bienvenido', 'welcome', [
    'nombre' => 'Juan Pérez'
]);
CODE;
echo "\n\n";

// Ejemplo 3: Recuperación de contraseña
echo "Ejemplo 3: Recuperación de contraseña\n";
echo "Código:\n";
echo <<<'CODE'
$mailer = new Mailer();
$mailer->sendTemplate('usuario@example.com', 'Recuperar Contraseña', 'password_reset', [
    'nombre' => 'Juan',
    'token' => 'abc123...',
    'url' => 'http://localhost/auth/resetPassword/abc123...'
]);
CODE;
echo "\n\n";

// Prueba real (comentada por seguridad)
echo "Para enviar un email de prueba real, descomenta y ejecuta:\n";
echo "// \$mailer->sendTest('tu@email.com');\n\n";

echo "=== Fin de la Prueba ===\n";
