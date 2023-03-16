<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaeBarriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mae_barrios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ciudad_id')->unsigned();
            $table->string('barrio', 200);
            $table->boolean('activo');
            $table->timestamps();

            $table->unique(['ciudad_id', 'barrio'], 'IX_MAE_BARRIO_IDCIUDADBARRIO');
            $table->foreign('ciudad_id', 'mae_barrios_ibfk_1')->references('id')->on('mae_ciudades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mae_barrios');
    }
}
