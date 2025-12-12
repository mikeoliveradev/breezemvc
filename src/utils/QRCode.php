<?php
// src/utils/QRCode.php

namespace src\utils;

/**
 * Generador de códigos QR híbrido
 * 
 * Soporta múltiples métodos de generación:
 * 1. Google Charts API (por defecto, sin dependencias)
 * 2. phpqrcode (fallback offline si está disponible)
 * 
 * @version 1.0
 * @author Mike Olivera mikeolivera.com
 */
class QRCode
{
    /**
     * Directorio donde se guardan los QR generados
     */
    private static string $qrDir = 'qr/';
    
    /**
     * Tamaño por defecto del QR en píxeles
     */
    private static int $defaultSize = 300;
    
    /**
     * Nivel de corrección de errores
     * L = ~7%, M = ~15%, Q = ~25%, H = ~30%
     */
    private static string $errorLevel = 'L';

    /**
     * Genera un código QR
     * 
     * @param string $data Datos a codificar en el QR
     * @param string|null $filename Nombre del archivo (opcional, si se quiere guardar)
     * @param int $size Tamaño del QR en píxeles
     * @return string URL o ruta del QR generado
     */
    public static function generate(string $data, ?string $filename = null, int $size = null): string
    {
        $size = $size ?? self::$defaultSize;
        
        // Asegurar que existe el directorio
        self::ensureDirectory();
        
        // Si se especifica filename, intentar guardar localmente
        if ($filename) {
            return self::saveLocal($data, $filename, $size);
        }
        
        // Por defecto: retornar URL de Google Charts
        return self::getGoogleChartsURL($data, $size);
    }

    /**
     * Genera QR en formato base64 para embed directo en HTML
     * 
     * @param string $data Datos a codificar
     * @param int $size Tamaño del QR
     * @return string Data URI en base64
     */
    public static function generateBase64(string $data, int $size = null): string
    {
        $size = $size ?? self::$defaultSize;
        $url = self::getGoogleChartsURL($data, $size);
        
        $image = @file_get_contents($url);
        
        if ($image === false) {
            error_log("QRCode: Error descargando QR desde Google Charts");
            return '';
        }
        
        return 'data:image/png;base64,' . base64_encode($image);
    }

    /**
     * Genera un código único alfanumérico
     * 
     * @param int $length Longitud del código (debe ser par)
     * @return string Código único hexadecimal
     */
    public static function generateUniqueCode(int $length = 16): string
    {
        return bin2hex(random_bytes($length / 2));
    }

    /**
     * Verifica si un código QR existe
     * 
     * @param string $filename Nombre del archivo
     * @return bool True si existe
     */
    public static function exists(string $filename): bool
    {
        return file_exists(self::$qrDir . $filename);
    }

    /**
     * Elimina un código QR guardado
     * 
     * @param string $filename Nombre del archivo
     * @return bool True si se eliminó correctamente
     */
    public static function delete(string $filename): bool
    {
        $filepath = self::$qrDir . $filename;
        
        if (file_exists($filepath)) {
            return unlink($filepath);
        }
        
        return false;
    }

    /**
     * Obtiene la URL de un QR guardado
     * 
     * @param string $filename Nombre del archivo
     * @return string|null URL del QR o null si no existe
     */
    public static function getURL(string $filename): ?string
    {
        if (self::exists($filename)) {
            return '/' . self::$qrDir . $filename;
        }
        
        return null;
    }

    /**
     * Genera URL de Google Charts API
     * 
     * @param string $data Datos a codificar
     * @param int $size Tamaño del QR
     * @return string URL del QR
     */
    private static function getGoogleChartsURL(string $data, int $size): string
    {
        $encoded = urlencode($data);
        return "https://chart.googleapis.com/chart?chs={$size}x{$size}&cht=qr&chl={$encoded}&choe=UTF-8";
    }

    /**
     * Guarda QR localmente
     * 
     * @param string $data Datos a codificar
     * @param string $filename Nombre del archivo
     * @param int $size Tamaño del QR
     * @return string Ruta del archivo guardado
     */
    private static function saveLocal(string $data, string $filename, int $size): string
    {
        $filepath = self::$qrDir . $filename;
        
        // Método 1: Intentar con phpqrcode si existe
        if (self::tryPhpQRCode($data, $filepath)) {
            return '/' . $filepath;
        }
        
        // Método 2: Descargar de Google Charts
        $url = self::getGoogleChartsURL($data, $size);
        $image = @file_get_contents($url);
        
        if ($image !== false) {
            file_put_contents($filepath, $image);
            return '/' . $filepath;
        }
        
        // Fallback: retornar URL de Google Charts
        error_log("QRCode: No se pudo guardar localmente, usando URL de Google Charts");
        return $url;
    }

    /**
     * Intenta generar QR con phpqrcode
     * 
     * @param string $data Datos a codificar
     * @param string $filepath Ruta completa del archivo
     * @return bool True si se generó correctamente
     */
    private static function tryPhpQRCode(string $data, string $filepath): bool
    {
        $phpqrcodePath = __DIR__ . '/../../vendor/phpqrcode/qrlib.php';
        
        if (!file_exists($phpqrcodePath)) {
            return false;
        }
        
        try {
            require_once $phpqrcodePath;
            
            // Generar QR con phpqrcode
            \QRcode::png($data, $filepath, self::$errorLevel, 10);
            
            return file_exists($filepath);
        } catch (\Exception $e) {
            error_log("QRCode: Error usando phpqrcode: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Asegura que existe el directorio de QR
     */
    private static function ensureDirectory(): void
    {
        if (!is_dir(self::$qrDir)) {
            mkdir(self::$qrDir, 0755, true);
        }
    }

    /**
     * Limpia QR antiguos (opcional, para mantenimiento)
     * 
     * @param int $days Días de antigüedad
     * @return int Cantidad de archivos eliminados
     */
    public static function cleanOldQRs(int $days = 30): int
    {
        $files = glob(self::$qrDir . '*.png');
        $count = 0;
        $threshold = time() - ($days * 24 * 60 * 60);
        
        foreach ($files as $file) {
            if (filemtime($file) < $threshold) {
                if (unlink($file)) {
                    $count++;
                }
            }
        }
        
        return $count;
    }

    /**
     * Obtiene estadísticas del directorio de QR
     * 
     * @return array Estadísticas
     */
    public static function getStats(): array
    {
        $files = glob(self::$qrDir . '*.png');
        $totalSize = 0;
        
        foreach ($files as $file) {
            $totalSize += filesize($file);
        }
        
        return [
            'total_files' => count($files),
            'total_size_bytes' => $totalSize,
            'total_size_mb' => round($totalSize / 1024 / 1024, 2),
            'directory' => self::$qrDir
        ];
    }
}
