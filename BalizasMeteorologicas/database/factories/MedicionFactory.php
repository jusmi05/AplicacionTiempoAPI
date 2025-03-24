<?php

namespace Database\Factories;

use App\Models\Medicion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class MedicionFactory extends Factory
{
    protected $model = Medicion::class;

    // Variable estática para controlar el incremento de tiempo
    private static $timeIncrement = 0;

    /**
     * Reinicia el incremento de tiempo.
     */
    public static function resetTimeIncrement()
    {
        self::$timeIncrement = 0;
    }

    public function definition()
    {
        // Temperatura base (puedes ajustarla según la ciudad o estación)
        static $baseTemperature = 15; // Temperatura base de 15°C

        // Generar temperaturas, con una fluctuación controlada
        $temperatureChange = rand(-2, 2); // Cambios entre -2°C y +2°C
        $temperature = $baseTemperature + $temperatureChange;

        // Humedad controlada, debe estar entre 60% y 80%
        $humidityChange = rand(-2, 2); // Cambios pequeños en la humedad
        $humidity = max(60, min(80, 70 + $humidityChange)); // Humedad entre 60% y 80%

        // Presión atmosférica, variación normal en intervalos
        $pressureChange = rand(-1, 1); // Cambios pequeños en la presión
        $pressure = 1013 + $pressureChange; // Presión en hPa, ajustada a un valor base de 1013 hPa

        // Viento, manteniendo una variación aún más pequeña
        $windSpeedChange = rand(-0.5, 0.5); // Cambios pequeños en la velocidad del viento (m/s)
        $windSpeed = max(0, min(20, 5 + $windSpeedChange)); // Viento entre 0 y 20 m/s

        // Dirección del viento, con una pequeña variación
        $windDirectionChange = rand(-10, 10); // Cambios pequeños en la dirección del viento
        $windDirection = (rand(0, 360) + $windDirectionChange) % 360; // Dirección del viento entre 0 y 360 grados, con fluctuación mínima

        // Nubosidad
        $cloudiness = rand(0, 100); // Nubosidad entre 0% y 100%

        // Establecer la fecha inicial: 1 de enero de 2024
        if (self::$timeIncrement == 0) {
            $date = Carbon::create(2024, 1, 1, 0, 0, 0);
        } else {
            // Incrementar el tiempo en 15 minutos para cada nueva medición
            $date = Carbon::create(2024, 1, 1, 0, 0, 0)->addMinutes(self::$timeIncrement);
        }

        self::$timeIncrement += 120; // Aumentar el contador en 15 minutos para la próxima medición

        return [
            // 1. Estación de medición
            'estacion_id' => 1,  // Puedes ajustar esto según la estación específica
            // 2. Temperatura
            'temperatura' => $temperature,
            // 3. Humedad
            'humedad' => $humidity,
            // 4. Presión
            'presion' => $pressure,
            // 5. Velocidad del viento
            'viento_velocidad' => $windSpeed,
            // 6. Dirección del viento
            'viento_direccion' => $windDirection,
            // 7. Nubosidad
            'nubosidad' => $cloudiness,
            // 8. Fecha y hora de la medición
            'fecha_hora' => $date,
        ];
    }
}
