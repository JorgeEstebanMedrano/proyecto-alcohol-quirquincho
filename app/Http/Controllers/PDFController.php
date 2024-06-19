<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF;
use setasign\Fpdi\Fpdi;
use setasign\Fpdf\Fpdf;
class PDFController extends Controller
{
    public function registroUsuarios(){
        Controller::class::comprobar_admin();
        $sql = DB::select("call vista_usuarios()");
        $users = [];
        foreach ($sql as $obj) {
            array_push($users, get_object_vars($obj));
        }

        $data = [
            "title"=>'Hola',
            'date'=>date("d-m-Y h:i:s"),
            "usuario"=> $sql
        ];

        $pdf = PDF::loadView('impresiones/vista_usuarios_print', $data);

        return $pdf->download('usuarios.pdf');
    }
    public function almacenesPrint(){
        Controller::class::comprobar_admin();
        $sql = DB::select("call vista_almacen()");
        $users = [];
        foreach ($sql as $obj) {
            array_push($users, get_object_vars($obj));
        }

        $data = [
            "title"=>'Hola',
            'date'=>date("d-m-Y h:i:s"),
            "almacen"=> $sql
        ];

        $pdf = PDF::loadView('impresiones/vista_almacen_print', $data);

        return $pdf->download('almacenes.pdf');
    }
    public function orderPrint(){
        Controller::class::comprobar_admin();
        $sql = DB::select("call vista_orden()");
        $users = [];
        foreach ($sql as $obj) {
            array_push($users, get_object_vars($obj));
        }

        $data = [
            "title"=>'Hola',
            'date'=>date("d-m-Y h:i:s"),
            "ordenes"=> $sql
        ];

        $pdf = PDF::loadView('impresiones/vista_ordenes_print', $data);

        return $pdf->download('ordenes.pdf');
    }
    //EMPLEADOS
    public function empBase(){
        Controller::class::comprobar_admin();
        $sql = DB::select('call ver_mas_compras_realizadas');
        $title = "Ventas por empleados de mayor a menor";
        $sqlMasGenerado = DB::select("call ver_mas_generado()");
        $title2 = "Cantidad de dinero generada por empleado de mayor a menor";
        $data = [
            'empleados'=> $sql,
            'Title'=> $title,
            'empleados_generado' => $sqlMasGenerado,
            'Titulo2'=> $title2,
            'date' => date("d-m-Y h:i:s")
        ];

        $pdf = PDF::loadView('impresiones/empleados_base', $data);

        return $pdf->download('Reporte_de_empleados.pdf');
    }
    public function empVentasId(Request $req){
        Controller::class::comprobar_admin();
        $sql = DB::select('call empleado_mayores_ventas_id(?)', [$req['id']]);
        $title = "Ventas por empleados del empleado con id: ".  $req['id'];
        $sqlMasGenerado = DB::select("call empleado_mas_generado_por_id(?)", [$req['id']]);
        $title2 = "Cantidad de dinero generado por el empleado con id: " . $req['id'];
        $data = [
            'empleados'=> $sql,
            'Title'=> $title,
            'empleados_generado' => $sqlMasGenerado,
            'Titulo2'=> $title2,
            'date' => date("d-m-Y h:i:s")
        ];

        $pdf = PDF::loadView('impresiones/empleados_base', $data);
        return $pdf->download('Reporte_de_empleados_por_id.pdf');
    }
    public function empVentasFecha(Request $req){
        Controller::class::comprobar_admin();
        $sql = DB::select('call empleado_mayores_ventas_fecha(?)', [$req['fecha']]);
        $title = "Ventas por empleados en: ".  $req['fecha'];
        $sqlMasGenerado = DB::select("call empleado_mas_generado_por_fecha(?)", [$req['fecha']]);
        $title2 = "Cantidad de dinero generado por empleado en:" . $req['fecha'];
        $data = [
            'empleados'=> $sql,
            'Title'=> $title,
            'empleados_generado' => $sqlMasGenerado,
            'Titulo2'=> $title2,
            'date' => date("d-m-Y h:i:s")
        ];
        $pdf = PDF::loadView('impresiones/empleados_base', $data);
        return $pdf->download('Reporte_de_empleados_por_fecha.pdf');
    }
    public function clienteBase(){
        Controller::class::comprobar_admin();
        $sql = DB::select('call ver_clientes_compra_productos');
        $title = "Productos mas comprados por cliente";
        $data = [
            'clientes'=> $sql,
            'Title'=> $title,
            'date' => date("d-m-Y h:i:s")
        ];
        $pdf = PDF::loadView('impresiones/clientes_base', $data);
        return $pdf->download('Reporte_de_clientes.pdf');
    }
    public function clienteId(Request $req){
        Controller::class::comprobar_admin();
        $arrayId = $req['arrayId'];
        $sql = DB::select('call ver_clientes_compra_producto_'. $arrayId);
        $title = 'Filtrando por id el resultado es:';
        $data = [
            'clientes'=> $sql,
            'Title'=> $title,
            'date' => date("d-m-Y h:i:s")
        ];
        $pdf = PDF::loadView('impresiones/clientes_base', $data);
        return $pdf->download('Reporte_de_clientes_por_id.pdf');
    }
    public function clienteFecha(Request $req){
        Controller::class::comprobar_admin();
        $sql = DB::select('call ver_cliente_compra_producto_fecha(?)', [$req['fecha']]);
        $title = "Productos mas comprados por cliente en: ". $req['fecha'];
        $data = [
            'clientes'=> $sql,
            'Title'=> $title,
            'date' => date("d-m-Y h:i:s")
        ];
        $pdf = PDF::loadView('impresiones/clientes_base', $data);
        return $pdf->download('Reporte_de_clientes_por_fecha.pdf');
    }
    //PRODUCTOS
    public function prodBase(){

        $sql = DB::select('call productos_que_mas_generan();');
        $title = "Productos que mas han generado";
        $data = [
            'productos'=> $sql,
            'Title'=> $title,
            'date' => date("d-m-Y h:i:s")
        ];
        $pdf = PDF::loadView('impresiones/productos_base', $data);
        return $pdf->download('Reporte_de_productos.pdf');
    }
    public function prodFecha(Request $req){
        $sql = DB::select('call ver_producto_mas_genero_desde(?);', [$req['fecha']]);
        $title = "Productos que mas generan desde: " . $req['fecha'];
        $data = [
            'productos'=> $sql,
            'Title'=> $title,
            'date' => date("d-m-Y h:i:s")
        ];
        $pdf = PDF::loadView('impresiones/productos_base', $data);
        return $pdf->download('Reporte_de_productos_desde.pdf');
    }
    //OTRA LIBRERIA PDF
    public function generarPDF()
    {
        // Obtener los datos de la vista1
        $entregas = DB::select('CALL vista_entrega()');

        // Crear un nuevo PDF
        $pdf = new Fpdi();
        $pdf->AddPage();

        // Ruta de la imagen del logo
        $logoPath = public_path('images/logo.png');

        // Agregar la imagen del logo si existe
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 20, 10, 40);
        }

        // Espacio después de la imagen del logo
        $pdf->Ln(45);

        // Título de la página
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetTextColor(0, 0, 51); // Color azul oscuro
        $pdf->Cell(0, 20, 'DISTRIBUIDORES CON MAS ENTREGAS', 0, 1, 'C');

        // FECHA Y HORA EN LITERAL
        $pdf->SetLeftMargin(15);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(120, 15); // Posiciona al lado de la imagen del logo
        $pdf->Cell(0, 10, $this->utf8('Fecha: ' . $this->dias(date('Y-m-d')) . ', ' . date('d') . ' de ' . $this->meses(date('Y-m-d')) . ' de ' . date('Y')), 0, 1, 'L');
        $pdf->SetXY(120, 20); // Posiciona al lado de la imagen del logo
        $pdf->Cell(0, 10, 'Hora: ' . date('H:i:s'), 0, 1, 'L');


        // Espacio después del título
        $pdf->Ln(50);

        // Encabezados de la tabla
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetFillColor(150, 150, 150); // Color de fondo plomizo
        $pdf->SetTextColor(0, 0, 51); // Color del texto
        $pdf->Cell(40, 10, 'Empleado ID', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Nombre', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Apellido', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Total Entregas', 1, 1, 'C', true);

        // Contenido de la tabla
        $pdf->SetFont('Arial', '', 12);
        foreach ($entregas as $entrega) {
            $pdf->Cell(40, 10, htmlspecialchars($entrega->empleado_id), 1);
            $pdf->Cell(50, 10, $this->utf8($entrega->nombre), 1);
            $pdf->Cell(50, 10, $this->utf8($entrega->apellido), 1);
            $pdf->Cell(40, 10, htmlspecialchars($entrega->total_entregas), 1);
            $pdf->Ln();
        }

        // Espacio antes de las firmas
        $pdf->Ln(20);

        // Área de firma personal
        $pdf->SetFont('Arial', 'I', 12);
        $pdf->Cell(80, 85, 'Firma: ________________________', 0, 0, 'C');

        // Espacio entre las firmas
        $pdf->Cell(30, 10, '', 0, 0, 'C');

        // Segunda firma con imagen
        $firmaPath = public_path('images/firma_empresa.png'); // Ruta de la imagen de la firma de la empresa
        if (file_exists($firmaPath)) {
            // Ajusta la posición de la imagen de la firma de la empresa
            $pdf->Image($firmaPath, 120, $pdf->GetY() - 5, 50);
        }

        // Ajustar la posición del texto debajo de la imagen de la firma de la empresa
        $pdf->SetXY(120, $pdf->GetY() + 40);
        $pdf->Cell(50, 10, 'Firma Empresa', 0, 1, 'C');

        // Descargar el PDF
        return response()->streamDownload(function() use ($pdf) {
            $pdf->Output('I', 'distribuidores_mas_entregas.pdf');
        }, 'distribuidores_mas_entregas.pdf');
    }

    public function generarPDF2()
    {
        // Obtener los datos de la vista2
        $pendientes = DB::select('CALL vista_pendiente()');

        // Crear un nuevo PDF
        $pdf = new Fpdi();
        $pdf->AddPage();

        // Ruta de la imagen del logo
        $logoPath = public_path('images/logo.png');

        // Agregar la imagen del logo si existe
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 20, 10, 40);
        }

        // Espacio después de la imagen del logo
        $pdf->Ln(45);

        // Título de la página
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetTextColor(0, 0, 51); // Color azul oscuro
        $pdf->Cell(0, 20, 'DISTRIBUIDORES CON MAS PEDIDOS PENDIENTES', 0, 1, 'C');

        // FECHA Y HORA EN LITERAL
        $pdf->SetLeftMargin(15);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(120, 15); // Posiciona al lado de la imagen del logo
        $pdf->Cell(0, 10, $this->utf8('Fecha: ' . $this->dias(date('Y-m-d')) . ', ' . date('d') . ' de ' . $this->meses(date('Y-m-d')) . ' de ' . date('Y')), 0, 1, 'L');
        $pdf->SetXY(120, 20); // Posiciona al lado de la imagen del logo
        $pdf->Cell(0, 10, 'Hora: ' . date('H:i:s'), 0, 1, 'L');

        // Espacio después del título
        $pdf->Ln(50);

        // Encabezados de la tabla
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetFillColor(150, 150, 150); // Color de fondo plomizo
        $pdf->SetTextColor(0, 0, 51); // Color del texto
        $pdf->Cell(40, 10, 'Empleado ID', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Nombre', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Apellido', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Total Pendientes', 1, 1, 'C', true);

        // Contenido de la tabla
        $pdf->SetFont('Arial', '', 12);
        foreach ($pendientes as $pendiente) {
            $pdf->Cell(40, 10, htmlspecialchars($pendiente->empleado_id), 1);
            $pdf->Cell(50, 10, $this->utf8($pendiente->nombre), 1);
            $pdf->Cell(50, 10, $this->utf8($pendiente->apellido), 1);
            $pdf->Cell(40, 10, htmlspecialchars($pendiente->total_entregas), 1);
            $pdf->Ln();
        }

        // Espacio antes de las firmas
        $pdf->Ln(20);

        // Área de firma personal
        $pdf->SetFont('Arial', 'I', 12);
        $pdf->Cell(80, 85, 'Firma: ________________________', 0, 0, 'C');

        // Espacio entre las firmas
        $pdf->Cell(30, 10, '', 0, 0, 'C');

        // Segunda firma con imagen
        $firmaPath = public_path('images/firma_empresa.png'); // Ruta de la imagen de la firma de la empresa
        if (file_exists($firmaPath)) {
            // Ajusta la posición de la imagen de la firma de la empresa
            $pdf->Image($firmaPath, 120, $pdf->GetY() - 5, 50);
        }

        // Ajustar la posición del texto debajo de la imagen de la firma de la empresa
        $pdf->SetXY(120, $pdf->GetY() + 40);
        $pdf->Cell(50, 10, 'Firma Empresa', 0, 1, 'C');


        // Descargar el PDF
        return response()->streamDownload(function() use ($pdf) {
            $pdf->Output('I', 'distribuidores_mas_entregas_pendientes.pdf');
        }, 'distribuidores_mas_entregas_pendientes.pdf');
    }

    public function generarPDF3()
    {
        // Obtener los datos de la vista2
        $aceptados = DB::select('CALL vista_acep()');
        $total_aceptados = DB::selectOne("SELECT total_pedidos_aceptados() AS total")->total;

        // Crear un nuevo PDF
        $pdf = new Fpdi();
        $pdf->AddPage();

        // Ruta de la imagen del logo
        $logoPath = public_path('images/logo.jpg');

        // Agregar la imagen del logo si existe
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 20, 10, 40);
        }

        // Espacio después de la imagen del logo
        $pdf->Ln(45);

        // Título de la página
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetTextColor(0, 0, 51); // Color azul oscuro
        $pdf->Cell(0, 20, 'PEDIDOS ACEPTADOS', 0, 1, 'C');

        // Fecha actual al lado de la imagen del logo
        // FECHA Y HORA EN LITERAL
        $pdf->SetLeftMargin(15);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(120, 15); // Posiciona al lado de la imagen del logo
        $pdf->Cell(0, 10, $this->utf8('Fecha: ' . $this->dias(date('Y-m-d')) . ', ' . date('d') . ' de ' . $this->meses(date('Y-m-d')) . ' de ' . date('Y')), 0, 1, 'L');
        $pdf->SetXY(120, 20); // Posiciona al lado de la imagen del logo
        $pdf->Cell(0, 10, 'Hora: ' . date('H:i:s'), 0, 1, 'L');

        // Espacio después del título y antes de la tabla
        $pdf->Ln(50);

        // Encabezados de la tabla
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetFillColor(150, 150, 150); // Color de fondo plomizo
        $pdf->SetTextColor(0, 0, 51); // Color del texto
        $pdf->Cell(25, 10, 'Orden ID', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Nombre Cliente', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Apellido Cliente', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Fecha', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Aceptado', 1, 1, 'C', true);

        // Contenido de la tabla
        $pdf->SetFont('Arial', '', 12);
        foreach ($aceptados as $aceptado) {
            $pdf->Cell(25, 10, htmlspecialchars($aceptado->orden_id), 1);
            $pdf->Cell(40, 10, $this->utf8($aceptado->nombre_cli), 1);
            $pdf->Cell(40, 10, $this->utf8($aceptado->apellido_cli), 1);
            $pdf->Cell(40, 10, htmlspecialchars($aceptado->fecha_conf), 1);
            $pdf->Cell(40, 10, htmlspecialchars($aceptado->estado_pedido), 1);
            $pdf->Ln();
        }

        // Fila con el total de pedidos aceptados
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(105, 10, 'Total de Pedidos Aceptados', 1, 0, 'C', true); // Encabezado
        $pdf->Cell(80, 10, $total_aceptados, 1, 1, 'C'); // Valor del total

        // Espacio antes de las firmas
        $pdf->Ln(20);

        // Área de firma personal
        $pdf->SetFont('Arial', 'I', 12);
        $pdf->Cell(80, 85, 'Firma: ________________________', 0, 0, 'C');

        // Espacio entre las firmas
        $pdf->Cell(30, 10, '', 0, 0, 'C');

        // Segunda firma con imagen
        $firmaPath = public_path('images/firma_empresa.png'); // Ruta de la imagen de la firma de la empresa
        if (file_exists($firmaPath)) {
            // Ajusta la posición de la imagen de la firma de la empresa
            $pdf->Image($firmaPath, 120, $pdf->GetY() - 5, 50);
        }

        // Ajustar la posición del texto debajo de la imagen de la firma de la empresa
        $pdf->SetXY(120, $pdf->GetY() + 40);
        $pdf->Cell(50, 10, 'Firma Empresa', 0, 1, 'C');

        // Descargar el PDF
        return response()->streamDownload(function() use ($pdf) {
            $pdf->Output('I', 'pedidos_aceptados.pdf');
        }, 'pedidos_aceptados.pdf');
    }

    public function generarPDF4()
    {
        // Obtener los datos de la vista2
        $aceptados = DB::select('CALL vista_rech()');
        $total_rechazados = DB::selectOne("SELECT total_pedidos_rechazados() AS total")->total;

        // Crear un nuevo PDF
        $pdf = new Fpdi();
        $pdf->AddPage();

        // Ruta de la imagen del logo
        $logoPath = public_path('images/logo.png');

        // Agregar la imagen del logo si existe
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 20, 10, 40);
        }

        // Espacio después de la imagen del logo
        $pdf->Ln(45);

        // Título de la página
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetTextColor(0, 0, 51); // Color azul oscuro
        $pdf->Cell(0, 20, 'PEDIDOS RECHAZADOS', 0, 1, 'C');

        // FECHA Y HORA EN LITERAL
        $pdf->SetLeftMargin(15);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(120, 15); // Posiciona al lado de la imagen del logo
        $pdf->Cell(0, 10, $this->utf8('Fecha: ' . $this->dias(date('Y-m-d')) . ', ' . date('d') . ' de ' . $this->meses(date('Y-m-d')) . ' de ' . date('Y')), 0, 1, 'L');
        $pdf->SetXY(120, 20); // Posiciona al lado de la imagen del logo
        $pdf->Cell(0, 10, 'Hora: ' . date('H:i:s'), 0, 1, 'L');

        // Espacio después del título y antes de la tabla
        $pdf->Ln(50);

        // Encabezados de la tabla
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetFillColor(150, 150, 150); // Color de fondo plomizo
        $pdf->SetTextColor(0, 0, 51); // Color del texto
        $pdf->Cell(25, 10, 'Orden ID', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Nombre Cliente', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Apellido Cliente', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Fecha', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Rechazado', 1, 1, 'C', true);

        // Contenido de la tabla
        $pdf->SetFont('Arial', '', 12);
        foreach ($aceptados as $aceptado) {
            $pdf->Cell(25, 10, htmlspecialchars($aceptado->orden_id), 1);
            $pdf->Cell(40, 10, $this->utf8($aceptado->nombre_cli), 1);
            $pdf->Cell(40, 10, $this->utf8($aceptado->apellido_cli), 1);
            $pdf->Cell(40, 10, htmlspecialchars($aceptado->fecha_conf), 1);
            $pdf->Cell(40, 10, htmlspecialchars($aceptado->estado_pedido), 1);
            $pdf->Ln();
        }

        // Fila con el total de pedidos aceptados
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(105, 10, 'Total de Pedidos Aceptados', 1, 0, 'C', true); // Encabezado
        $pdf->Cell(80, 10, $total_rechazados, 1, 1, 'C'); // Valor del total

        // Espacio antes de las firmas
        $pdf->Ln(20);

        // Área de firma personal
        $pdf->SetFont('Arial', 'I', 12);
        $pdf->Cell(80, 85, 'Firma: ________________________', 0, 0, 'C');

        // Espacio entre las firmas
        $pdf->Cell(30, 10, '', 0, 0, 'C');

        // Segunda firma con imagen
        $firmaPath = public_path('images/firma_empresa.png'); // Ruta de la imagen de la firma de la empresa
        if (file_exists($firmaPath)) {
            // Ajusta la posición de la imagen de la firma de la empresa
            $pdf->Image($firmaPath, 120, $pdf->GetY() - 5, 50);
        }

        // Ajustar la posición del texto debajo de la imagen de la firma de la empresa
        $pdf->SetXY(120, $pdf->GetY() + 40);
        $pdf->Cell(50, 10, 'Firma Empresa', 0, 1, 'C');

        // Descargar el PDF
        return response()->streamDownload(function() use ($pdf) {
            $pdf->Output('I', 'pedidos_aceptados.pdf');
        }, 'pedidos_aceptados.pdf');
    }

    public function generarPDF5()
    {
        // Obtener los datos de la vista2
        $aceptados = DB::select('CALL vista_resumen()');

        // Crear un nuevo PDF
        $pdf = new Fpdi();
        $pdf->AddPage();

        // Ruta de la imagen del logo
        $logoPath = public_path('images/logo.png');

        // Agregar la imagen del logo si existe
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 20, 10, 40);
        }

        // Espacio después de la imagen del logo
        $pdf->Ln(45);

        // Título de la página
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetTextColor(0, 0, 51); // Color azul oscuro
        $pdf->Cell(0, 20, 'RESUMEN ENTREGAS', 0, 1, 'C');

        // FECHA Y HORA EN LITERAL
        $pdf->SetLeftMargin(15);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(120, 15); // Posiciona al lado de la imagen del logo
        $pdf->Cell(0, 10, $this->utf8('Fecha: ' . $this->dias(date('Y-m-d')) . ', ' . date('d') . ' de ' . $this->meses(date('Y-m-d')) . ' de ' . date('Y')), 0, 1, 'L');
        $pdf->SetXY(120, 20); // Posiciona al lado de la imagen del logo
        $pdf->Cell(0, 10, 'Hora: ' . date('H:i:s'), 0, 1, 'L');

        // Espacio después del título y antes de la tabla
        $pdf->Ln(50);

        // Encabezados de la tabla
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetFillColor(150, 150, 150); // Color de fondo plomizo
        $pdf->SetTextColor(0, 0, 51); // Color del texto
        $pdf->Cell(25, 10, 'Nombre', 1, 0, 'C', true);
        $pdf->Cell(25, 10, 'Apellido', 1, 0, 'C', true);
        $pdf->Cell(20, 10, 'Placa', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'T. Entregas', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'T. Pend.', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'P. Entregas', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'P. Pend.', 1, 1, 'C', true);

        // Contenido de la tabla
        $pdf->SetFont('Arial', '', 12);
        foreach ($aceptados as $aceptado) {
            $pdf->Cell(25, 10, $this->utf8($aceptado->nombre), 1);
            $pdf->Cell(25, 10, $this->utf8($aceptado->apellido), 1);
            $pdf->Cell(20, 10, htmlspecialchars($aceptado->placa), 1);
            $pdf->Cell(30, 10, htmlspecialchars($aceptado->total_entregadas), 1);
            $pdf->Cell(30, 10, htmlspecialchars($aceptado->total_pendientes), 1);
            $pdf->Cell(30, 10, htmlspecialchars($aceptado->promedio_entregadas), 1);
            $pdf->Cell(30, 10, htmlspecialchars($aceptado->promedio_pendientes), 1);
            $pdf->Ln();
        }

        // Espacio antes de las firmas
        $pdf->Ln(20);

        // Área de firma personal
        $pdf->SetFont('Arial', 'I', 12);
        $pdf->Cell(80, 85, 'Firma: ________________________', 0, 0, 'C');

        // Espacio entre las firmas
        $pdf->Cell(30, 10, '', 0, 0, 'C');

        // Segunda firma con imagen
        $firmaPath = public_path('images/firma_empresa.png'); // Ruta de la imagen de la firma de la empresa
        if (file_exists($firmaPath)) {
            // Ajusta la posición de la imagen de la firma de la empresa
            $pdf->Image($firmaPath, 120, $pdf->GetY() - 5, 50);
        }

        // Ajustar la posición del texto debajo de la imagen de la firma de la empresa
        $pdf->SetXY(120, $pdf->GetY() + 40);
        $pdf->Cell(50, 10, 'Firma Empresa', 0, 1, 'C');

        // Descargar el PDF
        return response()->streamDownload(function() use ($pdf) {
            $pdf->Output('I', 'pedidos_aceptados.pdf');
        }, 'pedidos_aceptados.pdf');
    }

    public function generarPDF_ver_mas($id)
    {
        // Obtener los datos específicos según el ID (ejemplo)
        $detalle = DB::select('CALL ver_info_hca(?)', [$id]);
        $detalle_2 = DB::select('CALL suma_cant(?)', [$id]);
        $total = DB::selectOne("SELECT calcular_total_orden(?) AS total",[$id])->total;

        // Crear un nuevo PDF
        $pdf = new Fpdi();
        $pdf->AddPage();

        // Ruta de la imagen del logo
        $logoPath = public_path('images/logo.png');

        // Agregar la imagen del logo si existe
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 20, 10, 40);
        }

        // Espacio después de la imagen del logo
        $pdf->Ln(35);

        // Fecha actual al lado de la imagen del logo
        // FECHA Y HORA EN LITERAL
        $pdf->SetLeftMargin(15);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(120, 15); // Posiciona al lado de la imagen del logo
        $pdf->Cell(0, 10, $this->utf8('Fecha: ' . $this->dias(date('Y-m-d')) . ', ' . date('d') . ' de ' . $this->meses(date('Y-m-d')) . ' de ' . date('Y')), 0, 1, 'L');
        $pdf->SetXY(120, 20); // Posiciona al lado de la imagen del logo
        $pdf->Cell(0, 10, 'Hora: ' . date('H:i:s'), 0, 1, 'L');

        // Espacio después del título y antes de la tabla
        $pdf->Ln(30);

        $pdf->SetFont('Arial', '', 12);
        foreach ($detalle as $item) {
            $pdf->Cell(40, 8, 'Fecha:', 0, 0, 'L');
            $pdf->Cell(60, 8, htmlspecialchars($item->fecha_pedido), 0, 1, 'L');

            $pdf->Cell(40, 8, 'Nombre del cliente:', 0, 0, 'L');
            $pdf->Cell(60, 8, $this->utf8($item->nombre_cliente . ' ' . $item->apellido_cliente), 0, 1, 'L');

            $pdf->Cell(40, 8, 'Direccion:', 0, 0, 'L');
            $pdf->Cell(60, 8, $this->utf8($item->direccion_cliente), 0, 1, 'L');

            $pdf->Cell(40, 8, 'Distribuidor:', 0, 0, 'L');
            $pdf->Cell(60, 8, $this->utf8($item->nombre_empleado . ' ' . $item->apellido_empleado), 0, 1, 'L');

            $pdf->Cell(40, 8, 'Placa del vehiculo:', 0, 0, 'L');
            $pdf->Cell(60, 8, htmlspecialchars($item->placa_vehiculo), 0, 1, 'L');

            $pdf->Ln(10); // Espacio entre cada grupo de información
        }

        $pdf->Ln(20); // Espacio antes de la tabla

        $anchoPagina = $pdf->GetPageWidth();
        $anchoTabla = 100; // Suma de los anchos de las celdas de la tabla (25 + 25 + 20 + 30 + 25 + 25)
        $posicionX = ($anchoPagina - $anchoTabla) / 2;

        // Encabezados de la tabla
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetFillColor(150, 150, 150); // Color de fondo plomizo
        $pdf->SetTextColor(0, 0, 51); // Color del texto
        $pdf->SetXY($posicionX, $pdf->GetY());
        $pdf->Cell(25, 10, 'Cantidad', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Nombre', 1, 0, 'C', true);
        $pdf->Cell(20, 10, 'Precio', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Total', 1, 1, 'C', true); // Use 1 para indicar que finaliza la línea

        // Contenido de la tabla
        $pdf->SetFont('Arial', '', 12);
        foreach ($detalle_2 as $det) {
            $pdf->SetX($posicionX);
            $pdf->Cell(25, 10, htmlspecialchars($det->cantidad), 1, 0, 'C');
            $pdf->Cell(30, 10, $this->utf8($det->nombre), 1, 0, 'C');
            $pdf->Cell(20, 10, htmlspecialchars($det->precio), 1, 0, 'C');
            $pdf->Cell(30, 10, htmlspecialchars($det->total), 1, 1, 'C');
        }

        // Fila con el total de pedidos aceptados
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetX($posicionX);
        $pdf->Cell(75, 10, 'Total : ', 1, 0, 'C', true); // Encabezado
        $pdf->Cell(30, 10, $total, 1, 1, 'C'); // Valor del total

        // Espacio antes de las firmas
            $pdf->Ln(10);

        // Área de firma personal
        $pdf->SetFont('Arial', 'I', 12);
        $pdf->Cell(80, 85, 'Firma: ________________________', 0, 0, 'C');

        // Espacio entre las firmas
        $pdf->Cell(30, 10, '', 0, 0, 'C');

        // Segunda firma con imagen
        $firmaPath = public_path('images/firma_empresa.png'); // Ruta de la imagen de la firma de la empresa
        if (file_exists($firmaPath)) {
            // Ajusta la posición de la imagen de la firma de la empresa
            $pdf->Image($firmaPath, 120, $pdf->GetY() - 5, 50);
        }

        // Ajustar la posición del texto debajo de la imagen de la firma de la empresa
        $pdf->SetXY(120, $pdf->GetY() + 40);
        $pdf->Cell(50, 10, 'Firma Empresa', 0, 1, 'C');

        // Descargar el PDF
        return response()->streamDownload(function() use ($pdf) {
            $pdf->Output('I', 'detalle_pedido.pdf');
        }, 'detalle_pedido.pdf');
    }

 //-------------------------------------------------------------------------------------//
//---------------------------------PDF PARA ALMACEN -----------------------------------//
//-------------------------------------------------------------------------------------//

    //PROOVEDORES
    public function dias($fecha)
    {
        $dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
        $dia = $dias[date('w', strtotime($fecha))];
        return $dia;
    }

    public function meses($fecha)
    {
        $meses = array(
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        );
        $mes = $meses[date('n', strtotime($fecha)) - 1];
        return $mes;
    }

    public function utf8($txt)
    {
        return mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8',); // ISO-8859-1 es el formato de codificacion de caracteres
    }


    public function mostrarOrden()
    {
        $pdf= new Fpdi();
        $pdf-> AddPage('L');

        $pdf-> image('images/logo.png', 240,5,50);
        // establecer fuente
        $pdf->SetFont('Arial','B',15);

        $pdf->Cell(0, 10, $this->utf8('PRODUCTOS MAS COMPRADOS'), 0, 1, 'C');
        $pdf->Ln(10);

        // FECHA Y HORA EN LITERAL
        $pdf->SetLeftMargin(15);
        $pdf->Cell(0, 10, $this->utf8('Fecha: ' . $this->dias(date('Y-m-d')) . ', ' . date('d') . ' de ' . $this->meses(date('Y-m-d')) . ' de ' . date('Y')), 0, 1, 'L');
        $pdf->Cell(0, 10, 'Hora: ' . date('H:i:s'), 0, 1, 'L');



        $ordenes= DB::select('call p_mas_pedidos()');

        $pdf->Ln();
        $pdf->Cell(90, 10, 'PRODUCTO', 1, 0, 'C'); // 40 de ancho, 10 de alto, 1 borde, 0 salto de linea, C centrado
        $pdf->Cell(90, 10, 'PROVEEDOR', 1, 0, 'C');
        $pdf->Cell(90, 10, 'CANTIDAD TOTAL', 1, 0, 'C');

        $pdf->Ln();

        foreach ($ordenes as $orden) {
            $pdf->cell(90, 10, $orden->producto, 1, 0, 'C');
            $pdf->Cell(90, 10, $this->utf8($orden->proveedor), 1, 0, 'C');
            $pdf->Cell(90, 10, $orden->cantidad_total, 1, 0, 'C');
            $pdf->Ln();
        }

        $pdf->Output();
    }

    public function ProductoProv1()
    {
        $pdf= new Fpdi();
        $pdf-> AddPage('L');

        $pdf-> image('images/logo.png', 240,5,50);
        // establecer fuente
        $pdf->SetFont('Arial','B',15);

        $pdf->Cell(0, 10, $this->utf8('PRODUCTOS MAS PEDIDOS EN CANTIDAD POR PROVEEDOR'), 0, 1, 'C');
        $pdf->Ln(10);

        // FECHA Y HORA EN LITERAL
        $pdf->SetLeftMargin(15);
        $pdf->Cell(0, 10, $this->utf8('Fecha: ' . $this->dias(date('Y-m-d')) . ', ' . date('d') . ' de ' . $this->meses(date('Y-m-d')) . ' de ' . date('Y')), 0, 1, 'L');
        $pdf->Cell(0, 10, 'Hora: ' . date('H:i:s'), 0, 1, 'L');


        $pdf->Cell(0, 10, $this->utf8('PRODUCTO MAS PEDIDO "DIEGO FERNANDEZ"'), 0, 1, 'C');


        $ordenes= DB::select('call p_mas_prov1()');

        $pdf->Ln();
        $pdf->Cell(90, 10, 'PRODUCTO', 1, 0, 'C'); // 40 de ancho, 10 de alto, 1 borde, 0 salto de linea, C centrado
        $pdf->Cell(90, 10, 'PROVEEDOR', 1, 0, 'C');
        $pdf->Cell(90, 10, 'CANTIDAD TOTAL', 1, 0, 'C');

        $pdf->Ln();

        foreach ($ordenes as $orden) {
            $pdf->cell(90, 10, $orden->fecha_orden, 1, 0, 'C');
            $pdf->Cell(90, 10, $orden ->producto, 1, 0, 'C');
            $pdf->Cell(90, 10, $orden->cantidad_total, 1, 0, 'C');
            $pdf->Ln();
        }

        $pdf->Output();
    }

    public function ProductoProv2()
    {
        $pdf= new Fpdi();
        $pdf-> AddPage('L');

        $pdf-> image('images/logo.png', 240,5,50);
        // establecer fuente
        $pdf->SetFont('Arial','B',15);

        $pdf->Cell(0, 10, $this->utf8('PRODUCTOS MAS PEDIDOS EN CANTIDAD POR PROVEEDOR'), 0, 1, 'C');
        $pdf->Ln(10);

        // FECHA Y HORA EN LITERAL
        $pdf->SetLeftMargin(15);
        $pdf->Cell(0, 10, $this->utf8('Fecha: ' . $this->dias(date('Y-m-d')) . ', ' . date('d') . ' de ' . $this->meses(date('Y-m-d')) . ' de ' . date('Y')), 0, 1, 'L');
        $pdf->Cell(0, 10, 'Hora: ' . date('H:i:s'), 0, 1, 'L');


        $pdf->Cell(0, 10, $this->utf8('PRODUCTO MAS PEDIDO "CARLA GUTIERREZ"'), 0, 1, 'C');

        $ordenes= DB::select('call p_mas_prov2()');

        $pdf->Ln();
        $pdf->Cell(90, 10, 'PRODUCTO', 1, 0, 'C'); // 40 de ancho, 10 de alto, 1 borde, 0 salto de linea, C centrado
        $pdf->Cell(90, 10, 'PROVEEDOR', 1, 0, 'C');
        $pdf->Cell(90, 10, 'CANTIDAD TOTAL', 1, 0, 'C');

        $pdf->Ln();

        foreach ($ordenes as $orden) {
            $pdf->cell(90, 10, $orden->fecha_orden, 1, 0, 'C');
            $pdf->Cell(90, 10, $orden ->producto, 1, 0, 'C');
            $pdf->Cell(90, 10, $orden->cantidad_total, 1, 0, 'C');
            $pdf->Ln();
        }

        $pdf->Output();
    }

    public function ProductoProv3()
    {
        $pdf= new Fpdi();
        $pdf-> AddPage('L');

        $pdf-> image('images/logo.png', 240,5,50);
        // establecer fuente
        $pdf->SetFont('Arial','B',15);

        $pdf->Cell(0, 10, $this->utf8('PRODUCTOS MAS PEDIDOS EN CANTIDAD POR PROVEEDOR'), 0, 1, 'C');
        $pdf->Ln(10);

        // FECHA Y HORA EN LITERAL
        $pdf->SetLeftMargin(15);
        $pdf->Cell(0, 10, $this->utf8('Fecha: ' . $this->dias(date('Y-m-d')) . ', ' . date('d') . ' de ' . $this->meses(date('Y-m-d')) . ' de ' . date('Y')), 0, 1, 'L');
        $pdf->Cell(0, 10, 'Hora: ' . date('H:i:s'), 0, 1, 'L');

        $pdf->Cell(0, 10, $this->utf8('PRODUCTO MAS PEDIDO "PEDRO CHAVEZ"'), 0, 1, 'C');

        $ordenes= DB::select('call p_mas_prov3()');


        $pdf->Ln();
        $pdf->Cell(90, 10, 'PRODUCTO', 1, 0, 'C'); // 40 de ancho, 10 de alto, 1 borde, 0 salto de linea, C centrado
        $pdf->Cell(90, 10, 'PROVEEDOR', 1, 0, 'C');
        $pdf->Cell(90, 10, 'CANTIDAD TOTAL', 1, 0, 'C');

        $pdf->Ln();

        foreach ($ordenes as $orden) {
            $pdf->cell(90, 10, $orden->fecha_orden, 1, 0, 'C');
            $pdf->Cell(90, 10, $orden ->producto, 1, 0, 'C');
            $pdf->Cell(90, 10, $orden->cantidad_total, 1, 0, 'C');
            $pdf->Ln();
        }

        $pdf->Output();
    }

    public function ProductoProv4()
    {
        $pdf= new Fpdi();
        $pdf-> AddPage('L');

        $pdf-> image('images/logo.png', 240,5,50);
        // establecer fuente
        $pdf->SetFont('Arial','B',15);

        $pdf->Cell(0, 10, $this->utf8('PRODUCTOS MAS PEDIDOS EN CANTIDAD POR PROVEEDOR'), 0, 1, 'C');
        $pdf->Ln(10);

        // FECHA Y HORA EN LITERAL
        $pdf->SetLeftMargin(15);
        $pdf->Cell(0, 10, $this->utf8('Fecha: ' . $this->dias(date('Y-m-d')) . ', ' . date('d') . ' de ' . $this->meses(date('Y-m-d')) . ' de ' . date('Y')), 0, 1, 'L');
        $pdf->Cell(0, 10, 'Hora: ' . date('H:i:s'), 0, 1, 'L');

        $pdf->Cell(0, 10, $this->utf8('PRODUCTO MAS PEDIDO "Grinplas SRL"'), 0, 1, 'C');

        $ordenes= DB::select('call p_mas_prov4()');


        $pdf->Ln();
        $pdf->Cell(90, 10, 'PRODUCTO', 1, 0, 'C'); // 40 de ancho, 10 de alto, 1 borde, 0 salto de linea, C centrado
        $pdf->Cell(90, 10, 'PROVEEDOR', 1, 0, 'C');
        $pdf->Cell(90, 10, 'CANTIDAD TOTAL', 1, 0, 'C');

        $pdf->Ln();

        foreach ($ordenes as $orden) {
            $pdf->cell(90, 10, $orden->fecha_orden, 1, 0, 'C');
            $pdf->Cell(90, 10, $orden ->producto, 1, 0, 'C');
            $pdf->Cell(90, 10, $orden->cantidad_total, 1, 0, 'C');
            $pdf->Ln();
        }

        $pdf->Output();
    }
    public function ProductoProv5()
    {
        $pdf= new Fpdi();
        $pdf-> AddPage('L');

        $pdf-> image('images/logo.png', 240,5,50);
        // establecer fuente
        $pdf->SetFont('Arial','B',15);

        $pdf->Cell(0, 10, $this->utf8('PRODUCTOS MAS PEDIDOS EN CANTIDAD POR PROVEEDOR'), 0, 1, 'C');
        $pdf->Ln(10);

        // FECHA Y HORA EN LITERAL
        $pdf->SetLeftMargin(15);
        $pdf->Cell(0, 10, $this->utf8('Fecha: ' . $this->dias(date('Y-m-d')) . ', ' . date('d') . ' de ' . $this->meses(date('Y-m-d')) . ' de ' . date('Y')), 0, 1, 'L');
        $pdf->Cell(0, 10, 'Hora: ' . date('H:i:s'), 0, 1, 'L');

        $pdf->Cell(0, 10, $this->utf8('PRODUCTO MAS PEDIDO "FABE - Fábrica de Envases S.A."'), 0, 1, 'C');

        $ordenes= DB::select('call p_mas_prov4()');


        $pdf->Ln();
        $pdf->Cell(90, 10, 'PRODUCTO', 1, 0, 'C'); // 40 de ancho, 10 de alto, 1 borde, 0 salto de linea, C centrado
        $pdf->Cell(90, 10, 'PROVEEDOR', 1, 0, 'C');
        $pdf->Cell(90, 10, 'CANTIDAD TOTAL', 1, 0, 'C');

        $pdf->Ln();

        foreach ($ordenes as $orden) {
            $pdf->cell(90, 10, $orden->fecha_orden, 1, 0, 'C');
            $pdf->Cell(90, 10, $orden ->producto, 1, 0, 'C');
            $pdf->Cell(90, 10, $orden->cantidad_total, 1, 0, 'C');
            $pdf->Ln();
        }


        $pdf->Output();
    }
    public function DetallePDF($id)
    {
        $pdf = new Fpdi();
        $pdf->AddPage('L');

        // Imagen del logo
        $pdf->Image('images/logo.png', 240, 5, 50);

        // Establecer fuente
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Ln(10);
        // Fecha y hora en literal
        $pdf->SetLeftMargin(10);
        $pdf->Cell(0, 5, 'Fecha: ' . date('d-m-Y'), 0, 1, 'L');
        $pdf->Cell(0, 5, 'Hora: ' . date('H:i:s'), 0, 1, 'L');

        $pdf->Cell(0, 15, $this->utf8('DETALLE DE LA ORDEN'), 0, 1, 'C');
        $pdf->Ln(15);
        // Obtener los detalles de la orden por ID
        $orderSummary = DB::select('CALL detalle_completo(?)', [$id]);
        $orderDetails = DB::select('CALL detalle_completo(?)', [$id]);

        if ($orderSummary) {
            $orderSummary = $orderSummary[0]; // Obtener el primer resultado

            // Información del pedido
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, 'Proveedor: ' . $orderSummary->proveedor, 0, 1, 'L');
            $pdf->Cell(0, 10, 'Empleado: ' . $orderSummary->nombre_completo, 0, 1, 'L');
            $pdf->Cell(0, 10, 'Nro. Orden: ' . $orderSummary->orden_compra_id, 0, 1, 'L');
            $pdf->Cell(0, 10, 'Fecha de la Orden: ' . $orderSummary->fecha_orden, 0, 1, 'L');

            // Encabezados de la tabla
            $pdf->Ln();
            $pdf->Cell(90, 10, 'PRODUCTO', 1, 0, 'C');
            $pdf->Cell(90, 10, 'CANTIDAD', 1, 0, 'C');
            $pdf->Cell(90, 10, 'PRECIO UNITARIO', 1, 0, 'C');
            $pdf->Ln();

            // Datos de la tabla
            foreach ($orderDetails as $detail) {
                $pdf->Cell(90, 10, $detail->producto, 1, 0, 'C');
                $pdf->Cell(90, 10, $detail->cantidad, 1, 0, 'C');
                $pdf->Cell(90, 10, $detail->precio_U, 1, 0, 'C');
                $pdf->Ln();
            }
        }

        // Salida del PDF
        $pdf->Output('I', 'Detalle_Orden_' . $id . '.pdf');
    }
}
