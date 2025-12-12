# Directorio de Migraciones

Este directorio contiene los archivos de migración de la base de datos.

## Formato de Archivos

Los archivos deben seguir el formato:
```
YYYY_MM_DD_HHMMSS_nombre_descriptivo.sql
```

Ejemplo:
```
2024_11_23_223000_create_usuarios_table.sql
```

## Uso Rápido

### 1. Crear una nueva migración
Genera un archivo con la estructura lista para editar:
```bash
php migrate.php create nombre_de_la_accion
# Ejemplo:
php migrate.php create create_productos_table
```

### 2. Editar el archivo SQL
El archivo generado tendrá dos secciones:
- `-- UP`: Comandos para aplicar cambios (CREATE TABLE, ALTER TABLE...)
- `-- DOWN`: Comandos para revertir cambios (DROP TABLE...)

### 3. Aplicar migraciones (UP)
Ejecuta los cambios pendientes en la base de datos:
```bash
php migrate.php up
```

### 4. Revertir migraciones (DOWN)
Deshace la última tanda de migraciones aplicada:
```bash
php migrate.php down
```

### 5. Ver estado
Muestra qué migraciones ya se ejecutaron:
```bash
php migrate.php status
```
