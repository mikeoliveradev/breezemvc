<?php
// src/utils/Cache.php

namespace src\utils;

/**
 * Sistema de caché simple con soporte para archivos y Redis.
 * Detecta automáticamente qué driver usar.
 */
class Cache
{
    private string $driver = 'file';
    
    /**
     * Instancia de Redis (si está disponible).
     * @var \Redis|null
     */
    private ?object $redis = null;
    
    private string $cacheDir;

    public function __construct()
    {
        $this->cacheDir = __DIR__ . '/../../storage/cache/';
        
        // Crear directorio de caché si no existe
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
        
        // Detectar si Redis está disponible
        if (extension_loaded('redis')) {
            try {
                $this->redis = new \Redis();
                $this->redis->connect('127.0.0.1', 6379);
                $this->driver = 'redis';
            } catch (\Exception $e) {
                // Redis no disponible, usar archivos
                $this->driver = 'file';
                $this->redis = null;
            }
        }
    }

    /**
     * Obtiene un valor del caché.
     * @param string $key Clave del valor
     * @return mixed|null Valor o null si no existe o expiró
     */
    public function get(string $key): mixed
    {
        if ($this->driver === 'redis' && $this->redis) {
            return $this->getFromRedis($key);
        }
        
        return $this->getFromFile($key);
    }

    /**
     * Guarda un valor en el caché.
     * @param string $key Clave del valor
     * @param mixed $value Valor a guardar
     * @param int $ttl Tiempo de vida en segundos (0 = sin expiración)
     * @return bool True si se guardó correctamente
     */
    public function set(string $key, mixed $value, int $ttl = 3600): bool
    {
        if ($this->driver === 'redis' && $this->redis) {
            return $this->setToRedis($key, $value, $ttl);
        }
        
        return $this->setToFile($key, $value, $ttl);
    }

    /**
     * Verifica si existe una clave en el caché.
     * @param string $key Clave a verificar
     * @return bool True si existe y no ha expirado
     */
    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }

    /**
     * Elimina un valor del caché.
     * @param string $key Clave a eliminar
     * @return bool True si se eliminó correctamente
     */
    public function delete(string $key): bool
    {
        if ($this->driver === 'redis' && $this->redis) {
            return $this->redis->del($key) > 0;
        }
        
        $filePath = $this->getFilePath($key);
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        
        return false;
    }

    /**
     * Limpia todo el caché.
     * @return bool True si se limpió correctamente
     */
    public function clear(): bool
    {
        if ($this->driver === 'redis' && $this->redis) {
            return $this->redis->flushDB();
        }
        
        $files = glob($this->cacheDir . '*.cache');
        foreach ($files as $file) {
            unlink($file);
        }
        
        return true;
    }

    /**
     * Obtiene el driver actual.
     * @return string 'redis' o 'file'
     */
    public function getDriver(): string
    {
        return $this->driver;
    }

    /**
     * Obtiene valor desde archivo.
     */
    private function getFromFile(string $key): mixed
    {
        $filePath = $this->getFilePath($key);
        
        if (!file_exists($filePath)) {
            return null;
        }
        
        $data = unserialize(file_get_contents($filePath));
        
        // Verificar expiración
        if ($data['expires'] > 0 && time() > $data['expires']) {
            unlink($filePath);
            return null;
        }
        
        return $data['value'];
    }

    /**
     * Guarda valor en archivo.
     */
    private function setToFile(string $key, mixed $value, int $ttl): bool
    {
        $filePath = $this->getFilePath($key);
        
        $data = [
            'value' => $value,
            'expires' => $ttl > 0 ? time() + $ttl : 0
        ];
        
        return file_put_contents($filePath, serialize($data)) !== false;
    }

    /**
     * Obtiene valor desde Redis.
     */
    private function getFromRedis(string $key): mixed
    {
        $value = $this->redis->get($key);
        return $value !== false ? unserialize($value) : null;
    }

    /**
     * Guarda valor en Redis.
     */
    private function setToRedis(string $key, mixed $value, int $ttl): bool
    {
        $serialized = serialize($value);
        
        if ($ttl > 0) {
            return $this->redis->setex($key, $ttl, $serialized);
        }
        
        return $this->redis->set($key, $serialized);
    }

    /**
     * Obtiene la ruta del archivo de caché.
     */
    private function getFilePath(string $key): string
    {
        $hash = md5($key);
        return $this->cacheDir . $hash . '.cache';
    }

    /**
     * Método helper para cachear el resultado de una función.
     * @param string $key Clave del caché
     * @param callable $callback Función a ejecutar si no hay caché
     * @param int $ttl Tiempo de vida
     * @return mixed Resultado cacheado o de la función
     */
    public function remember(string $key, callable $callback, int $ttl = 3600): mixed
    {
        if ($this->has($key)) {
            return $this->get($key);
        }
        
        $value = $callback();
        $this->set($key, $value, $ttl);
        
        return $value;
    }
}
