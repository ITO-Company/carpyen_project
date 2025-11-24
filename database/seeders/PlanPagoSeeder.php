<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlanPago;
use App\Models\Proyecto;
use App\Models\Pago;
use App\Models\Cliente;
use Carbon\Carbon;

class PlanPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener proyectos y clientes existentes
        $proyectos = Proyecto::all();
        $clientes = Cliente::all();

        if ($proyectos->isEmpty() || $clientes->isEmpty()) {
            $this->command->warn('No hay proyectos o clientes en la base de datos. Crea algunos primero.');
            return;
        }

        // Crear planes de pago
        $planes = [
            [
                'deuda_total' => 50000.00,
                'numero_pagos' => 5,
                'numero_deuda' => 1,
                'estado' => 'activo',
                'proyecto' => $proyectos->random(),
                'pagos' => [
                    [
                        'fecha' => Carbon::now()->addDays(30),
                        'total' => 10000.00,
                        'estado' => 'pendiente',
                    ],
                    [
                        'fecha' => Carbon::now()->addDays(60),
                        'total' => 10000.00,
                        'estado' => 'pendiente',
                    ],
                    [
                        'fecha' => Carbon::now()->addDays(90),
                        'total' => 10000.00,
                        'estado' => 'pendiente',
                    ],
                    [
                        'fecha' => Carbon::now()->addDays(120),
                        'total' => 10000.00,
                        'estado' => 'pendiente',
                    ],
                    [
                        'fecha' => Carbon::now()->addDays(150),
                        'total' => 10000.00,
                        'estado' => 'pendiente',
                    ],
                ]
            ],
            [
                'deuda_total' => 75000.00,
                'numero_pagos' => 3,
                'numero_deuda' => 2,
                'estado' => 'activo',
                'proyecto' => $proyectos->random(),
                'pagos' => [
                    [
                        'fecha' => Carbon::now()->addDays(45),
                        'total' => 25000.00,
                        'estado' => 'pendiente',
                    ],
                    [
                        'fecha' => Carbon::now()->addDays(90),
                        'total' => 25000.00,
                        'estado' => 'pendiente',
                    ],
                    [
                        'fecha' => Carbon::now()->addDays(135),
                        'total' => 25000.00,
                        'estado' => 'pendiente',
                    ],
                ]
            ],
            [
                'deuda_total' => 30000.00,
                'numero_pagos' => 4,
                'numero_deuda' => 3,
                'estado' => 'completado',
                'proyecto' => $proyectos->random(),
                'pagos' => [
                    [
                        'fecha' => Carbon::now()->subDays(90),
                        'total' => 7500.00,
                        'estado' => 'pagado',
                    ],
                    [
                        'fecha' => Carbon::now()->subDays(60),
                        'total' => 7500.00,
                        'estado' => 'pagado',
                    ],
                    [
                        'fecha' => Carbon::now()->subDays(30),
                        'total' => 7500.00,
                        'estado' => 'pagado',
                    ],
                    [
                        'fecha' => Carbon::now(),
                        'total' => 7500.00,
                        'estado' => 'pagado',
                    ],
                ]
            ],
        ];

        foreach ($planes as $planData) {
            $proyecto = $planData['proyecto'];
            $cliente = $proyecto->cliente;
            $pagosData = $planData['pagos'];
            unset($planData['proyecto'], $planData['pagos']);

            // Crear plan de pago
            $plan = PlanPago::create([
                ...$planData,
                'id_proyecto' => $proyecto->id,
                'pagado_total' => 0,
            ]);

            // Crear pagos asociados
            foreach ($pagosData as $pagoData) {
                Pago::create([
                    ...$pagoData,
                    'id_plan_pago' => $plan->id,
                    'id_cliente' => $cliente->id,
                ]);
            }

            // Actualizar pagado_total si hay pagos completados
            $pagadoTotal = Pago::where('id_plan_pago', $plan->id)
                ->where('estado', 'pagado')
                ->sum('total');
            
            $plan->update(['pagado_total' => $pagadoTotal]);
        }

        $this->command->info('Se han creado ' . count($planes) . ' planes de pago con sus pagos asociados.');
    }
}
