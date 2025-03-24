<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estacion extends Model
{
    use HasFactory;

    protected $table = 'estaciones'; // Asegúrate de usar el nombre correcto de la tabla

    protected $fillable = [
        'altitud', 'municipio',
        'provincia', 'latitud', 'longitud', 'fecha_creacion',
    ];

    // Relación con Mediciones
    public function mediciones()
    {
        return $this->hasMany(Medicion::class, 'estacion_id');
    }
}
