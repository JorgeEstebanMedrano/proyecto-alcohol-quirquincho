<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style_PROV.css') }}">
    <title>Orders</title>
</head>
<body>
    <nav class="sidebar">
        <a href="{{ route('almacen') }}">ALMACEN GENERAL</a>
        <a href="{{ route('Reporte') }}">REPORTE DE COMPRAS</a>
        <a href="{{ route('pedidos') }}">PEDIDOS DE INSUMOS</a>
        <a href="{{ route('detalle') }}">VER COMPRA</a>
    </nav>
    <div class="users-table">
        <h2>DETALLE DE MI COMPRA</h2>

        <form method="GET" action="{{ route('detalle') }}">
            <label for="fecha">Buscar por fecha:</label>
            <input type="date" id="fecha" name="fecha">
            <button type="submit">Buscar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Nro. ORDEN</th>
                    <th>FECHA ORDEN</th>
                    <th>PRECIO TOTAL</th>
                    <th>VER DETALLE</th>
                    <th>PDF</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->orden_compra_id }}</td>
                        <td>{{ $order->fecha_orden }}</td>
                        <td>{{ $order->total_precio }}</td>
                        <td><a href="{{ url('orders', $order->orden_compra_id) }}">DETALLE</a></td>
                        <td><a href="{{ route('PDFdetalle', ['id' => $order->orden_compra_id]) }}">PDF</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
