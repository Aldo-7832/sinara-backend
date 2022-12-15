<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45);
            $table->string('primer_apellido', 45);
            $table->string('segundo_apellido', 45)->nullable();
            $table->Date('fecha_nacimiento');
            $table->string('telefono', 10);
            $table->timestamp('fecha_registro');
            $table->unsignedBigInteger('ubicacion_id')->nullable();
        });
        Schema::table('personas', function(Blueprint $table){
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
        Schema::dropIfExists('personas');
    }
}
