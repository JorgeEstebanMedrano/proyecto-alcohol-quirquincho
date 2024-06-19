<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoMasGeneradoView extends Migration
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
            CREATE VIEW `empleado_mas_generado` AS select `d`.`id` AS `id`,`d`.`nombre` AS `nombre`,sum(`c`.`precio`) AS `Total_Generado` from (((`modificado_alcohol`.`empleado_ventas` `a` join `modificado_alcohol`.`orden` `b` on(`a`.`id` = `b`.`empleado_ventas_id`)) join `modificado_alcohol`.`orden_producto` `c` on(`b`.`id` = `c`.`orden_id`)) join `modificado_alcohol`.`empleado` `d` on(`a`.`empleado_id` = `d`.`id`)) group by `d`.`id`
        SQL;
    }

    private function dropView()
    {
        return <<<SQL
            DROP VIEW IF EXISTS `empleado_mas_generado`;
        SQL;
    }
}
