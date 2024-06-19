<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venta</title>
    <link href="{{ asset('CSS/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('CSS/Ventas/carrito.css') }}" rel="stylesheet">
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
                    <a href="/ver_ventas?id=<?php echo $_SESSION['id']; ?>">
                        <ion-icon name="cube"></ion-icon>
                        <span>Ver mis ventas</span>
                    </a>
                </li>
                <li>
                    <a href="/logout">
                        <ion-icon name="people"></ion-icon>
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
    <main class="pagina">
        <h2>Realiza una venta</h2>
        <div class="ventas">
            <div class="Articulos">
                <div class="articulo">
                    <h3 class="subtitulo">Selecciona un producto</h3>
                    <!--Creacion de select para agregar productos-->
                    <select name="producto" id="producto">
                        <!--Incrustamos codigo php para la generacion de las opciones-->
                        @foreach ($productos as $prod)
                            @if ($prod->stock > 0)
                                <option id={{ $prod->id }} value={{ $prod->id }}>
                                    {{ $prod->envase }}{{ $prod->capacidad }}-{{ $prod->stock }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <h3 class="subtitulo">Cantidad</h3>
                <input name="cantidad" type="number" id="cantidad" value=1 min="0"
                    onchange="comprobar('cantidad')">
                <!--Boton para realizar la accion de agregar productos-->
                <button onclick="productoNuevo()">Agregar</button>
                <br>
                <!--Creacion de select para quitar productos-->
                <h3 class="subtitulo">Selecciona un producto a quitar</h3>
                <div class="articulo">
                    <select name="productoQuitar" id="producto_quitar">
                        @foreach ($productos as $prod)
                            @if ($prod->stock > 0)
                                <option id={{ $prod->id }} value={{ $prod->id }}>
                                    {{ $prod->envase }}{{ $prod->capacidad }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <h3 class="subtitulo">Cantidad</h3>
                <input name="cantidad" type="number" id="cantidad_quitar" value=1 min="0"
                    onchange="comprobar('cantidad_quitar')">
                <!--Boton para realizar la accion de reducir productos-->
                <button onclick="productoQuitar()">Quitar</button>
            </div>
        </div>
        <div id="Listado">
        </div>
    </main>
</body>
<script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    var selected = 0;
    class Producto {
        constructor(id, capacidad, cantidad, stock) {
            this.id = id;
            this.capacidad = capacidad;
            this.cantidad = cantidad;
            this.stock = parseInt(stock);
            this.stockSinActualizar = parseInt(stock);
        }
    }
    var adminId;

    function comprobar(a) {
        inp = document.getElementById(a);
        if (inp.value < 0) {
            inp.value = 1
        }
    }

    function productoNuevo() {
        const producto = document.getElementById('producto');
        const identificador = producto.value;
        const cantidad = document.getElementById('cantidad');
        if (parseInt(cantidad.value) < 0) {
            alert("INGRESE SOLO NUMEROS POSITIVOS!!!");
        } else {
            vecProd.forEach(prod => {
                if (prod.id == identificador) {
                    selected = prod.id;
                    if (parseInt(cantidad.value) + prod.cantidad > prod.stockSinActualizar) {
                        prod.cantidad = prod.stockSinActualizar;
                        alert("Stock maximo alcanzado")
                        prod.stock = 0;
                    } else {
                        prod.cantidad += parseInt(cantidad.value);
                        prod.stock -= parseInt(cantidad.value);
                    }
                }
            });
        }
        imprimirLista();
    }

    function productoQuitar() {
        const producto = document.getElementById('producto_quitar');
        const identificador = producto.value;
        const cantidad = document.getElementById('cantidad_quitar');
        if (parseInt(cantidad.value) < 0) {
            alert("SOLO NUMEROS POSITIVOS!!")
            cantidad.value = 0;
        }
        vecProd.forEach(prod => {
            if (prod.id == identificador) {
                prod.cantidad -= parseInt(cantidad.value);
                prod.stock += parseInt(cantidad.value);
                if (prod.stock > prod.stockSinActualizar) {
                    prod.stock = prod.stockSinActualizar;
                }
            }
        });


        imprimirLista();
    }

    function imprimirLista() {
        var distintoDe0 = false;
        const div = document.getElementById('Listado');
        div.innerHTML = "";
        var html = "<table class='productos'><tr><thead><th>Producto</th><th>Cantidad</th></tr><tbody>";
        vecProd.forEach(prod => {
            if (prod.cantidad > 0) {
                distintoDe0 = true;
                html += "<tr><th>" + prod.capacidad + "</th><th>" + prod.cantidad + "</th></tr>";
            } else if (prod.cantidad < 0) {
                prod.cantidad = 0;
            }
        })
        html += "</tbody></table><button onclick = 'obtenerJson()' class='buttonGreen'>Realizar</button>";
        div.innerHTML = html;
        const producto = document.getElementById('producto');
        var newinnerHTML = "";
        vecProd.forEach(element => {
            if (element.id == selected) {
                newinnerHTML += "<option id='" + element.id + "' value='" + element.id + "' selected>" + element
                    .capacidad +
                    "-" + element.stock + "</option>"
            } else {
                newinnerHTML += "<option id='" + element.id + "' value='" + element.id + "'>" + element
                    .capacidad +
                    "-" + element.stock + "</option>"
            }
        });
        producto.innerHTML = (newinnerHTML);
        if (!distintoDe0) {
            div.innerHTML = "";
        }
    }
    var vecProd = [];
    var jsonProd = "";
    const productos = document.getElementById('producto')
    const todos_los_productos = productos.options;
    var a = 0;
    while (todos_los_productos[a] !== undefined) {
        var as = [];
        as[0] = todos_los_productos[a].id;
        as[1] = todos_los_productos[a].text.split("-")[0];
        as[2] = todos_los_productos[a].text.split("-")[1];
        var prodNuevo = new Producto(as[0], as[1], 0, as[2]);
        vecProd.push(prodNuevo);
        a++;
    }
    console.log(vecProd);

    function obtenerJson() {
        jsonProd = JSON.stringify(vecProd)
        window.location.href = 'realizar_orden?arrayDeProductos=' + jsonProd;
    }

    function agregarProducto(prod, cant) {
        vecProd[prod - 1].cantidad = cant;
        imprimirLista();
    }
</script>
<script src="{{ asset('js/sidebar.js') }}"></script>
<script>
    <?php
    if ($_GET) {
        $array = json_decode($_GET['productosEdit'], true);
        foreach ($array as $key) {
            echo 'agregarProducto(' . $key['id'] . ',' . $key['cantidad'] . ");\n";
        }
    }
    ?>
</script>

</html>
