<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('ci')->unique('ci_UNIQUE');
            $table->string('nombre', 30);
            $table->string('apellido', 45);
            $table->integer('telefono');
            $table->time('hora_entrada');
            $table->decimal('salario', 10, 2)->nullable();
            $table->boolean('borrado')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleado');
    }
}
