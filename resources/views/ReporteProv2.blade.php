<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style_prov.css') }}">
    <script src="{{ asset('js/script.js') }}"></script>
    <title>ORDENES</title>
</head>
<body>
<div class="users-table">
    <nav class="sidebar">
        <a href="{{ route('almacen') }}">ALMACEN GENERAL</a>
        <a href="{{ route('Reporte') }}">REPORTE DE COMPRAS</a>
        <a href="{{ route('pedidos') }}">PEDIDOS DE INSUMOS</a>
        <a href="{{ route('detalle') }}">DETALLE COMPRA</a>
    </nav>
    <div >
        <button><a href="{{ route('Reporte') }}">PRODUCTOS MAS COMPRADOS</a></button>
        <button><a href="{{ route('r_pm_prov1') }}">"PROVEEDOR 1"</a></button>
        <button><a href="{{ route('r_pm_prov2') }}">"PROVEEDOR 2"</a></button>
        <button><a href="{{ route('r_pm_prov3') }}">"PROVEEDOR 3"</a></button>
        <button><a href="{{ route('r_pm_prov4') }}">"PROVEEDOR 4"</a></button>
        <button><a href="{{ route('r_pm_prov5') }}">"PROVEEDOR 5"</a></button>
    </div>
    <br>
    <button><a href="{{ route('verPDFOrdenes') }}">IMPRIMIR</a></button>

    <h2>PRODUCTO MAS PEDIDO "CARLA GUTIERREZ"</h2>
        <table>
            <thead>
                <tr>
                    <th>FECHA ORDEN</th>
                    <th>PRODUCTO</th>
                    <th>CANTIDAD</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ordenes as $orden)
                    <tr>
                        <td>{{ $orden->fecha_orden }}</td>
                        <td>{{ $orden->producto }}</td>
                        <td>{{ $orden->cantidad_total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>

