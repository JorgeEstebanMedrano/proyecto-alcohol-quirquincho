<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Compra</title>
    <link rel="stylesheet" href="{{ asset('css/hoja_carga.css') }}">
</head>
<body>
    <h1>Detalle de la compra</h1>
    <br>
    <div class="body-hoja">
        <div class="informacion-1">
        <table>
            <tbody>
                <tr>
                    <td>Fecha: </td>
                    <td>{{ $details->fecha_pedido ?? '' }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Nombre del cliente: </td>
                    <td>{{ $details->nombre_cliente ?? '' }}</td>
                    <td>{{ $details->apellido_cliente ?? '' }}</td>
                </tr>
                <tr>
                    <td>Dirección: </td>
                    <td>{{ $details->direccion_cliente ?? '' }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Distribuidor: </td>
                    <td>{{ $details->nombre_empleado ?? '' }}</td>
                    <td>{{ $details->apellido_empleado ?? '' }}</td>
                </tr>
                <tr>
                    <td>Placa del vehiculo: </td>
                    <td>{{ $details->placa_vehiculo ?? '' }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        </div>        
    <br>
    <div class="hoja-tabla">
        <table>
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->cantidad }}</td>
                        <td>{{ $product->nombre }}</td>
                        <td>{{ $product->precio }}</td>
                        <td>{{ $product->total }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No se encontraron productos.</td>
                    </tr>
                @endforelse
                <tr>
                    <td colspan="3">Total a Pagar:</td>
                    <td>{{ $total }}</td>
                </tr>
            </tbody>
        </table>
    </div><br>
    <div class="informacion-1">
        <div class="info">
            <a href="{{ route('generarPDF_ver_mas.pdf', ['id' => $details->orden_id]) }}" class="hoja-tabla-ver">Descargar</a>
        </div>
    </div>
    </div>
    
</body>
</html>