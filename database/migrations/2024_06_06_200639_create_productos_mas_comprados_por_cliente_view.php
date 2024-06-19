<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosMasCompradosPorClienteView extends Migration
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
            CREATE VIEW `productos_mas_comprados_por_cliente` AS select `a`.`id` AS `Id_Cliente`,`a`.`nombre` AS `Nombre_Cliente`,`d`.`id` AS `Id_Producto`,concat(`d`.`envase`,' ',`d`.`capacidad`) AS `Producto`,count(`d`.`id`) AS `Cantidad_Vendidos` from (((`modificado_alcohol`.`cliente` `a` join `modificado_alcohol`.`orden` `b` on(`a`.`id` = `b`.`cliente_id`)) join `modificado_alcohol`.`orden_producto` `c` on(`b`.`id` = `c`.`orden_id`)) join `modificado_alcohol`.`producto` `d` on(`c`.`producto_id` = `d`.`id`)) group by `a`.`id`,`d`.`id` order by `d`.`id` desc,count(`d`.`id`) desc
        SQL;
    }

    private function dropView()
    {
        return <<<SQL
            DROP VIEW IF EXISTS `productos_mas_comprados_por_cliente`;
        SQL;
    }
}
