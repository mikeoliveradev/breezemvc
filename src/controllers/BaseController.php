<?php
// src/controllers/BaseController.php

namespace src\controllers;

class BaseController
{
    /**
     * Renderiza una vista (archivo PHP/HTML) pasando datos.
     * 
     * Ejemplo de uso:
     * $this->render('views/productos/index', ['titulo' => 'Lista', 'items' => $lista]);
     * 
     * @param string $view Ruta relativa a la vista (ej: 'productos/detalle')
     * @param array $data Datos a extraer para la vista (clave => valor)
     */
    protected function render(string $view, array $data = []): void
    {
        // Extraer los datos para que sean variables locales en la vista
        // Ej: ['titulo' => 'Hola'] se convierte en $titulo = 'Hola'
        extract($data);

        // Construir ruta completa
        // Asumimos que las vistas están en public/views o similar, 
        // pero por flexibilidad del proyecto actual, buscamos en public/
        // Ajusta esta ruta base según tu estructura real de vistas.
        $viewFile = __DIR__ . '/../../public/' . $view . '.php';

        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo "Error: La vista '{$view}' no existe.";
        }
    }

    /**
     * Envía una respuesta en formato JSON.
     * Útil para APIs o peticiones AJAX.
     * 
     * Ejemplo de uso:
     * $this->jsonResponse(['status' => 'ok', 'data' => $usuario]);
     * 
     * @param mixed $data Datos a codificar
     * @param int $statusCode Código HTTP (200 por defecto)
     */
    protected function jsonResponse($data, int $statusCode = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
}
