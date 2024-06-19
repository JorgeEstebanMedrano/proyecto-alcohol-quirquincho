</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('CSS/estilo-reportes.css')}}">
</head>

<body>
    <a href="/adminpag">volver</a>
    <img src="https://i.pinimg.com/originals/10/4f/78/104f785645cf17215303e48e01c975ee.jpg" alt="">
    <div class="cabecera">
        <h1>Alcohol Quirquincho</h1>
    </div>
    <div class="users-table">
        <hr>
        <h2>Usuarios Registrados</h2>
        <hr>
        <table>
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Tipo Pago</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ordenes as $row)
                    <tr>
                        <th>{{ $row->estado_pedido }}</th>
                        <th>{{ $row->fecha_pedido }}</th>
                        <th>{{ $row->tipo_pago }}</th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="/pdf/orderPrint" class="users-table--edit">Imprimir</a>
</body>

</html>
