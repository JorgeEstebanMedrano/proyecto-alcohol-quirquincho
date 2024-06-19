<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Orden;

use Exception;

class InsertarVariosPedidoController extends Controller
{
    public function insertar(Request $request)
    {
        if ($request->isMethod('post')) {
            // Verificar si se envió el valor de orden_id
            if ($request->has('orden_id')) {
                // Obtener el valor de orden_id del formulario
                $orden_id_seleccionado = $request->input('orden_id');

                // Validar que el valor sea numérico
                if (is_numeric($orden_id_seleccionado)) {
                    DB::beginTransaction();

                    try {
                        // Insertar en la tabla ordenes_por_hoja_carga
                        $success = DB::insert('INSERT INTO ordenes_por_hoja_carga (orden_id) VALUES (?)', [$orden_id_seleccionado]);

                        if ($success) {
                            // Actualizar la columna activa en la tabla confirmar
                            DB::update('UPDATE confirmar SET activa = 1 WHERE orden_id = ?', [$orden_id_seleccionado]);

                            // Confirmar la transacción
                            DB::commit();

                            return redirect()->route('insertar_pedido_hca')->with('success', 'Pedido insertado correctamente');
                        } else {
                            throw new Exception("Error: La inserción en la hoja de carga falló.");
                        }
                    } catch (Exception $e) {
                        // Revertir la transacción en caso de error
                        DB::rollback();
                        return redirect()->route('insertar_pedido_hca')->with('error', $e->getMessage());
                    }
                } else {
                    return redirect()->route('insertar_pedido_hca')->with('error', 'Error: El valor de orden_id no es válido.');
                }
            } else {
                return redirect()->route('insertar_pedido_hca')->with('error', 'Error: No se recibió el valor de orden_id.');
            }
        }
    }
    public function eliminar(Request $request)
    {
        if ($request->has('id') && $request->filled('id')) {
            $orden_id = $request->input('id');

            $result = DB::select("CALL eliminar_2(?)", [$orden_id]);

            if ($result) {
                return "La orden con ID $orden_id fue eliminada correctamente.";
            }   else {
                return "La orden con ID $orden_id fue eliminada correctamente.";
            }      
        } else {
            return "Error: El parámetro 'id' no está definido o está vacío.";
        }
    }
    public function insertar_pedido_hca()
    {
        // Ejecutar la primera consulta -- orden_id
        $ordenes = DB::select('CALL mostrar_datos_hca()');
        
        // Ejecutar la segunda consulta -- empleado_distribuidor
        $empleadosDistribucion = DB::select('CALL edn_hca()');
        
        // Obtener datos de fecha y id_hoja
        $datosIniciales = DB::select('CALL obtener_datos_iniciales()');
        $sig_id = $datosIniciales[0]->sig_id;
        $fecha_actual = $datosIniciales[0]->fecha_actual;
        
        // Obtener datos de la tabla ordenes_por_hoja_carga
        $ordenesPorHojaCarga = DB::table('ordenes_por_hoja_carga')->where('activa', 1)->get();
        
        return view('insertar_pedido_hca', compact('ordenes', 'empleadosDistribucion', 'sig_id', 'fecha_actual', 'ordenesPorHojaCarga'));
    }

    //aprobacion del pedido
    public function aprobacion_index()
    {
        $ordenesEnEspera = DB::select("CALL mostrar_ordenes_espera()");
        return view('aprobacion_pedido', ['ordenesEnEspera' => $ordenesEnEspera]);
    }

    public function acceptOrder(Request $request, $id)
    {
        try {
            DB::statement("CALL aceptar_orden(?)", [$id]);
            return redirect()->route('insertar_pedido_hca')->with('success', 'Orden aceptada correctamente');
        } catch (\Exception $e) {
            return redirect()->route('insertar_pedido_hca')->with('error', 'Hubo un error al aceptar la orden');
        }
    }

    public function rechazar($id)
    {
        // Lógica para rechazar la orden
        DB::statement("CALL rechazar_orden(?)", [$id]);
        return redirect()->route('aprobacion_pedido')->with('success', 'Orden rechazada correctamente');
    }
}
