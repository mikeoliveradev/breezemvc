<?php
// public/index.php - Punto de entrada principal (Front Controller)

// ============================================
// 1. AUTOLOADING (Carga automática de clases)
// ============================================
// Esto reemplaza los require_once manuales.
// Convierte namespaces como src\controllers\ProductoController 
// en rutas como src/controllers/ProductoController.php
spl_autoload_register(function ($class) {
    // Directorio base para el prefijo del namespace
    // IMPORTANTE: Estamos en /public/, así que subimos un nivel con '..'
    $base_dir = __DIR__ . '/../';

    // Reemplaza los separadores de namespace con separadores de directorio
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';

    // Si el archivo existe, lo carga
    if (file_exists($file)) {
        require $file;
    }
});

use src\utils\Utils;
use src\utils\Env;

// Cargar variables de entorno (.env)
Env::load(__DIR__ . '/../.env');

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
        require '404.html'; 
    }
} else {
    // Controlador no encontrado - Mostrar 404
    http_response_code(404);
    if (file_exists('404.html')) {
        require '404.html';
    } else {
        echo "<h1>Error 404</h1><p>Página no encontrada.</p>";
    }
}