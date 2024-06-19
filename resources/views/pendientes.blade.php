<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados con más pedidos pendientes</title>
    <link rel="stylesheet" href="{{ asset('css/hoja_carga.css') }}">
</head>
<body>
    <div class="informacion">
        <h1>Distribuidores con más pedidos pendientes</h1>
        <div class="hoja-tabla">
        <table>
            <tr>
                <th><a href="#" class="hoja-tabla-ver">Pendientes</a></th>
                <th><a href="{{ url('vista1') }}" class="hoja-tabla-ver">Entregados</a></th>
                <th><a href="{{ url('vista3') }}" class="hoja-tabla-ver">Aceptados</a></th>
                <th><a href="{{ url('vista4') }}" class="hoja-tabla-ver">Rechazados</a></th>
                <th><a href="{{ url('vista5') }}" class="hoja-tabla-ver">Resumen</a></th>
            </tr>
            <tr>
                <th colspan="2">Empleado ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Total Pendientes</th>
            </tr>
            @foreach ($pendientes as $pendiente)
                <tr>
                    <td colspan="2">{{ htmlspecialchars($pendiente->empleado_id) }}</td>
                    <td>{{ htmlspecialchars($pendiente->nombre) }}</td>
                    <td>{{ htmlspecialchars($pendiente->apellido) }}</td>
                    <td>{{ htmlspecialchars($pendiente->total_entregas) }}</td>
                </tr>
            @endforeach
        </table>
        <br>
        <a href="{{ route('generar2.pdf') }}" class="hoja-tabla-ver">Generar PDF</a>
        </div>
    </div>      
</body>
</html>
