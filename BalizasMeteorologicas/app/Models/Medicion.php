<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicion extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'mediciones';

    // Campos asignables en masa
    protected $fillable = [
        'estacion_id',
        'temperatura',
        'humedad',
        'presion',
        'viento_velocidad',
        'viento_direccion',
        'nubosidad',
        'fecha_hora',
    ];

    // Relación con la tabla estaciones
    public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'estacion_id');
    }
}
