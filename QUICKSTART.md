# 🚀 Inicio Rápido - BreezeMVC

## Prerrequisitos

Antes de comenzar, asegúrate de tener instalado:

- **PHP 8.0+**
- **MySQL Server** (o acceso a una base de datos MySQL)
- **MySQL Client** (para que `init-project.sh` funcione)

### Instalar MySQL Client

```bash
# macOS
brew install mysql-client
echo 'export PATH="/opt/homebrew/opt/mysql-client/bin:$PATH"' >> ~/.zshrc
source ~/.zshrc

# Linux
sudo apt-get install mysql-client

# Verificar
mysql --version
```

---

## Método Recomendado (Automático)

### 1. Duplicar la carpeta
```bash
cp -r breezemvc mi-nuevo-proyecto
cd mi-nuevo-proyecto
```

### 2. Ejecutar script de inicialización
```bash
./init-project.sh
```

El script te guiará paso a paso para:
- ✅ Configurar credenciales de base de datos
- ✅ Crear archivo `.env` automáticamente
- ✅ Crear tabla de migraciones
- ✅ Aplicar migraciones existentes
- ✅ Generar Modelos y Controladores para tus tablas
- ✅ Configurar URL de la aplicación

### 3. Iniciar servidor
```bash
php -S localhost:8000 -t public/
```

### 4. Verificar instalación
Abre en tu navegador: `http://localhost:8000`

---

## Método Manual (Alternativo)

Si prefieres configurar todo manualmente:

### 1. Copiar archivo de entorno
```bash
cp .env.example .env
nano .env  # Edita con tus credenciales
```

### 2. Crear tabla de migraciones
```bash
mysql -u usuario -p base_datos < database/schema.sql
```

### 3. Aplicar migraciones
```bash
php migrate.php up
```

### 4. Configurar servidor web

#### Opción A: Apache/Nginx (Producción)
Apunta el document root a: `/ruta/completa/mi-nuevo-proyecto/public`

#### Opción B: PHP Built-in Server (Desarrollo)
```bash
php -S localhost:8000 -t public/
```

---

## 📝 Checklist de configuración

### Esencial
- [ ] Ejecutar `./init-project.sh` (o configurar manualmente)
- [ ] Verificar que `.env` tiene las credenciales correctas
- [ ] Confirmar que las migraciones se aplicaron (`php migrate.php status`)
- [ ] Configurar servidor web para apuntar a `/public/`

### Opcional
- [ ] Configurar SMTP para emails (ver `docs/EMAIL_SYSTEM.md`)
- [ ] Configurar Google OAuth (ver `docs/GOOGLE_OAUTH.md`)
- [ ] Eliminar archivos de ejemplo en `public/views/test/`
- [ ] Personalizar branding (ver `docs/BRANDING.md`)

---

## 🛠️ Comandos útiles

```bash
# Migraciones
php migrate.php status              # Ver estado
php migrate.php create nombre       # Crear nueva migración
php migrate.php up                  # Aplicar pendientes
php migrate.php down                # Revertir última

# Generadores de código
php cli.php make:controller ProductoController
php cli.php make:model Producto
php cli.php make:middleware AuthCheck
php cli.php list                    # Ver todos los comandos

# Servidor de desarrollo
php -S localhost:8000 -t public/    # Iniciar servidor
```

---

## 📚 Próximos pasos

1. **Crear tu primer CRUD:** Ver [README.md#inicio-rápido](README.md#-inicio-rápido)
2. **Configurar servicios:** Ver [docs/CONFIGURATION.md](docs/CONFIGURATION.md)
3. **Desplegar a producción:** Ver [docs/DEPLOYMENT.md](docs/DEPLOYMENT.md)

---

## 💡 Consejos

- 🔒 **Seguridad:** Asegúrate de que tu servidor web apunte a `/public/`, no a la raíz
- 📦 **Vendor incluido:** No necesitas ejecutar `composer install`, todo está listo
- 🧹 **Limpieza:** Elimina `public/views/test/` y controladores de ejemplo si no los usas
- 📖 **Documentación:** Revisa `docs/` para guías detalladas de cada característica
