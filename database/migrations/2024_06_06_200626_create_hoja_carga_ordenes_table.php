<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHojaCargaOrdenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoja_carga_ordenes', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('hoja_carga_id');
            $table->integer('orden_id');
            
            $table->primary(['id', 'hoja_carga_id', 'orden_id']);
            $table->foreign('hoja_carga_id', 'fk_hoja_carga_ordenes_hoja_carga1')->references('id')->on('hoja_carga')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('orden_id', 'fk_hoja_carga_ordenes_orden1')->references('id')->on('orden')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hoja_carga_ordenes');
    }
}
