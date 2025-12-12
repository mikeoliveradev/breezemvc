# Sistema de Códigos QR - BreezeMVC

Sistema híbrido para generar códigos QR sin dependencias externas.

---

## 🎯 Características

- ✅ **Sin dependencias** - Funciona sin Composer
- ✅ **Híbrido** - Google Charts API + phpqrcode (opcional)
- ✅ **Múltiples formatos** - URL, archivo, base64
- ✅ **Fácil de usar** - API simple
- ✅ **Limpieza automática** - Elimina QR antiguos

---

## 🚀 Uso Básico

### Generar QR con Google Charts API

```php
use src\utils\QRCode;

// Generar URL directa (no guarda archivo)
$qrUrl = QRCode::generate('https://miapp.com/producto/123');

// Usar en HTML
echo "<img src='{$qrUrl}' alt='QR Code'>";
```

### Guardar QR como Archivo

```php
// Guardar en storage/qrcodes/
$filename = QRCode::generateFile('https://miapp.com/producto/123');

// Usar el archivo
echo "<img src='/storage/qrcodes/{$filename}' alt='QR'>";
```

### Generar Base64

```php
// Para embeber directamente en HTML
$base64 = QRCode::generateBase64('https://miapp.com/producto/123');

echo "<img src='{$base64}' alt='QR'>";
```

---

## 📝 Ejemplos Completos

### En un Controlador

```php
// src/controllers/ProductoController.php
public function show(int $id): void
{
    $producto = Producto::find($id);
    $productoUrl = "https://miapp.com/producto/{$id}";
    
    // Generar QR
    $qrCode = QRCode::generate($productoUrl);
    
    $this->render('views/productos/show', [
        'producto' => $producto,
        'qrCode' => $qrCode
    ]);
}
```

### En una Vista

```php
<!-- public/views/productos/show.php -->
<div class="producto">
    <h1><?= $producto->nombre ?></h1>
    <p><?= $producto->descripcion ?></p>
    
    <!-- QR Code -->
    <div class="qr-code">
        <img src="<?= $qrCode ?>" alt="QR del producto">
        <p>Escanea para compartir</p>
    </div>
</div>
```

---

## ⚙️ Configuración

### Tamaños Disponibles

```php
// Pequeño (150x150)
$qr = QRCode::generate($url, 150);

// Mediano (300x300) - Por defecto
$qr = QRCode::generate($url);

// Grande (500x500)
$qr = QRCode::generate($url, 500);
```

### Limpieza Automática

Los QR guardados como archivos se eliminan automáticamente después de 7 días.

```php
// Ejecutar limpieza manual
QRCode::cleanup();

// Cambiar días de retención (en la clase)
private const RETENTION_DAYS = 7;
```

---

## 🔧 Implementación Alternativa

Si prefieres usar phpqrcode (librería local):

1. Descarga phpqrcode
2. Coloca en `vendor/phpqrcode/`
3. Usa el método alternativo:

```php
$qr = QRCode::generateWithPhpQrCode($url);
```

---

## 📊 Comparación de Métodos

| Método | Ventajas | Desventajas |
|--------|----------|-------------|
| **Google Charts** | Sin archivos, rápido | Requiere internet |
| **phpqrcode** | Offline, más control | Requiere librería |
| **Base64** | Embebido en HTML | Aumenta tamaño HTML |

---

## 🎯 Casos de Uso

### 1. Compartir Productos

```php
$qr = QRCode::generate("https://mitienda.com/producto/{$id}");
```

### 2. Tickets/Entradas

```php
$ticketUrl = "https://eventos.com/ticket/{$ticketId}";
$qr = QRCode::generateFile($ticketUrl);
```

### 3. Información de Contacto (vCard)

```php
$vcard = "BEGIN:VCARD\nVERSION:3.0\nFN:Juan Pérez\nEND:VCARD";
$qr = QRCode::generate($vcard);
```

### 4. WiFi

```php
$wifi = "WIFI:T:WPA;S:MiRed;P:MiPassword;;";
$qr = QRCode::generate($wifi);
```

---

## 📞 Soporte

- 📖 [Documentación](../README.md)
- 🐛 [Reportar issue](https://github.com/mikeoliveradev/breezemvc/issues)
- 📧 Email: rinoceronte.digital@gmail.com

---

**Última actualización:** Noviembre 2025  
**Versión:** 1.0
