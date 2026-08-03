<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipoEstados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipo_estados', function (Blueprint $table) {
            $table->id();
            $table->string('mac')->index(); // Guardará la MAC (puedes estandarizarla a minúsculas en el controlador)
            $table->boolean('cerrado'); // 1 para cerrado, 0 para abierto
            $table->decimal('latitud', 10, 8); // Coordenadas con buena precisión
            $table->decimal('longitud', 11, 8);
            $table->timestamp('datetime'); // Fecha y hora enviada por el equipo
            $table->timestamps(); // created_at y updated_at de Laravel
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipo_estados');
    }
}
