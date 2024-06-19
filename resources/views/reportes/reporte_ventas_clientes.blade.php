<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('CSS/estilo-reportes.css') }}" rel="stylesheet">
    <link href="{{ asset('CSS/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('CSS/sidebar.css') }}" rel="stylesheet">
    <title>Ventas Por Cliente</title>
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
                    <a href="#">
                        <ion-icon name="people"></ion-icon>
                        <span>Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="/reportes_ventas">
                        <ion-icon name="hammer"></ion-icon>
                        <span>Empleados</span>
                    </a>
                </li>
                <li>
                    <a href="reportes_productos">
                        <ion-icon name="appstore"></ion-icon>
                        <span>Productos</span>
                    </a>
                </li>
                <li>
                    <a href="/<?php echo $impPag ?>">
                        <ion-icon name="print"></ion-icon>
                        <span>Imprimir</span>
                    </a>
                </li>
                <li>
                    <a href="/adminpag">
                        <ion-icon name="arrow-dropleft-circle"></ion-icon>
                        <span>Volver</span>
                    </a>
                </li>
                <li>
                    <a href="/logout">
                        <ion-icon name="arrow-round-back"></ion-icon>
                        <span>Cerrar Sesión</span>
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
        <form action="filtClientProdId" method="post">
            @csrf
            <h2>Filtrar por id</h2>
            <select name="idFilt">
                <option value="Id_Cliente" selected>Id_Cliente</option>
                <option value="Id_Producto">Id_Producto</option>
            </select>
            <input type="number" name="id" min="0" value="0">
        </form>
        <form action="filtClientFecha" method="post">
            @csrf
            <h2>Filtrar por fehca</h2>
            <input type="date" name="fecha">
            <input type="submit" enviar/>
        </form>
        <div class="users-table">
            <hr>
            <h2 class="titulo"><?php echo $Title; ?></h2>
            <hr>
            <table>
                <thead>
                    <tr>
                        <th>Id Cliente</th>
                        <th>Cliente</th>
                        <th>Id Producto</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $row)
                        <tr>
                            <th>{{ $row->Id_Cliente }}</th>
                            <th>{{ $row->Nombre_Cliente }}</th>
                            <th>{{ $row->Id_Producto }}</th>
                            <th>{{ $row->Producto }}</th>
                            <th>{{ $row->Cantidad }}</th>
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
