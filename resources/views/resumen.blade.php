<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de las Entregas</title>
    <link rel="stylesheet" href="{{ asset('css/hoja_carga.css') }}">
</head>
<body>
    <h1>Resumen de las Entregas</h1>
    <br>
    <div class="hoja-tabla">
        <table>
            <tr>
                <th><a href="{{ url('vista2') }}" class="hoja-tabla-ver">Pendientes</a></th>
                <th><a href="{{ url('vista1') }}" class="hoja-tabla-ver">Entregados</a></th>
                <th><a href="{{ url('vista3') }}" class="hoja-tabla-ver">Aceptados</a></th>
                <th><a href="{{ url('vista4') }}" class="hoja-tabla-ver">Rechazados</a></th>
                <th><a href="#" class="hoja-tabla-ver">Resumen</a></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th>Nombre Empleado</th>
                <th>Apellido Empleado</th>
                <th>Placa</th>
                <th>Total Entregadas</th>
                <th>Total Pendientes</th>
                <th>Promedio Entregadas</th>
                <th>Promedio Pendientes</th>
            </tr>
            @foreach ($resumen as $item)
                <tr>
                    <td>{{ htmlspecialchars($item->nombre) }}</td>
                    <td>{{ htmlspecialchars($item->apellido) }}</td>
                    <td>{{ htmlspecialchars($item->placa) }}</td>
                    <td>{{ htmlspecialchars($item->total_entregadas) }}</td>
                    <td>{{ htmlspecialchars($item->total_pendientes) }}</td>
                    <td>{{ htmlspecialchars($item->promedio_entregadas) }}</td>
                    <td>{{ htmlspecialchars($item->promedio_pendientes) }}</td>
                </tr>
            @endforeach
        </table>
        <br>
        <div style="text-align: center;">
            <a href="{{ route('generar5.pdf') }}" class="hoja-tabla-ver">Generar PDF</a>
        </div>
    </div>
</body>
</html>
