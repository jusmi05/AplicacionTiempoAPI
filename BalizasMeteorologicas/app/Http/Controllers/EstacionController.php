<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use Illuminate\Http\Request;

class EstacionController extends Controller
{
    public function getEstaciones()
    {
        // Obtener las estaciones desde la base de datos
        $estaciones = Estacion::all();

        return response()->json($estaciones);
    }

    public function deleteEstacion($id)
    {
        try {
            $estacion = Estacion::findOrFail($id); // Buscar la estación por ID
            $estacion->delete(); // Eliminar la estación

            return response()->json(['message' => 'Estación eliminada con éxito.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Estación no encontrada.'], 404);
        }
    }


    public function createEstacion(Request $request)
    {
        // Validar los datos entrantes
        $validated = $request->validate([
            'id' => 'required|integer|unique:estaciones,id', // Aseguramos que el ID sea único
            'altitud' => 'required|numeric',
            'municipio' => 'required|string|max:255',
            'provincia' => 'required|string|max:255',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'fecha_creacion' => 'required|date', // Aseguramos que sea una fecha válida
        ]);

        // Crear la nueva estación con los datos validados
        $estacion = Estacion::create([
            'id' => $validated['id'],
            'altitud' => $validated['altitud'],
            'municipio' => $validated['municipio'],
            'provincia' => $validated['provincia'],
            'latitud' => $validated['latitud'],
            'longitud' => $validated['longitud'],
            'fecha_creacion' => $validated['fecha_creacion'],
        ]);

        // Retornar una respuesta JSON con el mensaje de éxito y los datos de la estación creada
        return response()->json(['message' => 'Estación creada con éxito.', 'estacion' => $estacion], 201);
    }

    public function updateEstacion($id, Request $request)
    {
        try {
            // Buscar la estación por ID
            $estacion = Estacion::findOrFail($id);

            // Validar los datos entrantes
            $validated = $request->validate([
                'altitud' => 'sometimes|required|numeric',
                'municipio' => 'sometimes|required|string|max:255',
                'provincia' => 'sometimes|required|string|max:255',
                'latitud' => 'sometimes|required|numeric',
                'longitud' => 'sometimes|required|numeric',
                'fecha_creacion' => 'sometimes|required|date',
            ]);

            // Actualizar la estación con los nuevos datos
            $estacion->update([
                'altitud' => $validated['altitud'] ?? $estacion->altitud,
                'municipio' => $validated['municipio'] ?? $estacion->municipio,
                'provincia' => $validated['provincia'] ?? $estacion->provincia,
                'latitud' => $validated['latitud'] ?? $estacion->latitud,
                'longitud' => $validated['longitud'] ?? $estacion->longitud,
                'fecha_creacion' => $validated['fecha_creacion'] ?? $estacion->fecha_creacion,
            ]);

            // Retornar una respuesta JSON con el mensaje de éxito y los datos de la estación actualizada
            return response()->json(['message' => 'Estación actualizada con éxito.', 'estacion' => $estacion], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Estación no encontrada.'], 404);
        }
    }
}
