<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpeners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('openers', function (Blueprint $table) {
            $table->string('id',32)->unique();
            $table->string('id_administrador',32);
            $table->string('nombres',150);
            $table->string('apellidos',150);
            $table->string('mail',150)->unique();
            $table->string('pass',150);
            $table->string('temp',150)->default('');
            $table->string('token',150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('openers');
    }
}
