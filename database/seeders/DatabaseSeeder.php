<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamada a tu seeder personalizado
        $this->call(ClientesSeeder::class); // Asegúrate que el nombre coincida
    }
    public function run2(): void
    {
        // Llamada a tu seeder personalizado
        $this->call(ClientesSeeder::class); // Asegúrate que el nombre coincida
    }
}