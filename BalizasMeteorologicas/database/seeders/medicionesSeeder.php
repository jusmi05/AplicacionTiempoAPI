<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicion;
use Database\Factories\MedicionFactory;

class MedicionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Definimos los IDs de las estaciones
        $estaciones = [1, 2, 3, 4, 5];

        // Iteramos por cada estación
        foreach ($estaciones as $estacionId) {

            // Reiniciar el incremento de tiempo antes de comenzar una nueva estación
            MedicionFactory::resetTimeIncrement();

            // Creamos 17568 mediciones para cada estación
            Medicion::factory()->count(2196)->create([
                'estacion_id' => $estacionId,  // Cambiar el 'estacion_id' según la estación
            ]);
        }
    }
}
