<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Hoja de Carga</title>
    <link rel="stylesheet" href="{{ asset('css/hoja_carga.css') }}">
</head>
<body>
    <div class="menu">
        <a href="{{ route('hoja_pedidos') }}">Pedidos Pendientes</a>
        <a href="{{ route('pedido_entrega') }}">Pedidos Entregados</a>
        <a href="{{ route('insertar_pedido_hca') }}">Añadir hoja de Carga</a>
        <a href="{{ route('aprobacion_pedido') }}">Pedidos encargados</a>
        <a href="{{ route('vista1') }}">Vistas</a>
    </div>
    <div class="body_hoja">
        <h1>Detalles de Hoja de Carga</h1>
        <br>

        <div class="hoja-tabla">
            <table>
                <thead>
                    <tr>
                        <th>ID Orden</th>
                        <th>ID Cliente</th>
                        <th>Estado de la Hoja</th>
                        <th>Fecha del Pedido</th>
                        <th>Fecha de Entrega</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->orden_id }}</td>
                            <td>{{ $detalle->cliente_id }}</td>
                            <td>{{ $detalle->estado_hoja }}</td>
                            <td>{{ $detalle->fecha_pedido }}</td>
                            <td>{{ $detalle->fecha_entrega }}</td>
                            <td><a href="{{ route('pedido_entrega', ['id' => $detalle->orden_id]) }}" class="hoja-tabla-ver">Ver detalles</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
    </div>
</body>
</html>
