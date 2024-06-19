<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosMasVentasView extends Migration
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
            CREATE VIEW `productos_mas_ventas` AS select concat(`a`.`envase`,' ',`a`.`capacidad`) AS `Producto`,sum(`b`.`cantidad`) AS `Total` from (`modificado_alcohol`.`producto` `a` join `modificado_alcohol`.`orden_producto` `b` on(`a`.`id` = `b`.`producto_id`)) group by `a`.`id` order by `b`.`cantidad` desc
        SQL;
    }

    private function dropView()
    {
        return <<<SQL
            DROP VIEW IF EXISTS `productos_mas_ventas`;
        SQL;
    }
}
