<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style_prov.css') }}">
    <script src="{{ asset('js/script.js') }}"></script>
    <title>Termocontraibles</title>
</head>
<body>
    <nav class="sidebar">
        <a href="{{ route('almacen') }}">ALMACEN GENERAL</a>
        <a href="{{ route('Reporte') }}">REPORTE DE COMPRAS</a>
        <a href="{{ route('pedidos') }}">PEDIDOS DE INSUMOS</a>
        <a href="{{ route('detalle') }}">DETALLE COMPRA</a>
    </nav>
    <div class="users-table">
        <button><a href="{{route('almacen')}}">Almacen</a></button>
        <button><a href="{{ route('tanques_alcohol') }}">Tanques de Alcohol</a></button>
        <button><a href="{{ route('termocontraibles') }}"> Termocontraibles</a></button>
        <button><a href="{{ route('botellas') }}">Botellas</a></button>
        <button><a href="{{ route('latas') }}">Latas</a></button>
    </div>
    <div class="users-table">
        <h2>ALMACEN DE TERMOCONTRAIBLES</h2>
        <h3>Encargado: {{ $empleado }}</h3>   <h3>Almacén : {{ $num_almacen }}</h3>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($termocontraibles as $termocontraible)
                    <tr>
                        <td>{{ $termocontraible->producto }}</td>
                        <td>{{ $termocontraible->stock }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</body>
</html>
