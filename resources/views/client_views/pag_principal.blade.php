<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link href="{{ asset('CSS/Ventas/carrito_cliente.css') }}" rel="stylesheet">
</head>
<body>
    <?php
    echo '<h2 class="title">Seleccione los productos</h2>';
    echo '<div id="contenedor">';
    foreach ($productos as $obj) {
        $row = get_object_vars($obj);
        if ($row['stock'] > 0) {
            $query = DB::select('select get_image(?) as src;', [$row['id']]);
            $src = get_object_vars($query[0])['src'];
            echo '
            <div class="productoCarrito" id="' .
                $row['envase'] .
                $row['capacidad'] .
                '">' .
                '<img src="' .
                $src .
                '" class="imagen"/>' .
                '<h2>' .
                $row['envase'] .
                $row['capacidad'] .
                '</h2>
                <h3>' .
                $row['precio'] .
                '</h3>
                <button class="boton" onclick = "añadir(' .
                "'" .
                $row['id'] .
                "'" .
                ')">Mas</button>
                <input class="cantidad" id=' .
                $row['id'] .
                ' type="number" name="' .
                $row['id'] .
                '" value="0" min="0" max="' .
                $row['stock'] .
                '" onchange=comprobar("' .
                $row['id'] .
                '")></input>
                <button class="boton" onclick = "quitar(' .
                $row['id'] .
                ')">Menos</button>
            </div>';
        }
    }
    echo '</div>';
    ?>
    <button onclick="comprar()" class="buttonGreen">Comprar</button>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    class Producto {
        constructor(id, nom, cantidad, stock) {
            this.id = id;
            this.nom = nom;
            this.cantidad = cantidad;
            this.stock = stock;
            this.stockSinActualizar = stock;
        }
    }

    function añadir(a) {
        const prod = document.getElementById(a);
        if (prod.value == "") {
            prod.value = "0";
        } else {
            prod.value = parseInt(prod.value) + 1;
        }
        comprobar(a);
    }

    function comprobar(a) {
        inp = document.getElementById(a);
        max = inp.max;
        if (parseInt(inp.value) >= max) {
            console.log(inp.max);
            inp.value = max;
        } else if (inp.value < 0) {
            inp.value = 0;
        }
    }

    function quitar(a) {
        const prod = document.getElementById(a);
        if (prod.value == "" || parseInt(prod.value) < 1) {
            prod.value = "0";
        } else {
            prod.value = parseInt(prod.value) - 1;
        }
        comprobar(a);
    }

    function comprar() {
        let vecProd = [];
        const nom = document.getElementsByClassName("productoCarrito");
        const inp = document.getElementsByClassName("cantidad");
        for (let index = 0; index < inp.length; index++) {
            if (inp[index].value > 0) {
                vecProd.push(new Producto(inp[index].id, nom[index].id, inp[index].value))
            }
        }
        var jsonProd = JSON.stringify(vecProd);
        window.location.href = 'compra_carrito?productos=' + jsonProd;
    }
</script>

</html>
