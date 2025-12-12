# Configuración de Google Sign-In

Para que Google Sign-In funcione, necesitas configurar credenciales OAuth 2.0 en Google Cloud Console.

## Pasos de Configuración

### 1. Crear Proyecto en Google Cloud

1. Ve a [Google Cloud Console](https://console.cloud.google.com/)
2. Haz clic en "Crear Proyecto"
3. Nombre del proyecto: `[Nombre de tu aplicación]`
4. Haz clic en "Crear"

### 2. Habilitar Google+ API

1. En el menú lateral, ve a **APIs y servicios** → **Biblioteca**
2. Busca "Google+ API"
3. Haz clic en "Habilitar"

### 3. Configurar Pantalla de Consentimiento

1. Ve a **APIs y servicios** → **Pantalla de consentimiento de OAuth**
2. Selecciona **Externo** (para pruebas) o **Interno** (si tienes Google Workspace)
3. Completa la información:
   - **Nombre de la aplicación**: [Tu app]
   - **Correo de asistencia**: tu@email.com
   - **Logotipo** (opcional)
4. Haz clic en "Guardar y continuar"
5. En **Scopes**, añade:
   - `email`
   - `profile`
6. Guarda y continúa

### 4. Crear Credenciales OAuth 2.0

1. Ve a **APIs y servicios** → **Credenciales**
2. Haz clic en **+ Crear credenciales** → **ID de cliente de OAuth 2.0**
3. Tipo de aplicación: **Aplicación web**
4. Nombre: `Web Client`
5. **URIs de redirección autorizados**:
   ```
   http://localhost/auth/googleCallback
   http://tudominio.com/auth/googleCallback
   ```
6. Haz clic en "Crear"
7. **Copia el Client ID y Client Secret**

### 5. Configurar en tu Aplicación

Abre el archivo `src/integrations/GoogleAuth.php` y reemplaza:

```php
private const GOOGLE_CLIENT_ID = 'TU_CLIENT_ID_AQUI.apps.googleusercontent.com';
private const GOOGLE_CLIENT_SECRET = 'TU_CLIENT_SECRET_AQUI';
private const GOOGLE_REDIRECT_URI = 'http://localhost/auth/googleCallback';
```

**Importante:** Cambia `GOOGLE_REDIRECT_URI` según tu entorno:
- Desarrollo: `http://localhost/auth/googleCallback`
- Producción: `https://tudominio.com/auth/googleCallback`

### 6. Probar

1. Ejecuta el script SQL en `database/usuarios.sql` para crear la tabla
2. Accede a `/auth/login` en tu navegador
3. Haz clic en "Continuar con Google"
4. Autoriza la aplicación
5. Deberías ser redirigido y autenticado automáticamente

## Solución de Problemas

### Error: "redirect_uri_mismatch"
- Verifica que la URI en `GoogleAuth.php` coincida EXACTAMENTE con la configurada en Google Cloud
- Incluye el protocolo (`http://` o `https://`)
- No incluyas barra final

### Error: "invalid_client"
- Verifica que el Client ID y Client Secret sean correctos
- Asegúrate de que no haya espacios extra al copiar

### Error: "access_denied"
- El usuario canceló la autorización
- Verifica que los scopes solicitados estén habilitados

## Seguridad en Producción

1. **Usa HTTPS** en producción
2. **Cambia GOOGLE_REDIRECT_URI** a tu dominio real
3. **Añade tu dominio** a las URIs autorizadas en Google Cloud
4. **Considera usar variables de entorno** para las credenciales (en lugar de hardcodearlas)
