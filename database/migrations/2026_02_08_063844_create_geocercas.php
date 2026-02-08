<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeocercas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geocercas', function (Blueprint $table) {
            $table->string('id', 32)->unique();
            $table->string('id_administrador', 32);
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->enum('tipo', ['poligono', 'circular', 'radio'])->default('poligono');
            $table->json('coordenadas')->nullable(); // Para polígonos: [[lat,lng],[lat,lng],...]
            $table->decimal('latitud', 10, 8)->nullable(); // Para centro de círculo/radio
            $table->decimal('longitud', 11, 8)->nullable(); // Para centro de círculo/radio
            $table->decimal('radio', 10, 2)->nullable(); // En metros/kilómetros
            $table->enum('unidad_distancia', ['metros', 'kilometros'])->default('metros');
            $table->string('color', 7)->default('#3B82F6'); // Código hex color
            $table->boolean('activa')->default(true);
            $table->timestamps();
            
            // Índices
            $table->index('id_administrador');
            $table->index('tipo');
            $table->index('activa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('geocercas');
    }
}
