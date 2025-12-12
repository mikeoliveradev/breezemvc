# Sistema de Validación JavaScript

Sistema completo de validación client-side que complementa el `Validator.php` del servidor.

## 📁 Archivos

- `form-validator.js` - Validación de formularios
- `form-formats.js` - Formatos automáticos de campos

---

## 🚀 Uso Básico

### 1. Incluir Scripts

```html
<script src="/assets/js/form-validator.js"></script>
<script src="/assets/js/form-formats.js"></script>
```

### 2. Validación con data-validate

```html
<form data-validate>
    <input type="text" name="nombre" data-validate="required|min:3">
    <input type="email" name="email" data-validate="required|email">
    <input type="password" name="password" data-validate="required|min:6">
    <input type="password" name="password_confirm" data-validate="required|match:password">
    <button type="submit">Enviar</button>
</form>
```

### 3. Formatos Automáticos con idformatocampo

```html
<input type="text" idformatocampo="9" name="nombre">  <!-- Mayúsculas -->
<input type="text" idformatocampo="13" name="celular"> <!-- Teléfono -->
<input type="text" idformatocampo="19" name="rfc">     <!-- RFC -->
```

---

## 📋 Reglas de Validación

| Regla | Descripción | Ejemplo |
|-------|-------------|---------|
| `required` | Campo requerido | `data-validate="required"` |
| `email` | Email válido | `data-validate="email"` |
| `min:n` | Mínimo n caracteres | `data-validate="min:6"` |
| `max:n` | Máximo n caracteres | `data-validate="max:50"` |
| `numeric` | Solo números | `data-validate="numeric"` |
| `match:campo` | Coincide con otro campo | `data-validate="match:password"` |
| `regex:pattern` | Patrón personalizado | `data-validate="regex:^[A-Z]+$"` |
| `url` | URL válida | `data-validate="url"` |
| `date` | Fecha válida (YYYY-MM-DD) | `data-validate="date"` |

### Combinar Reglas

```html
<input data-validate="required|email|max:100">
<input data-validate="required|min:8|max:20">
```

---

## 🎨 Formatos Automáticos

| ID | Formato | Descripción |
|----|---------|-------------|
| 1 | Números reales | Permite decimales |
| 2 | Números naturales | Solo enteros positivos |
| 3 | Solo letras | Letras y espacios |
| 4 | Minúsculas | Convierte a minúsculas |
| 7 | Alfanuméricos | Letras y números |
| 8 | Email | Valida formato email |
| 9 | Mayúsculas | Convierte a mayúsculas |
| 10 | Capitalizar | Primera letra mayúscula |
| 11 | Letras capitalizadas | Solo letras + capitalizar |
| 12 | Código postal | 5 dígitos |
| 13 | Teléfono | 10 dígitos |
| 19 | RFC | 13 caracteres |
| 20 | CURP | 18 caracteres |

---

## 💡 Ejemplos Completos

### Formulario de Registro

```html
<form data-validate>
    <div class="form-group">
        <label>Nombre Completo</label>
        <input type="text" 
               name="nombre" 
               idformatocampo="10"
               data-validate="required|min:3">
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" 
               name="email" 
               idformatocampo="4"
               data-validate="required|email">
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group">
        <label>Teléfono</label>
        <input type="text" 
               name="celular" 
               idformatocampo="13"
               data-validate="required|numeric">
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group">
        <label>RFC</label>
        <input type="text" 
               name="rfc" 
               idformatocampo="19"
               data-validate="required|min:13|max:13">
        <div class="invalid-feedback"></div>
    </div>

    <button type="submit" class="btn btn-primary">Registrar</button>
</form>
```

### Formulario de Login

```html
<form data-validate action="/auth/loginPost" method="POST">
    <div class="form-group">
        <label>Email</label>
        <input type="email" 
               name="email" 
               data-validate="required|email"
               autofocus>
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group">
        <label>Contraseña</label>
        <input type="password" 
               name="password" 
               id="password"
               data-validate="required|min:6">
        <button type="button" onclick="FormValidator.togglePasswordVisibility('toggleBtn', 'password')">
            👁️
        </button>
        <div class="invalid-feedback"></div>
    </div>

    <button type="submit">Iniciar Sesión</button>
</form>
```

---

## ⚙️ Configuración

Puedes personalizar el comportamiento en `form-validator.js`:

```javascript
const VALIDATOR_CONFIG = {
    errorClass: 'is-invalid',           // Clase CSS para errores
    successClass: 'is-valid',           // Clase CSS para éxito
    errorMessageClass: 'invalid-feedback', // Clase para mensajes
    showSuccessState: true,             // Mostrar estado de éxito
    validateOnBlur: true,               // Validar al perder foco
    validateOnInput: false              // Validar mientras escribe
};
```

---

## 🎯 Funciones Útiles

### Validación Manual

```javascript
// Validar un campo específico
const input = document.getElementById('email');
const isValid = FormValidator.validateField(input, form);

// Validar todo el formulario
const form = document.getElementById('myForm');
const isValid = FormValidator.validateForm(form);
```

### Formatos Manuales

```javascript
const input = document.getElementById('nombre');

// Convertir a mayúsculas
FormValidator.toUpperCase(input);

// Solo números
FormValidator.onlyNumbers(input);

// Validar RFC
FormValidator.validateRFC(input);

// Validar teléfono
FormValidator.validatePhone(input);
```

### Utilidades

```javascript
// Calcular edad
const age = FormValidator.calculateAge('1990-05-15');

// Toggle password
FormValidator.togglePasswordVisibility('btnToggle', 'password');

// Formatear miles
FormFormats.formatThousands(input);

// Número a letras
const text = FormFormats.numberToWords(123); // "ciento veintitrés"
```

---

## 🔄 Integración con PHP

El sistema JavaScript usa las **mismas reglas** que `Validator.php`:

**JavaScript:**
```html
<input data-validate="required|email|min:6">
```

**PHP:**
```php
$validator = new Validator($_POST);
$validator->required(['email'])
          ->email('email')
          ->min('email', 6);
```

---

## 🎨 Estilos CSS Recomendados

```css
.is-invalid {
    border-color: #dc3545 !important;
}

.is-valid {
    border-color: #28a745 !important;
}

.invalid-feedback {
    display: block;
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
```

---

## 📝 Mensajes Personalizados

Puedes personalizar los mensajes en `form-validator.js`:

```javascript
const ErrorMessages = {
    required: 'Este campo es obligatorio',
    email: 'Email inválido',
    min: 'Mínimo {param} caracteres',
    // ... más mensajes
};
```

---

## 🐛 Solución de Problemas

### La validación no funciona

1. Verifica que los scripts estén incluidos
2. Asegúrate de que el formulario tenga `data-validate`
3. Revisa la consola del navegador

### Los formatos no se aplican

1. Verifica que el atributo sea `idformatocampo` (sin guiones)
2. Asegúrate de que el ID del formato sea válido (1-20)
3. Revisa que `form-formats.js` esté cargado

### Conflicto con otros scripts

Los scripts usan `window.FormValidator` y `window.FormFormats` para evitar conflictos.

---

## ✅ Ventajas

- ✅ **Feedback instantáneo** - El usuario ve errores inmediatamente
- ✅ **Menos carga al servidor** - Validación antes de enviar
- ✅ **Mejor UX** - No pierde datos al recargar
- ✅ **Consistente con PHP** - Mismas reglas en cliente y servidor
- ✅ **Sin dependencias** - Vanilla JavaScript puro
- ✅ **Fácil de usar** - Solo atributos HTML

---

## 🔒 Seguridad

**IMPORTANTE:** La validación JavaScript es para **UX**, no para **seguridad**.

✅ **Siempre valida en el servidor** con `Validator.php`
❌ **Nunca confíes solo en JavaScript**

El usuario puede:
- Deshabilitar JavaScript
- Modificar el código del navegador
- Enviar peticiones directas

**Flujo correcto:**
```
1. JavaScript valida → Feedback rápido
2. Usuario envía formulario
3. PHP valida → Seguridad real
```
