<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nombres y apellidos aleatorios para los clientes
        $nombres = ['Juan', 'María', 'Pedro', 'Ana', 'Luis', 'Sofía', 'Carlos', 'Lucía'];
        $apellidos = ['Pérez', 'García', 'Rodríguez', 'López', 'Martínez', 'Sánchez', 'Ramírez', 'Torres'];

        // Generar clientes para cada día de octubre de 2024
        for ($dia = 1; $dia <= 31; $dia++) {
            // Definir una cantidad aleatoria de clientes para el día actual (entre 1 y 10)
            $cantidadClientes = rand(1, 10);

            // Insertar los clientes para ese día
            for ($i = 0; $i < $cantidadClientes; $i++) {
                DB::table('clientes')->insert([
                    'nombre' => $nombres[array_rand($nombres)],
                    'apellido' => $apellidos[array_rand($apellidos)],
                    'apellidoMat' => $apellidos[array_rand($apellidos)],
                    'nroReinscripciones' => rand(0, 5),
                    'direccion' => 'Calle Falsa ' . rand(1, 100),
                    'costo' => rand(50, 200), // costo aleatorio entre 500 y 5000
                    'codigo' => rand(100000, 999999), // código único
                    'modalidad' => 'Presencial',
                    'horario' => 'Matutino',
                    'observciones' => null,
                    'usuario' => 'Usuario' . rand(1, 100),
                    'nrsesiones' => rand(1, 20),
                    'descuento' => rand(0, 20),
                    'edad' => rand(18, 60),
                    'telefono' => rand(1000000000, 9999999999),
                    'created_at' => Carbon::create(2024, 10, $dia)->toDateTimeString(),
                    'created_at' => Carbon::create(2024, 9, $dia)->toDateTimeString(), // fecha en octubre 2024
                    
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }
        }
    }
   
        
    
}
