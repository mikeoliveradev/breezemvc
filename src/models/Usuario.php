<?php
// src/models/Usuario.php

namespace src\models;

// Importar la clase BaseModel
use src\models\BaseModel; 

class Usuario extends BaseModel
{
    // Las propiedades (excepto $id, que ya está en BaseModel) definen las columnas:
    // El ORM las usará para mapear los datos leídos.
    public string $nombre = ''; 
    public string $email = '';
    public ?string $password = null; // Nullable para usuarios de Google
    public ?string $google_id = null;
    public ?string $avatar = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;
    public ?string $reset_token = null;
    public ?string $reset_token_expires = null;

    /**
     * Define explícitamente el nombre de la tabla para esta clase.
     */
    protected static function getTableName(): string
    {
        return 'usuarios';
    }

    /**
     * Busca un usuario por su email.
     * @param string $email
     * @return Usuario|null
     */
    public static function findByEmail(string $email): ?static
    {
        $conn = \src\config\Database::getConnection();
        $tabla = static::getTableName();

        $sql = "SELECT * FROM {$tabla} WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();

        return $data ? new static($data) : null;
    }

    /**
     * Busca un usuario por su Google ID.
     * @param string $googleId
     * @return Usuario|null
     */
    public static function findByGoogleId(string $googleId): ?static
    {
        $conn = \src\config\Database::getConnection();
        $tabla = static::getTableName();

        $sql = "SELECT * FROM {$tabla} WHERE google_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $googleId);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();

        return $data ? new static($data) : null;
    }
}