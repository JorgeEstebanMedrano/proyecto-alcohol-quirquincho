<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->date('fecha_pedido');
            $table->string('estado_pedido', 10);
            $table->char('tipo_pago', 8);
            $table->integer('empleado_ventas_id');
            $table->integer('cliente_id')->nullable();
            $table->string('ordencol', 45)->nullable();
            
            $table->foreign('cliente_id', 'fk_orden_cliente1')->references('id')->on('cliente')->onDelete('set NULL')->onUpdate('restrict');
            $table->foreign('empleado_ventas_id', 'fk_orden_empleado_ventas1')->references('id')->on('empleado_ventas')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden');
    }
}
