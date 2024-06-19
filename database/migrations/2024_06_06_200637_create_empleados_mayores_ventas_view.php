<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosMayoresVentasView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->dropView());
        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement($this->dropView());
    }

    private function createView()
    {
        return <<<SQL
            CREATE VIEW `empleados_mayores_ventas` AS select `a`.`id` AS `id`,`a`.`nombre` AS `nombre`,count(`c`.`empleado_ventas_id`) AS `Total` from ((`modificado_alcohol`.`empleado` `a` join `modificado_alcohol`.`empleado_ventas` `b` on(`a`.`id` = `b`.`empleado_id`)) join `modificado_alcohol`.`orden` `c` on(`b`.`id` = `c`.`empleado_ventas_id`)) group by `c`.`empleado_ventas_id` order by count(`c`.`empleado_ventas_id`) desc
        SQL;
    }

    private function dropView()
    {
        return <<<SQL
            DROP VIEW IF EXISTS `empleados_mayores_ventas`;
        SQL;
    }
}
