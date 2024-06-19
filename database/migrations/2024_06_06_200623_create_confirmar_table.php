<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirmar', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->boolean('estado_confi')->default(1);
            $table->date('fecha');
            $table->integer('orden_id');
            $table->boolean('activa')->default(1);
            
            $table->foreign('orden_id', 'fk_confirmar_orden1')->references('id')->on('orden')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('confirmar');
    }
}
