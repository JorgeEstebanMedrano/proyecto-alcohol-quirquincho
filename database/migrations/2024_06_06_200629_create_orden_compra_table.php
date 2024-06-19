<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('empleado_almacen_id');
            $table->integer('proveedor_id');
            $table->date('fecha_orden');
            $table->date('plazo');
            $table->decimal('precio', 10, 2);
            $table->char('pago', 8);
            
            $table->foreign('empleado_almacen_id', 'fk_orden_compra_empleado_almacen1')->references('id')->on('empleado_almacen')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('proveedor_id', 'fk_orden_compra_proveedor1')->references('id')->on('proveedor')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_compra');
    }
}
