<?php
// src/cli/MakeController.php

namespace src\cli;

class MakeController
{
    /**
     * Genera un nuevo controlador.
     * @param string $name Nombre del controlador (ej: ProductoController)
     */
    public static function generate(string $name): void
    {
        // Asegurar que termina en "Controller"
        if (!str_ends_with($name, 'Controller')) {
            $name .= 'Controller';
        }

        $filePath = __DIR__ . '/../../src/controllers/' . $name . '.php';

        // Verificar si ya existe
        if (file_exists($filePath)) {
            self::error("El controlador {$name} ya existe.");
            return;
        }

        // Template del controlador
        $template = self::getTemplate($name);

        // Crear el archivo
        if (file_put_contents($filePath, $template)) {
            self::success("Controlador creado: src/controllers/{$name}.php");
            self::info("Puedes acceder a él en: /" . self::getRouteName($name) . "/index");
        } else {
            self::error("Error al crear el controlador.");
        }
    }

    /**
     * Obtiene el template del controlador.
     */
    private static function getTemplate(string $name): string
    {
        $modelName = str_replace('Controller', '', $name);
        $varName = strtolower($modelName);

        return <<<PHP
<?php
// src/controllers/{$name}.php

namespace src\controllers;

use src\models\\{$modelName};
use src\utils\Validator;

/**
 * Controlador para gestionar {$modelName}.
 * 
 * Rutas automáticas:
 * - GET  /{$varName}/index   -> index()
 * - GET  /{$varName}/show/1  -> show(1)
 * - GET  /{$varName}/create  -> create()
 * - POST /{$varName}/store   -> store()
 * - GET  /{$varName}/edit/1  -> edit(1)
 * - POST /{$varName}/update/1 -> update(1)
 * - POST /{$varName}/destroy/1 -> destroy(1)
 */
class {$name} extends BaseController
{
    /**
     * Muestra el listado principal.
     * URL: /{$varName}/index
     */
    public function index(): void
    {
        // Ejemplo: Obtener todos los registros
        // \$registros = {$modelName}::all();
        
        // Renderizar vista pasando datos
        // \$this->render('views/{$varName}/index', ['registros' => \$registros]);
        
        echo "<h1>Listado de {$modelName}</h1>";
    }

    /**
     * Muestra el detalle de un elemento específico.
     * URL: /{$varName}/show/{id}
     * @param int \$id ID del elemento
     */
    public function show(int \$id): void
    {
        // Ejemplo: Buscar por ID
        // \$item = {$modelName}::find(\$id);
        
        // if (!\$item) {
        //     \$this->render('views/404');
        //     return;
        // }

        // \$this->render('views/{$varName}/show', ['item' => \$item]);
        
        echo "<h1>Detalle de {$modelName} #{\$id}</h1>";
    }

    /**
     * Muestra el formulario de creación.
     * URL: /{$varName}/create
     */
    public function create(): void
    {
        // \$this->render('views/{$varName}/create');
        echo "<h1>Formulario Crear {$modelName}</h1>";
    }

    /**
     * Procesa el formulario de creación (POST).
     * URL: /{$varName}/store
     */
    public function store(): void
    {
        // 1. Validar datos
        // \$validator = new Validator(\$_POST);
        // \$validator->required(['nombre', 'email']);
        
        // if (\$validator->fails()) {
        //     \$_SESSION['error'] = \$validator->firstError();
        //     header('Location: /{$varName}/create');
        //     exit;
        // }

        // 2. Guardar en BD
        // \$item = new {$modelName}();
        // \$item->nombre = \$_POST['nombre'];
        // \$item->save();

        // 3. Redirigir
        // header('Location: /{$varName}/index');
        
        echo "<h1>Procesando creación...</h1>";
    }

    /**
     * Muestra el formulario de edición.
     * URL: /{$varName}/edit/{id}
     */
    public function edit(int \$id): void
    {
        // \$item = {$modelName}::find(\$id);
        // \$this->render('views/{$varName}/edit', ['item' => \$item]);
        echo "<h1>Formulario Editar {$modelName} #{\$id}</h1>";
    }

    /**
     * Actualiza un elemento existente (POST).
     * URL: /{$varName}/update/{id}
     */
    public function update(int \$id): void
    {
        // Lógica similar a store() pero actualizando
        echo "<h1>Actualizando {$modelName} #{\$id}...</h1>";
    }

    /**
     * Elimina un elemento.
     * URL: /{$varName}/destroy/{id}
     */
    public function destroy(int \$id): void
    {
        // \$item = {$modelName}::find(\$id);
        // \$item->delete();
        // header('Location: /{$varName}/index');
        echo "<h1>Eliminando {$modelName} #{\$id}...</h1>";
    }
}

PHP;
    }

    /**
     * Obtiene el nombre de la ruta basado en el nombre del controlador.
     */
    private static function getRouteName(string $name): string
    {
        // ProductoController -> producto
        $route = str_replace('Controller', '', $name);
        return strtolower($route);
    }

    private static function success(string $msg): void {
        echo "\033[32m✓ {$msg}\033[0m\n";
    }

    private static function error(string $msg): void {
        echo "\033[31m✗ {$msg}\033[0m\n";
    }

    private static function info(string $msg): void {
        echo "\033[33mℹ {$msg}\033[0m\n";
    }
}
