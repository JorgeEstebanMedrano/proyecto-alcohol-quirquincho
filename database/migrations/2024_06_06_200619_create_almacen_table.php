<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlmacenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('almacen', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('empleado_almacen_id');
            $table->integer('num_almacen')->unique('num_almacen_UNIQUE');
            $table->string('tipo_almacen', 50);
            
            $table->foreign('empleado_almacen_id', 'fk_almacen_empleado_almacen1')->references('id')->on('empleado_almacen')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('almacen');
    }
}
