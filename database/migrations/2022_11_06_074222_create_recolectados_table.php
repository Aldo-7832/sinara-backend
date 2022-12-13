<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecolectadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recolectados', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->date('caducidad');
            $table->boolean('estatus');
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->unsignedBigInteger('donacion_id')->nullable();
        });
        Schema::table('recolectados', function(Blueprint $table){
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('donacion_id')->references('id')->on('donaciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recolectados');
    }
}
