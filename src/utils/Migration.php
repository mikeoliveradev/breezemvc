<?php
// src/utils/Migration.php

namespace src\utils;

use src\config\Database;

/**
 * Sistema de migraciones de base de datos.
 * Permite versionar y aplicar cambios al esquema de BD.
 */
class Migration
{
    private $conn;
    private string $migrationsDir;

    public function __construct()
    {
        $this->conn = Database::getConnection();
        $this->migrationsDir = __DIR__ . '/../../database/migrations/';
        
        // Asegurar que existe la tabla de migraciones
        $this->ensureMigrationsTable();
    }

    /**
     * Crea la tabla de migraciones si no existe.
     */
    private function ensureMigrationsTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL UNIQUE,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_migration (migration)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $this->conn->query($sql);
    }

    /**
     * Obtiene todas las migraciones disponibles.
     * @return array Lista de archivos de migración
     */
    public function getAvailable(): array
    {
        $files = glob($this->migrationsDir . '*.sql');
        $migrations = [];
        
        foreach ($files as $file) {
            $migrations[] = basename($file);
        }
        
        sort($migrations);
        return $migrations;
    }

    /**
     * Obtiene migraciones ya ejecutadas.
     * @return array Lista de migraciones ejecutadas
     */
    public function getExecuted(): array
    {
        $sql = "SELECT migration FROM migrations ORDER BY migration";
        $result = $this->conn->query($sql);
        
        $executed = [];
        while ($row = $result->fetch_assoc()) {
            $executed[] = $row['migration'];
        }
        
        return $executed;
    }

    /**
     * Obtiene migraciones pendientes.
     * @return array Lista de migraciones pendientes
     */
    public function getPending(): array
    {
        $available = $this->getAvailable();
        $executed = $this->getExecuted();
        
        return array_diff($available, $executed);
    }

    /**
     * Ejecuta una migración (UP).
     * @param string $migration Nombre del archivo de migración
     * @return bool True si se ejecutó correctamente
     */
    public function up(string $migration): bool
    {
        $filePath = $this->migrationsDir . $migration;
        
        if (!file_exists($filePath)) {
            echo "❌ Migración no encontrada: {$migration}\n";
            return false;
        }

        $content = file_get_contents($filePath);
        $sql = $this->extractUpSQL($content);
        
        if (!$sql) {
            echo "❌ No se encontró sección -- UP en: {$migration}\n";
            return false;
        }

        try {
            // Ejecutar SQL
            if ($this->conn->multi_query($sql)) {
                // Limpiar resultados
                while ($this->conn->next_result()) {
                    if ($result = $this->conn->store_result()) {
                        $result->free();
                    }
                }
            }
            
            // Registrar migración
            $stmt = $this->conn->prepare("INSERT INTO migrations (migration) VALUES (?)");
            $stmt->bind_param("s", $migration);
            $stmt->execute();
            $stmt->close();
            
            echo "✅ Migración aplicada: {$migration}\n";
            return true;
        } catch (\Exception $e) {
            echo "❌ Error ejecutando migración: " . $e->getMessage() . "\n";
            return false;
        }
    }

    /**
     * Revierte una migración (DOWN).
     * @param string $migration Nombre del archivo de migración
     * @return bool True si se revirtió correctamente
     */
    public function down(string $migration): bool
    {
        $filePath = $this->migrationsDir . $migration;
        
        if (!file_exists($filePath)) {
            echo "❌ Migración no encontrada: {$migration}\n";
            return false;
        }

        $content = file_get_contents($filePath);
        $sql = $this->extractDownSQL($content);
        
        if (!$sql) {
            echo "❌ No se encontró sección -- DOWN en: {$migration}\n";
            return false;
        }

        try {
            // Ejecutar SQL
            if ($this->conn->multi_query($sql)) {
                // Limpiar resultados
                while ($this->conn->next_result()) {
                    if ($result = $this->conn->store_result()) {
                        $result->free();
                    }
                }
            }
            
            // Eliminar registro de migración
            $stmt = $this->conn->prepare("DELETE FROM migrations WHERE migration = ?");
            $stmt->bind_param("s", $migration);
            $stmt->execute();
            $stmt->close();
            
            echo "✅ Migración revertida: {$migration}\n";
            return true;
        } catch (\Exception $e) {
            echo "❌ Error revirtiendo migración: " . $e->getMessage() . "\n";
            return false;
        }
    }

    /**
     * Extrae el SQL de la sección UP.
     */
    private function extractUpSQL(string $content): ?string
    {
        if (preg_match('/-- UP\s*\n(.*?)(?=-- DOWN|$)/s', $content, $matches)) {
            return trim($matches[1]);
        }
        return null;
    }

    /**
     * Extrae el SQL de la sección DOWN.
     */
    private function extractDownSQL(string $content): ?string
    {
        if (preg_match('/-- DOWN\s*\n(.*?)$/s', $content, $matches)) {
            return trim($matches[1]);
        }
        return null;
    }

    /**
     * Crea un nuevo archivo de migración.
     * @param string $name Nombre descriptivo de la migración
     * @return string Nombre del archivo creado
     */
    public function create(string $name): string
    {
        $timestamp = date('Y_m_d_His');
        $filename = "{$timestamp}_{$name}.sql";
        $filePath = $this->migrationsDir . $filename;
        
        $template = <<<SQL
-- Migración: {$name}
-- Creada: {$timestamp}

-- UP
-- Escribe aquí los cambios a aplicar


-- DOWN
-- Escribe aquí cómo revertir los cambios


SQL;

        file_put_contents($filePath, $template);
        echo "✅ Migración creada: {$filename}\n";
        
        return $filename;
    }

    /**
     * Muestra el estado de las migraciones.
     */
    public function status(): void
    {
        $available = $this->getAvailable();
        $executed = $this->getExecuted();
        $pending = $this->getPending();
        
        echo "\n=== Estado de Migraciones ===\n\n";
        echo "Total disponibles: " . count($available) . "\n";
        echo "Ejecutadas: " . count($executed) . "\n";
        echo "Pendientes: " . count($pending) . "\n\n";
        
        if (!empty($executed)) {
            echo "Ejecutadas:\n";
            foreach ($executed as $migration) {
                echo "  ✅ {$migration}\n";
            }
            echo "\n";
        }
        
        if (!empty($pending)) {
            echo "Pendientes:\n";
            foreach ($pending as $migration) {
                echo "  ⏳ {$migration}\n";
            }
            echo "\n";
        }
        
        if (empty($available)) {
            echo "No hay migraciones disponibles.\n\n";
        }
    }
}
