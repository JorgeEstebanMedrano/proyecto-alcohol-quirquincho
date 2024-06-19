<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordenes Aceptadas</title>
    <link rel="stylesheet" href="{{ asset('css/hoja_carga.css') }}">
</head>
<body>
    <h1>Todas las ordenes Aceptadas</h1>
    <br>
    <div class="informacion-1">
        <div class="info">
            <form method="POST" action="{{ url('vista3') }}">        
                @csrf
                <input type="date" name="texto" value="buscar_fecha_h">
                <input type="hidden" name="opcion" value="buscar_fecha_h">
                <input type="submit" value="🔎">
            </form>
        </div>
    </div>    
    <br>
    <div class="hoja-tabla">
        <table>
            <tr>
                <th><a href="{{ url('vista2') }}" class="hoja-tabla-ver">Pendientes</a></th>
                <th><a href="{{ url('vista1') }}" class="hoja-tabla-ver">Entregados</a></th>
                <th><a href="#" class="hoja-tabla-ver">Aceptados</a></th>
                <th><a href="{{ url('vista4') }}" class="hoja-tabla-ver">Rechazados</a></th>
                <th><a href="{{ url('vista5') }}" class="hoja-tabla-ver">Resumen</a></th>
            </tr>
            <tr>
                <th>Orden ID</th>
                <th>Nombre Cliente</th>
                <th>Apellido Cliente</th>
                <th>Fecha de Confirmación</th>
                <th>Aceptado</th>
            </tr>
            @foreach ($aceptados as $aceptado)
                <tr>
                    <td>{{ htmlspecialchars($aceptado->orden_id) }}</td>
                    <td>{{ htmlspecialchars($aceptado->nombre_cli) }}</td>
                    <td>{{ htmlspecialchars($aceptado->apellido_cli) }}</td>
                    <td>{{ htmlspecialchars($aceptado->fecha_conf) }}</td>
                    <td>{{ htmlspecialchars($aceptado->estado_pedido) }}</td>
                </tr>                
            @endforeach
            <tr>
                <td colspan="4">Total</td>
                <td>{{ $total_aceptados }}</td>
            </tr>
        </table>
        <br>
        <div style="text-align: center;">
            <a href="{{ route('generar3.pdf') }}" class="hoja-tabla-ver">Generar PDF</a>
        </div>
    </div>
    <br>
</body>
</html>
