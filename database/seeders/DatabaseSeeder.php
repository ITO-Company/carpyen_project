<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345'),
        ]);

        // Seed menu items
        $this->call(MenuItemSeeder::class);
        
        // Seed clientes y proyectos (requeridos para planes de pago)
        $this->call(ClienteSeeder::class);
        $this->call(ProyectoSeeder::class);
        
        // Seed planes de pago y pagos
        $this->call(PlanPagoSeeder::class);
    }
}
