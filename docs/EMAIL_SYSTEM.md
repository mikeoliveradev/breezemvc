# Sistema de Emails Híbrido

El sistema de emails detecta automáticamente si PHPMailer está disponible y usa el mejor método.

## Detección Automática

```php
$mailer = new Mailer();
$driver = $mailer->getDriver();

// Retorna: 'phpmailer' o 'native'
```

**Si PHPMailer existe:**
- ✅ Usa SMTP configurado en `Database.php`
- ✅ Más confiable
- ✅ Mejor deliverability

**Si PHPMailer NO existe:**
- ✅ Usa `mail()` nativo de PHP
- ✅ Funciona sin dependencias
- ✅ Perfecto para desarrollo

---

## Instalación de PHPMailer (Opcional)

### Opción 1: Manual (Sin Composer)

1. Descarga PHPMailer desde: https://github.com/PHPMailer/PHPMailer
2. Copia la carpeta `src` a `/vendor/PHPMailer/src/`
3. ¡Listo! El sistema lo detectará automáticamente

**Estructura esperada:**
```
/vendor/PHPMailer/src/
    PHPMailer.php
    SMTP.php
    Exception.php
```

### Opción 2: Con Composer (Si decides usarlo)

```bash
composer require phpmailer/phpmailer
```

---

## Configuración SMTP

Edita `src/config/database.php`:

```php
const SMTP_HOST = 'smtp.gmail.com';
const SMTP_USER = 'tu@email.com';
const SMTP_PASS = 'tu-password-app';  // Password de aplicación
const SMTP_PORT = 587;
```

### Gmail

1. Habilita "Verificación en 2 pasos"
2. Genera una "Contraseña de aplicación"
3. Usa esa contraseña en `SMTP_PASS`

### Otros Proveedores

| Proveedor | SMTP_HOST | SMTP_PORT |
|-----------|-----------|-----------|
| Gmail | smtp.gmail.com | 587 |
| Outlook | smtp-mail.outlook.com | 587 |
| SendGrid | smtp.sendgrid.net | 587 |
| Mailgun | smtp.mailgun.org | 587 |

---

## Uso

### Email Simple

```php
use src\utils\Mailer;

$mailer = new Mailer();
$mailer->send('usuario@example.com', 'Asunto', '<h1>Hola</h1>');
```

### Email con Template

```php
$mailer = new Mailer();
$mailer->sendTemplate('usuario@example.com', 'Bienvenido', 'welcome', [
    'nombre' => 'Juan Pérez',
    'login_url' => '/auth/login'
]);
```

### Cambiar Remitente

```php
$mailer = new Mailer();
$mailer->setFrom('ventas@tuempresa.com', 'Equipo de Ventas')
       ->send('cliente@example.com', 'Asunto', 'Mensaje');
```

---

## Templates Disponibles

### 1. `welcome` - Bienvenida
Variables: `$nombre`, `$login_url`

### 2. `password_reset` - Recuperación de Contraseña
Variables: `$nombre`, `$token`, `$url`

### 3. `email_base` - Template Base
Variables: `$app_name`, `$content`

---

## Crear Nuevos Templates

1. Crea archivo en `public/views/emails/mi_template.php`
2. Usa HTML inline (requerido para emails)
3. Accede a variables con `<?php echo $variable; ?>`

**Ejemplo:**
```php
<!-- public/views/emails/mi_template.php -->
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial; }
        .btn { background: #667eea; color: white; padding: 10px; }
    </style>
</head>
<body>
    <h1>Hola, <?php echo $nombre; ?>!</h1>
    <p><?php echo $mensaje; ?></p>
</body>
</html>
```

**Uso:**
```php
$mailer->sendTemplate('user@example.com', 'Asunto', 'mi_template', [
    'nombre' => 'Juan',
    'mensaje' => 'Contenido personalizado'
]);
```

---

## Pruebas

### Verificar Driver

```bash
php tests/test_mailer.php
```

### Enviar Email de Prueba

```php
use src\utils\Mailer;

Mailer::sendTest('tu@email.com');
```

---

## Solución de Problemas

### PHPMailer no se detecta

**Verifica:**
```bash
ls -la vendor/PHPMailer/src/PHPMailer.php
```

Debe existir el archivo.

### Emails no llegan (mail() nativo)

1. Verifica que `sendmail` esté configurado en `php.ini`
2. Revisa logs: `tail -f /var/log/mail.log`
3. Considera usar PHPMailer con SMTP

### Error SMTP con PHPMailer

1. Verifica credenciales en `Database.php`
2. Usa contraseña de aplicación (no tu contraseña normal)
3. Verifica que el puerto esté abierto (587 o 465)

### Emails van a spam

1. Configura SPF, DKIM y DMARC en tu dominio
2. Usa un servicio SMTP profesional (SendGrid, Mailgun)
3. Evita palabras spam en el asunto

---

## Ventajas del Sistema Híbrido

✅ **Funciona siempre** - Con o sin PHPMailer
✅ **Cero configuración** - Detección automática
✅ **Flexible** - Cambia de driver sin tocar código
✅ **Producción-ready** - SMTP cuando lo necesites
✅ **Desarrollo fácil** - mail() nativo para pruebas locales
