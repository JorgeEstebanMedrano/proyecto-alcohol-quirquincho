<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('nombre', 45);
            $table->string('peso', 25);
            $table->decimal('precio', 10, 2);
            $table->integer('almacen_id');
            
            $table->foreign('almacen_id', 'fk_producto_almacen1')->references('id')->on('almacen')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto');
    }
}
