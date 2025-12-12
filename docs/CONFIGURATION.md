# Guía de Configuración - BreezeMVC

Esta guía te ayudará a configurar BreezeMVC con tus propias credenciales y servicios.

---

## 📋 Tabla de Contenidos

1. [Configuración de Base de Datos](#1-configuración-de-base-de-datos)
2. [Configuración de Email (SMTP)](#2-configuración-de-email-smtp)
3. [Google OAuth (Opcional)](#3-google-oauth-opcional)
4. [Google Maps API (Opcional)](#4-google-maps-api-opcional)
5. [Variables de Entorno (.env)](#5-variables-de-entorno-env)

---

## 1. Configuración de Base de Datos

### Opción A: Configuración Directa (Desarrollo)

Edita el archivo `src/config/database.php`:

```php
private const DB_HOST = 'localhost';        // Tu servidor MySQL
private const DB_USER = 'tu_usuario';       // Tu usuario de MySQL
private const DB_PASS = 'tu_password';      // Tu contraseña de MySQL
private const DB_NAME = 'tu_base_datos';    // Nombre de tu base de datos
```

### Opción B: Usando .env (Recomendado para Producción)

1. Copia el archivo de ejemplo:
```bash
cp .env.example .env
```

2. Edita `.env` con tus credenciales:
```env
DB_HOST=localhost
DB_USER=mi_usuario
DB_PASS=mi_password_seguro
DB_NAME=mi_base_datos
```

> [!IMPORTANT]
> El archivo `.env` está en `.gitignore` y NO se subirá a Git. Esto protege tus credenciales.

### Crear la Base de Datos

```bash
# Opción 1: Desde terminal
mysql -u root -p
CREATE DATABASE tu_base_datos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;

# Opción 2: Importar schema
mysql -u tu_usuario -p tu_base_datos < database/schema.sql
```

### Ejecutar Migraciones

```bash
# Ver estado de migraciones
php migrate.php status

# Ejecutar todas las migraciones pendientes
php migrate.php up
```

---

## 2. Configuración de Email (SMTP)

Para que el sistema de recuperación de contraseña y notificaciones funcione, configura tu servidor SMTP.

### Proveedores Populares

#### Gmail
```php
public const SMTP_HOST = 'smtp.gmail.com';
public const SMTP_USERNAME = 'tu-email@gmail.com';
public const SMTP_PASSWORD = 'tu_app_password'; // Usar App Password, no tu contraseña normal
```

**Obtener App Password de Gmail:**
1. Ve a [myaccount.google.com](https://myaccount.google.com)
2. Seguridad → Verificación en 2 pasos (actívala)
3. Contraseñas de aplicaciones → Generar nueva
4. Usa esa contraseña en `SMTP_PASSWORD`

#### SendGrid
```php
public const SMTP_HOST = 'smtp.sendgrid.net';
public const SMTP_USERNAME = 'apikey';
public const SMTP_PASSWORD = 'TU_SENDGRID_API_KEY';
```

#### Mailgun
```php
public const SMTP_HOST = 'smtp.mailgun.org';
public const SMTP_USERNAME = 'postmaster@tu-dominio.mailgun.org';
public const SMTP_PASSWORD = 'TU_MAILGUN_PASSWORD';
```

#### Hosting Compartido (cPanel)
```php
public const SMTP_HOST = 'mail.tudominio.com';
public const SMTP_USERNAME = 'noreply@tudominio.com';
public const SMTP_PASSWORD = 'tu_password_email';
```

### Probar Configuración de Email

Usa el script de prueba incluido:

```bash
php tests/test_email.php
```

---

## 3. Google OAuth (Opcional)

Si quieres permitir login con Google, sigue estos pasos:

### Paso 1: Crear Proyecto en Google Cloud

1. Ve a [Google Cloud Console](https://console.cloud.google.com/)
2. Crea un nuevo proyecto o selecciona uno existente
3. Habilita la API de Google+ (Google+ API)

### Paso 2: Crear Credenciales OAuth

1. Ve a **APIs & Services** → **Credentials**
2. Click en **Create Credentials** → **OAuth client ID**
3. Tipo de aplicación: **Web application**
4. Nombre: `BreezeMVC`
5. **Authorized redirect URIs:**
   ```
   http://localhost:8000/auth/google/callback
   https://tudominio.com/auth/google/callback
   ```
6. Click **Create**
7. Copia el **Client ID** y **Client Secret**

### Paso 3: Configurar en BreezeMVC

Edita `src/integrations/GoogleAuth.php`:

```php
private const GOOGLE_CLIENT_ID = 'TU_CLIENT_ID.apps.googleusercontent.com';
private const GOOGLE_CLIENT_SECRET = 'TU_CLIENT_SECRET';
private const REDIRECT_URI = 'http://localhost:8000/auth/google/callback';
```

### Documentación Completa

Ver: [docs/GOOGLE_SIGNIN_SETUP.md](GOOGLE_SIGNIN_SETUP.md)

---

## 4. Google Maps API (Opcional)

Si tu aplicación usa mapas o geolocalización:

### Obtener API Key

1. Ve a [Google Cloud Console](https://console.cloud.google.com/)
2. **APIs & Services** → **Credentials**
3. **Create Credentials** → **API Key**
4. Restringe la key a tu dominio (recomendado)
5. Habilita las APIs necesarias:
   - Maps JavaScript API
   - Geocoding API
   - Places API (si la necesitas)

### Configurar en BreezeMVC

Edita `src/config/database.php`:

```php
public const GOOGLE_MAPS_API_KEY = 'TU_GOOGLE_MAPS_API_KEY';
```

---

## 5. Variables de Entorno (.env)

### Crear tu archivo .env

```bash
cp .env.example .env
```

### Ejemplo de .env Completo

```env
# Base de Datos
DB_HOST=localhost
DB_USER=breezemvc_user
DB_PASS=password_seguro_123
DB_NAME=breezemvc_db

# SMTP
SMTP_HOST=smtp.gmail.com
SMTP_USERNAME=miapp@gmail.com
SMTP_PASSWORD=abcd efgh ijkl mnop

# Google OAuth
GOOGLE_CLIENT_ID=123456789-abc.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-abcdefghijklmnop
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# Google Maps
GOOGLE_MAPS_API_KEY=AIzaSyABCDEFGHIJKLMNOPQRSTUVWXYZ

# App
APP_NAME=Mi Aplicación
APP_ENV=production
APP_DEBUG=false
APP_URL=https://midominio.com
```

### Implementar Carga de .env (Futuro)

Actualmente BreezeMVC usa constantes en `database.php`. Si quieres usar `.env`:

**Opción 1: Librería vlucas/phpdotenv**
```bash
composer require vlucas/phpdotenv
```

**Opción 2: Función personalizada simple**
```php
// En src/utils/Utils.php
public static function loadEnv(string $path): void
{
    if (!file_exists($path)) return;
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        if (!array_key_exists($name, $_ENV)) {
            $_ENV[$name] = $value;
            putenv("$name=$value");
        }
    }
}
```

---

## 🔒 Seguridad

### ✅ Buenas Prácticas

1. **Nunca subas `.env` a Git**
   - Ya está en `.gitignore`
   - Verifica antes de hacer commit

2. **Usa contraseñas fuertes**
   - Mínimo 12 caracteres
   - Combina letras, números y símbolos

3. **Diferentes credenciales por entorno**
   - Desarrollo: credenciales locales
   - Producción: credenciales seguras diferentes

4. **Rotar credenciales regularmente**
   - Cambia passwords cada 3-6 meses
   - Especialmente después de que alguien deje el equipo

### ❌ Nunca Hagas Esto

- ❌ Subir credenciales a GitHub
- ❌ Compartir passwords por email/Slack
- ❌ Usar la misma password en desarrollo y producción
- ❌ Hardcodear API keys en el código

---

## 🧪 Verificar Configuración

### Script de Verificación

Crea `tests/verify_config.php`:

```php
<?php
require_once __DIR__ . '/../index.php';

use src\config\Database;

echo "=== Verificación de Configuración ===\n\n";

// 1. Base de datos
try {
    $conn = Database::getConnection();
    echo "✅ Conexión a base de datos: OK\n";
} catch (Exception $e) {
    echo "❌ Conexión a base de datos: FALLO\n";
    echo "   Error: " . $e->getMessage() . "\n";
}

// 2. SMTP
if (Database::SMTP_HOST !== 'smtp.tu-proveedor.com') {
    echo "✅ SMTP configurado\n";
} else {
    echo "⚠️  SMTP no configurado (usando valores por defecto)\n";
}

// 3. Google OAuth
if (strpos(Database::GOOGLE_CLIENT_ID ?? '', 'TU_CLIENT_ID') === false) {
    echo "✅ Google OAuth configurado\n";
} else {
    echo "⚠️  Google OAuth no configurado\n";
}

echo "\n=== Verificación Completa ===\n";
```

Ejecutar:
```bash
php tests/verify_config.php
```

---

## 📞 Soporte

¿Problemas con la configuración?

- 📖 [Documentación completa](../README.md)
- 🐛 [Reportar issue](https://github.com/mikeoliveradev/breezemvc/issues)
- 📧 Email: rinoceronte.digital@gmail.com

---

**Última actualización:** Noviembre 2025  
**Versión:** 1.0
