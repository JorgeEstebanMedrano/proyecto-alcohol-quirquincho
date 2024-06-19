<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoMasGeneraView extends Migration
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
            CREATE VIEW `producto_mas_genera` AS select `a`.`producto_id` AS `id`,concat(`b`.`envase`,' ',`b`.`capacidad`) AS `Producto`,sum(`a`.`precio`) AS `Total_Generado` from (`modificado_alcohol`.`orden_producto` `a` join `modificado_alcohol`.`producto` `b` on(`a`.`producto_id` = `b`.`id`)) group by `a`.`producto_id` order by `a`.`producto_id` desc
        SQL;
    }

    private function dropView()
    {
        return <<<SQL
            DROP VIEW IF EXISTS `producto_mas_genera`;
        SQL;
    }
}
