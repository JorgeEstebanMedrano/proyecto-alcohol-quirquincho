<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style_PROV.css') }}">
    <title>Detalle de la Orden</title>
</head>
<body>
    <nav class="sidebar">
        <a href="{{ route('almacen') }}">ALMACEN GENERAL</a>
        <a href="{{ route('Reporte') }}">REPORTE DE COMPRAS</a>
        <a href="{{ route('pedidos') }}">PEDIDOS DE INSUMOS</a>
        <a href="{{ route('detalle') }}">DETALLE COMPRA</a>
    </nav>
    <div class="users-table">

        <h1>DETALLE COMPRA</h1>
        <h4>Proveedor: {{ $orderSummary->proveedor }}</h4>
        <h4>Empleado: {{ $orderSummary->nombre_completo }}</h4>
        <h4>Nro. Orden: {{ $orderSummary->orden_compra_id }}</h4>
        <h4>Fecha de la Orden: {{ $orderSummary->fecha_orden }}</h4>
        <br><br>
        <button><a href="{{ route('PDFdetalle', ['id' => $orderSummary->orden_compra_id]) }}">PDF</a></button>
        <table>
            <thead>
                <tr>
                    <th>PRODUCTO</th>
                    <th>CANTIDAD</th>
                    <th>PRECIO UNITARIO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderDetails as $detail)
                    <tr>
                        <td>{{ $detail->producto }}</td>
                        <td>{{ $detail->cantidad }}</td>
                        <td>{{ $detail->precio_U }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
