<?php
// examples/qrcode_examples.php
// Ejemplos de uso de la clase QRCode

require_once __DIR__ . '/../index.php';

use src\utils\QRCode;

echo "=== Ejemplos de Uso de QRCode ===\n\n";

// ============================================
// Ejemplo 1: Generar URL directa (sin guardar)
// ============================================
echo "1. Generar URL directa (Google Charts)\n";
echo "   Uso: Cuando no necesitas guardar el QR\n\n";

$url = QRCode::generate('https://miapp.com/mascota/abc123');
echo "   URL generada: {$url}\n";
echo "   HTML: <img src='{$url}' alt='QR Code'>\n\n";

// ============================================
// Ejemplo 2: Guardar QR localmente
// ============================================
echo "2. Guardar QR localmente\n";
echo "   Uso: Cuando necesitas el QR offline\n\n";

$filepath = QRCode::generate(
    'https://miapp.com/mascota/def456',
    'mascota_def456.png'
);
echo "   Archivo guardado en: {$filepath}\n";
echo "   HTML: <img src='{$filepath}' alt='QR Code'>\n\n";

// ============================================
// Ejemplo 3: QR en base64 (embed directo)
// ============================================
echo "3. QR en base64 (embed directo en HTML)\n";
echo "   Uso: Cuando quieres embed sin archivo externo\n\n";

$base64 = QRCode::generateBase64('https://miapp.com/mascota/ghi789');
echo "   Base64 generado (primeros 50 chars): " . substr($base64, 0, 50) . "...\n";
echo "   HTML: <img src='{$base64}' alt='QR Code'>\n\n";

// ============================================
// Ejemplo 4: Generar código único
// ============================================
echo "4. Generar código único para QR\n";
echo "   Uso: Para crear identificadores únicos\n\n";

$code1 = QRCode::generateUniqueCode();
$code2 = QRCode::generateUniqueCode(32); // Más largo
echo "   Código 16 chars: {$code1}\n";
echo "   Código 32 chars: {$code2}\n\n";

// ============================================
// Ejemplo 5: Verificar si existe un QR
// ============================================
echo "5. Verificar si existe un QR\n\n";

$exists = QRCode::exists('mascota_def456.png');
echo "   ¿Existe 'mascota_def456.png'? " . ($exists ? 'SÍ' : 'NO') . "\n\n";

// ============================================
// Ejemplo 6: Obtener URL de QR guardado
// ============================================
echo "6. Obtener URL de QR guardado\n\n";

$qrUrl = QRCode::getURL('mascota_def456.png');
echo "   URL: " . ($qrUrl ?? 'No existe') . "\n\n";

// ============================================
// Ejemplo 7: Estadísticas del directorio
// ============================================
echo "7. Estadísticas del directorio de QR\n\n";

$stats = QRCode::getStats();
echo "   Total archivos: {$stats['total_files']}\n";
echo "   Tamaño total: {$stats['total_size_mb']} MB\n";
echo "   Directorio: {$stats['directory']}\n\n";

// ============================================
// Ejemplo 8: Uso en aplicación real (Mascotas)
// ============================================
echo "8. Ejemplo de uso en aplicación de mascotas\n\n";

// Simular registro de mascota
$mascotaId = 123;
$codigoQR = QRCode::generateUniqueCode();
$landingURL = "https://miapp.com/mascota/landing/{$codigoQR}";

// Generar y guardar QR
$qrPath = QRCode::generate($landingURL, "mascota_{$mascotaId}.png");

echo "   Mascota ID: {$mascotaId}\n";
echo "   Código QR: {$codigoQR}\n";
echo "   Landing URL: {$landingURL}\n";
echo "   QR guardado en: {$qrPath}\n\n";

// ============================================
// Ejemplo 9: QR con datos vCard (Contacto)
// ============================================
echo "9. QR con vCard (Tarjeta de contacto)\n\n";

$vcard = "BEGIN:VCARD\n";
$vcard .= "VERSION:3.0\n";
$vcard .= "FN:Juan Pérez\n";
$vcard .= "TEL:+52 55 1234 5678\n";
$vcard .= "EMAIL:juan@example.com\n";
$vcard .= "END:VCARD";

$vcardQR = QRCode::generate($vcard, 'contacto_juan.png');
echo "   vCard QR generado: {$vcardQR}\n\n";

// ============================================
// Ejemplo 10: QR con WiFi
// ============================================
echo "10. QR con credenciales WiFi\n\n";

$wifi = "WIFI:T:WPA;S:MiRedWiFi;P:MiPassword123;;";
$wifiQR = QRCode::generate($wifi, 'wifi_oficina.png');
echo "   WiFi QR generado: {$wifiQR}\n";
echo "   Al escanear, se conectará automáticamente a la red\n\n";

// ============================================
// Ejemplo 11: Limpiar QR antiguos
// ============================================
echo "11. Limpiar QR antiguos (mantenimiento)\n\n";

$deleted = QRCode::cleanOldQRs(30); // Eliminar QR de más de 30 días
echo "   QR eliminados: {$deleted}\n\n";

echo "=== Fin de los Ejemplos ===\n";
