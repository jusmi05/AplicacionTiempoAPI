<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class WeatherController extends Controller
{
    public function getWeather($ciudad)
    {
        // Realiza el JOIN entre estaciones y mediciones
        $ultimaMedicion = DB::table('mediciones')
            ->join('estaciones', 'estaciones.id', '=', 'mediciones.estacion_id') // Une las tablas por estación
            ->where('estaciones.municipio', $ciudad) // Filtra por municipio que coincida con la ciudad
            ->orderBy('mediciones.created_at', 'desc') // Ordena por la fecha de creación (más reciente primero)
            ->select(
                'mediciones.*', // Selecciona todos los campos de mediciones
            )
            ->first(); // Obtiene solo el último registro

        // Verifica si se encontró un resultado
        if (!$ultimaMedicion) {
            return response()->json(['error' => 'No se encontraron mediciones para esta ciudad'], 404);
        }

        // Devuelve los datos como respuesta JSON
        return response()->json($ultimaMedicion);
    }

    public function getForecast($city)
    {
        $apiKey = "82dabf3bf2faa74193a51043141b50fc";
        $url = "https://api.openweathermap.org/data/2.5/forecast?q=" . urlencode($city) . "&appid={$apiKey}&units=metric&lang=es";

        $response = Http::get($url);
        $data = $response->json();

        if (!isset($data['list'])) {
            return response()->json(["error" => "No se encontraron datos para la ciudad especificada"]);
        }

        // Filtrar pronósticos para cada día a las 15:00:00
        $filteredForecast = [];
        foreach ($data['list'] as $forecast) {
            $hour = date('H', $forecast['dt']);
            if ($hour == '15') {
                $filteredForecast[] = $forecast;
            }
        }

        // Remover el último día de pronóstico si hay al menos un día en la lista
        if (count($filteredForecast) > 0) {
            array_pop($filteredForecast);
        }

        return response()->json(["list" => $filteredForecast]);
    }
    public function getWeatherHistory($city, $start, $end)
    {
        // Consulta con JOIN entre 'mediciones' y 'balizas' usando la relación 'estacion_id' y 'id'
        $results = DB::select('SELECT m.temperatura, m.humedad, m.fecha_hora
                               FROM mediciones AS m
                               JOIN estaciones AS e ON m.estacion_id = e.id
                               WHERE e.municipio = ?
                               AND m.fecha_hora BETWEEN ? AND ?', [$city, $start, $end]);

        // Devolvemos los resultados en formato JSON
        return response()->json($results);
    }
}
