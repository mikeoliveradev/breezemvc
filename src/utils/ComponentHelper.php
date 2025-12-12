<?php
namespace src\utils;

/**
 * ComponentHelper - Sistema de componentes reutilizables para BreezeMVC
 * 
 * Permite renderizar componentes PHP de forma sencilla y reutilizable.
 * 
 * @example
 * // Renderizar directamente
 * ComponentHelper::render('auth/login-form', ['title' => 'Login']);
 * 
 * // Obtener como string
 * $html = ComponentHelper::get('ui/alert', ['type' => 'success', 'message' => 'OK']);
 */
class ComponentHelper
{
    /**
     * Renderiza un componente directamente
     * 
     * @param string $component Ruta del componente (ej: 'auth/login-form')
     * @param array $data Datos a pasar al componente
     * @return void
     */
    public static function render(string $component, array $data = []): void
    {
        $componentPath = __DIR__ . "/../../public/views/components/{$component}.php";
        
        if (!file_exists($componentPath)) {
            throw new \Exception("Componente no encontrado: {$component}");
        }
        
        extract($data);
        require $componentPath;
    }
    
    /**
     * Obtiene el HTML de un componente como string
     * 
     * @param string $component Ruta del componente
     * @param array $data Datos a pasar al componente
     * @return string HTML del componente
     */
    public static function get(string $component, array $data = []): string
    {
        ob_start();
        self::render($component, $data);
        return ob_get_clean();
    }
    
    /**
     * Verifica si un componente existe
     * 
     * @param string $component Ruta del componente
     * @return bool
     */
    public static function exists(string $component): bool
    {
        $componentPath = __DIR__ . "/../../public/views/components/{$component}.php";
        return file_exists($componentPath);
    }
}
