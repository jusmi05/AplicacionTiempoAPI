<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;  // Añade esta línea

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
        Schema::create('estaciones', function (Blueprint $table) {
            $table->id();
            $table->float('altitud')->nullable();
            $table->string('municipio', 100)->nullable();
            $table->string('provincia', 50)->nullable();
            $table->float('latitud')->nullable();
            $table->float('longitud')->nullable();
            $table->timestamp('fecha_creacion')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->timestamps();
        });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estaciones');
    }
};
