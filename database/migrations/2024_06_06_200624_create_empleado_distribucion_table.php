<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoDistribucionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado_distribucion', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('empleado_id');
            $table->string('placa', 10)->unique('placa_UNIQUE');
            $table->string('vehiculo', 45)->nullable();
            
            $table->foreign('empleado_id', 'fk_empleado_distribucion_empleado1')->references('id')->on('empleado')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleado_distribucion');
    }
}
