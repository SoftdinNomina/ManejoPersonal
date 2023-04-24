<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaeDepartamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mae_departamentos', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('pais_id')->unsigned();
            $table->string('departamento', 200);
            $table->string('codigodane', 50)->nullable();
            $table->string('codigo_iso', 10)->nullable();
            $table->boolean('activo');
            $table->timestamps();

            $table->unique(['pais_id', 'codigodane'], 'IX_MAE_DEPARTAMENTO_CODIGO_DANE');
            $table->unique(['pais_id', 'codigo_iso'], 'IX_MAE_DEPARTAMENTO_CODIGO_ISO');
            $table->unique(['pais_id', 'departamento'], 'IX_MAE_DEPARTAMENTO_IDPAISDEPARTAMENTO');
            $table->foreign('pais_id', 'mae_departamentos_ibfk_1')->references('id')->on('mae_paises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mae_departamentos');
    }
}
