<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('CSS/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('CSS/styles.css') }}" rel="stylesheet">
    <title>Alcohol_Quirquincho</title>
</head>

<body>
    <div class="menu">
        <ion-icon name="menu"></ion-icon>
        <ion-icon name="close"></ion-icon>
    </div>
    <div class="barra-lateral">
        <div>
            <div class="nombre-pagina">
                <ion-icon name="information-circle-outline" id="info"></ion-icon>
                <span>Opciones</span>
            </div>
            <button class="boton">
                <ion-icon name="add-circle-outline"></ion-icon>
                <span>Create new</span>
            </button>
        </div>
        <nav class="navegacion">
            <ul>
                <li>
                    <a href="/ver_usuarios">
                        <ion-icon name="people"></ion-icon>
                        <span>Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="/ver_almacenes">
                        <ion-icon name="cube"></ion-icon>
                        <span>Almacen</span>
                    </a>
                </li>
                <li>
                    <a href="/ver_ordenes">
                        <ion-icon name="filing"></ion-icon>
                        <span>Ordenes</span>
                    </a>
                </li>
                <li>
                    <a href="reportes_ventas">
                        <ion-icon name="construct"></ion-icon>
                        <span>Reportes</span>
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
        <div class="users-form">
            <h1>CREAR USUARIO</h1>
            <form action="insert_user" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Nombre" required>
                <input type="text" name="lastname" placeholder="Apellido" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="number" name="carnet" min="0" placeholder="carnet" required>
                <input type="text" name="telefono" placeholder="Teléfono" required>
                <input type="date" name="fecha" value="<?= date('Y-m-d') ?>" readonly required>

                <select name="type" required>
                    <option value="3000">Almacen</option>
                    <option value="3500">Distribucion</option>
                    <option value="4000">Ventas</option>
                </select>

                <input type="text" name="employee_number" value="<?= $newCodEmpleado ?>" readonly required>
                <input type="submit" value="Agregar">
            </form>
        </div>
        <div class="users-table">
            <h2>Empleados registrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nro de empleado</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Username</th>
                        <th>Contraseña</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($emp as $key) {
                        $row = get_object_vars($key);
                        echo '<tr>' . '<td>' . $row['employee_number'] . '</td>' . '<td>' . $row['name'] . '</td>' . '<td>' . $row['lastname'] . '</td>' . '<td>' . $row['username'] . '</td>' . '<td>' . $row['password'] . '</td>' . '<td>' . $row['hire_date'] . '</td>' . '<td><a href="update_user?id=' . $row['id'] . '" class="users-table--edit">Editar</a></td>' . '</tr>';
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </main>
</body>
<script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
<script src="{{ asset('js/sidebar.js') }}"></script>

</html>
