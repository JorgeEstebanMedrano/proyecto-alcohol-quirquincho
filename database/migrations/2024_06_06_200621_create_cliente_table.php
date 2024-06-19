<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('ci')->unique('ci_UNIQUE');
            $table->string('nombre', 20);
            $table->string('apellido', 45);
            $table->string('direccion', 100);
            $table->integer('telefono')->nullable();
            $table->boolean('borrado')->default(0);
            $table->integer('empleado_ventas_id')->nullable();
            
            $table->foreign('empleado_ventas_id', 'fk_cliente_empleado_ventas1')->references('id')->on('empleado_ventas')->onDelete('set NULL')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente');
    }
}
