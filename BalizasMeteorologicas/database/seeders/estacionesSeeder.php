<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class estacionesSeeder extends Seeder
{
    public function run(): void
    {
        // Insertar datos en la tabla `ciudades` para las ciudades mencionadas con altitud
        DB::table('estaciones')->insert([
            [
                'altitud' => 122,  // Altitud en metros
                'municipio' => 'Irun',
                'provincia' => 'Gipuzkoa',
                'latitud' => 43.3402,
                'longitud' => -1.82138,
                'fecha_creacion' => Carbon::create('2025', '01', '13', '00', '00', '00'),
            ],
            [
                'altitud' => 48,  // Altitud en metros
                'municipio' => 'Donostia',
                'provincia' => 'Gipuzkoa',
                'latitud' => 43.3218,
                'longitud' => -1.99834,
                'fecha_creacion' => Carbon::create('2025', '01', '13', '00', '00', '00'),
            ],
            [
                'altitud' => 546,  // Altitud en metros
                'municipio' => 'Vitoria-Gasteiz',
                'provincia' => 'Álava',
                'latitud' => 42.8604,
                'longitud' => -2.68899,
                'fecha_creacion' => Carbon::create('2025', '01', '13', '00', '00', '00'),
            ],
            [
                'altitud' => 13,  // Altitud en metros
                'municipio' => 'Bilbao',
                'provincia' => 'Bizkaia',
                'latitud' => 43.2630,
                'longitud' => -2.9340,
                'fecha_creacion' => Carbon::create('2025', '01', '13', '00', '00', '00'),
            ],
            [
                'altitud' => 51,  // Altitud en metros
                'municipio' => 'Errenteria',
                'provincia' => 'Gipuzkoa',
                'latitud' =>  43.3125271,
                'longitud' => -1.8986133,
                'fecha_creacion' => Carbon::create('2025', '01', '13', '00', '00', '00'),
            ],
        ]);
    }
}
