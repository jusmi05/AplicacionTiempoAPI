<?php

use App\Http\Controllers\EstacionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/app', function () {
    return view('app'); // Carga la vista principal
});

// Grupo para estaciones
Route::prefix('/estaciones')->group(function () {
    // Obtener todas las estaciones
    Route::get('/', [EstacionController::class, 'getEstaciones']);
    // Crear una nueva estación
    Route::post('/create', [EstacionController::class, 'createEstacion']);
    // Actualizar una estación existente
    Route::put('/update/{id}', [EstacionController::class, 'updateEstacion']);
    // Eliminar una estación por ID
    Route::delete('/delete/{id}', [EstacionController::class, 'deleteEstacion']);
});

// Grupo para mediciones
Route::prefix('/mediciones')->group(function () {
    // Obtener el clima de una ciudad
    Route::get('/{city}', [WeatherController::class, 'getWeather']);
    // Obtener el pronóstico del clima
    Route::get('/pronostico/{city}', [WeatherController::class, 'getForecast']);
    // Obtener el historial del clima entre dos fechas
    Route::get('/weather-history/{city}/{start_date}/{end_date}', [WeatherController::class, 'getWeatherHistory']);
});
