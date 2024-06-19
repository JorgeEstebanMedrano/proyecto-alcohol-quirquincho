<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprobación de Pedido</title>
    <link rel="stylesheet" href="{{ asset('css/hoja_carga.css') }}"> <!-- Asegúrate de que la ruta del CSS sea correcta -->
</head>
<body>
    <div class="menu">
        <a href="{{ route('hoja_pedidos') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path fill="#2196f3" d="M9 11H4.5l-1 4h15l-2.563-10.25a1.003 1.003 0 0 0-.938-.75h-8v-2h8c.55 0 1 .45 1 1v.156l2.313 9.25h1.688c.55 0 1 .45 1 1s-.45 1-1 1H15c-.275 0-.525-.175-.75-.438l-1.313-1.75H7.5l-1.25 5H22v1h-8.5c-.55 0-1-.45-1-1s.45-1 1-1H18l2.563-10.25a1.003 1.003 0 0 0 .937-.75H9v-2zm7.688 9l-2.313-9.25h5.125l1 4H12v2h4.313z"/>
            </svg>
            Pedidos Pendientes
        </a>
        <a href="{{ route('pedido_entrega') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="64" height="64">
                <path fill="#4caf50" d="M464 0H48A48 48 0 0 0 0 48v416a48 48 0 0 0 48 48h416a48 48 0 0 0 48-48V48a48 48 0 0 0-48-48zm-48 176L208 400 96 288l32-32 80 80L352 144z"/>
            </svg>
            Pedidos Entregados
        </a>
        <a href="{{ route('insertar_pedido_hca') }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24">
            <path fill="#f44336" d="M480,96H320L264,40a24,24,0,0,0-18-8H74.82A25.69,25.69,0,0,0,50.82,57.63L31.58,124.37a25.69,25.69,0,0,0,24,33.63H464a16,16,0,0,1,16,16V368a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V160a16,16,0,0,1,16-16H265.44l47.48-61.72A24,24,0,0,1,336,64h98.86a25.69,25.69,0,0,1,24,33.63ZM232,368a8,8,0,0,0,8,8h24a8,8,0,0,0,8-8V320a8,8,0,0,0-8-8H240a8,8,0,0,0-8,8ZM344,240H168a8,8,0,0,0,0,16H344a8,8,0,0,0,0-16Zm88,0H408a8,8,0,0,0,0,16h24a8,8,0,0,0,8-8V192a8,8,0,0,0-8-8H408a8,8,0,0,0,0,16h24Z"/>
        </svg>
            Añadir hoja de Carga
        </a>
        <a href="{{ route('aprobacion_pedido') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path d="M18.5 14c.825 0 1.5-.675 1.5-1.5S19.325 11 18.5 11 17 11.675 17 12.5s.675 1.5 1.5 1.5zM6.5 14c.825 0 1.5-.675 1.5-1.5S7.325 11 6.5 11 5 11.675 5 12.5s.675 1.5 1.5 1.5zM23 7.5c0-.825-.675-1.5-1.5-1.5H17l-1-2h-7l-1 2H2.5C1.675 6 1 6.675 1 7.5v8c0 .825.675 1.5 1.5 1.5H3v2c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h10v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-2h.5c.825 0 1.5-.675 1.5-1.5v-8zM5 6l.5-1h13l.5 1h-14zm14 10H5v-4h14v4zm2-6c0 .275-.225.5-.5.5H20V8h-9v2H8V8H3v6.5c0 .275.225.5.5.5H4v-1h16v1h1.5c.275 0 .5-.225.5-.5V10z"/>
            </svg>
            Pedidos encargados
        </a>
        <a href="{{ route('vista1') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path fill="#2196f3" d="M12 3.5c-4.142 0-7.5 3.358-7.5 7.5s3.358 7.5 7.5 7.5 7.5-3.358 7.5-7.5-3.358-7.5-7.5-7.5zm0 2c3.033 0 5.5 2.467 5.5 5.5s-2.467 5.5-5.5 5.5-5.5-2.467-5.5-5.5 2.467-5.5 5.5-5.5zM12 13c1.378 0 2.5-1.122 2.5-2.5S13.378 8 12 8s-2.5 1.122-2.5 2.5S10.622 13 12 13zm0-1c-.827 0-1.5-.673-1.5-1.5s.673-1.5 1.5-1.5 1.5.673 1.5 1.5-.673 1.5-1.5 1.5z"/>
            </svg>
            Vistas
        </a>
    </div>
    <div class="body-hoja">
        <h2>Aprobación de Pedido</h2>
        <br>
        <div class="hoja-tabla">
            @if (count($ordenesEnEspera) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>ID de la Orden</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ordenesEnEspera as $orden)
                            <tr>
                                <td>{{ $orden->id }}</td>
                                <td><a class="hoja-tabla-ver" href="{{ route('aceptar_orden', $orden->id) }}">Aceptar</a></td>
                                <td><a class="hoja-tabla-ver" href="{{ route('rechazar_orden', $orden->id) }}">Rechazar</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No hay órdenes en espera.</p>
            @endif
        </div>
        <br>
    </div>
</body>
</html>
