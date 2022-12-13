<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadenasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadenas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45);
            $table->string('descripcion', 255);
            $table->boolean('estatus');
            $table->unsignedBigInteger('ubicacion_id')->nullable();
        });
        Schema::table('cadenas', function(Blueprint $table){
            $table->foreign('ubicacion_id')->references('id')->on('ubicaciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cadenas');
    }
}
