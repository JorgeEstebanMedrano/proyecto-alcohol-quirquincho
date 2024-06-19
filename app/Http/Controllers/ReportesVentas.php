<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
function comprobar()
{
    //SI NO SOMOS ADMINISTRADORES NO PODEMOS ENTRAR
    if ($_SESSION['rol'] != 'Admin') {
        header('Location:/');
        exit();
    }
}
class ReportesVentas extends Controller
{
    //REPORTES DE EMPLEADOS
    function empleados_mas_ventas(){
        comprobar();
        $sql = DB::select('call ver_mas_compras_realizadas');
        $title = "Ventas por empleados de mayor a menor";
        $sqlMasGenerado = DB::select("call ver_mas_generado()");
        $title2 = "Cantidad de dinero generada por empleado de mayor a menor";
        $impPag = "pdf/empBase";
        return view('reportes/reporte_ventas_empleados', [
            'empleados'=> $sql,
            'Title'=> $title,
            'empleados_generado' => $sqlMasGenerado,
            'Titulo2'=> $title2,
            'impPag' => $impPag
        ]);
    }
    function filtrar_empleado_id(Request $req){
        comprobar();
        if ($req['id'] == "") {
            return redirect('/reportes_ventas');
        }
        $sql = DB::select('call empleado_mayores_ventas_id(?)', [$req['id']]);
        $title = "Ventas por empleados del empleado con id: ".  $req['id'];
        $sqlMasGenerado = DB::select("call empleado_mas_generado_por_id(?)", [$req['id']]);
        $title2 = "Cantidad de dinero generado por el empleado con id: " . $req['id'];
        $impPag = "pdf/empVentasId?id=".$req['id'];
        return view('reportes/reporte_ventas_empleados', [
            'empleados'=> $sql,
            'Title'=> $title,
            'empleados_generado' => $sqlMasGenerado,
            'Titulo2'=> $title2,
            'impPag' => $impPag
        ]);
    }
    function filtrar_empleado_fecha(Request $req){
        comprobar();
        if ($req['fecha'] == '') {
            return redirect('/reportes_ventas');
        }
        $sql = DB::select('call empleado_mayores_ventas_fecha(?)', [$req['fecha']]);
        $title = "Ventas por empleados en: ".  $req['fecha'];
        $sqlMasGenerado = DB::select("call empleado_mas_generado_por_fecha(?)", [$req['fecha']]);
        $title2 = "Cantidad de dinero generado por empleado en:" . $req['fecha'];
        $impPag = "pdf/empVentasFecha?fecha=".$req['fecha'];
        return view('reportes/reporte_ventas_empleados', [
            'empleados'=> $sql,
            'Title'=> $title,
            'empleados_generado' => $sqlMasGenerado,
            'Titulo2'=> $title2,
            'impPag' => $impPag
        ]);
    }
    //REPORTES DE CLIENTES
    function reportes_clientes(Request $req){
        comprobar();
        $sql = DB::select('call ver_clientes_compra_productos');
        $title = "Productos mas comprados por cliente";
        $impPag = "pdf/clienteBase";
        return view('reportes/reporte_ventas_clientes', [
            'clientes'=> $sql,
            'Title'=> $title,
            'impPag' => $impPag
        ]);
    }
    function reportes_clientes_id(Request $req){
        comprobar();
        if ($req['idFilt'] == "" || $req['id'] == "") {
            return redirect('/reportes_clientes');
        }
        $array_id = [];
        array_push($array_id, $req['id']);
        array_push($array_id, $req['idFilt']);
        $sql = DB::select('call ver_clientes_compra_producto_'. $req['idFilt'] . '(?)', [$req['id']]);
        $title = "Filtrando por id el resultado es";
        $impPag = "pdf/clienteId?arrayId=".$req['idFilt']."(".$req['id'].")";
        return view('reportes/reporte_ventas_clientes', [
            'clientes'=> $sql,
            'Title'=> $title,
            'impPag' => $impPag
        ]);
    }
    function reportes_clientes_fecha(Request $req){
        comprobar();
        if ($req['fecha'] == '') {
            return redirect('/reportes_ventas');
        }
        $sql = DB::select('call ver_cliente_compra_producto_fecha(?)', [$req['fecha']]);
        $title = "Productos mas comprados por cliente en: ". $req['fecha'];
        $impPag = "pdf/clienteFecha?fecha=".$req['fecha'];
        return view('reportes/reporte_ventas_clientes', [
            'clientes'=> $sql,
            'Title'=> $title,
            'impPag' => $impPag
        ]);
    }
    //REPORTES DE PRODUCTOS
    function reportes_productos(){
        comprobar();
        $sql = DB::select('call productos_que_mas_generan();');
        $title = "Productos que mas generan";
        $impPag = "pdf/prodBase";
        return view("reportes/reporte_ventas_productos", [
            'productos'=> $sql,
            'Title'=> $title,
            'impPag' => $impPag
        ]);
    }
    function reportes_productos_fecha(Request $req){
        comprobar();
        if ($req['fecha'] == ""){
            return redirect('/reportes_ventas');
        }
        $sql = DB::select('call ver_producto_mas_genero_desde(?);', [$req['fecha']]);
        $title = "Productos que mas generan desde: " . $req['fecha'];
        $impPag = "pdf/prodFecha?fecha=".$req['fecha'];        
        return view("reportes/reporte_ventas_productos", [
            'productos'=> $sql,
            'Title'=> $title,
            'impPag' => $impPag
        ]);
    }
}
