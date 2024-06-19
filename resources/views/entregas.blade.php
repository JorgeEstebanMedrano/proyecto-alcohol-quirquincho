<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados con más entregas completadas</title>
    <link rel="stylesheet" href="{{ asset('css/hoja_carga.css') }}">
</head>
<body>
    <div class="informacion">
        <h1>Distribuidores con más entregas</h1>
        <div class="hoja-tabla">
        <table>
            <tr>
                <th><a href="{{ url('vista2') }}" class="hoja-tabla-ver-2">Pendientes</a></th>
                <th><a href="{{ url('vista1') }}" class="hoja-tabla-ver">Entregados</a></th>
                <th><a href="{{ url('vista3') }}" class="hoja-tabla-ver-2">Aceptados</a></th>
                <th><a href="{{ url('vista4') }}" class="hoja-tabla-ver-2">Rechazados</a></th>
                <th><a href="{{ url('vista5') }}" class="hoja-tabla-ver-2">Resumen</a></th>
            </tr>
            <tr>
                <th colspan="2">Empleado ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Total Entregas</th>
            </tr>
            @foreach ($entregas as $entrega)
                <tr>
                    <td colspan="2">{{ htmlspecialchars($entrega->empleado_id) }}</td>
                    <td>{{ htmlspecialchars($entrega->nombre) }}</td>
                    <td>{{ htmlspecialchars($entrega->apellido) }}</td>
                    <td>{{ htmlspecialchars($entrega->total_entregas) }}</td>
                </tr>
            @endforeach
        </table>
        <br>
        <a href="{{ route('generar.pdf') }}" class="hoja-tabla-ver">Generar PDF</a>
        </div>
    </div>      
</body>
</html>
