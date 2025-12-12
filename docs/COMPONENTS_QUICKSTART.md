# Guía Rápida: Componentes Reutilizables

## Uso Básico

```php
use src\utils\ComponentHelper;

// Renderizar componente
ComponentHelper::render('ui/alert', [
    'type' => 'success',
    'message' => 'Operación exitosa'
]);
```

## Componentes Disponibles

### Autenticación
- `auth/login-form` - Formulario de login
- `auth/register-form` - Formulario de registro  
- `auth/forgot-password-form` - Recuperar contraseña
- `auth/reset-password-form` - Resetear contraseña

### UI
- `ui/alert` - Alertas (success, error, warning, info)
- `ui/modal` - Modales flexibles
- `ui/card` - Tarjetas
- `ui/breadcrumb` - Migas de pan

## Ejemplos Rápidos

### Alert
```php
ComponentHelper::render('ui/alert', [
    'type' => 'success',
    'message' => 'Usuario creado'
]);
```

### Modal
```php
ComponentHelper::render('ui/modal', [
    'id' => 'myModal',
    'title' => 'Confirmar',
    'content' => '<p>¿Continuar?</p>',
    'centered' => true
]);
```

### Card
```php
ComponentHelper::render('ui/card', [
    'title' => 'Título',
    'content' => '<p>Contenido</p>',
    'footer' => '<button>Acción</button>'
]);
```

## Demo
Ver `public/views/components-demo.php` para ejemplos completos.

## Documentación Completa
Ver `docs/COMPONENTS.md` para detalles de todos los parámetros.
