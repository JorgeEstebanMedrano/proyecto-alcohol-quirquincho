<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('CSS/estilo-reportes.css') }}" rel="stylesheet">
    <link href="{{ asset('CSS/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('CSS/styles.css') }}" rel="stylesheet">
    <title>Tus ventas</title>
</head>
<style>
    .titulo{
        background-color: grey;
        opacity: 0.8;
    }
</style>
<body>
    <div class="menu">
        <ion-icon name="menu"></ion-icon>
        <ion-icon name="close"></ion-icon>
    </div>
    <div class="barra-lateral">
        <div>
            <div class="nombre-pagina">
                <ion-icon name="information-circle-outline" id="info"></ion-icon>
                <span>Reportes</span>
            </div>
            <button class="boton">
                <ion-icon name="add-circle-outline"></ion-icon>
                <span>Create new</span>
            </button>
        </div>

        <nav class="navegacion">
            <ul>
                <li>
                    <a href="/admin_ventas">
                        <ion-icon name="people"></ion-icon>
                        <span>Volver</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div>
            <div class="linea"></div>

            <div class="modo-oscuro">
                <div class="info">
                    <ion-icon name="moon"></ion-icon>
                    <span>Osucro</span>
                </div>
                <div class="switch">
                    <div class="base">
                        <div class="circulo">
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <main>
        <img src="https://i.pinimg.com/originals/10/4f/78/104f785645cf17215303e48e01c975ee.jpg" alt="">
        <div class="cabecera">
            <h1>Alcohol Quirquincho</h1>
        </div>
        <div class="users-table">
            <hr>
            <h2 class="titulo"><?php echo $Title; ?></h2>
            <hr>
            <table>
                <thead>
                    <tr>
                        <th>Id de Orden</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Cliente</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empleados as $row)
                        <tr>
                            <th>{{ $row->orden_id }}</th>
                            <th>{{ $row->fecha_pedido }}</th>
                            <th>{{ $row->estado_pedido }}</th>
                            <th>{{ $row->cliente }}</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>
<script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
<script src="{{ asset('js/sidebar.js') }}"></script>
</html>
