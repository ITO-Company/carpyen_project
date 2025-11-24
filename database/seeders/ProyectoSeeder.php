<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proyecto;
use App\Models\Cliente;
use App\Models\User;

class ProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = Cliente::all();
        $users = User::all();

        if ($clientes->isEmpty() || $users->isEmpty()) {
            $this->command->warn('No hay clientes o usuarios en la base de datos.');
            return;
        }

        $proyectos = [
            [
                'nombre' => 'Sitio Web Corporativo',
                'descripcion' => 'Desarrollo de sitio web corporativo con diseño moderno y responsive',
                'ubicacion' => 'Oficina Central, Piso 3',
                'estado' => 'en_progreso',
                'id_cliente' => $clientes->first()->id,
                'user_id' => $users->first()->id,
            ],
            [
                'nombre' => 'Aplicación Móvil de Ventas',
                'descripcion' => 'Desarrollo de app móvil para gestión de ventas con sincronización en tiempo real',
                'ubicacion' => 'Centro de Desarrollo',
                'estado' => 'en_progreso',
                'id_cliente' => $clientes[1]->id ?? $clientes->first()->id,
                'user_id' => $users->first()->id,
            ],
            [
                'nombre' => 'Sistema de Gestión Administrativa',
                'descripcion' => 'Sistema ERP para gestión integral de la empresa',
                'ubicacion' => 'Servidor en la nube',
                'estado' => 'en_progreso',
                'id_cliente' => $clientes[2]->id ?? $clientes->first()->id,
                'user_id' => $users->first()->id,
            ],
            [
                'nombre' => 'Plataforma de E-commerce',
                'descripcion' => 'Tienda online con carrito de compras y pasarela de pago',
                'ubicacion' => 'Servidor Dedicado',
                'estado' => 'completado',
                'id_cliente' => $clientes[3]->id ?? $clientes->first()->id,
                'user_id' => $users->first()->id,
            ],
            [
                'nombre' => 'Rediseño de Interfaz Usuario',
                'descripcion' => 'Rediseño completo de UI/UX para la plataforma existente',
                'ubicacion' => 'Remoto',
                'estado' => 'en_progreso',
                'id_cliente' => $clientes[4]->id ?? $clientes->first()->id,
                'user_id' => $users->first()->id,
            ],
        ];

        foreach ($proyectos as $proyecto) {
            Proyecto::create($proyecto);
        }

        $this->command->info('Se han creado ' . count($proyectos) . ' proyectos.');
    }
}
