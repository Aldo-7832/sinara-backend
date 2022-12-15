<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->boolean('activo');
            $table->string('contrasenia', 110);
            $table->string('usuario', 65);
            $table->unsignedBigInteger('rol_id')->nullable();
            $table->unsignedBigInteger('persona_id')->nullable();
        });
        Schema::table('usuarios', function(Blueprint $table){
            $table->foreign('rol_id')->references('id')->on('roles');
            $table->foreign('persona_id')->references('id')->on('personas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
