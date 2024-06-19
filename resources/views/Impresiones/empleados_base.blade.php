<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas Por Empleado</title>
</head>
<style>
 * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    html {
        font-family: 'Segoe UI', sans-serif;
        text-align: center;
    }

    a {
        text-decoration: none;
    }

    .users-form {
        margin: auto;
    }

    .users-form form {
        display: flex;
        flex-direction: column;
        gap: 24px;
        width: 30%;
        margin: auto;
        text-align: center;
    }

    .users-form form input {
        font-family: 'Segoe UI', sans-serif;
    }

    .users-form form input[type=text],
    .users-form form input[type=password],
    .users-form form input[type=email] {
        padding: 8px;
        border: 2px solid #aaa;
        border-radius: 4px;
        outline: none;
        transition: .3s;
    }

    .users-form form input[type=text]:focus,
    .users-form form input[type=password]:focus,
    .users-form form input[type=password]:focus {
        border-color: dodgerBlue;
        box-shadow: 0 0 6px 0 dodgerBlue;
    }

    .users-form form input[type=submit] {
        border: none;
        padding: 12px 50px;
        text-decoration: none;
        transition-duration: 0.4s;
        cursor: pointer;
        border-radius: 5px;
        background-color: white;
        color: black;
        border: 2px solid #60a100;
    }

    .users-form form input[type=submit]:hover {
        background-color: #60a100;
        color: white;
    }

    .users-table table {
        border: 1px solid #ccc;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        width: 100%;
        table-layout: fixed;
    }

    table tr {
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        height: 45px;
        padding: 4px;
    }

    table th {
        padding: 16px;
        text-align: center;
        font-size: .85em;
    }

    .users-table--edit {
        background: #009688;
        padding: 6px;
        color: #fff;
        text-align: center;
        font-weight: bold;
    }

    .users-table--delete {
        background: #b11e1e;
        padding: 6px;
        color: #fff;
        text-align: center;
        font-weight: bold;
    }

    .view-employees-button {
        display: inline-block;
        padding: 10px 20px;
        margin: 20px 0;
        background-color: #4CAF50;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
    }

    .view-employees-button:hover {
        background-color: #45a049;
    }

    body {
        text-align: center
        height: 100vh;
        width: 100%;
        background-size: cover;
    }

    /*Modo oscuro*/
    .barra-lateral .modo-oscuro {
        width: 100%;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
    }

    .barra-lateral .modo-oscuro .info {
        width: 150px;
        height: 45px;
        overflow: hidden;
        display: flex;
        align-items: center;
        color: var(--color-texto-menu);
    }

    .barra-lateral .modo-oscuro ion-icon {
        width: 50px;
        font-size: 20px;
    }

    /*Contenedor de pagina*/
    .pagina {
        height: 100%;
        display: block;
        width: 100%;
        margin: auto;
        text-align: center;
        justify-content: center;
    }

    img {
        width: 90px;
        height: 90px;
        opacity: 0.8;
        border-radius: 100%;
    }

    .cabecera {
        width: 100%;
        text-align: center;
    }
    .fecha{
        width: 100%;
        text-align: right;
    }
</style>

<body>
    <div class="fecha">Fecha: <?php echo $date?></div>
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
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Total</th>
                    <th>Total Ventas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $emp = 0;
                foreach ($empleados as $row) {
                    echo "<tr>" . 
                        "<th>".$row->id."</th>" . 
                        "<th>".$row->nombre."</th>" . 
                        "<th>".$row->Total."</th>" .
                        "<th>".$empleados_generado[$emp]->Total_Generado."</th>";  
                    $emp++;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
