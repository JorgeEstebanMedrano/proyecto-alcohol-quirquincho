<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenesPorHojaCargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenes_por_hoja_carga', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('orden_id');
            $table->boolean('activa')->default(1);
            
            $table->foreign('orden_id', 'fk_ordenes_por_hoja_carga_orden1')->references('id')->on('orden')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordenes_por_hoja_carga');
    }
}
