<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;

class Ventas extends Controller
{
    //PAGINA PRINCIPAL
    public function venta_productos()
    {
        Controller::class::comprobar_ventas();
        $user = $_SESSION['username'];
        $sql = DB::select('call get_ci(?)', [$user]);
        $ci = get_object_vars($sql[0])['ci'];
        $sql = DB::select('select get_emp_id(?) as id;', [$ci]);
        $id = get_object_vars($sql[0])['id'];
        $sql = DB::select('select get_emp_ventas_id(?) as id;', [$id]);
        $ventas_id = get_object_vars($sql[0])['id'];
        $_SESSION['id'] = $ventas_id;
        $productos = DB::select('call ver_productos()');
        return view('ventas_views/emp_ventas', [
            'productos' => $productos
        ]);
    }
    public function ver_detalles(Request $request)
    {
        Controller::class::comprobar_ventas();
        $productos = $request->query('arrayDeProductos');
        return view('ventas_views/realizar_orden', [
            'productos' => $productos
        ]);
    }
    public function obtener_cliente(Request $request)
    {
        Controller::class::comprobar_ventas();
        $carnet = $request['carnet'];
        $admin_id = $request['admin'];
        $query = DB::select('call obtener_cliente(' . $carnet . ')');
        if ($query) {
            $res = get_object_vars($query[0]);
            $html =
                '<input type="hidden" name="_token" value="' . $request['_token'] . '" autocomplete="off" required>' .
                '<input id="carnet" type="number" name="ci" value=' . $carnet . '><br>' .
                '<input type="text" name="nombre" required placeholder="Nombre" value=' . $res["nombre"] . '><br>' .
                '<input type="text" name="apellido" required placeholder="Apellido" value=' . $res["apellido"] . '><br>' .
                '<input type="text" name="direccion" required placeholder="Direccion" value="' . $res["direccion"] . '"><br>' .
                '<input type="number" name="telefono" required placeholder="Telefono" value=' . $res["telefono"] . '><br>' .
                '<input type="hidden" name="admin" id="admin" value="' . $admin_id . '">' .
                '<input type="radio" class="radio" name="pago" required value="efectivo"><label for="efectivo">Efectivo</label><br>
            <input type="radio" class="radio" name="pago" required value="tarjeta"><label for="tarjeta">Tarjeta</label><br>' .
                '<input type="submit" value="enviar">';
            return response($html, 200);
        } else {
            return response("", 404);
        }
    }
    public function crear_compra(Request $request)
    {
        Controller::class::comprobar_ventas();
        $admin_id = $request['admin'];
        $ci = ($request["ci"]);
        $carnet = $ci;
        $nombre = $request["nombre"];
        $apellido = $request["apellido"];
        $direccion = $request["direccion"];
        $telefono = $request["telefono"];
        $tipoDePago = $request["pago"];
        $sql = DB::select("call obtener_cliente($ci)");
        if (!$sql) {
            DB::insert("call insertar_cliente(?,?,?,?,?,?)", [$ci, $nombre, $apellido, $direccion, $telefono, $admin_id]);
            if (isset($request['usuario']) && isset($request['contraseña']) && isset($request['correo'])) 
            {
                $email = $request['correo'];
                $password = $request['contraseña'];
                $user = $request['usuario'];
                $sql = DB::insert("CALL registro_alc('$email','$user','$password','$carnet')");
            }
        }
        $sql = DB::select("call obtener_cliente($ci)");
        $res = get_object_vars($sql[0]);
        $idC = $res["id"];
        $fecha = date("Y-m-d");
        DB::insert("call crear_orden(?, ?, ?, ?, ?)", [$fecha, 'Espera', $tipoDePago, $admin_id, $idC]);
        $sql = DB::select('SELECT ultima_orden() as "Ultima"');
        $query = get_object_vars($sql[0]);
        $res = $query["Ultima"];
        $arrayOrden = json_decode($_GET["orden"], true);
        foreach ($arrayOrden as $key) {
            if ($key['cantidad'] > 0) {
                $sql = DB::select('SELECT calcular_precio(?, ?) as Precio', [$key['id'], $key['cantidad']]);
                $precioT = get_object_vars($sql[0])['Precio'];
                DB::insert('call insertar_orden_producto(?,?,?,?)', [$precioT, $key['cantidad'], $res, $key['id']]);
            }
        }
        header('Location: /admin_ventas');
        exit();
    }
    public function ver_mis_ventas(Request $req){
        Controller::class::comprobar_ventas();
        $mi_id = $req['id'];
        $sql = DB::select('call ventas_del_empleado_id(?)', [$mi_id]);
        $nom = DB::select("SELECT nombre_empleado($mi_id) AS nombre;");
        $title = "Tus ventas: ".  $nom[0]->nombre;
        return view('reportes/ventas_del_empleado', [
            'empleados'=> $sql,
            'Title'=> $title
        ]);
    }
}
