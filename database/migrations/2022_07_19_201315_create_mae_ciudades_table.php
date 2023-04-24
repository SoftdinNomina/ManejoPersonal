<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaeCiudadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mae_ciudades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('departamento_id')->unsigned();
            $table->string('ciudad', 200);
            $table->string('codigodane', 50)->nullable();
            $table->boolean('activo');
            $table->timestamps();

            $table->unique(['departamento_id', 'ciudad'], 'IX_MAE_CIUDAD_IDDEPARTAMENTOCIUDAD');
            $table->unique(['departamento_id', 'codigodane'], 'IX_MAE_CIUDAD_CODIGO_DANE');
            $table->foreign('departamento_id', 'mae_ciudades_ibfk_1')->references('id')->on('mae_departamentos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mae_ciudades');
    }
}
