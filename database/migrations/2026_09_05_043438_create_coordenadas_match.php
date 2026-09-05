<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('coordenadas_match', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('coordenada_bruto_id');
            $table->decimal('latitud', 10, 8);
            $table->decimal('longitud', 11, 8);
            $table->string('datetime');
            $table->text('datos_bluetooth');
            $table->timestamp('recibido_at')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('coordenada_bruto_id');
            $table->index('datetime');
        });
    }

    public function down()
    {
        Schema::dropIfExists('coordenadas_match');
    }
};