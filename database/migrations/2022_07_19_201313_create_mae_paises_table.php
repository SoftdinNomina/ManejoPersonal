<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaePaisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mae_paises', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('pais', 200)->unique('ix_mae_pais_pais');
            $table->string('codigo_alfa2', 10)->nullable()->unique('ix_mae_pais_codigo_alfa2');
            $table->string('codigo_alfa3', 10)->nullable()->unique('ix_mae_pais_codigo_alfa3');
            $table->string('codigo_numerico', 10)->nullable()->unique('ix_mae_pais_codigo_numerico');
            $table->string('continente', 50)->nullable();
            $table->string('bandera')->nullable();
            $table->boolean('activo');
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
        Schema::dropIfExists('mae_paises');
    }
}
