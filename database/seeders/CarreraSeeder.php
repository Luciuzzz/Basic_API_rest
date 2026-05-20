<?php

namespace Database\Seeders;

use App\Models\Carrera;
use Illuminate\Database\Seeder;

class CarreraSeeder extends Seeder
{
    public function run(): void
    {
        $carreras = [
            [
                'nombre' => 'Administración de Empresas',
                'facultad' => 'Facultad de Ciencias Empresariales',
                'duracion_semestres' => 8,
            ],
            [
                'nombre' => 'Bioquímica',
                'facultad' => 'Facultad de Ciencias de la Salud',
                'duracion_semestres' => 10,
            ],
            [
                'nombre' => 'Ciencias Contables',
                'facultad' => 'Facultad de Ciencias Empresariales',
                'duracion_semestres' => 8,
            ],
            [
                'nombre' => 'Comercio Exterior y Relaciones Internacionales',
                'facultad' => 'Facultad de Ciencias Empresariales',
                'duracion_semestres' => 8,
            ],
            [
                'nombre' => 'Derecho',
                'facultad' => 'Facultad de Ciencias Jurídicas',
                'duracion_semestres' => 10,
            ],
            [
                'nombre' => 'Enfermería',
                'facultad' => 'Facultad de Ciencias de la Salud',
                'duracion_semestres' => 8,
            ],
            [
                'nombre' => 'Fisioterapia y Kinesiología',
                'facultad' => 'Facultad de Ciencias de la Salud',
                'duracion_semestres' => 8,
            ],
            [
                'nombre' => 'Ingeniería Comercial',
                'facultad' => 'Facultad de Ciencias Empresariales',
                'duracion_semestres' => 10,
            ],
            [
                'nombre' => 'Ingeniería Electromecánica',
                'facultad' => 'Facultad de Ingeniería',
                'duracion_semestres' => 10,
            ],
            [
                'nombre' => 'Ingeniería Informática',
                'facultad' => 'Facultad de Ingeniería',
                'duracion_semestres' => 10,
            ],
            [
                'nombre' => 'Odontología',
                'facultad' => 'Facultad de Ciencias de la Salud',
                'duracion_semestres' => 10,
            ],
            [
                'nombre' => 'Mercadotecnia',
                'facultad' => 'Facultad de Ciencias Empresariales',
                'duracion_semestres' => 8,
            ],
            [
                'nombre' => 'Medicina',
                'facultad' => 'Facultad de Ciencias de la Salud',
                'duracion_semestres' => 12,
            ],
            [
                'nombre' => 'Periodismo',
                'facultad' => 'Facultad de Ciencias Sociales',
                'duracion_semestres' => 8,
            ],
            [
                'nombre' => 'Psicología',
                'facultad' => 'Facultad de Ciencias Sociales',
                'duracion_semestres' => 10,
            ],
            [
                'nombre' => 'Nutrición',
                'facultad' => 'Facultad de Ciencias de la Salud',
                'duracion_semestres' => 8,
            ],
        ];

        foreach ($carreras as $carrera) {
            Carrera::updateOrCreate(
                ['nombre' => $carrera['nombre']],
                [
                    'facultad' => $carrera['facultad'],
                    'duracion_semestres' => $carrera['duracion_semestres'],
                ]
            );
        }
    }
}
