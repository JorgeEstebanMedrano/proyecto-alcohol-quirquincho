<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_producto', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->decimal('precio', 10, 2);
            $table->integer('cantidad');
            $table->integer('orden_id');
            $table->integer('producto_id')->nullable();
            
            $table->foreign('orden_id', 'fk_orden_producto_orden1')->references('id')->on('orden')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('producto_id', 'fk_orden_producto_producto1')->references('id')->on('producto')->onDelete('set NULL')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_producto');
    }
}
