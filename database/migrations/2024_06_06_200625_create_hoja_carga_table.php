<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHojaCargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoja_carga', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->date('fecha_entrega');
            $table->integer('orden_id');
            $table->integer('empleado_distribucion_id');
            $table->string('estado_hoja', 50)->nullable();
            
            $table->foreign('empleado_distribucion_id', 'fk_hoja_carga_empleado_distribucion1')->references('id')->on('empleado_distribucion')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('orden_id', 'fk_hoja_carga_orden1')->references('id')->on('orden')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hoja_carga');
    }
}
