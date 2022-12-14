<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observaciones', function (Blueprint $table) {
            $table->id();
            $table->string('observacion', 255);
            $table->string('evidencia',255);
            $table->timestamp('fecha');
            $table->unsignedBigInteger('recolectado_id')->nullable();
        });
        Schema::table('observaciones', function(Blueprint $table){
            $table->foreign('recolectado_id')->references('id')->on('recolectados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('observaciones');
    }
}
