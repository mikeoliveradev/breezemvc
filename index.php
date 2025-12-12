<?php
/**
 * ⚠️ ARCHIVO DESHABILITADO - SOLO PARA REFERENCIA
 * 
 * Este archivo NO debe usarse como punto de entrada principal.
 * 
 * CONFIGURACIÓN CORRECTA:
 * - Configura tu servidor web para que el document root apunte a: /public/
 * - El punto de entrada principal es: /public/index.php
 * 
 * BENEFICIOS DE SEGURIDAD:
 * - Las carpetas /src/, /vendor/, /config/ quedan inaccesibles desde el navegador
 * - Archivos sensibles como .env, composer.json, migrate.php están protegidos
 * - Es el estándar de la industria (Laravel, Symfony, etc.)
 * 
 * Si por alguna razón NO puedes configurar el document root a /public/,
 * descomenta el código siguiente, pero considera usar .htaccess para proteger
 * las carpetas sensibles.
 */

// Redirigir temporalmente a /public/ si se accede por error
header('Location: /public/');
exit;

/*
// ============================================
// CÓDIGO ORIGINAL (COMENTADO)
// ============================================

// index.php - Punto de entrada principal (Front Controller)

// ============================================
// 1. AUTOLOADING (Carga automática de clases)
// ============================================
// Esto reemplaza los require_once manuales.
// Convierte namespaces como src\controllers\ProductoController 
// en rutas como src/controllers/ProductoController.php
spl_autoload_register(function ($class) {
    // Directorio base para el prefijo del namespace
    $base_dir = __DIR__ . '/';

    // Reemplaza los separadores de namespace con separadores de directorio
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';

    // Si el archivo existe, lo carga
    if (file_exists($file)) {
        require $file;
    }
});

use src\utils\Utils;

// ============================================
// 2. INICIO DE SESIÓN Y CONFIGURACIÓN
// ============================================
// Utils::secureSessionStart(); // Descomentar cuando Utils esté listo
session_start(); // Inicio de sesión básico por ahora

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    // Asumimos que Utils tiene sanitizeInt, si no, usar intval
    $id_usuario_actual = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
} else {
    $id_usuario_actual = 0;
}

// ============================================
// 3. ENRUTAMIENTO (ROUTER DINÁMICO)
// ============================================

// Obtener la URL solicitada
$uri_completa = $_SERVER['REQUEST_URI'];
$path_limpio = parse_url($uri_completa, PHP_URL_PATH);
$request = trim($path_limpio, '/');
$partes_url = explode('/', $request);

// Definir Controlador, Método y Parámetros por defecto
$controlador_nombre = 'Home'; // Controlador por defecto (HomeController)
$metodo = 'index';            // Método por defecto
$params = [];

// Analizar la URL: /controlador/metodo/param1/param2...
if (!empty($partes_url[0])) {
    $controlador_nombre = ucfirst($partes_url[0]); // Capitalizar (ej: producto -> Producto)
}

if (isset($partes_url[1]) && !empty($partes_url[1])) {
    $metodo = $partes_url[1];
}

if (count($partes_url) > 2) {
    $params = array_slice($partes_url, 2);
}

// Construir el nombre completo de la clase del controlador
// Asumimos que todos los controladores están en src\controllers y terminan en 'Controller'
$clase_controlador = "src\\controllers\\{$controlador_nombre}Controller";

// Verificar si la clase existe (gracias al Autoload)
if (class_exists($clase_controlador)) {
    $controller = new $clase_controlador();

    // Verificar si el método existe en el controlador
    if (method_exists($controller, $metodo)) {
        // Llamar al método con los parámetros
        call_user_func_array([$controller, $metodo], $params);
    } else {
        // Método no encontrado
        // Opcional: Cargar controlador de error o mostrar 404
        http_response_code(404);
        require 'public/404.html'; 
    }
} else {
    // Controlador no encontrado
    // Verificar si es una ruta estática especial o mostrar 404
    
    // Mapeo de rutas estáticas legacy (opcional, para compatibilidad)
    $rutas_estaticas = [
        '' => 'public/home.php', // Home si no hay controlador
        'home' => 'public/home.php'
    ];

    if (array_key_exists(strtolower($controlador_nombre), $rutas_estaticas)) {
        // Si el "controlador" coincide con una ruta estática (ej: la raíz)
        if ($controlador_nombre === 'Home' && empty($partes_url[0])) {
             require $rutas_estaticas[''];
        } else {
             require $rutas_estaticas[strtolower($controlador_nombre)];
        }
    } else {
        http_response_code(404);
        if (file_exists('public/404.html')) {
            require 'public/404.html';
        } else {
            echo "<h1>Error 404</h1><p>Página no encontrada.</p>";
        }
    }
}
*/