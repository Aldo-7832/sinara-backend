<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donaciones', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 15);
            $table->boolean('estatus');
            $table->timestamp('fecha_recoleccion');
            $table->string('observaciones_generales', 255);
            $table->unsignedBigInteger('cadena_id')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
        });
        Schema::table('donaciones', function(Blueprint $table){
            $table->foreign('cadena_id')->references('id')->on('cadenas');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donaciones');
    }
}
