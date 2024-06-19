<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;
use function Laravel\Prompts\select;


if ($_SESSION['rol'] != 'Cliente') {
    header("Location: /");
}
class ClienteController extends Controller
{
    public function     pag_principal(){
        $user = $_SESSION['username'];
        $sql = DB::select('call get_ci(?)', [$user]);
        $ci = get_object_vars($sql[0])['ci'];
        $sql = DB::select('select get_client_id(?) as id;', [$ci]);
        $id = get_object_vars($sql[0])['id'];
        $_SESSION['id'] = $id;
        $sql = DB::select('call ver_productos()');
        return view('client_views/pag_principal', [
            'productos'=> $sql
        ]);
    }
    public function compra_carrito(Request $req){
        $productos = json_decode($req['productos'], true);
        if (!$productos) {
            return redirect('/pag_principal');
        }
        return view('client_views/compra_carrito', [
            'productos' => $productos
        ]);
    }
    public function pagar(Request $req){
        $arrayOrden = json_decode($_GET['orden'], true);
        if (!$arrayOrden) {
            return redirect('/pag_principal');
        }
        $admin_id = 0;
        $tipoDePago = $req['pago'];
        $client_id = $_SESSION['id'];
        $fecha = date("Y-m-d");
        DB::insert("call crear_orden(?, ?, ?, ?, ?)", [$fecha, 'Espera', $tipoDePago, $admin_id, $client_id]);
        $query = DB::SELECT("SELECT ultima_orden() as id;");
        $orden_id = get_object_vars($query[0])["id"];
        foreach ($arrayOrden as $key) {
            if ($key['cantidad'] > 0) {
                $precioT = 0;
                $sql = DB::select('SELECT calcular_precio(' . $key['id'] . ', ' . $key["cantidad"] . ') as Precio');
                $precioT = get_object_vars($sql[0])['Precio'];
                $sql = DB::insert("call insertar_orden_producto($precioT," . $key['cantidad'] . "," .  $orden_id. ",". $key['id'] .")");
            }
        }
        header('Location:/pag_principal');
        exit();
    }
}
