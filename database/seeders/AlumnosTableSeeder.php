<?php
// database/seeders/AlumnosTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumno;

class AlumnosTableSeeder extends Seeder
{
    public function run()
    {
        $alumnos = [
            [
                'nombre_completo' => 'María García López',
                'curso_academico' => '3º Primaria',
                'edad' => 8
            ],
            [
                'nombre_completo' => 'Carlos Rodríguez Martín',
                'curso_academico' => '5º Primaria',
                'edad' => 10
            ],
            [
                'nombre_completo' => 'Ana Fernández Silva',
                'curso_academico' => '2º ESO',
                'edad' => 13
            ],
            [
                'nombre_completo' => 'David Pérez Gómez',
                'curso_academico' => '4º Primaria',
                'edad' => 9
            ],
            [
                'nombre_completo' => 'Laura Martínez Ruiz',
                'curso_academico' => '1º Bachillerato',
                'edad' => 16
            ]
        ];

        foreach ($alumnos as $alumno) {
            Alumno::create($alumno);
        }
    }
}