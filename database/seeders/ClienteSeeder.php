<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = [
            [
                'nombre' => 'Juan Carlos López',
                'email' => 'juan.carlos@empresa.com',
                'telefono' => '555-0001',
                'direccion' => 'Calle Principal 123, Edificio A',
            ],
            [
                'nombre' => 'María González Ruiz',
                'email' => 'maria.gonzalez@empresa.com',
                'telefono' => '555-0002',
                'direccion' => 'Avenida Central 456, Piso 2',
            ],
            [
                'nombre' => 'Carlos Martínez Pérez',
                'email' => 'carlos.martinez@empresa.com',
                'telefono' => '555-0003',
                'direccion' => 'Paseo de la Reforma 789, Suite 100',
            ],
            [
                'nombre' => 'Ana Rodríguez Fernández',
                'email' => 'ana.rodriguez@empresa.com',
                'telefono' => '555-0004',
                'direccion' => 'Boulevard del Norte 321, Local 5',
            ],
            [
                'nombre' => 'Roberto Sánchez García',
                'email' => 'roberto.sanchez@empresa.com',
                'telefono' => '555-0005',
                'direccion' => 'Calle Sur 654, Departamento 10',
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }

        $this->command->info('Se han creado ' . count($clientes) . ' clientes.');
    }
}
