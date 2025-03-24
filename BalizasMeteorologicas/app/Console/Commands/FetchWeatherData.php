<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class FetchWeatherData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and store weather data for all cities in the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $apiKey =  "82dabf3bf2faa74193a51043141b50fc";
        $baseUrl = 'https://api.openweathermap.org/data/2.5/weather';

        // Obtener todas las estaciones de la base de datos
        $estaciones = DB::table('estaciones')->get();

        if ($estaciones->isEmpty()) {
            $this->error('No se encontraron estaciones en la base de datos.');
            return 1;
        }

        foreach ($estaciones as $estacion) {
            $this->info("Procesando datos para: {$estacion->municipio}...");

            // Realizar la solicitud a la API para cada estación
            $response = Http::get($baseUrl, [
                'lat' => $estacion->latitud,
                'lon' => $estacion->longitud,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'es',
            ]);

            if ($response->ok()) {
                $data = $response->json();

                // Extraer los datos relevantes
                $temperatura = $data['main']['temp'] ?? null;
                $humedad = $data['main']['humidity'] ?? null;
                $presion = $data['main']['pressure'] ?? null;
                $vientoVelocidad = $data['wind']['speed'] ?? null;
                $vientoDireccion = $data['wind']['deg'] ?? null;
                $nubosidad = $data['clouds']['all'] ?? null;

                // Insertar los datos en la tabla `mediciones`
                DB::table('mediciones')->insert([
                    'estacion_id' => $estacion->id,
                    'temperatura' => $temperatura,
                    'humedad' => $humedad,
                    'presion' => $presion,
                    'viento_velocidad' => $vientoVelocidad,
                    'viento_direccion' => $vientoDireccion,
                    'nubosidad' => $nubosidad,
                    'fecha_hora' => Carbon::now()->toDateTimeString(),
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);

                $this->info("Datos guardados para: {$estacion->municipio}.");
            } else {
                $this->error("Error al obtener datos para: {$estacion->municipio}.");
            }
        }

        $this->info('Proceso completado.');
        return 0;
    }
}
