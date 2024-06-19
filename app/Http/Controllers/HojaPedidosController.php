<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Exception;

class HojaPedidosController extends Controller
{
    public function index()
    {
        try {
            // Ejecutar el procedimiento almacenado para obtener los datos
            $query = DB::select("CALL ver_hoja_pedidos()");
            return view('hoja_pedidos', ['query' => $query]);
        } catch (Exception $e) {
            // Manejar cualquier excepción ocurrida durante la ejecución del procedimiento almacenado
            return redirect()->route('hoja_pedidos')->with('error', 'Error al obtener los datos de la hoja de pedidos: ' . $e->getMessage());
        }
    }

    public function entregarPedido($hoja_carga_id)
    {
        // Verificar si se proporcionó el ID de hoja de carga
        if (!$hoja_carga_id) {
            return redirect()->back()->with('error', 'ID de hoja de carga no proporcionado.');
        }

        try {
            // Ejecutar el procedimiento almacenado para actualizar el estado de la hoja de carga
            DB::statement("CALL actualizar_estado_hoja(?)", [$hoja_carga_id]);

            return redirect()->route('hoja_pedidos')->with('success', 'Orden entregada correctamente.');
        } catch (Exception $e) {
            // Manejar cualquier excepción ocurrida durante la ejecución del procedimiento almacenado
            return redirect()->route('hoja_pedidos')->with('error', 'Error al ejecutar el procedimiento: ' . $e->getMessage());
        }
    }

    public function eliminar($hoja_carga_id)
    {
        try {
            // Ejecutar el procedimiento almacenado para eliminar el registro de la hoja de carga
            $result = DB::statement("CALL eliminar_1(?)", [$hoja_carga_id]);

            if ($result) {
                // Redireccionar a hoja_pedidos con un mensaje de éxito
                return Redirect::route('hoja_pedidos');
            } else {
                // Redireccionar a hoja_pedidos con un mensaje de error si no se pudo eliminar
                return Redirect::route('hoja_pedidos')->with('error', 'Hubo un error al eliminar el registro.');
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción ocurrida durante la ejecución del procedimiento almacenado
            return redirect()->route('hoja_pedidos')->with('error', 'Error al eliminar el registro: ' . $e->getMessage());
        }
    }

    //hoja carga
    public function ver_hoja_carga()
    {
        // Ejecutar la primera consulta -- orden_id
        $ordenes = DB::select("CALL mostrar_datos_hca()");

        // Ejecutar la segunda consulta -- empleado_distribuidor
        $empleadosDistribucion = DB::select("CALL edn_hca()");

        // Obtener datos de fecha y id_hoja
        $datosIniciales = DB::select("CALL obtener_datos_iniciales()");

        $sig_id = $datosIniciales[0]->sig_id ?? null;
        $fecha_actual = $datosIniciales[0]->fecha_actual ?? null;

        // Obtener datos de la tabla ordenes_por_hoja_carga
        $ordenesPorHojaCarga = DB::table('ordenes_por_hoja_carga')->where('activa', 1)->get();

        return view('hoja_carga', [
            'ordenes' => $ordenes,
            'empleadosDistribucion' => $empleadosDistribucion,
            'sig_id' => $sig_id,
            'fecha_actual' => $fecha_actual,
            'ordenesPorHojaCarga' => $ordenesPorHojaCarga
        ]);
    }

    public function ver_hoja_carga_index(Request $request)
    {
        $query = [];  // Variable para almacenar los resultados de la búsqueda
        $detalles = [];

        if ($request->isMethod('post') && $request->has('opcion') && $request->has('texto')) {
            $opt = $request->post('opcion');
            $txt = $request->post('texto');

            if ($opt === 'buscar_orden_h') {
                $query = DB::select('CALL buscar_orden_hoja(?)', [$txt]);
            } elseif ($opt === 'buscar_cliente_h') {
                $query = DB::select('CALL buscar_cliente_hoja(?)', [$txt]);
            }
        }

        if ($request->query('hoja_carga_id')) {
            $hoja_carga_id = $request->query('hoja_carga_id');
            $detalles = DB::select('CALL ver_hoja(?)', [$hoja_carga_id]);
        }

        // Combina query y detalles en una sola variable
        $hojas = array_merge($query, $detalles);

        return view('hoja_carga', compact('hojas'));
    }
    public function insertarHojaCarga(Request $request)
    {
        $nombre_empleado = $request->input('nombre_empleado');
        $fecha_entrega = $request->input('fecha_entrega');

        // Obtener todas las órdenes activas de la tabla ordenes_por_hoja_carga
        $ordenes_activas = DB::table('ordenes_por_hoja_carga')->where('activa', 1)->pluck('orden_id');

        if ($ordenes_activas->isEmpty()) {
            return redirect()->back()->with('error', 'No hay órdenes activas disponibles.');
        }

        DB::beginTransaction();
        try {
            // Obtener el ID del empleado de distribución
            $empleado = DB::table('empleado')
                ->join('empleado_distribucion', 'empleado.id', '=', 'empleado_distribucion.empleado_id')
                ->where(DB::raw("CONCAT(empleado.nombre, ' ', empleado.apellido)"), $nombre_empleado)
                ->select('empleado_distribucion.id as empleado_distribucion_id')
                ->first();

            if (!$empleado) {
                throw new Exception("Error: No se encontró el empleado de distribución para el nombre proporcionado.");
            }

            $empleado_distribucion_id = $empleado->empleado_distribucion_id;

            // Crear una nueva hoja de carga
            $hoja_id = DB::table('hoja_carga')->insertGetId([
                'empleado_distribucion_id' => $empleado_distribucion_id,
                'fecha_entrega' => $fecha_entrega,
            ]);

            foreach ($ordenes_activas as $orden_id) {
                // Insertar en hoja_carga_ordenes
                DB::table('hoja_carga_ordenes')->insert([
                    'hoja_id' => $hoja_id,
                    'orden_id' => $orden_id,
                ]);

                // Actualizar hoja_carga_id en la tabla orden
                DB::table('orden')->where('id', $orden_id)->update([
                    'hoja_carga_id' => $hoja_id,
                ]);
            }

            // Actualizar las órdenes activas a inactivas (activa = 0)
            DB::table('ordenes_por_hoja_carga')->whereIn('orden_id', $ordenes_activas)->update(['activa' => 0]);

            DB::commit();
            return redirect()->route('hoja_pedidos');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error en la transacción: ' . $e->getMessage());
        }
    }

    //pedidos entregados
    public function verindex(Request $request)
    {
        $sql = "CALL ver_hoja_entregado()";

        if ($request->isMethod('post')) {
            $opcion = $request->input('opcion');
            $texto = $request->input('texto');

            switch ($opcion) {
                case "buscar_orden_h":
                    $sql = "CALL buscar_orden_hoja(?)";
                    break;
                case "buscar_cliente_h":
                    $sql = "CALL buscar_cliente_hoja(?)";
                    break;
                case "buscar_estado_h":
                    $sql = "CALL buscar_estado_hoja(?)";
                    break;
                case "buscar_fecha_h":
                    $texto = date('Y-m-d', strtotime($texto));
                    $sql = "CALL buscar_fecha_hoja(?)";
                    break;
                default:
                    break;
            }

            $result = DB::select($sql, [$texto]);
        } else {
            $result = DB::select($sql);
        }

        

        return view('pedido_entregado', ['result' => $result]);
    }
    public function pedido_entregado_index(Request $request)
    {
        $sql = "CALL ver_hoja_entregado()";

        if ($request->isMethod('post')) {
            $opcion = $request->input('opcion');
            $texto = $request->input('texto');

            switch ($opcion) {
                case "buscar_orden_h":
                    $sql = "CALL buscar_orden_hoja(?)";
                    break;
                case "buscar_cliente_h":
                    $sql = "CALL buscar_cliente_hoja(?)";
                    break;
                case "buscar_estado_h":
                    $sql = "CALL buscar_estado_hoja(?)";
                    break;
                case "buscar_fecha_h":
                    $texto = date('Y-m-d', strtotime($texto));
                    $sql = "CALL buscar_fecha_hoja(?)";
                    break;
                default:
                    break;
            }

            $result = DB::select($sql, [$texto]);
        } else {
            $result = DB::select($sql);
        }

        return view('pedido_entregado', ['result' => $result]);
    }

    public function verDetalles($id)
    {
        // Obtener detalles generales de la orden
        $details = DB::select('CALL ver_info_hca(?)', [$id]);

        if (empty($details)) {
            return back()->with('error', 'No se encontraron detalles para la orden.');
        }

        // Obtener productos y sus totales
        $products = DB::select('CALL suma_cant(?)', [$id]);

        // Obtener el total de la orden utilizando la función personalizada
        $totalResult = DB::select('SELECT calcular_total_orden(?) as total', [$id]);
        $total = $totalResult[0]->total ?? 0;

        return view('detalles_compra', [
            'details' => $details[0], // Suponiendo que la consulta devuelve un único resultado
            'products' => $products,
            'total' => $total,
        ]);
    }
}
