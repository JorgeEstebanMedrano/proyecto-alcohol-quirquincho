<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlmacenController extends Controller
{
    public function VerAlmacen()
    {
        $almacen=DB::select('call ver_almacen_general()');
        return view('Almacen',['almacenes' => $almacen]);
    }
    public function DescrpcionAlmacen1()
    {
        $d_almacen1=DB::select('call almacen1()');
         // Extraer datos para el encabezado (suponiendo que el primer registro tiene los datos necesarios)
         $empleado = isset($d_almacen1[0]) ? $d_almacen1[0]->nombre_empleado : 'Desconocido';
         $num_almacen = isset($d_almacen1[0]) ? $d_almacen1[0]->num_almacen : 'Desconocido';
 
         // Pasar los datos a la vista
         return view('d_Almacen1', ['tanques' => $d_almacen1,'empleado' => $empleado,
                     'num_almacen' => $num_almacen]);
    }
    public function DescrpcionAlmacen2()
    {
        $d_almacen2=DB::select('call almacen2()');
        // Extraer datos para el encabezado (suponiendo que el primer registro tiene los datos necesarios)
        $empleado = isset($d_almacen2[0]) ? $d_almacen2[0]->nombre_empleado : 'Desconocido';
        $num_almacen = isset($d_almacen2[0]) ? $d_almacen2[0]->num_almacen : 'Desconocido';

        // Pasar los datos a la vista
        return view('d_Almacen2', ['termocontraibles' => $d_almacen2,'empleado' => $empleado,
                    'num_almacen' => $num_almacen]);

    }
     public function DescrpcionAlmacen3()
    {
        // Llamada al procedimiento almacenado
        $d_almacen3 = DB::select('call almacen3()');

        // Extraer datos para el encabezado (suponiendo que el primer registro tiene los datos necesarios)
        $empleado = isset($d_almacen3[0]) ? $d_almacen3[0]->nombre_empleado : 'Desconocido';
        $num_almacen = isset($d_almacen3[0]) ? $d_almacen3[0]->num_almacen : 'Desconocido';

        // Pasar los datos a la vista
        return view('d_Almacen3', ['botellas' => $d_almacen3,'empleado' => $empleado,
                    'num_almacen' => $num_almacen]);
    }
    public function DescrpcionAlmacen4()
    {
        $d_almacen4=DB::select('call almacen4()');
        // Extraer datos para el encabezado (suponiendo que el primer registro tiene los datos necesarios)
        $empleado = isset($d_almacen4[0]) ? $d_almacen4[0]->nombre_empleado : 'Desconocido';
        $num_almacen = isset($d_almacen4[0]) ? $d_almacen4[0]->num_almacen : 'Desconocido';

        // Pasar los datos a la vista
        return view('d_Almacen4', ['latas' => $d_almacen4,'empleado' => $empleado,
                    'num_almacen' => $num_almacen]);
    }
}
