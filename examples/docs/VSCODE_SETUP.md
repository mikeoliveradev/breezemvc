# Configuración de VS Code para BreezeMVC

Esta carpeta `.vscode/` contiene configuraciones **personales** de Visual Studio Code. Cada desarrollador debe crear sus propias configuraciones según sus necesidades.

---

## 🚫 NO Incluir en Git

La carpeta `.vscode/` está en `.gitignore` porque:

1. **Credenciales sensibles** - Puede contener passwords de FTP/SFTP
2. **Configuración personal** - Cada dev tiene sus preferencias
3. **Rutas locales** - Paths específicos de cada máquina

---

## 📋 Archivos Comunes en .vscode/

### 1. settings.json (Opcional)

Configuraciones del proyecto:

```json
{
  "git.ignoreLimitWarning": true,
  "files.exclude": {
    "**/.git": true,
    "**/.DS_Store": true,
    "**/node_modules": true
  },
  "php.validate.executablePath": "/usr/bin/php",
  "editor.formatOnSave": true
}
```

### 2. sftp.json (Para extensión SFTP)

**⚠️ NUNCA subir a Git - contiene credenciales**

```json
{
  "name": "Mi Servidor",
  "host": "tuservidor.com",
  "protocol": "sftp",
  "port": 22,
  "username": "tu_usuario",
  "password": "tu_password",
  "remotePath": "/public_html/",
  "uploadOnSave": false,
  "ignore": [
    ".vscode",
    ".git",
    ".DS_Store",
    "node_modules"
  ]
}
```

### 3. launch.json (Para debugging)

```json
{
  "version": "0.2.0",
  "configurations": [
    {
      "name": "Listen for Xdebug",
      "type": "php",
      "request": "launch",
      "port": 9003
    }
  ]
}
```

---

## 🔧 Extensiones Recomendadas de VS Code

### PHP
- **PHP Intelephense** - Autocompletado y análisis
- **PHP Debug** - Debugging con Xdebug
- **PHP DocBlocker** - Documentación automática

### FTP/SFTP
- **SFTP** by Natizyskunk - Upload/download archivos
- **FTP-Simple** - Cliente FTP integrado

### Utilidades
- **GitLens** - Git mejorado
- **Better Comments** - Comentarios coloridos
- **Path Intellisense** - Autocompletado de rutas

---

## 🚀 Alternativas para Subir Archivos

### Opción 1: Extensión SFTP de VS Code

1. Instalar extensión "SFTP"
2. Crear `.vscode/sftp.json` (local, no subir a Git)
3. Configurar credenciales
4. Usar comandos: `SFTP: Upload` / `SFTP: Download`

### Opción 2: Clientes FTP Externos

**FileZilla (Gratis)**
- Multiplataforma
- Interfaz gráfica
- Gestión de sitios

**Cyberduck (Gratis)**
- Mac/Windows
- Integración con cloud storage
- Bookmarks

**Transmit (Mac, Pago)**
- Muy rápido
- Sincronización
- Múltiples conexiones

### Opción 3: Git + SSH

```bash
# En el servidor
cd /public_html/
git init
git remote add origin https://github.com/tuusuario/tu-repo.git

# Desde local
git push origin main

# En servidor
git pull origin main
```

### Opción 4: rsync (Terminal)

```bash
rsync -avz --exclude='.git' --exclude='node_modules' \
  /ruta/local/breezemvc/ usuario@servidor:/public_html/
```

---

## 📝 Recomendación

**Para BreezeMVC:**

1. ✅ Cada desarrollador crea su propia carpeta `.vscode/`
2. ✅ Configura sus propias credenciales FTP/SFTP
3. ✅ NO sube `.vscode/` a Git (ya está en `.gitignore`)
4. ✅ Usa el método de deployment que prefiera

**Ventajas:**
- 🔒 Seguridad - No expones credenciales
- 🎯 Personalización - Cada dev usa sus herramientas
- 🚀 Flexibilidad - No impones un workflow

---

## 🔐 Seguridad

### ❌ Nunca Hagas Esto

```json
// ❌ NO subir a Git
{
  "password": "mi_password_real"
}
```

### ✅ Mejor Práctica

```json
// ✅ Usar SSH keys en lugar de passwords
{
  "privateKeyPath": "/Users/tu/.ssh/id_rsa",
  "passphrase": true  // Te pedirá la passphrase
}
```

O usar variables de entorno:

```json
{
  "password": "${env:FTP_PASSWORD}"
}
```

---

## 📚 Más Información

- [VS Code SFTP Extension](https://marketplace.visualstudio.com/items?itemName=Natizyskunk.sftp)
- [VS Code PHP Debug](https://marketplace.visualstudio.com/items?itemName=xdebug.php-debug)
- [Guía de Deployment](DEPLOYMENT.md)

---

**Conclusión:** La carpeta `.vscode/` es **personal** y **no debe incluirse** en el repositorio de BreezeMVC. Cada usuario debe crear la suya según sus necesidades.
