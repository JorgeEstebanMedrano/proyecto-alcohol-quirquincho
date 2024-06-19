<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class VerMasController extends Controller
{
    public function index()
    {
        $result = DB::select('CALL vista_entrega()');
        
        return view('entregas', ['entregas' => $result]);
    }

    public function pendientes()
    {
        $result = DB::select('CALL vista_pendiente()');
        return view('pendientes', ['pendientes' => $result]);
    }

    public function aceptados(Request $request)
    {
        $sql = "CALL vista_acep()";
        
        if ($request->isMethod('post') && $request->has('opcion') && $request->has('texto')) {
            $opt = $request->input('opcion');
            $txt = $request->input('texto');
            
            if ($opt === "buscar_fecha_h") {
                $txt = date('Y-m-d', strtotime($txt));
                $sql = "CALL buscar_vista_fecha('$txt')";
            }
        }

        $result = DB::select($sql);
        $total_aceptados = DB::selectOne("SELECT total_pedidos_aceptados() AS total")->total;

        return view('aceptados', ['aceptados' => $result, 'total_aceptados' => $total_aceptados]);
    }

    public function rechazados()
    {
        $result = DB::select('CALL vista_rech()');
        $total_rechazados = DB::selectOne("SELECT total_pedidos_rechazados() AS total")->total;
        return view('rechazados', ['rechazados' => $result, 'total_rechazados' => $total_rechazados]);

        

    }

    public function resumen()
    {
        $result = DB::select('CALL vista_resumen()');
        return view('resumen', ['resumen' => $result]);
    }
}
