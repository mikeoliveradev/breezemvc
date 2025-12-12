<?php
// tests/test_cache.php
// Script de prueba para el sistema de caché

// Autoload
spl_autoload_register(function ($class) {
    $base_dir = __DIR__ . '/../';
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use src\utils\Cache;

echo "=== Prueba del Sistema de Caché ===\n\n";

$cache = new Cache();

echo "Driver detectado: " . strtoupper($cache->getDriver()) . "\n\n";

// Prueba 1: Set y Get
echo "1. Guardando valor en caché...\n";
$cache->set('test_key', 'Hola Mundo', 60);
echo "   Valor guardado: 'Hola Mundo'\n";
echo "   TTL: 60 segundos\n\n";

echo "2. Recuperando valor...\n";
$value = $cache->get('test_key');
echo "   Valor recuperado: '{$value}'\n";
echo "   " . ($value === 'Hola Mundo' ? '✅ CORRECTO' : '❌ ERROR') . "\n\n";

// Prueba 2: Has
echo "3. Verificando existencia...\n";
$exists = $cache->has('test_key');
echo "   ¿Existe 'test_key'? " . ($exists ? 'SÍ' : 'NO') . "\n";
echo "   " . ($exists ? '✅ CORRECTO' : '❌ ERROR') . "\n\n";

// Prueba 3: Cachear arrays
echo "4. Guardando array...\n";
$data = ['nombre' => 'Juan', 'edad' => 30, 'ciudad' => 'México'];
$cache->set('user_data', $data, 60);
$retrieved = $cache->get('user_data');
echo "   Array guardado y recuperado\n";
echo "   " . (is_array($retrieved) && $retrieved['nombre'] === 'Juan' ? '✅ CORRECTO' : '❌ ERROR') . "\n\n";

// Prueba 4: Remember helper
echo "5. Probando método remember()...\n";
$result = $cache->remember('expensive_operation', function() {
    echo "   Ejecutando operación costosa...\n";
    return 'Resultado calculado';
}, 60);
echo "   Resultado: {$result}\n";

$result2 = $cache->remember('expensive_operation', function() {
    echo "   Esta línea NO debería aparecer (viene del caché)\n";
    return 'Nuevo resultado';
}, 60);
echo "   Resultado desde caché: {$result2}\n";
echo "   " . ($result === $result2 ? '✅ CORRECTO' : '❌ ERROR') . "\n\n";

// Prueba 5: Delete
echo "6. Eliminando clave...\n";
$cache->delete('test_key');
$exists = $cache->has('test_key');
echo "   ¿Existe después de eliminar? " . ($exists ? 'SÍ' : 'NO') . "\n";
echo "   " . (!$exists ? '✅ CORRECTO' : '❌ ERROR') . "\n\n";

// Prueba 6: Clear
echo "7. Limpiando todo el caché...\n";
$cache->clear();
$exists1 = $cache->has('user_data');
$exists2 = $cache->has('expensive_operation');
echo "   Todo limpio: " . (!$exists1 && !$exists2 ? 'SÍ' : 'NO') . "\n";
echo "   " . (!$exists1 && !$exists2 ? '✅ CORRECTO' : '❌ ERROR') . "\n\n";

echo "=== Fin de las Pruebas ===\n";
