# Guía de Deployment - BreezeMVC

Esta guía te ayudará a subir tu aplicación BreezeMVC a un servidor de producción.

---

## 📋 Tabla de Contenidos

1. [Archivos a Subir](#archivos-a-subir)
2. [Archivos a NO Subir](#archivos-a-no-subir)
3. [Preparación Pre-Deployment](#preparación-pre-deployment)
4. [Configuración en Servidor](#configuración-en-servidor)
5. [Checklist de Seguridad](#checklist-de-seguridad)
6. [Troubleshooting](#troubleshooting)

---

## 📦 Archivos a Subir

### ✅ Carpetas y Archivos Esenciales

```
breezemvc/
├── .htaccess                    ✅ SUBIR (rewrite rules)
├── index.php                    ✅ SUBIR (front controller)
├── cli.php                      ✅ SUBIR (comandos CLI)
├── migrate.php                  ✅ SUBIR (migraciones)
│
├── src/                         ✅ SUBIR TODO
│   ├── cli/
│   ├── config/
│   ├── controllers/
│   ├── integrations/
│   ├── middleware/
│   ├── models/
│   └── utils/
│
├── public/                      ✅ SUBIR TODO
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   ├── views/
│   └── 404.html
│
├── database/                    ✅ SUBIR TODO
│   ├── migrations/
│   ├── schema.sql
│   └── usuarios.sql
│
├── storage/                     ✅ SUBIR (estructura)
│   └── cache/
│       └── .gitkeep
│
└── vendor/                      ✅ SUBIR (si usas PHPMailer)
    └── PHPMailer/
```

### 📄 Archivos de Configuración

```
✅ .htaccess              - Rewrite rules de Apache
✅ .env                   - TU archivo .env con credenciales REALES
                           (créalo en el servidor, NO subas el de desarrollo)
```

---

## ❌ Archivos a NO Subir

### Archivos de Desarrollo

```
❌ .env.example           - Solo es plantilla
❌ .git/                  - Historial de Git
❌ .gitignore             - Configuración de Git
❌ .DS_Store              - Archivos de macOS
❌ .vscode/               - Configuración de VS Code
❌ node_modules/          - Dependencias de Node (si las tienes)
❌ composer.json          - Solo para desarrollo
❌ package.json           - Solo para desarrollo
❌ README.md              - Documentación (opcional)
❌ LICENSE                - Licencia (opcional)
```

### Archivos de Documentación (Opcionales)

```
❌ docs/                  - Guías y documentación
❌ examples/              - Ejemplos de código
❌ tests/                 - Scripts de prueba
```

---

## 🔧 Preparación Pre-Deployment

### 1. Verificar Configuración Local

```bash
# Ejecutar verificación
php tests/verify_config.php

# Asegurarte de que todo funciona
php -S localhost:8000
```

### 2. Limpiar Archivos Temporales

```bash
# Limpiar caché
rm -rf storage/cache/*
touch storage/cache/.gitkeep

# Limpiar logs (si los tienes)
rm -rf storage/logs/*.log
```

### 3. Crear Backup de Base de Datos

```bash
# Exportar estructura y datos
mysqldump -u usuario -p nombre_bd > backup_$(date +%Y%m%d).sql
```

---

## 🚀 Configuración en Servidor

### Opción A: Subir vía FTP/SFTP

#### 1. Conectar al Servidor

Usa un cliente FTP como:
- **FileZilla** (gratis)
- **Cyberduck** (gratis)
- **Transmit** (Mac, de pago)

#### 2. Estructura Recomendada

```
/public_html/                    (o /www/ o /htdocs/)
├── .htaccess
├── index.php
├── cli.php
├── migrate.php
├── src/
├── public/
├── database/
├── storage/
└── vendor/
```

#### 3. Subir Archivos

1. Selecciona las carpetas/archivos listados en "Archivos a Subir"
2. Arrastra a `/public_html/` (o la carpeta raíz de tu hosting)
3. Espera a que termine la transferencia

### Opción B: Subir vía SSH/Terminal

```bash
# Conectar al servidor
ssh usuario@tuservidor.com

# Navegar a la carpeta web
cd /public_html/

# Clonar desde Git (si usas Git)
git clone https://github.com/tuusuario/tu-proyecto.git .

# O subir con rsync desde tu máquina local
rsync -avz --exclude='.git' --exclude='node_modules' \
  /ruta/local/breezemvc/ usuario@servidor:/public_html/
```

---

## ⚙️ Configuración Post-Upload

### 1. Crear Archivo .env en el Servidor

**NO subas tu .env local con credenciales de desarrollo**

```bash
# Conectar por SSH o usar el File Manager del hosting
cd /public_html/

# Crear .env nuevo
nano .env
```

Contenido del `.env` de producción:

```env
# Base de Datos (credenciales del hosting)
DB_HOST=localhost                    # O la IP del servidor MySQL
DB_USER=usuario_produccion
DB_PASS=password_seguro_produccion
DB_NAME=base_datos_produccion

# SMTP (configuración real)
SMTP_HOST=smtp.gmail.com
SMTP_USERNAME=tu-email@gmail.com
SMTP_PASSWORD=tu_app_password_real

# Google OAuth (credenciales de producción)
GOOGLE_CLIENT_ID=TU_CLIENT_ID_REAL.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=TU_CLIENT_SECRET_REAL
GOOGLE_REDIRECT_URI=https://tudominio.com/auth/google/callback

# App (configuración de producción)
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tudominio.com
```

### 2. Configurar database.php

Edita `src/config/database.php` con las credenciales del servidor:

```php
private const DB_HOST = 'localhost';              // O IP del servidor
private const DB_USER = 'usuario_hosting';
private const DB_PASS = 'password_hosting';
private const DB_NAME = 'nombre_bd_hosting';
```

### 3. Configurar Permisos

```bash
# Dar permisos de escritura a storage/cache
chmod 755 storage/cache

# Verificar permisos del .htaccess
chmod 644 .htaccess
```

### 4. Crear Base de Datos

**Opción A: Panel de Control (cPanel/Plesk)**

1. Ir a "MySQL Databases" o "Bases de Datos"
2. Crear nueva base de datos
3. Crear usuario y asignar privilegios
4. Importar `database/schema.sql`

**Opción B: Terminal/SSH**

```bash
# Crear base de datos
mysql -u root -p
CREATE DATABASE nombre_bd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'usuario'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON nombre_bd.* TO 'usuario'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Importar schema
mysql -u usuario -p nombre_bd < database/schema.sql
```

### 5. Ejecutar Migraciones

```bash
# Por SSH
php migrate.php up

# O desde navegador (si creas un script)
https://tudominio.com/migrate.php?action=up&key=TU_CLAVE_SECRETA
```

### 6. Verificar Configuración

```bash
# Ejecutar script de verificación
php tests/verify_config.php
```

---

## 🔒 Checklist de Seguridad

### Antes de Publicar

- [ ] ✅ `.env` tiene credenciales de PRODUCCIÓN (no desarrollo)
- [ ] ✅ `APP_DEBUG=false` en producción
- [ ] ✅ Passwords fuertes en base de datos
- [ ] ✅ HTTPS configurado (certificado SSL)
- [ ] ✅ Permisos correctos en archivos (644) y carpetas (755)
- [ ] ✅ `storage/cache/` es escribible
- [ ] ✅ `.htaccess` funciona correctamente
- [ ] ✅ Google OAuth redirect URI apunta a dominio real
- [ ] ✅ SMTP configurado con credenciales reales

### Protección Adicional

#### Proteger archivos sensibles

Agregar al `.htaccess`:

```apache
# Proteger archivos de configuración
<FilesMatch "^\.env">
    Order allow,deny
    Deny from all
</FilesMatch>

# Proteger archivos PHP de configuración
<FilesMatch "^(database\.php|config\.php)$">
    Order allow,deny
    Deny from all
</FilesMatch>
```

#### Deshabilitar listado de directorios

```apache
# Evitar que se listen archivos
Options -Indexes
```

---

## 🌐 Configuración de Dominio

### Si tu dominio apunta a una subcarpeta

**Problema:** Tu dominio está en `/public_html/miapp/` pero quieres que se vea como `https://tudominio.com`

**Solución 1: Subdomain**
Crear un subdominio que apunte directamente a `/public_html/miapp/`

**Solución 2: .htaccess en raíz**

En `/public_html/.htaccess`:
```apache
RewriteEngine On
RewriteCond %{REQUEST_URI} !^/miapp/
RewriteRule ^(.*)$ /miapp/$1 [L]
```

---

## 🐛 Troubleshooting

### Error: "500 Internal Server Error"

**Causa:** Problema con `.htaccess`

**Solución:**
```bash
# Verificar que mod_rewrite está habilitado
# Contactar al hosting si no lo está

# Verificar sintaxis del .htaccess
# Probar con .htaccess vacío y agregar reglas una por una
```

### Error: "Cannot connect to database"

**Causa:** Credenciales incorrectas

**Solución:**
```bash
# Verificar credenciales en src/config/database.php
# Verificar que el usuario tiene permisos
# Verificar que MySQL está corriendo
```

### Error: "Permission denied" en storage/cache

**Causa:** Permisos incorrectos

**Solución:**
```bash
chmod 755 storage/cache
chown www-data:www-data storage/cache  # En algunos servidores
```

### Las rutas no funcionan (404 en todo)

**Causa:** `.htaccess` no funciona o mod_rewrite deshabilitado

**Solución:**
```bash
# Verificar que .htaccess se subió correctamente
# Contactar al hosting para habilitar mod_rewrite
# Verificar AllowOverride en configuración de Apache
```

---

## 📊 Resumen Rápido

### Archivos Mínimos Necesarios

```
✅ .htaccess
✅ index.php
✅ src/ (todo)
✅ public/ (todo)
✅ database/ (todo)
✅ storage/cache/
✅ vendor/PHPMailer/ (si usas email)
```

### Pasos Esenciales

1. ✅ Subir archivos al servidor
2. ✅ Crear `.env` con credenciales de producción
3. ✅ Configurar `database.php`
4. ✅ Crear base de datos
5. ✅ Ejecutar migraciones
6. ✅ Configurar permisos
7. ✅ Verificar que funciona

---

## 📞 Soporte

¿Problemas con el deployment?

- 📖 [Documentación](../README.md)
- 🐛 [Reportar issue](https://github.com/mikeoliveradev/breezemvc/issues)
- 📧 Email: rinoceronte.digital@gmail.com

---

## 🎯 Hosting Recomendados

### Compartido (Económico)
- **Hostinger** - Desde $2/mes
- **SiteGround** - Desde $3/mes
- **DreamHost** - Desde $3/mes

### VPS (Más Control)
- **DigitalOcean** - Desde $5/mes
- **Linode** - Desde $5/mes
- **Vultr** - Desde $5/mes

### Requisitos Mínimos
- PHP 8.0+
- MySQL 5.7+
- mod_rewrite habilitado
- 256MB RAM mínimo

---

**Última actualización:** Noviembre 2025  
**Versión:** 1.0
