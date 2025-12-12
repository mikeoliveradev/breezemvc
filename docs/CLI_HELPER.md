# CLI Helper - Guía de Uso

Herramienta de línea de comandos para generar código automáticamente.

## Comandos Disponibles

### 1. Generar Controlador

```bash
php cli.php make:controller NombreController
```

**Ejemplos:**
```bash
# Crear controlador de productos
php cli.php make:controller ProductoController

# Crear controlador de clientes
php cli.php make:controller ClienteController

# Crear controlador de ventas
php cli.php make:controller VentaController
```

**Resultado:**
- Crea: `src/controllers/NombreController.php`
- Hereda de `BaseController`
- Incluye métodos: `index()`, `show()`, `create()`, `store()`
- Ruta automática: `/nombre/index`

---

### 2. Generar Modelo

```bash
php cli.php make:model NombreModelo
```

**Ejemplos:**
```bash
# Crear modelo de producto
php cli.php make:model Producto

# Crear modelo de cliente
php cli.php make:model Cliente

# Crear modelo de venta
php cli.php make:model Venta
```

**Resultado:**
- Crea: `src/models/NombreModelo.php`
- Hereda de `BaseModel`
- Pluraliza automáticamente el nombre de tabla
- Incluye propiedades de ejemplo

**Pluralización automática:**
- `Producto` → tabla `productos`
- `Vendedor` → tabla `vendedores`
- `Luz` → tabla `luces`

---

### 3. Generar Middleware

```bash
php cli.php make:middleware NombreMiddleware
```

**Ejemplos:**
```bash
# Crear middleware de administrador
php cli.php make:middleware AdminMiddleware

# Crear middleware de permisos
php cli.php make:middleware PermissionMiddleware

# Crear middleware de rate limiting
php cli.php make:middleware RateLimitMiddleware
```

**Resultado:**
- Crea: `src/middleware/NombreMiddleware.php`
- Incluye métodos: `handle()`, `check()`
- Listo para personalizar

---

### 4. Ver Ayuda

```bash
php cli.php list
# o
php cli.php help
```

---

## Flujo de Trabajo Típico

### Crear un CRUD completo

```bash
# 1. Crear el modelo
php cli.php make:model Producto

# 2. Crear el controlador
php cli.php make:controller ProductoController

# 3. Crear la tabla en la base de datos
# (Ejecutar SQL manualmente o usar migraciones)

# 4. Acceder en el navegador
# http://localhost/producto/index
```

---

## Tips y Trucos

### El nombre se autocompleta
```bash
# Estos son equivalentes:
php cli.php make:controller Producto
php cli.php make:controller ProductoController
# Ambos crean: ProductoController.php
```

### Pluralización inteligente
```bash
php cli.php make:model Vendedor
# Crea tabla: vendedores (no vendedors)

php cli.php make:model Producto
# Crea tabla: productos
```

### Detecta duplicados
```bash
php cli.php make:controller ProductoController
# Primera vez: ✓ Controlador creado

php cli.php make:controller ProductoController
# Segunda vez: ✗ El controlador ProductoController ya existe.
```

---

## Personalización

### Después de generar un controlador:

1. Abre `src/controllers/NombreController.php`
2. Personaliza los métodos según tu necesidad
3. Añade validación con `Validator`
4. Usa el modelo correspondiente

**Ejemplo:**
```php
public function store(): void
{
    $validator = new Validator($_POST);
    $validator->required(['nombre', 'precio'])
              ->numeric('precio');
    
    if ($validator->fails()) {
        // Manejar error
    }
    
    $producto = new Producto();
    $producto->nombre = $_POST['nombre'];
    $producto->save();
}
```

---

## Solución de Problemas

### Error: "comando no encontrado"
```bash
# Asegúrate de estar en la raíz del proyecto
cd /ruta/a/tu/proyecto
php cli.php list
```

### Error: "No se especificó ningún comando"
```bash
# Debes incluir el comando
php cli.php make:controller MiController
```

### Permisos en Linux/Mac
```bash
# Hacer el archivo ejecutable
chmod +x cli.php

# Ahora puedes usarlo así:
./cli.php make:controller MiController
```

---

## Atajos Útiles

Puedes crear un alias en tu terminal para acortar el comando:

**Bash/Zsh (~/.bashrc o ~/.zshrc):**
```bash
alias make="php cli.php"
```

**Uso:**
```bash
make make:controller ProductoController
make make:model Producto
```

---

## Próximas Mejoras

- [ ] `make:view` - Generar vistas
- [ ] `make:migration` - Generar migraciones de BD
- [ ] `make:crud` - Generar CRUD completo (modelo + controlador + vistas)
- [ ] `make:api` - Generar controlador API REST

---

¿Dudas? Ejecuta `php cli.php help` para ver la ayuda completa.
