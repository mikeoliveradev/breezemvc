<?php
// src/cli/MakeModel.php

namespace src\cli;

class MakeModel
{
    /**
     * Genera un nuevo modelo.
     * @param string $name Nombre del modelo (ej: Producto)
     */
    public static function generate(string $name): void
    {
        $filePath = __DIR__ . '/../../src/models/' . $name . '.php';

        // Verificar si ya existe
        if (file_exists($filePath)) {
            self::error("El modelo {$name} ya existe.");
            return;
        }

        // Template del modelo
        $template = self::getTemplate($name);

        // Crear el archivo
        if (file_put_contents($filePath, $template)) {
            self::success("Modelo creado: src/models/{$name}.php");
            self::info("Tabla esperada: " . self::getTableName($name));
            self::info("No olvides crear la tabla en la base de datos.");
        } else {
            self::error("Error al crear el modelo.");
        }
    }

    /**
     * Obtiene el template del modelo.
     */
    private static function getTemplate(string $name): string
    {
        $tableName = self::getTableName($name);
        
        return <<<PHP
<?php
// src/models/{$name}.php

namespace src\models;

use src\models\BaseModel;

class {$name} extends BaseModel
{
    // Define las propiedades que corresponden a las columnas de la tabla
    // Ejemplo:
    public string \$nombre = '';
    public string \$descripcion = '';
    // public int \$precio = 0;
    // public ?string \$imagen = null;

    /**
     * Define el nombre de la tabla en la base de datos.
     */
    protected static function getTableName(): string
    {
        return '{$tableName}';
    }

    // Puedes añadir métodos personalizados aquí
    // Ejemplo:
    // public static function findByNombre(string \$nombre): ?static
    // {
    //     \$conn = \src\config\Database::getConnection();
    //     \$tabla = static::getTableName();
    //     \$sql = "SELECT * FROM {\$tabla} WHERE nombre = ?";
    //     \$stmt = \$conn->prepare(\$sql);
    //     \$stmt->bind_param("s", \$nombre);
    //     \$stmt->execute();
    //     \$result = \$stmt->get_result();
    //     \$data = \$result->fetch_assoc();
    //     \$stmt->close();
    //     return \$data ? new static(\$data) : null;
    // }
}

PHP;
    }

    /**
     * Convierte el nombre del modelo al nombre de tabla (plural en minúsculas).
     */
    private static function getTableName(string $name): string
    {
        // Producto -> productos
        $table = strtolower($name);
        
        // Pluralización simple en español
        if (str_ends_with($table, 'or')) {
            return $table . 'es'; // vendedor -> vendedores
        } elseif (str_ends_with($table, 'z')) {
            return substr($table, 0, -1) . 'ces'; // luz -> luces
        } else {
            return $table . 's'; // producto -> productos
        }
    }

    private static function success(string $msg): void {
        echo "\033[32m✓ {$msg}\033[0m\n";
    }

    private static function error(string $msg): void {
        echo "\033[31m✗ {$msg}\033[0m\n";
    }

    private static function info(string $msg): void {
        echo "\033[33mℹ {$msg}\033[0m\n";
    }
}
