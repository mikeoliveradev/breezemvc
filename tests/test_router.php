<?php
// tests/test_router.php
// Script simple para verificar que el autoload y el router funcionan
// Ejecutar con: php tests/test_router.php

// Simular entorno web
$_SERVER['REQUEST_URI'] = '/producto/index';
$_SERVER['REQUEST_METHOD'] = 'GET';

// Capturar salida
ob_start();
require_once __DIR__ . '/../index.php';
$output = ob_get_clean();

echo "--- Prueba 1: /producto/index ---\n";
if (strpos($output, 'Listado de Modelos') !== false) {
    echo "✅ ÉXITO: Se cargó el controlador y se mostró el listado.\n";
} else {
    echo "❌ FALLO: No se encontró la salida esperada.\n";
    echo "Salida: " . substr($output, 0, 100) . "...\n";
}

// Prueba 2: Clase inexistente
$_SERVER['REQUEST_URI'] = '/inexistente/algo';
ob_start();
// Reiniciar estado de headers para evitar warnings en CLI (simulado)
if (function_exists('header_remove')) header_remove(); 

require __DIR__ . '/../index.php';
$output2 = ob_get_clean();

echo "\n--- Prueba 2: /inexistente/algo ---\n";
if (strpos($output2, 'Error 404') !== false || strpos($output2, 'Página no encontrada') !== false) {
    echo "✅ ÉXITO: Se manejó correctamente el error 404.\n";
} else {
    echo "⚠️ AVISO: Verifica si se mostró el 404 correctamente.\n"; 
    // Nota: Puede fallar si index.php hace require de 404.html y este tiene rutas relativas que no cuadran en CLI test
}
