<?php
// src/models/BaseModel.php

namespace src\models;

// Importar la clase Database que tiene la conexión
use src\config\Database;


abstract class BaseModel
{
    protected ?int $id = null; // Usamos null para diferenciar nuevos registros

    // Método público para obtener el ID desde fuera
    public function getId(): ?int
    {
        return $this->id;
    }
    
    // Asumimos que el constructor "hidrata" el objeto
    public function __construct(array $data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // Método abstracto que debe definir la tabla en las clases hijas
    abstract protected static function getTableName(): string;

    // ============================================
    // SELECT: Abstrae la lectura (FIND)
    // ============================================
    public static function find(int $id): ?static
    {
        $conn = Database::getConnection();
        $tabla = static::getTableName();

        $sql = "SELECT * FROM {$tabla} WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();

        return $data ? new static($data) : null;
    }

    // ============================================
    // SELECT: Abstrae la lectura (ALL)
    // ============================================
    public static function all(): array
    {
        $conn = Database::getConnection();
        $tabla = static::getTableName();
        $sql = "SELECT * FROM {$tabla}";
        $result = $conn->query($sql);
        
        $coleccion = [];
        if ($result && $result->num_rows > 0) {
            while ($data = $result->fetch_assoc()) {
                $coleccion[] = new static($data); // Mapea cada fila a un objeto
            }
        }
        return $coleccion;
    }

    // ============================================
    // INSERT y UPDATE: Abstrae la persistencia (SAVE)
    // ============================================
    public function save(): bool
    {
        $conn = Database::getConnection();
        $tabla = static::getTableName();
        
        // Excluimos la propiedad 'id' de la lista de columnas a guardar
        $atributos = get_object_vars($this);
        unset($atributos['id']); 

        if ($this->id === null) {
            // --- INSERT ---
            $campos = implode(', ', array_keys($atributos));
            $marcadores = implode(', ', array_fill(0, count($atributos), '?'));
            $sql = "INSERT INTO {$tabla} ({$campos}) VALUES ({$marcadores})";
        } else {
            // --- UPDATE ---
            $set_part = [];
            foreach (array_keys($atributos) as $campo) {
                $set_part[] = "{$campo} = ?";
            }
            $set_sql = implode(', ', $set_part);
            $sql = "UPDATE {$tabla} SET {$set_sql} WHERE id = ?";
            // Añadimos el ID al final para el bind_param
            $atributos['id'] = $this->id; 
        }

        $stmt = $conn->prepare($sql);
        
        // Lógica para determinar los tipos y vincular los parámetros
        // NOTA: Esto es complejo en PHP mysqli sin librerías, aquí simplificamos asumiendo 's' para todos:
        $valores = array_values($atributos);
        $tipos = str_repeat('s', count($valores));
        if ($this->id !== null) { // Si es UPDATE, el ID es un entero (i) al final
            $tipos[strlen($tipos)-1] = 'i';
        }
        
        $stmt->bind_param($tipos, ...$valores);
        
        $exito = $stmt->execute();
        
        if ($exito && $this->id === null) {
            $this->id = $conn->insert_id; // Asigna el ID recién creado
        }

        $stmt->close();
        return $exito;
    }

    // ============================================
    // DELETE: Abstrae la eliminación
    // ============================================
    public function delete(): bool
    {
        if ($this->id === null) return false;
        
        $conn = Database::getConnection();
        $tabla = static::getTableName();
        
        $sql = "DELETE FROM {$tabla} WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $exito = $stmt->execute();
        $stmt->close();
        
        return $exito;
    }
}