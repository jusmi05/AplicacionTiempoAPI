<?php

namespace App\Http\Controllers;

use App\Models\Medicion;

class MedicionController extends Controller
{
    public function show($id)
    {
        return Medicion::where('estacion_id', $id)
            ->orderBy('fecha_hora', 'desc')
            ->first(['temperatura', 'humedad', 'fecha_hora']);
    }
}
