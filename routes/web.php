<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ventas;
use App\Http\Controllers\Login;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ReportesVentas;
use App\Http\Controllers\VerMasController;
use App\Http\Controllers\InsertarVariosPedidoController;
use App\Http\Controllers\HojaPedidosController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\OrdenCompraController;
use App\Http\Controllers\AlmacenController;
session_start();
//CREACION Y GESTION DE USUARIOS
Route::get('/', [Login::class, 'index']);
Route::post('/insert', [Login::class, 'insert']);
Route::get('/registro', [Login::class, 'registro']);
Route::post('/login', [Login::class, 'login']);
Route::post('/logout', [Login::class, 'logout']);
//CREACION Y GESTION DE USUARIOS DE TIPO EMPLEADO
if (isset($_POST)) {
    Route::post('/adminpag', [AdminController::class, 'admin']);
}
Route::get('/adminpag', [AdminController::class, 'admin']);
Route::get('/update_user', [AdminController::class, 'update_user']);
Route::get('/delete_user', [AdminController::class, 'delete_user']);
Route::post('/edit_user', [AdminController::class, 'edit_user']);
Route::post('/insert_user', [AdminController::class, 'insert_user']);
//Gestion de ventas
Route::get('/admin_ventas', [Ventas::class, 'venta_productos']);
Route::get('/ver_ventas', [Ventas::class, 'ver_mis_ventas']);
if (isset($_GET['arrayDeProductos'])) {
    Route::get('/realizar_orden', [Ventas::class, 'ver_detalles']);
}
Route::post('/obtener_cliente', [Ventas::class, 'obtener_cliente']);
Route::post('/crear_compra', [Ventas::class, 'crear_compra']);
Route::get('/pag_principal', [ClienteController::class, 'pag_principal']);
Route::get('/compra_carrito', [ClienteController::class, 'compra_carrito']);
Route::post('/pagar', [ClienteController::class, 'pagar']);
//REPORTES
Route::get('/ver_usuarios', [AdminController::class,'ver_usuarios']);
Route::get('/ver_almacenes', [AdminController::class,'ver_almacenes']);
Route::get('/ver_ordenes', [AdminController::class,'ver_ordenes']);
//Reportes de ventas
//Empleados
Route::get('/reportes_ventas', [ReportesVentas::class,'empleados_mas_ventas']);
Route::post('/filtEmpId', [ReportesVentas::class,'filtrar_empleado_id']);
Route::post('/filtEmpFecha', [ReportesVentas::class,'filtrar_empleado_fecha']);
//Clientes
Route::get('/reportes_clientes', [ReportesVentas::class,'reportes_clientes']);
Route::post('/filtClientProdId', [ReportesVentas::class,'reportes_clientes_id']);
Route::post('/filtClientFecha', [ReportesVentas::class, 'reportes_clientes_fecha']);
//Productos
Route::get('/reportes_productos', [ReportesVentas::class,'reportes_productos']);
Route::post('/filtProdFecha', [ReportesVentas::class, 'reportes_productos_fecha']);
//IMPRESIONES
Route::get('/pdf/usersPrint', [PDFController::class,'registroUsuarios']);
Route::get('/pdf/almacenesPrint', [PDFController::class,'almacenesPrint']);
Route::get('/pdf/orderPrint', [PDFController::class,'orderPrint']);
//Impresiones reportes de ventas
//Impresiones empleados
Route::get('/pdf/empBase', [PDFController::class,'empBase']);
Route::get('/pdf/empVentasId', [PDFController::class,'empVentasId']);
Route::get('/pdf/empVentasFecha', [PDFController::class,'empVentasFecha']);
//Impresiones clientes
Route::get('/pdf/clienteBase', [PDFController::class,'clienteBase']);
Route::get('/pdf/clienteId', [PDFController::class,'clienteId']);
Route::get('/pdf/clienteFecha', [PDFController::class,'clienteFecha']);
//Impresiones productos
Route::get('/pdf/prodBase', [PDFController::class,'prodBase']);
Route::get('/pdf/prodFecha', [PDFController::class,'prodFecha']);
//ANDREA
// Rutas para AprobacionPedidoController
Route::get('/aprobacion_pedido', [InsertarVariosPedidoController::class, 'aprobacion_index'])->name('aprobacion_pedido');
Route::get('/aceptar_orden/{id}', [InsertarVariosPedidoController::class, 'acceptOrder'])->name('aceptar_orden');
Route::get('/rechazar_orden/{id}', [InsertarVariosPedidoController::class, 'rechazar'])->name('rechazar_orden');

// Rutas para EntregaController
Route::get('/vista1', [VerMasController::class, 'index'])->name('vista1');
Route::get('/vista2', [VerMasController::class, 'pendientes']);
Route::match(['get', 'post'], '/vista3', [VerMasController::class, 'aceptados']);
Route::get('/vista4', [VerMasController::class, 'rechazados']);
Route::get('/vista5', [VerMasController::class, 'resumen']);

// Rutas para PedidoEntregadoController
Route::get('/pedido_entrega', [HojaPedidosController::class, 'pedido_entregado_index'])->name('pedido_entrega');
Route::get('/pedido_entregado', [HojaPedidosController::class, 'pedido_entregado_index'])->name('pedido_entregado');
Route::match(['get', 'post'], '/pedido_entrega', [HojaPedidosController::class, 'verindex'])->name('pedido_entrega');

// Rutas para PDFController
Route::get('/generar-pdf', [PDFController::class, 'generarPDF'])->name('generar.pdf');
Route::get('/generar2-pdf', [PDFController::class, 'generarPDF2'])->name('generar2.pdf');
Route::get('/generar3-pdf', [PDFController::class, 'generarPDF3'])->name('generar3.pdf');
Route::get('/generar4-pdf', [PDFController::class, 'generarPDF4'])->name('generar4.pdf');
Route::get('/generar5-pdf', [PDFController::class, 'generarPDF5'])->name('generar5.pdf');
Route::get('/generarPDF_ver_mas-pdf/{id}', [PDFController::class, 'generarPDF_ver_mas'])->name('generarPDF_ver_mas.pdf');

// Rutas para HojaPedidosController
Route::get('/hoja_pedidos', [HojaPedidosController::class, 'index'])->name('hoja_pedidos');
Route::get('/entregar_pedido/{hoja_carga_id}', [HojaPedidosController::class, 'entregarPedido'])->name('entregar_pedido');
Route::get('/eliminar_log/{hoja_carga_id}', [HojaPedidosController::class, 'eliminar'])->name('eliminar_log');

// Rutas para InsertarVariosPedidoController
Route::post('/insertar_varios_pedido', [InsertarVariosPedidoController::class, 'insertar'])->name('insertar_varios_pedido');
Route::get('/eliminar_pedido', [InsertarVariosPedidoController::class, 'eliminar'])->name('eliminar_pedido');
Route::get('/insertar_pedido_hca', [InsertarVariosPedidoController::class, 'insertar_pedido_hca'])->name('insertar_pedido_hca');

// Rutas para HojaCargaController
Route::match(['get', 'post'], '/hoja_carga', [HojaPedidosController::class, 'ver_hoja_carga_index'])->name('hoja_carga');
Route::post('/insert_hca', [HojaPedidosController::class, 'insertarHojaCarga'])->name('insert_hca');

// Rutas para DetalleCompraController
Route::get('/ver_detalles/{id}', [HojaPedidosController::class, 'verDetalles'])->name('ver_detalles');
Route::get('/ver_detalles_orden/{id}', [HojaPedidosController::class, 'verDetalles'])->name('ver_detalles_orden');
Route::get('/ver_mas/{id}', [HojaPedidosController::class, 'verDetalles'])->name('ver_mas');


//-----------------------------------------------------------//
//---------------------ALMACEN-------------------------------//
//----------------------------------------------------------//
//rutas para las vistas
//ALMACEN
Route::get('/almacen', [AlmacenController::class, 'VerAlmacen'])->name('almacen');
Route::get('/almacen/tanques_alcohol', [AlmacenController::class, 'DescrpcionAlmacen1'])->name('tanques_alcohol');
Route::get('/almacen/termocontraibles', [AlmacenController::class, 'DescrpcionAlmacen2'])->name('termocontraibles');
Route::get('/almacen/botellas', [AlmacenController::class, 'DescrpcionAlmacen3'])->name('botellas');
Route::get('/almacen/latas', [AlmacenController::class, 'DescrpcionAlmacen4'])->name('latas');

//ORDENES DE COMPRA

Route::get('/pedido-proveedor', [OrdenCompraController::class, 'index'])->name('pedidos');
Route::post('/orden-compra', [OrdenCompraController::class, 'store'])->name('ordencompra.store');
Route::post('/orden', [OrdenCompraController::class, 'procesarOrdenes']);
Route::get('/orders/{id}', [OrdenCompraController::class, 'show']);

//PARA DETALLE
Route::get('/detalle', [OrdenCompraController::class, 'VerDetalle'])->name('detalle');
Route::get('/detalle/pdf/{id}', [PDFController::class, 'DetallePDF'])->name('PDFdetalle');


//REPORTES
Route::get('/Reporte', [ReportesController::class, 'mostrarOrdenes'])->name('Reporte');
Route::get('/r_pm_prov1', [ReportesController::class, 'mostrarComprasProv1'])->name('r_pm_prov1');
Route::get('/r_pm_prov2', [ReportesController::class, 'mostrarComprasProv2'])->name('r_pm_prov2');
Route::get('/r_pm_prov3', [ReportesController::class, 'mostrarComprasProv3'])->name('r_pm_prov3');
Route::get('/r_pm_prov4', [ReportesController::class, 'mostrarComprasProv4'])->name('r_pm_prov4');
Route::get('/r_pm_prov5', [ReportesController::class, 'mostrarComprasProv5'])->name('r_pm_prov5');
//rutas para los pdf de cada vista
Route::get('/pdf-ordenes', [PDFController::class, 'mostrarOrden'])->name('verPDFOrdenes');
Route::get('/pdf-prov1', [PDFController::class, 'ProductoProv1'])->name('prov1');
Route::get('/pdf-prov2', [PDFController::class, 'ProductoProv2'])->name('prov2');
Route::get('/pdf-prov3', [PDFController::class, 'ProductoProv3'])->name('prov3');
Route::get('/pdf-prov4', [PDFController::class, 'ProductoProv4'])->name('prov4');
Route::get('/pdf-prov5', [PDFController::class, 'ProductoProv5'])->name('prov5');
