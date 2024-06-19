<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class OrdenCompraController extends Controller
{
    public function index()
    {
        $empleados = [];
        $productos = [];
        $proveedores = [];

        $con = DB::connection()->getPdo();
        $stmt = $con->prepare("CALL ver_productos_proveedor_empleado()");
        $stmt->execute();

        do {
            if ($result = $stmt->fetchAll(\PDO::FETCH_ASSOC)) {
                if (empty($empleados)) {
                    $empleados = $result;
                } elseif (empty($productos)) {
                    $productos = $result;
                } else {
                    $proveedores = $result;
                }
            }
        } while ($stmt->nextRowset());

        return view('PedidoProveedor', compact('empleados', 'productos', 'proveedores'));
    }

    public function store(Request $request)
    {
        $ordenes = $request->input('ordenes');

        // Insertar órdenes en la base de datos (ejemplo simplificado)
        foreach ($ordenes as $orden) {
            DB::table('ordenes')->insert([
                'empleado_id' => $orden['empleado_id'],
                'proveedor_id' => $orden['proveedor_id'],
                'producto_id' => $orden['id_prod'],
                'cantidad' => $orden['cantidad'],
                'tipo_pago' => $orden['tipo_pago'],
                'total' => $orden['total'],
                'fecha' => now()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Orden realizada con éxito'
        ]);
    }


    public function procesarOrdenes(Request $request)
    {
        // Recibir datos JSON desde la entrada
        $data = $request->all();
        if (!empty($data)) {
            $success = true;
            $orden_compra_id = null;
            $string = "2";
            foreach ($data["ordenes"] as $orden) {
                $id_empleado = $orden['empleado_id'];
                $id_proveedor = $orden['proveedor_id'];
                $cantidad = $orden['cantidad'];
                $producto_precio = $orden['producto'];
                $tipo_pago = $orden['tipo_pago'];
                $fecha_orden = now()->toDateString(); // Fecha automática
                $plazo = now()->addDays(3)->toDateString(); // Plazo de 3 días

                // Obtener ID y Precio_Unit del producto usando un procedimiento almacenado
                $producto = DB::select('CALL obtener_producto(?)', [$producto_precio]);
                if (!empty($producto)) {
                    $id_prod = $producto[0]->id;
                    $precio = $producto[0]->precio;
                } else {
                    $success = false;
                    break;
                }

                // Insertar la orden de compra y obtener su ID
                if ($orden_compra_id === null) {
                    $string =  "call insertar_orden_compra($id_empleado, $id_proveedor, $fecha_orden, $plazo, $tipo_pago, $cantidad)";
                    DB::insert('call insertar_orden_compra(?,?,?,?,?,?)', [$id_empleado, $id_proveedor, $fecha_orden, $plazo, $tipo_pago, $cantidad]);
                    $sql = DB::select('call obtener_id_orden_compra');
                    $orden_compra_id = $sql[0]->id;
                }

                // Insertar producto en orden_item usando otro procedimiento almacenado
                $success &= DB::insert('CALL insertar_orden_item(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                    $id_empleado,
                    $id_proveedor,
                    $fecha_orden,
                    $plazo,
                    $tipo_pago,
                    $cantidad,
                    $producto_precio,
                    $id_prod,
                    $precio,
                    $orden_compra_id
                ]);
            }

            if ($success) {
                //return response()->json(['success' => false, 'message' => $string], 400);
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => $string], 400);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'No se recibieron datos'], 400);
        }
    }

    public function VerDetalle(Request $request)
    {
        $fecha = $request->input('fecha');

        if ($fecha) {
            // Llamar al procedimiento almacenado para buscar las órdenes por fecha
            $detalle = DB::select('CALL buscar_fecha(?)', [$fecha]);
        } else {
            // Obtener todas las órdenes si no se especifica una fecha
            $detalle = DB::select('CALL ver_detalle()');
        }

        return view('DetalleOrden', ['orders' => $detalle]);
    }

    //FUNCUIÓN PARA MOSTRAR EL DETALLE DE UNA ORDEN
    public function show($id)
    {
        $orderDetails = DB::select('CALL detalle_completo(?)', [$id]);

        if (empty($orderDetails)) {
            return redirect('/orders')->with('error', 'Orden no encontrada');
        }

        // Extraer la primera fila para la información general
        $orderSummary = $orderDetails[0];

        return view('Detalle', compact('orderDetails', 'orderSummary'));
    }
}
