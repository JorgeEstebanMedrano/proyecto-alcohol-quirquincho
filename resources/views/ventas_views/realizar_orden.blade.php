<?php
$admin_id = $_SESSION['id'];
$arrayDeProductos = json_decode($productos, true);
$array = [];
$precioT = 0;
foreach ($arrayDeProductos as $obj) {
    if ($obj['capacidad'] != 'empId') {
        $arrayProd = $obj;
        array_push($array, $arrayProd);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden</title>
</head>
<link href="{{ asset('CSS/Ventas/carrito.css') }}" rel="stylesheet">
<link href="{{ asset('CSS/sidebar.css') }}" rel="stylesheet">

<body class="pagOrden">
    <div class="menu">
        <ion-icon name="menu"></ion-icon>
        <ion-icon name="close"></ion-icon>
    </div>
    <div class="barra-lateral">
        <div>
            <div class="nombre-pagina">
                <ion-icon name="information-circle-outline" id="info"></ion-icon>
                <span>Ventas</span>
            </div>
            <button class="boton">
                <ion-icon name="add-circle-outline"></ion-icon>
                <span>Options</span>
            </button>
        </div>
        <nav class="navegacion">
            <ul>
                <li>
                    <a href=<?php echo "'/admin_ventas?productosEdit=" . json_encode($array) . "'"; ?>>
                        <ion-icon name="people"></ion-icon>
                        <span>Editar Pedido</span>
                    </a>
                </li>
                <li>
                    <a href="/admin_ventas">
                        <span>Volver</span>
                    </a>
                </li>
                <li>
                    <a href="/logout">
                        <ion-icon name="cube"></ion-icon>
                        <span>Cerrar Sesion</span>
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
        <div class="pagina">
            <center>
                <h2 class="title">Orden</h2>
                <div id="Contenedor">
                    <table class="productos">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($array as $key) {
                                if (is_array($key) && $key['cantidad'] > 0) {
                                    echo '<tr>';
                                    echo '<th>' . $key['capacidad'] . '</th>';
                                    echo '<th>' . $key['cantidad'] . '</th>';
                                    $query = DB::select('SELECT calcular_precio(' . $key['id'] . ', ' . $key['cantidad'] . ') as Precio');
                                    $precio = get_object_vars($query[0]);
                                    echo '<th>' . $precio['Precio'] . '</th>';
                                    $precioT += $precio['Precio'];
                                    echo '</tr>';
                                }
                            }
                            echo '<tr><th>Total</th><th>-</th><th>' . $precioT . '</th></tr>';
                            ?>
                        </tbody>
                    </table>
                </div>
            </center>
            <div class="formPago">
                <h2>Datos del cliente</h2>
                <form action='crear_compra?orden=<?php echo json_encode($array); ?>' method="post" id="form">
                    @csrf
                    <input id="carnet" type="number" name="ci" placeholder="Carnet" required><br>
                    <input type="text" name="nombre" placeholder="Nombre" required><br>
                    <input type="text" name="apellido" placeholder="Apellido" required><br>
                    <input type="text" name="usuario" placeholder="Usuario" required><br>
                    <input type="password" name="contraseña" placeholder="Contraseña" required><br>
                    <input type="email" name="correo" placeholder="Correo" required><br>
                    <input type="text" name="direccion" placeholder="Direccion" required><br>
                    <input type="number" name="telefono" placeholder="Telefono" required><br>
                    <input type="hidden" name="precioTotal" value="<?php echo $precioT; ?>">
                    <input type="hidden" name="admin" id="admin" value="<?php echo $admin_id; ?>">
                    <input type="radio" class="radio" name="pago" value="efectivo" required><label
                        for="efectivo">Efectivo</label><br>
                    <input type="radio" class="radio" name="pago" value="tarjeta"><label
                        for="tarjeta">Tarjeta</label><br>
                    <input type="submit" value="enviar">
                </form>
                <button class="button" onclick="buscarCliente()">Buscar</button>
            </div>
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <script>
        function buscarCliente() {
            const div = document.getElementById("form");
            const car = document.getElementById("carnet").value;
            const id = document.getElementById("admin").value
            $.ajax({
                url: 'obtener_cliente',
                method: 'POST',
                data: {
                    carnet: car,
                    admin: id,
                    _token: $('input[name="_token"]').val()
                }
            }).done(function(res) {
                div.innerHTML = res;
            }).fail(function(jqXHR, textStatus, errorThrown) {
                if (errorThrown == "Not Found") {
                    alert("No se encontro al cliente");
                } else {
                    console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                    alert("Ha ocurrido un error. Por favor, inténtelo de nuevo.");
                }
            });
        }
    </script>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
