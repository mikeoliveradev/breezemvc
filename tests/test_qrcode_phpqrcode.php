<?php
// tests/test_qrcode_phpqrcode.php
// Prueba específica de QRCode con phpqrcode

require_once __DIR__ . '/../index.php';

use src\utils\QRCode;

echo "=== Prueba de QRCode con phpqrcode ===\n\n";

// Verificar que phpqrcode existe
$phpqrcodePath = __DIR__ . '/../vendor/phpqrcode/qrlib.php';
echo "1. Verificando phpqrcode...\n";
echo "   Ruta: {$phpqrcodePath}\n";
echo "   Existe: " . (file_exists($phpqrcodePath) ? 'SÍ ✅' : 'NO ❌') . "\n\n";

// Crear directorio de QR si no existe
if (!is_dir('qr')) {
    mkdir('qr', 0755, true);
    echo "2. Directorio qr/ creado\n\n";
} else {
    echo "2. Directorio qr/ ya existe\n\n";
}

// Prueba 1: Generar QR y guardar localmente
echo "3. Generando QR con phpqrcode (guardar localmente)...\n";
$data1 = 'https://miapp.com/mascota/test123';
$filename1 = 'test_mascota_123.png';

try {
    $result1 = QRCode::generate($data1, $filename1);
    echo "   Datos: {$data1}\n";
    echo "   Archivo: {$filename1}\n";
    echo "   Resultado: {$result1}\n";
    
    // Verificar si se guardó
    if (QRCode::exists($filename1)) {
        echo "   Estado: ✅ GUARDADO LOCALMENTE\n";
        $filepath = 'qr/' . $filename1;
        $filesize = filesize($filepath);
        echo "   Tamaño: " . round($filesize / 1024, 2) . " KB\n";
    } else {
        echo "   Estado: ⚠️ NO SE GUARDÓ (usando Google Charts)\n";
    }
} catch (Exception $e) {
    echo "   Error: " . $e->getMessage() . "\n";
}
echo "\n";

// Prueba 2: Generar varios QR
echo "4. Generando múltiples QR...\n";
$tests = [
    ['data' => 'https://miapp.com/producto/456', 'file' => 'test_producto_456.png'],
    ['data' => 'https://miapp.com/evento/789', 'file' => 'test_evento_789.png'],
    ['data' => 'BEGIN:VCARD\nVERSION:3.0\nFN:Test User\nEND:VCARD', 'file' => 'test_vcard.png']
];

foreach ($tests as $test) {
    $result = QRCode::generate($test['data'], $test['file']);
    $exists = QRCode::exists($test['file']);
    echo "   {$test['file']}: " . ($exists ? '✅' : '❌') . "\n";
}
echo "\n";

// Prueba 3: Estadísticas
echo "5. Estadísticas del directorio QR...\n";
$stats = QRCode::getStats();
echo "   Total archivos: {$stats['total_files']}\n";
echo "   Tamaño total: {$stats['total_size_mb']} MB\n";
echo "   Directorio: {$stats['directory']}\n\n";

// Prueba 4: Generar QR de diferentes tamaños
echo "6. Generando QR de diferentes tamaños...\n";
$sizes = [200, 300, 500];
foreach ($sizes as $size) {
    $filename = "test_size_{$size}.png";
    QRCode::generate('https://miapp.com/test', $filename, $size);
    if (QRCode::exists($filename)) {
        $filepath = 'qr/' . $filename;
        $filesize = filesize($filepath);
        echo "   {$size}x{$size}px: " . round($filesize / 1024, 2) . " KB ✅\n";
    }
}
echo "\n";

// Prueba 5: Verificar método de generación
echo "7. Verificando método de generación usado...\n";
$testFile = 'test_method.png';
$result = QRCode::generate('https://test.com', $testFile);

if (strpos($result, 'chart.googleapis.com') !== false) {
    echo "   Método: Google Charts API ⚠️\n";
    echo "   Nota: phpqrcode no se está usando\n";
} else if (strpos($result, 'qr/') !== false) {
    echo "   Método: phpqrcode (local) ✅\n";
    echo "   Nota: QR guardado localmente\n";
}
echo "\n";

// Prueba 6: Limpiar archivos de prueba
echo "8. Limpiando archivos de prueba...\n";
$testFiles = glob('qr/test_*.png');
$deleted = 0;
foreach ($testFiles as $file) {
    if (unlink($file)) {
        $deleted++;
    }
}
echo "   Archivos eliminados: {$deleted}\n\n";

// Estadísticas finales
echo "9. Estadísticas finales...\n";
$finalStats = QRCode::getStats();
echo "   Total archivos restantes: {$finalStats['total_files']}\n";
echo "   Tamaño total: {$finalStats['total_size_mb']} MB\n\n";

echo "=== Fin de las Pruebas ===\n";
