<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado_ventas', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->decimal('bono', 10, 2);
            $table->boolean('borrado')->default(0);
            $table->integer('empleado_id');
            
            $table->foreign('empleado_id', 'fk_empleado_ventas_empleado1')->references('id')->on('empleado')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleado_ventas');
    }
}
