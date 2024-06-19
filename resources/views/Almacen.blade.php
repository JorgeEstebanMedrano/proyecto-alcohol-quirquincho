<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style_prov.css') }}">
    <script src="{{ asset('js/script.js') }}"></script>
    <title>Almacen</title>
</head>
<body>
<div class="users-table">
    <h2>DESCRIPCION GENERAL DE LOS ALMACENES</h2>
    <nav class="sidebar">
        <a href="{{ route('almacen') }}">ALMACEN GENERAL</a>
        <a href="{{ route('Reporte') }}">REPORTE DE COMPRAS</a>
        <a href="{{ route('pedidos') }}">PEDIDOS DE INSUMOS</a>
        <a href="{{ route('detalle') }}">DETALLE COMPRA</a>
    </nav>
   <div>
        <button><a href="{{route('almacen')}}">Almacen</a></button>
        <button><a href="{{ route('tanques_alcohol') }}">Tanques de Alcohol</a></button>
        <button><a href="{{ route('termocontraibles') }}"> Termocontraibles</a></button>
        <button><a href="{{ route('botellas') }}">Botellas</a></button>
        <button><a href="{{ route('latas') }}">Latas</a></button>
   </div>
    <table>
        <thead>
            <tr>
                <th>ID EMPLEADO</th>
                <th>EMPLEADO A CARGO</th>
                <th># ALMACEN</th>
                <th>NOMBRE ALMACEN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($almacenes as $almacen)
                <tr>
                    <th>{{ $almacen->empleado }}</th>
                    <th>{{ $almacen->nombre_completo }}</th>
                    <th>{{ $almacen->num_almacen }}</th>
                    <th>{{ $almacen->almacen }}</th>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
