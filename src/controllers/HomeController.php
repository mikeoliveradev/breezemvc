<?php
// src/controllers/HomeController.php

namespace src\controllers;

use src\utils\Utils;

class HomeController extends BaseController
{
    /**
     * Muestra la página principal del sitio.
     */
    public function index()
    {
        // Preparar datos para la vista
        $data = [
            'pageTitle' => 'Inicio - Impulsora',
            'pageDescription' => 'Distribuidor Parker: Soluciones en líneas de producción, extracción petrolera, energías renovables y automatización industrial.',
            
            // Estadísticas
            'stats' => [
                'years' => 10,
                'sales' => '+ 35k',
                'satisfaction' => '99%'
            ],
            
            // Slides del hero
            'heroSlides' => [
                [
                    'image' => 'assets/img/others/impulsora-soluciones-en-lineas-de-produccion-2.jpg',
                    'title' => 'Tecnología Parker: impulsando su retorno de inversión.',
                    'subtitle' => '¿Por qué elegirnos?',
                    'description' => 'Como distribuidor Parker, ofrecemos la vanguardia en soluciones diseñadas para brindar respuestas ágiles y el mejor retorno de inversión a nuestros clientes.'
                ],
                [
                    'image' => 'assets/img/others/impulsora-soluciones-en-extraccion-petrolera-3.jpg',
                    'title' => 'Expertos en soluciones Parker para hidrocarburos.',
                    'subtitle' => 'Cotice su proyecto hoy',
                    'description' => 'Suministramos productos y servicios para controles hidráulicos, incluidas aplicaciones marinas. En operaciones en tierra y mar. Seguridad y calidad a la industria de Petroquímica y Refinación en México.'
                ],
                [
                    'image' => 'assets/img/others/impulsora-soluciones-en-energias-renovables-3.jpg',
                    'title' => 'Distribuidor Parker: movimiento para un futuro sostenible.',
                    'subtitle' => 'Vea nuestras aplicaciones',
                    'description' => 'Si bien nos enfocamos en el sector energético, nuestra tecnología Parker es clave en la optimización de procesos de energías renovables.'
                ],
                [
                    'image' => 'assets/img/others/impulsora-soluciones-en-automatizacion-industrial-3.jpg',
                    'title' => 'Distribuidor Parker, soluciones para el sector industrial.',
                    'subtitle' => 'Conozca el catálogo Parker',
                    'description' => 'Somos el socio líder en tecnologías de control y movimiento. Suministramos seguridad y calidad a la industria automotriz, aeronáutica y de manufactura.'
                ]
            ],
            
            // Servicios
            'services' => [
                [
                    'number' => '1',
                    'title' => 'Venta especializada',
                    'description' => 'Tenemos la gama más completa en productos para la industria mexicana.<br><br>Tenemos la capacidad para proveer cualquier pieza o material que necesite para su línea de producción, somos los únicos en México con el catálogo Parker más amplio.'
                ],
                [
                    'number' => '2',
                    'title' => 'Asesoría',
                    'description' => 'Impulsora cuenta con personal especializado con un respaldo de 20 años de experiencia.<br><br>Podemos ofrecerle una asesoría especializada ya sea telefónica, por correo electrónico o chat en línea a través de nuestra página web, para que su empresa obtenga el producto exacto a sus necesidades.'
                ],
                [
                    'number' => '3',
                    'title' => 'Capacitación',
                    'description' => 'Para la perfecta colocación de las piezas.<br><br>Cuando adquiera productos extremadamente delicados, podemos ofrecer capacitación para su adecuada colocación.'
                ]
            ],
            
            // Productos
            'products' => [
                ['name' => 'Mangueras y tubing', 'image' => 'assets/img/productos/mangueras-y-tubing.png'],
                ['name' => 'O-Rings', 'image' => 'assets/img/productos/0-rings.png'],
                ['name' => 'Filtros separadores y purificadores', 'image' => 'assets/img/productos/filtros-separadores-y-purificadores.png'],
                ['name' => 'Motores drives y controladores', 'image' => 'assets/img/productos/motores-drives-y-controladores.png'],
                ['name' => 'Reguladores control de flujo y medicion', 'image' => 'assets/img/productos/reguladores-control-de-flujo-y-medicion.png'],
                ['name' => 'Tratamiento de aire y secadores', 'image' => 'assets/img/productos/tratamiento-de-aire-y-secadores.png'],
                ['name' => 'Aeroespacial', 'image' => 'assets/img/productos/aeroespacial.png'],
                ['name' => 'EMI', 'image' => 'assets/img/productos/emi.png'],
                ['name' => 'Generadores de gas', 'image' => 'assets/img/productos/generadores-de-gas.png'],
                ['name' => 'Refrigeración', 'image' => 'assets/img/productos/refrigeracion.png'],
                ['name' => 'Bioprocesamiento y tecnologías médicas', 'image' => 'assets/img/productos/bioprocesamiento-y-tecnologias-medicas.png'],
                ['name' => 'Gestión térmica y potencia', 'image' => 'assets/img/productos/gestion-termica-y-potencia.png'],
                ['name' => 'Sistemas de accionamiento y de tomas de fuerza', 'image' => 'assets/img/productos/sistemas-de-accionamiento-y-de-tomas-de-fuerza.png'],
                ['name' => 'Racores y acoplamientos rápidos', 'image' => 'assets/img/productos/racores-y-acoplamientos-rapidos.png'],
                ['name' => 'Válvulas', 'image' => 'assets/img/productos/valvulas.png'],
                ['name' => 'Cilindros y accionadores', 'image' => 'assets/img/productos/cilindros-y-accionadores.png'],
                ['name' => 'Bombas', 'image' => 'assets/img/productos/bombas.png']
            ],
            
            // Información de contacto
            'contact' => [
                'phone' => '(55) 5788 9091',
                'email' => 'informes@impulsora.me',
                'address' => 'Pachuca N0. 8, Col. Cuauhtémoc Xalostoc. Estado de México.',
                'mapCoords' => [37.4040344, -122.0289704] // Actualizar con coordenadas reales
            ]
        ];
        
        // Renderizar la vista principal
        $this->render('views/home/index', $data);
    }
}
