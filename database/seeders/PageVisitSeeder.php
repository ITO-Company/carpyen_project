<?php

namespace Database\Seeders;

use App\Models\PageVisit;
use Illuminate\Database\Seeder;

class PageVisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear registros iniciales de visitas para páginas comunes
        $pages = [
            ['page_name' => 'Dashboard', 'page_route' => '/'],
            ['page_name' => 'Cliente', 'page_route' => '/clientes'],
            ['page_name' => 'Cliente - Crear', 'page_route' => '/clientes/create'],
            ['page_name' => 'Proyecto', 'page_route' => '/proyectos'],
            ['page_name' => 'Proyecto - Crear', 'page_route' => '/proyectos/create'],
            ['page_name' => 'Cotizacion', 'page_route' => '/cotizaciones'],
            ['page_name' => 'Cotizacion - Crear', 'page_route' => '/cotizaciones/create'],
            ['page_name' => 'Diseno', 'page_route' => '/disenos'],
            ['page_name' => 'Diseno - Crear', 'page_route' => '/disenos/create'],
            ['page_name' => 'Producto', 'page_route' => '/productos'],
            ['page_name' => 'Producto - Crear', 'page_route' => '/productos/create'],
            ['page_name' => 'Proveedor', 'page_route' => '/proveedores'],
            ['page_name' => 'Proveedor - Crear', 'page_route' => '/proveedores/create'],
            ['page_name' => 'Plan Pago', 'page_route' => '/plan-pagos'],
            ['page_name' => 'Plan Pago - Crear', 'page_route' => '/plan-pagos/create'],
            ['page_name' => 'Pago', 'page_route' => '/pagos'],
            ['page_name' => 'Pago - Crear', 'page_route' => '/pagos/create'],
            ['page_name' => 'Cronograma', 'page_route' => '/cronogramas'],
            ['page_name' => 'Cronograma - Crear', 'page_route' => '/cronogramas/create'],
            ['page_name' => 'Tarea', 'page_route' => '/tareas'],
            ['page_name' => 'Tarea - Crear', 'page_route' => '/tareas/create'],
            ['page_name' => 'Evaluacion Servicio', 'page_route' => '/evaluacion-servicios'],
            ['page_name' => 'Evaluacion Servicio - Crear', 'page_route' => '/evaluacion-servicios/create'],
        ];

        foreach ($pages as $page) {
            PageVisit::updateOrCreate(
                ['page_name' => $page['page_name']],
                [
                    'page_route' => $page['page_route'],
                    'visit_count' => 0,
                ]
            );
        }
    }
}
