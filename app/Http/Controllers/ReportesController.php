<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ReportesController extends Controller
{
       //-----------REPORTES---------------//
       public function mostrarOrdenes()
       {
           $productos = DB::select('call p_mas_pedidos()');
           return view('Reporte', ['productos' => $productos]);
       }
       public function mostrarComprasProv1()
       {
           $productos = DB::select('call p_mas_prov1()');   
           return view('ReporteProv1', ['ordenes' => $productos]);
       }
       public function mostrarComprasProv2()
       {
           $productos = DB::select('call p_mas_prov2()');
           return view('ReporteProv2', ['ordenes' => $productos]);
       }
       public function mostrarComprasProv3()
       {
           $productos = DB::select('call p_mas_prov3()'); 
           return view('ReporteProv3', ['ordenes' => $productos]);
       }
       public function mostrarComprasProv4()
       {
           $productos = DB::select('call p_mas_prov4()');
           return view('ReporteProv4', ['ordenes' => $productos]);
       }
       public function mostrarComprasProv5()
       {
           $productos = DB::select('call p_mas_prov5()');
           return view('ReporteProv5', ['ordenes' => $productos]);
       }
   
}
