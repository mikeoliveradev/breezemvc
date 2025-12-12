<?php
// examples/validator_examples.php
// Ejemplos de uso del sistema de validación

require_once __DIR__ . '/../src/utils/Validator.php';
use src\utils\Validator;

echo "=== Ejemplos de Uso del Validator ===\n\n";

// ============================================
// Ejemplo 1: Validación Básica
// ============================================
echo "1. Validación Básica (required, email)\n";
$_POST = [
    'nombre' => 'Juan Pérez',
    'email' => 'juan@example.com'
];

$validator = new Validator($_POST);
$validator->required(['nombre', 'email'])
          ->email('email');

if ($validator->passes()) {
    echo "✅ Validación exitosa\n\n";
} else {
    echo "❌ Errores: " . print_r($validator->errors(), true) . "\n";
}

// ============================================
// Ejemplo 2: Validación con Errores
// ============================================
echo "2. Validación con Errores\n";
$_POST = [
    'nombre' => '',
    'email' => 'email-invalido'
];

$validator = new Validator($_POST);
$validator->required(['nombre', 'email'])
          ->email('email');

if ($validator->fails()) {
    echo "❌ Primer error: " . $validator->firstError() . "\n";
    echo "Todos los errores:\n";
    foreach ($validator->errors() as $field => $errors) {
        foreach ($errors as $error) {
            echo "  - $error\n";
        }
    }
}
echo "\n";

// ============================================
// Ejemplo 3: Validación de Contraseñas
// ============================================
echo "3. Validación de Contraseñas (min, match)\n";
$_POST = [
    'password' => '12345',
    'password_confirm' => '123456'
];

$validator = new Validator($_POST);
$validator->required(['password', 'password_confirm'])
          ->min('password', 6)
          ->match('password', 'password_confirm');

if ($validator->fails()) {
    echo "❌ Errores encontrados:\n";
    foreach ($validator->errors() as $field => $errors) {
        echo "  Campo '$field': " . implode(', ', $errors) . "\n";
    }
}
echo "\n";

// ============================================
// Ejemplo 4: Mensajes Personalizados
// ============================================
echo "4. Mensajes Personalizados\n";
$_POST = [
    'username' => ''
];

$validator = new Validator($_POST);
$validator->required(['username'])
          ->messages([
              'username.required' => 'El nombre de usuario es obligatorio, amigo.'
          ]);

if ($validator->fails()) {
    echo "❌ " . $validator->firstError() . "\n";
}
echo "\n";

// ============================================
// Ejemplo 5: Validación Numérica
// ============================================
echo "5. Validación Numérica\n";
$_POST = [
    'edad' => '25',
    'precio' => 'abc'
];

$validator = new Validator($_POST);
$validator->numeric('edad')
          ->numeric('precio');

if ($validator->fails()) {
    echo "❌ Error en precio: " . $validator->firstErrorFor('precio') . "\n";
}
echo "\n";

// ============================================
// Ejemplo 6: Validación con Regex
// ============================================
echo "6. Validación con Regex (Teléfono)\n";
$_POST = [
    'telefono' => '1234567890'
];

$validator = new Validator($_POST);
$validator->regex('telefono', '/^[0-9]{10}$/');

if ($validator->passes()) {
    echo "✅ Teléfono válido\n";
}
echo "\n";

// ============================================
// Ejemplo 7: Uso en Controlador (Simulado)
// ============================================
echo "7. Uso en Controlador\n";
function procesarFormulario($data) {
    $validator = new Validator($data);
    $validator->required(['nombre', 'email', 'mensaje'])
              ->email('email')
              ->min('mensaje', 10);
    
    if ($validator->fails()) {
        return [
            'success' => false,
            'error' => $validator->firstError()
        ];
    }
    
    return [
        'success' => true,
        'message' => 'Formulario procesado correctamente'
    ];
}

$resultado = procesarFormulario([
    'nombre' => 'Juan',
    'email' => 'juan@example.com',
    'mensaje' => 'Hola mundo'
]);

echo ($resultado['success'] ? '✅ ' : '❌ ') . ($resultado['message'] ?? $resultado['error']) . "\n";

echo "\n=== Fin de Ejemplos ===\n";
