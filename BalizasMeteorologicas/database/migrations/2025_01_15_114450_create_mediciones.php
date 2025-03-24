<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('mediciones', function (Blueprint $table) {
            $table->id();  // Clave primaria autoincremental
            $table->unsignedBigInteger('estacion_id');  // Relación con la tabla `estaciones`
            $table->float('temperatura')->nullable();       // Temperatura en °C
            $table->float('humedad')->nullable();           // Humedad relativa en %
            $table->float('presion')->nullable();           // Presión atmosférica en hPa
            $table->float('viento_velocidad')->nullable();  // Velocidad del viento en m/s
            $table->integer('viento_direccion')->nullable(); // Dirección del viento en grados (0-360)
            $table->float('nubosidad')->nullable();         // Nubosidad en porcentaje (%)
            $table->dateTime('fecha_hora')->nullable();     // Fecha y hora en que se tomó la medición
            $table->timestamps();                           // Campos created_at y updated_at

            // Definir la clave foránea que enlaza con la tabla `estaciones`
            $table->foreign('estacion_id')
                  ->references('id')
                  ->on('estaciones')
                  ->onDelete('cascade'); // Borra las mediciones si la estación se elimina
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('mediciones'); // Elimina la tabla `mediciones`
    }
};
