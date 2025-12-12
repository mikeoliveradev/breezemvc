<?php
// tests/test_extract.php
// Prueba simple para verificar que extract() funciona

echo "=== Prueba 1: Extract básico ===\n";
$data = ['nombre' => 'Usuario Test', 'total' => 2750.00];
extract($data);
echo "Nombre: $nombre\n";
echo "Total: $total\n";

echo "\n=== Prueba 2: Extract en función ===\n";
function testExtractEnFuncion() {
    $data = ['nombre' => 'Usuario Test', 'total' => 2750.00];
    extract($data);
    echo "Nombre: $nombre\n";
    echo "Total: $total\n";
}
testExtractEnFuncion();

echo "\n=== Prueba 3: Extract + require (simulando BaseController) ===\n";
function renderTest($data) {
    extract($data);
    $viewFile = __DIR__ . '/test_view.php';
    require $viewFile;
}

// Crear vista temporal
file_put_contents(__DIR__ . '/test_view.php', '<?php echo "Nombre en vista: $nombre, Total: $total"; ?>');

renderTest(['nombre' => 'Usuario Test', 'total' => 2750.00]);

// Limpiar
unlink(__DIR__ . '/test_view.php');

echo "\n\n✅ Si ves los valores arriba, extract() funciona correctamente.\n";
