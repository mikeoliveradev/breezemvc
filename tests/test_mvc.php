<?php
// tests/test_mvc.php
// Script para verificar que la refactorización MVC funciona
// Ejecutar con: php tests/test_mvc.php

// Simular entorno web
$_SERVER['REQUEST_URI'] = '/test/invoice';
$_SERVER['REQUEST_METHOD'] = 'GET';

// Capturar salida
ob_start();
// Suprimir warnings de headers en CLI
if (function_exists('header_remove')) header_remove(); 

require_once __DIR__ . '/../index.php';
$output = ob_get_clean();

echo "--- Prueba MVC: /test/invoice ---\n";

// Verificaciones clave
$checks = [
    'Invoice #' => strpos($output, 'Invoice #') !== false,
    'Front Inc.' => strpos($output, 'Front Inc.') !== false,
    'Usuario Test' => strpos($output, 'Usuario Test') !== false, // Nombre por defecto si no hay DB
    '2750.00' => strpos($output, '2750.00') !== false // Total calculado
];

$all_pass = true;
foreach ($checks as $name => $passed) {
    if ($passed) {
        echo "✅ {$name}: Encontrado\n";
    } else {
        echo "❌ {$name}: NO encontrado\n";
        $all_pass = false;
    }
}

if ($all_pass) {
    echo "\n🎉 ÉXITO TOTAL: La refactorización MVC funciona correctamente.\n";
} else {
    echo "\n⚠️ ALGUNAS PRUEBAS FALLARON.\n";
    echo "Primeros 200 caracteres de salida:\n" . substr($output, 0, 200) . "...\n";
}
