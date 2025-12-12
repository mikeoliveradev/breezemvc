#!/bin/bash
# init-project.sh - Script para inicializar un nuevo proyecto desde BreezeMVC

# Obtener el directorio donde está el script
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$SCRIPT_DIR"

echo "🚀 Inicializando nuevo proyecto BreezeMVC..."

# 1. Copiar .env.example a .env
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✅ Archivo .env creado"
else
    echo "⚠️  .env ya existe, no se sobrescribirá"
fi

# 2. Limpiar caché
rm -rf storage/cache/*
echo "✅ Caché limpiado"

# 3. Configurar Base de Datos y .env
echo ""
echo "🔧 Configuración de Base de Datos"
read -p "¿Quieres configurar la base de datos ahora? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    read -p "Host MySQL (default: localhost): " db_host
    db_host=${db_host:-localhost}
    
    read -p "Puerto MySQL (default: 3306, MAMP usa 8889): " db_port
    db_port=${db_port:-3306}
    
    read -p "Usuario MySQL: " db_user
    read -sp "Contraseña MySQL: " db_pass
    echo
    read -p "Nombre de la base de datos: " db_name

    # Actualizar .env (compatible con MacOS/Linux)
    # Usamos perl para reemplazo in-place más seguro que sed entre sistemas
    perl -pi -e "s/DB_HOST=.*/DB_HOST=$db_host/" .env
    perl -pi -e "s/DB_PORT=.*/DB_PORT=$db_port/" .env
    perl -pi -e "s/DB_USER=.*/DB_USER=$db_user/" .env
    perl -pi -e "s/DB_PASS=.*/DB_PASS=$db_pass/" .env
    perl -pi -e "s/DB_NAME=.*/DB_NAME=$db_name/" .env
    
    echo "✅ Archivo .env actualizado con credenciales"

    # Crear tabla de migraciones
    read -p "¿Quieres crear la tabla de migraciones en la BD? (y/n): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        # Verificar si mysql está disponible
        if ! command -v mysql &> /dev/null; then
            echo "❌ Error: El comando 'mysql' no está disponible."
            echo "   Opciones:"
            echo "   1. Instala MySQL client: brew install mysql-client"
            echo "   2. O crea la tabla manualmente en phpMyAdmin usando database/schema.sql"
        else
            mysql -h "$db_host" -P "$db_port" -u "$db_user" -p"$db_pass" "$db_name" < database/schema.sql
            if [ $? -eq 0 ]; then
                echo "✅ Tabla de migraciones creada exitosamente"
                
                # Aplicar migraciones
                read -p "¿Quieres aplicar las migraciones pendientes? (y/n): " -n 1 -r
                echo
                if [[ $REPLY =~ ^[Yy]$ ]]; then
                    php migrate.php up
                    echo "✅ Migraciones aplicadas"
                fi
            else
                echo "❌ Error al conectar con MySQL. Verifica tus credenciales."
            fi
        fi
    fi
fi

# 4. Ayuda para crear nuevas tablas
echo ""
echo "🏗️  Creación de Tablas"
read -p "¿Quieres generar archivos de migración para nuevas tablas? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "Ingresa los nombres de las tablas que necesitas (separados por espacio)."
    echo "Ejemplo: productos categorias pedidos"
    read -p "> " tables
    
    for table in $tables; do
        # 1. Crear Migración
        php migrate.php create "create_${table}_table"
        echo "✅ Migración creada: create_${table}_table"
        
        # 2. Lógica simple para singularizar (muy básica, quita la 's' final si existe)
        # productos -> Producto
        model_name=$(echo "$table" | sed 's/s$//')
        # Capitalizar primera letra
        model_name="$(tr '[:lower:]' '[:upper:]' <<< ${model_name:0:1})${model_name:1}"
        
        # 3. Preguntar si crear Modelo y Controlador
        read -p "¿Crear Modelo ($model_name) y Controlador (${model_name}Controller) para '$table'? (y/n): " -n 1 -r
        echo
        if [[ $REPLY =~ ^[Yy]$ ]]; then
            # Verificar que cli.php existe
            if [ -f "cli.php" ]; then
                # Crear Modelo
                php cli.php make:model "$model_name"
                
                # Crear Controlador
                php cli.php make:controller "${model_name}Controller"
                
                echo "✨ Código generado para $model_name"
            else
                echo "❌ Error: cli.php no encontrado en $SCRIPT_DIR"
            fi
        fi
    done
    
    echo ""
    echo "⚠️  IMPORTANTE: Los archivos de migración están en database/migrations/"
    echo "   Debes editarlos para definir las columnas antes de ejecutar 'php migrate.php up'."
fi

# 5. Configurar URL de la aplicación
echo ""
echo "🌐 Configuración del Dominio"
read -p "Ingresa la URL de tu proyecto (ej: http://mi-dominio.com): " app_url
if [ ! -z "$app_url" ]; then
    # Escapar barras para perl
    escaped_url=$(echo $app_url | sed 's/\//\\\//g')
    perl -pi -e "s/APP_URL=.*/APP_URL=$escaped_url/" .env
    echo "✅ APP_URL actualizada en .env"
fi

# 5. Limpiar archivos de ejemplo (opcional)
echo ""
read -p "¿Quieres eliminar los archivos de ejemplo? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    rm -rf examples/
    rm -rf tests/
    echo "✅ Archivos de ejemplo eliminados"
fi

echo ""
echo "🎉 ¡Proyecto inicializado correctamente!"
echo ""
echo "📝 Resumen de cambios:"
echo "- Archivo .env creado y configurado"
echo "- Caché limpiado"
echo "- Base de datos configurada (si seleccionaste sí)"
echo ""
echo "🚀 Siguientes pasos:"
echo "1. Configura tu servidor web para apuntar a /public/"
echo "2. ¡Empieza a programar!"
echo ""
