<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoAlmacenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado_almacen', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('empleado_id');
            $table->string('puesto', 50);
            
            $table->foreign('empleado_id', 'fk_empleado_almacen_empleado1')->references('id')->on('empleado')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleado_almacen');
    }
}
