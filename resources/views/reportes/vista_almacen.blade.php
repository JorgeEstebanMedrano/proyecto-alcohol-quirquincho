</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">    
    <link href="{{ asset('CSS/estilo-reportes.css') }}" rel="stylesheet">
    <title>Almacenes</title>
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
                    <th>Nro Almacen</th>
                    <th>Tipo Almacen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($almacen as $row)
                    <tr>
                        <th>{{ $row->nro_de_almacen }}</th>
                        <th>{{ $row->Almacen }}</th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="/pdf/almacenesPrint" class="users-table--edit">Imprimir</a>
</body>

</html>
