<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear ítems principales del menú
        $dashboard = MenuItem::create([
            'name' => 'dashboard',
            'label' => 'Dashboard',
            'icon' => 'LayoutGrid',
            'href' => '/dashboard',
            'order' => 1,
            'is_active' => true,
        ]);

        $clientes = MenuItem::create([
            'name' => 'clientes',
            'label' => 'Clientes',
            'icon' => 'Users',
            'href' => '/clientes',
            'order' => 2,
            'is_active' => true,
        ]);

        $proyectos = MenuItem::create([
            'name' => 'proyectos',
            'label' => 'Proyectos',
            'icon' => 'FolderOpen',
            'href' => '/proyectos',
            'order' => 3,
            'is_active' => true,
        ]);

        $cotizaciones = MenuItem::create([
            'name' => 'cotizaciones',
            'label' => 'Cotizaciones',
            'icon' => 'BarChart3',
            'href' => '/cotizaciones',
            'order' => 4,
            'is_active' => true,
        ]);

        $disenos = MenuItem::create([
            'name' => 'disenos',
            'label' => 'Diseños',
            'icon' => 'ShoppingCart',
            'href' => '/disenos',
            'order' => 5,
            'is_active' => true,
        ]);

        $productos = MenuItem::create([
            'name' => 'productos',
            'label' => 'Productos',
            'icon' => 'FileText',
            'href' => '/productos',
            'order' => 6,
            'is_active' => true,
        ]);

        $proveedores = MenuItem::create([
            'name' => 'proveedores',
            'label' => 'Proveedores',
            'icon' => 'Truck',
            'href' => '/proveedores',
            'order' => 7,
            'is_active' => true,
        ]);

        $planPagos = MenuItem::create([
            'name' => 'plan-pagos',
            'label' => 'Plan Pagos',
            'icon' => 'CreditCard',
            'href' => '/plan-pagos',
            'order' => 8,
            'is_active' => true,
        ]);

        $pagos = MenuItem::create([
            'name' => 'pagos',
            'label' => 'Pagos',
            'icon' => 'CreditCard',
            'href' => '/pagos',
            'order' => 9,
            'is_active' => true,
        ]);

        $cronogramas = MenuItem::create([
            'name' => 'cronogramas',
            'label' => 'Cronogramas',
            'icon' => 'Calendar',
            'href' => '/cronogramas',
            'order' => 10,
            'is_active' => true,
        ]);

        $tareas = MenuItem::create([
            'name' => 'tareas',
            'label' => 'Tareas',
            'icon' => 'CheckSquare',
            'href' => '/tareas',
            'order' => 11,
            'is_active' => true,
        ]);

        $evaluaciones = MenuItem::create([
            'name' => 'evaluaciones',
            'label' => 'Evaluaciones',
            'icon' => 'Star',
            'href' => '/evaluacion-servicios',
            'order' => 12,
            'is_active' => true,
        ]);
    }
}
