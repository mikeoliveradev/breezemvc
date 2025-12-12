# Componentes Reutilizables - BreezeMVC

Sistema de componentes PHP reutilizables extraídos de HTMLStream Front.

## Uso Básico

### ComponentHelper

```php
use src\utils\ComponentHelper;

// Renderizar directamente
ComponentHelper::render('auth/login-form', [
    'title' => 'Iniciar Sesión',
    'action' => '/auth/loginPost'
]);

// Obtener como string
$html = ComponentHelper::get('ui/alert', [
    'type' => 'success',
    'message' => 'Operación exitosa'
]);
```

---

## Componentes de Autenticación

### login-form

Formulario de login moderno con toggle de contraseña y validación.

**Parámetros:**
- `$title` - Título (default: "Bienvenido")
- `$subtitle` - Subtítulo
- `$action` - URL de acción
- `$error` - Mensaje de error (opcional)
- `$forgotPasswordUrl` - URL de recuperación
- `$registerUrl` - URL de registro
- `$googleAuthUrl` - URL de Google OAuth (opcional)

**Ejemplo:**
```php
ComponentHelper::render('auth/login-form', [
    'title' => 'Iniciar Sesión',
    'action' => '/auth/loginPost',
    'googleAuthUrl' => $googleAuthUrl
]);
```

---

### register-form

Formulario de registro con confirmación de contraseña.

**Parámetros:**
- `$title` - Título
- `$subtitle` - Subtítulo
- `$action` - URL de acción
- `$error` - Mensaje de error (opcional)
- `$privacyUrl` - URL de política de privacidad
- `$loginUrl` - URL de login

**Ejemplo:**
```php
ComponentHelper::render('auth/register-form', [
    'title' => 'Crear Cuenta',
    'action' => '/auth/registerPost'
]);
```

---

### forgot-password-form

Formulario de recuperación de contraseña.

**Parámetros:**
- `$title` - Título
- `$subtitle` - Subtítulo
- `$action` - URL de acción
- `$success` - Mensaje de éxito (opcional)
- `$error` - Mensaje de error (opcional)
- `$loginUrl` - URL de login

---

### reset-password-form

Formulario de reseteo de contraseña con token.

**Parámetros:**
- `$title` - Título
- `$subtitle` - Subtítulo
- `$action` - URL de acción
- `$token` - Token de reseteo
- `$error` - Mensaje de error (opcional)

---

## Componentes de UI

### alert

Sistema de alertas con 4 tipos.

**Parámetros:**
- `$type` - Tipo: `success`, `error`, `warning`, `info`
- `$message` - Mensaje a mostrar
- `$dismissible` - Puede cerrarse (default: true)
- `$icon` - Icono Bootstrap (opcional)

**Ejemplo:**
```php
ComponentHelper::render('ui/alert', [
    'type' => 'success',
    'message' => 'Usuario creado exitosamente'
]);
```

---

### modal

Modal flexible con múltiples tamaños.

**Parámetros:**
- `$id` - ID único del modal
- `$title` - Título
- `$content` - Contenido HTML
- `$footer` - Footer HTML (opcional)
- `$size` - Tamaño: `sm`, `md`, `lg`, `xl`
- `$centered` - Centrar verticalmente (default: false)
- `$scrollable` - Contenido scrollable (default: false)

**Ejemplo:**
```php
ComponentHelper::render('ui/modal', [
    'id' => 'confirmModal',
    'title' => 'Confirmar acción',
    'content' => '<p>¿Estás seguro?</p>',
    'footer' => '<button class="btn btn-primary">Confirmar</button>',
    'size' => 'sm',
    'centered' => true
]);
```

---

### card

Tarjeta flexible con imagen, título y footer opcionales.

**Parámetros:**
- `$title` - Título (opcional)
- `$content` - Contenido HTML
- `$footer` - Footer HTML (opcional)
- `$image` - URL de imagen (opcional)
- `$imageAlt` - Texto alternativo
- `$class` - Clases CSS adicionales
- `$headerClass` - Clases para header
- `$bodyClass` - Clases para body

**Ejemplo:**
```php
ComponentHelper::render('ui/card', [
    'title' => 'Producto',
    'image' => '/assets/img/producto.jpg',
    'content' => '<p>Descripción del producto</p>',
    'footer' => '<a href="#" class="btn btn-primary">Ver más</a>'
]);
```

---

### breadcrumb

Navegación de migas de pan.

**Parámetros:**
- `$items` - Array de items: `['label' => 'Texto', 'url' => '/ruta']`

**Ejemplo:**
```php
ComponentHelper::render('ui/breadcrumb', [
    'items' => [
        ['label' => 'Inicio', 'url' => '/'],
        ['label' => 'Productos', 'url' => '/productos'],
        'Detalle' // Último item sin URL
    ]
]);
```

---

## Integración con Controladores

```php
namespace src\controllers;

use src\utils\ComponentHelper;

class AuthController extends Controller
{
    public function login(): void
    {
        $this->renderLayout('auth/login', [
            'googleAuthUrl' => $this->getGoogleAuthUrl()
        ]);
    }
}
```

En la vista `public/views/auth/login.php`:

```php
<?php
use src\utils\ComponentHelper;

ComponentHelper::render('auth/login-form', [
    'title' => 'Iniciar Sesión',
    'action' => '/auth/loginPost',
    'error' => $error ?? null,
    'googleAuthUrl' => $googleAuthUrl ?? null
]);
```

---

## Notas Importantes

1. **Validación**: Los formularios usan `js-validate` y `needs-validation` de Bootstrap
2. **Toggle Password**: Requiere el plugin `hs-toggle-password` de Front
3. **Iconos**: Usa Bootstrap Icons (`bi-*`)
4. **Responsive**: Todos los componentes son responsive por defecto
5. **Accesibilidad**: Incluyen atributos ARIA apropiados
