<?php
// Archivo: src/Config/Database.php
namespace src\config;

use src\utils\Utils;
use mysqli;

/**
 * Clase de configuración y conexión a la base de datos y servicios externos.
 * Reemplaza el uso de define() en el ámbito global.
 */
class Database
{
    // =============================================
    // 1. CONSTANTES DE CONEXIÓN A LA BASE DE DATOS
    // =============================================
    
    // Las credenciales se cargan desde el archivo .env usando src\utils\Env
    // Se definen getters estáticos para acceder a ellas dinámicamente
    
    // =============================================
    // 2. CONSTANTES DE SERVICIOS EXTERNOS
    // =============================================
    
    // Estas constantes se mantienen para compatibilidad, pero idealmente
    // deberían accederse vía Env::get() directamente donde se necesiten.
    
    // =============================================
    // 3. PROPIEDAD DE CONEXIÓN
    // =============================================
    
    private static ?mysqli $connection = null;

    /**
     * Obtiene y establece la conexión a la base de datos.
     * Utiliza un patrón Singleton para asegurar una única conexión.
     * @return mysqli La instancia de la conexión a la base de datos.
     */
    public static function getConnection(): mysqli
    {
        // 1. Si la conexión ya existe, la devuelve
        if (self::$connection !== null) {
            return self::$connection;
        }

        // 2. Obtener credenciales del entorno
        $host = \src\utils\Env::get('DB_HOST', 'localhost');
        $port = \src\utils\Env::get('DB_PORT', '3306');
        $user = \src\utils\Env::get('DB_USER', 'root');
        $pass = \src\utils\Env::get('DB_PASS', '');
        $name = \src\utils\Env::get('DB_NAME', 'breezemvc');

        // 3. Intenta establecer la conexión
        $conn = new mysqli($host, $user, $pass, $name, $port);

        // 3. Manejo de error de conexión
        if ($conn->connect_error) {
            // Registrar el error para el desarrollador
            error_log("Error de conexión a la DB: " . $conn->connect_error);
            // Mostrar un mensaje seguro al usuario
            die("Lo sentimos, no podemos conectar con la base de datos en este momento. Por favor, inténtelo de nuevo más tarde.");
        }

        // 4. Configuración
        $conn->set_charset('utf8mb4');
        date_default_timezone_set('America/Mexico_City'); // Solo por si acaso, aunque ya está en Utils

        // 5. Almacena la conexión y la devuelve
        self::$connection = $conn;
        return self::$connection;
    }
}