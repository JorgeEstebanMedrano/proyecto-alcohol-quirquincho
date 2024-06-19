<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_item', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('item_id');
            $table->integer('orden_compra_id');
            $table->string('producto', 45);
            $table->integer('cantidad');
            $table->decimal('precio_U', 10, 2);
            $table->date('fecha_caducidad')->nullable();
            
            $table->foreign('item_id', 'fk_orden_item_item1')->references('id')->on('item')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('orden_compra_id', 'fk_orden_item_orden_compra1')->references('id')->on('orden_compra')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_item');
    }
}
