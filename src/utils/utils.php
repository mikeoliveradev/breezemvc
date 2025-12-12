<?php
// Archivo: src/utils/Utils.php

// https://developer.parker.com

namespace src\utils;

/**
 * Clase de utilidades estáticas para funciones comunes en la aplicación.
 * Usará la fuente Montserrat que priorizas para el cliente INVEX si fuera necesario.
 */
class Utils
{
    // =============================================
    // 1. SANITIZACIÓN DE DATOS (SEGURIDAD)
    // =============================================

    /**
     * Limpia una cadena de entrada para evitar inyección XSS y elimina etiquetas HTML.
     * @param string $data La cadena a limpiar.
     * @return string La cadena sanitizada.
     */
    public static function sanitizeString(string $data): string
    {
        // 1. Elimina espacios al inicio y al final
        $data = trim($data);
        // 2. Elimina barras invertidas
        $data = stripslashes($data);
        // 3. Convierte caracteres especiales a entidades HTML (protege contra XSS)
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    /**
     * Valida y sanitiza una entrada de tipo entero.
     * @param mixed $data La entrada.
     * @return int|false El entero validado o false si no es un entero válido.
     */
    public static function sanitizeInt(mixed $data): int|false
    {
        return filter_var($data, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0] ]);
    }
    
    // =============================================
    // 2. MANEJO DE SESIÓN Y CONFIGURACIÓN
    // =============================================
    
    /**
     * Inicia la sesión de forma segura si aún no está activa.
     */
    public static function secureSessionStart(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params(0, "/", $_SERVER["HTTP_HOST"], true, true);
            session_start();
        }
    }

    // =============================================
    // 3. MANEJO DE FECHAS
    // =============================================

    /**
     * Obtiene la fecha y hora actual en formato de base de datos (YYYY-MM-DD HH:MM:SS) 
     * y establece la zona horaria de México (UTC-6 o -5).
     * @return string La marca de tiempo formateada.
     */
    public static function getCurrentTimestamp(): string
    {
        // Puedes ajustar la zona horaria si es necesario (ej: 'America/Mexico_City')
        date_default_timezone_set('America/Mexico_City');
        return date('Y-m-d H:i:s');
    }

    /**
     * Formatea una fecha de BD a un formato legible en español.
     * @param string $dbDate La fecha de la base de datos (YYYY-MM-DD).
     * @return string La fecha formateada (ej: 07 de Noviembre de 2025).
     */
    public static function formatSpanishDate(string $dbDate): string
    {
        // Requiere una configuración local si se usan funciones como strftime
        $timestamp = strtotime($dbDate);
        $meses = [
            1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        
        $dia = date('d', $timestamp);
        $mes = date('n', $timestamp);
        $anio = date('Y', $timestamp);
        
        return $dia . ' de ' . $meses[$mes] . ' de ' . $anio;
    }

    // =============================================
    // 4. VERSIÓN DE ACTIVOS (CSS/JS)
    // =============================================

    /**
     * Agrega un parámetro de versión (timestamp) a una URL de activo para forzar la recarga 
     * del navegador cuando el archivo cambia (cache busting).
     * @param string $file El path relativo al archivo CSS o JS (ej: /public/assets/css/style.css).
     * @return string El path con el timestamp (ej: /public/assets/css/style.css?v=1636287600).
     */
    public static function versionAsset(string $file): string
    {
        // Se asume que $file está en la carpeta raíz del servidor web o se ajusta la ruta.
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . $file;
        
        if (file_exists($fullPath)) {
            // Usa el timestamp de la última modificación del archivo.
            return $file . '?v=' . filemtime($fullPath);
        }
        
        return $file; // Devuelve el path original si el archivo no existe
    }

    // =============================================
    // 5. DETECTOR DE DISPOSITIVO (BÁSICO)
    // =============================================
    /**
     * Detecta si el usuario está en un dispositivo móvil (teléfono o tablet)
     * basándose en la cadena de agente de usuario.
     * @return bool True si es móvil, false si es escritorio.
     */
    public static function isMobileDevice(): bool
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        // Patrones comunes de dispositivos móviles y tablets
        $patterns = '/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i';
        return (bool) preg_match($patterns, $userAgent);
    }

    // =============================================
    // 6. GENERACIÓN DE CÓDIGOS Y TOKENS (NUEVO)
    // =============================================
    /**
     * Genera una clave alfanumérica y segura de 20 caracteres para tokens o hashes.
     * @return string La clave de 20 caracteres generada.
     */
    public static function crearKey(): string
    {
        // Conjunto de caracteres base: letras mayúsculas, minúsculas, números y el símbolo $
        $chars = 'Aa1Bb2Cc3Dd4Ee5Ff6Gg7Hh8Ii9Jj0Kk$LlMm1Nn2Oo3Pp4Qq5Rr6Ss7Tt8Uu9Vv0Ww$XxYyZz';
        // La implementación actual ya usa str_shuffle y substr para seleccionar los primeros 20.
        // Se asegura de que la longitud de la clave es 20.
        $key = substr(str_shuffle($chars), 0, 20);
        return $key;
    }

    // =============================================
    // 7. SEGURIDAD DE CONTRASEÑAS Y TOKENS
    // =============================================
    
    /**
     * Genera un hash seguro de una contraseña usando bcrypt.
     * @param string $password La contraseña en texto plano.
     * @return string El hash de la contraseña.
     */
    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Verifica si una contraseña coincide con su hash.
     * @param string $password La contraseña en texto plano.
     * @param string $hash El hash almacenado.
     * @return bool True si coincide, false si no.
     */
    public static function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Genera un token aleatorio seguro.
     * @param int $length Longitud del token (por defecto 32).
     * @return string Token hexadecimal.
     */
    public static function generateToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

}