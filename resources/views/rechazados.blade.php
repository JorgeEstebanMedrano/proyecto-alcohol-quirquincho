<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordenes Rechazadas</title>
    <link rel="stylesheet" href="{{ asset('css/hoja_carga.css') }}">
</head>
<body>
    <div class="informacion">
        <h1>Todas las ordenes Rechazadas</h1>
        <div class="hoja-tabla">
            <table>
                <tr>
                    <th><a href="{{ url('vista2') }}" class="hoja-tabla-ver">Pendientes</a></th>
                    <th><a href="{{ url('vista1') }}" class="hoja-tabla-ver">Entregados</a></th>
                    <th><a href="{{ url('vista3') }}" class="hoja-tabla-ver">Aceptados</a></th>
                    <th><a href="#" class="hoja-tabla-ver">Rechazados</a></th>
                    <th><a href="{{ url('vista5') }}" class="hoja-tabla-ver">Resumen</a></th>
                </tr>
                <tr>
                    <th>Orden ID</th>
                    <th>Nombre Cliente</th>
                    <th>Apellido Cliente</th>
                    <th>Fecha de Confirmación</th>
                    <th>Estado Pedido</th>
                </tr>
                @foreach ($rechazados as $rechazado)
                    <tr>
                        <td>{{ htmlspecialchars($rechazado->orden_id) }}</td>
                        <td>{{ htmlspecialchars($rechazado->nombre_cli) }}</td>
                        <td>{{ htmlspecialchars($rechazado->apellido_cli) }}</td>
                        <td>{{ htmlspecialchars($rechazado->fecha_conf) }}</td>
                        <td>{{ htmlspecialchars($rechazado->estado_pedido) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4">Total</td>
                    <td>{{ $total_rechazados }}</td>
                </tr>
            </table>
            <br>
            <a href="{{ route('generar4.pdf') }}" class="hoja-tabla-ver">Generar PDF</a>
        </div>
    </div>      
</body>
</html>
