<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActividadesTableSeeder extends Seeder
{
    public function run()
    {
        $actividades = [
            [
                'nombre' => 'Robótica',
                'descripcion' => 'Introducción a la programación y robótica educativa',
                'dia_semana' => 'Lunes',
                'hora_inicio' => '16:00',
                'hora_finalizacion' => '18:00',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Ajedrez',
                'descripcion' => 'Estrategias y técnicas de ajedrez para todos los niveles',
                'dia_semana' => 'Martes',
                'hora_inicio' => '17:00',
                'hora_finalizacion' => '19:00',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Pintura',
                'descripcion' => 'Expresión artística a través de la pintura',
                'dia_semana' => 'Miércoles',
                'hora_inicio' => '16:30',
                'hora_finalizacion' => '18:30',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Inglés',
                'descripcion' => 'Refuerzo de inglés conversacional',
                'dia_semana' => 'Jueves',
                'hora_inicio' => '17:30',
                'hora_finalizacion' => '19:00',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        // Usar DB facade para evitar problemas con el modelo
        DB::table('actividades')->insert($actividades);
    }
}