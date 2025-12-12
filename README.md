# BreezeMVC

> Una plantilla PHP moderna, ligera y profesional con arquitectura MVC. Desarrollo ágil sin complicaciones.

[![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![BreezeMVC](https://img.shields.io/badge/BreezeMVC-v1.0-00D4FF.svg)](https://github.com/mikeoliveradev/breezemvc)

---

## 📋 Tabla de Contenidos

- [¿Por qué esta plantilla?](#-por-qué-esta-plantilla)
- [Características](#-características)
- [Requisitos](#-requisitos)
- [Instalación](#-instalación)
- [Inicio Rápido](#-inicio-rápido)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Documentación](#-documentación)
- [Comparación con Frameworks](#-comparación-con-frameworks)
- [Contribuir](#-contribuir)

---

## 🎯 ¿Por qué esta plantilla?

### El Problema

Los frameworks modernos como Laravel, Symfony o CodeIgniter son excelentes, pero:

- ❌ **Pesados** - Requieren ~80MB y miles de archivos
- ❌ **Complejos** - Curva de aprendizaje pronunciada
- ❌ **Overkill** - Demasiadas características para proyectos pequeños/medianos
- ❌ **Dependencias** - Requieren Composer y configuración compleja
- ❌ **Hosting** - No funcionan en hosting compartido básico

### Nuestra Solución

Una plantilla **vanilla PHP** con las mejores características de los frameworks, pero:

- ✅ **Ligera** - Solo ~160 archivos core, ~54MB (vs 1.8GB de Laravel)
- ✅ **Simple** - Fácil de entender y mantener
- ✅ **Suficiente** - Todo lo necesario para el 80% de proyectos
- ✅ **Zero Composer** - 100% PHP nativo, dependencias incluidas
- ✅ **Flexible** - Hosting compartido o VPS
- ✅ **Componentes Reutilizables** - Sistema de componentes UI modernos

### Filosofía

> "No uses un camión de 18 ruedas para ir al supermercado"

Esta plantilla es perfecta para:
- 👨‍💻 Desarrolladores freelance
- 🏢 Agencias pequeñas/medianas
- 🚀 Startups con presupuesto limitado
- 📚 Aprendizaje de arquitectura MVC
- ⚡ Proyectos que necesitan velocidad de desarrollo

---

## ✨ Características

### Core

- 🏗️ **Arquitectura MVC** - Separación clara de responsabilidades
- 🔄 **Router Dinámico** - Front Controller con rutas limpias
- 📦 **ORM Simple** - CRUD básico sin complejidad
- 🔐 **Autoloading Nativo** - PSR-4 sin Composer
- 🎨 **Templates** - Sistema de vistas con layouts
- 🚀 **Script de Inicialización** - Configuración automática en segundos

### Sistemas Avanzados

#### 1. Sistema de Validación
```php
$validator = new Validator($_POST);
$validator->required(['email', 'password'])
          ->email('email')
          ->min('password', 6);
```

**JavaScript (Client-Side):**
```html
<input data-validate="required|email|min:6">
```

#### 2. CLI Helper
```bash
php cli.php make:controller ProductoController
php cli.php make:model Producto
```

#### 3. Emails Híbrido
- PHPMailer 6.12 (SMTP) + mail() nativo
- Templates HTML responsive
- Recuperación de contraseña completa

#### 4. Migraciones de BD
```bash
php migrate.php create add_column
php migrate.php up
php migrate.php down
```

#### 5. Sistema de Caché
```php
$cache->remember('productos', function() {
    return Producto::all();
}, 3600);
```

#### 6. Componentes Reutilizables
```php
use src\utils\ComponentHelper;

// Renderizar componentes UI modernos
ComponentHelper::render('ui/alert', [
    'type' => 'success',
    'message' => 'Operación exitosa'
]);

ComponentHelper::render('ui/modal', [
    'id' => 'confirmModal',
    'title' => 'Confirmar',
    'content' => '<p>¿Continuar?</p>'
]);
```

**Componentes Disponibles:**
- Autenticación: login-form, register-form, forgot-password-form, reset-password-form
- UI: alert, modal, card, breadcrumb

### Autenticación Completa

- ✅ Login tradicional (email/password)
- ✅ Registro de usuarios
- ✅ Google Sign-In (OAuth 2.0)
- ✅ Recuperación de contraseña por email
- ✅ Middleware de protección de rutas
- ✅ Formularios modernos con validación integrada

---

## 📦 Requisitos

- **PHP:** 8.0 o superior
- **MySQL:** 5.7 o superior
- **MySQL Client:** Recomendado para usar `init-project.sh` (ver instalación abajo)
- **Extensiones PHP:**
  - `mysqli` (requerido)
  - `session` (requerido)
  - `redis` (opcional, para caché)

### Instalar MySQL Client (Recomendado)

Para que el script de inicialización funcione correctamente:

```bash
# macOS (Homebrew)
brew install mysql-client
echo 'export PATH="/opt/homebrew/opt/mysql-client/bin:$PATH"' >> ~/.zshrc
source ~/.zshrc

# Linux (Ubuntu/Debian)
sudo apt-get install mysql-client

# Verificar instalación
mysql --version
```

**Alternativa:** Si usas MAMP/XAMPP, agrega MySQL al PATH:
```bash
# MAMP
echo 'export PATH="/Applications/MAMP/Library/bin:$PATH"' >> ~/.zshrc
source ~/.zshrc
```

## 📱 QR Codes

Escanea para acceder rápidamente a recursos importantes:

| Recurso | QR Code |
|---------|---------|
| **GitHub Repo** | ![GitHub QR](https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://github.com/mikeoliveradev/breezemvc) |
| **Documentación** | ![Docs QR](https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://github.com/mikeoliveradev/breezemvc/wiki) |
| **Soporte Email** | ![Email QR](https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=mailto:rinoceronte.digital@gmail.com) |

---

## 🚀 Instalación

### 1. Clonar el Repositorio

```bash
git clone https://github.com/mikeoliveradev/breezemvc.git
cd breezemvc
```

### 2. Inicialización Automática

Ejecuta el script interactivo que configurará todo por ti (BD, .env, migraciones, URL):

```bash
./init-project.sh
```

### 3. Iniciar Servidor

```bash
php -S localhost:8000 -t public/
```

---

## ⚡ Inicio Rápido

### Crear un CRUD Completo

```bash
# 1. Crear modelo
php cli.php make:model Producto

# 2. Crear controlador
php cli.php make:controller ProductoController

# 3. Crear migración
php migrate.php create create_productos_table
```

Edita `database/migrations/YYYY_MM_DD_HHMMSS_create_productos_table.sql`:

```sql
-- UP
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- DOWN
DROP TABLE productos;
```

Aplica la migración:

```bash
php migrate.php up
```

### Ejemplo de Controlador

```php
// src/controllers/ProductoController.php
public function index(): void
{
    $cache = new Cache();
    
    $productos = $cache->remember('productos_lista', function() {
        return Producto::all();
    }, 3600);
    
    $this->render('views/productos/index', [
        'productos' => $productos
    ]);
}

public function store(): void
{
    $validator = new Validator($_POST);
    $validator->required(['nombre', 'precio'])
              ->numeric('precio');
    
    if ($validator->fails()) {
        $_SESSION['error'] = $validator->firstError();
        header('Location: /producto/create');
        exit;
    }
    
    $producto = new Producto();
    $producto->nombre = $_POST['nombre'];
    $producto->precio = $_POST['precio'];
    $producto->save();
    
    header('Location: /producto/index');
}
```

### Rutas

Las rutas siguen el patrón: `/{controlador}/{metodo}/{parametro}`

```
/producto/index          → ProductoController::index()
/producto/show/5         → ProductoController::show(5)
/auth/login             → AuthController::login()
```

---

## 📁 Estructura del Proyecto

```
breezemvc/
├── cli.php                      # CLI para generar código
├── migrate.php                  # CLI para migraciones
├── init-project.sh              # Script de instalación
├── public/                      # Document Root (Seguro)
│   ├── index.php                # Front Controller
│   ├── .htaccess                # Reglas Apache
│   ├── views/                   # Vistas
│   └── assets/                  # CSS, JS, imágenes
├── src/
│   ├── config/                  # Configuración (Database.php)
│   ├── controllers/             # Controladores
│   ├── models/                  # Modelos
│   ├── middleware/              # Middleware
│   └── utils/                   # Helpers (Env, Validator, Mailer)
├── database/
│   ├── migrations/             # Migraciones SQL
│   └── schema.sql              # Tabla de control
├── vendor/                     # Librerías (Incluido en Git)
└── docs/                       # Documentación
```

---

## 📚 Documentación

### Guías Principales

- **[Configuración](docs/CONFIGURATION.md)** - Configurar credenciales y servicios
- **[Deployment](docs/DEPLOYMENT.md)** - Subir a producción
- **[Componentes](docs/COMPONENTS.md)** - Sistema de componentes reutilizables
- [Componentes - Guía Rápida](docs/COMPONENTS_QUICKSTART.md) - Referencia rápida
- [CLI Helper](docs/CLI_HELPER.md) - Generar código automáticamente
- [Sistema de Emails](docs/EMAIL_SYSTEM.md) - Envío de correos
- [Google OAuth](docs/GOOGLE_OAUTH.md) - Login con Google
- [Códigos QR](docs/QRCODE.md) - Generar QR codes
- [Branding](docs/BRANDING.md) - Guía de marca

### Ejemplos de Código

```php
// Validación
$validator = new Validator($_POST);
$validator->required(['nombre'])->min('nombre', 3);

// Caché
$cache = new Cache();
$data = $cache->remember('key', fn() => fetchData(), 3600);

// Email
$mailer = new Mailer();
$mailer->sendTemplate('user@example.com', 'Bienvenido', 'welcome', [
    'nombre' => 'Juan'
]);

// Componentes UI
ComponentHelper::render('ui/card', [
    'title' => 'Producto',
    'content' => '<p>Descripción</p>'
]);

// Middleware
AuthMiddleware::requireAuth();
```

---

## 📊 Comparación con Frameworks

| Característica | Esta Plantilla | Laravel | CodeIgniter |
|----------------|----------------|---------|-------------|
| **Tamaño** | ~54MB | ~1.85GB | ~2MB |
| **Archivos Core** | ~160 | ~3000 | ~500 |
| **Curva aprendizaje** | Baja | Alta | Media |
| **Velocidad** | 10ms | 50-100ms | 30ms |
| **Composer** | ❌ No Requerido | ✅ Requerido | ⚠️ Opcional |
| **Hosting compartido** | ✅ Nativo | ❌ Complejo | ✅ Nativo |
| **Validación** | ✅ PHP + JS | ✅ | ✅ |
| **ORM** | Simple | Eloquent | Query Builder |
| **Migraciones** | ✅ | ✅ | ✅ |
| **CLI** | ✅ | ✅ | ✅ |
| **Caché** | ✅ | ✅ | ✅ |
| **Componentes UI** | ✅ 8+ componentes | ❌ | ❌ |

### Cuándo Usar Esta Plantilla

✅ **Úsala si:**
- Proyectos pequeños/medianos (hasta ~50 tablas)
- Equipo pequeño (1-3 desarrolladores)
- Hosting compartido o VPS
- Presupuesto limitado
- Necesitas velocidad de desarrollo
- Quieres control total del código

❌ **Usa Laravel si:**
- Proyecto empresarial grande
- Equipo de 10+ desarrolladores
- Necesitas ecosistema completo
- APIs REST complejas
- El cliente exige "tecnología estándar"

---

## 🛠️ Herramientas Incluidas

### CLI Helper

```bash
php cli.php make:controller NombreController
php cli.php make:model NombreModelo
php cli.php make:middleware NombreMiddleware
php cli.php list
```

### Sistema de Migraciones

```bash
php migrate.php status
php migrate.php create nombre_migracion
php migrate.php up
php migrate.php down
```

---

## 🔒 Seguridad

- ✅ Contraseñas hasheadas con `password_hash()`
- ✅ Protección CSRF (implementar según necesidad)
- ✅ Sanitización de inputs con `htmlspecialchars()`
- ✅ Validación de emails con `filter_var()`
- ✅ Sesiones seguras con `httponly` y `secure`
- ✅ Prepared statements para prevenir SQL injection

---

## 🤝 Contribuir

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama (`git checkout -b feature/nueva-caracteristica`)
3. Commit tus cambios (`git commit -m 'Añadir nueva característica'`)
4. Push a la rama (`git push origin feature/nueva-caracteristica`)
5. Abre un Pull Request

---

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

---

## 👨‍💻 Autor

**Mike Olivera**

---

## 📱 QR Codes

Escanea para acceder rápidamente a recursos importantes:

| Recurso | QR Code |
|---------|---------|
| **GitHub Repo** | ![GitHub QR](https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://github.com/mikeoliveradev/breezemvc) |
| **Documentación** | ![Docs QR](https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://github.com/mikeoliveradev/breezemvc/wiki) |
| **Soporte Email** | ![Email QR](https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=mailto:rinoceronte.digital@gmail.com) |

---

## 🙏 Agradecimientos

- Inspirado en Laravel, CodeIgniter y Symfony
- PHPMailer por el excelente sistema de emails
- La comunidad PHP por las mejores prácticas

---

## 📞 Soporte

¿Tienes preguntas o problemas?

- 📧 Email: rinoceronte.digital@gmail.com
- 🐛 Issues: [GitHub Issues](https://github.com/mikeoliveradev/breezemvc/issues)
- 📖 Documentación: [Wiki](https://github.com/mikeoliveradev/breezemvc/wiki)

---

<div align="center">

**⭐ Si te gusta este proyecto, dale una estrella en GitHub ⭐**

Hecho con ❤️ por desarrolladores, para desarrolladores

</div>
