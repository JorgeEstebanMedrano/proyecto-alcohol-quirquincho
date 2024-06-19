<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra</title>
    <link href="{{ asset('CSS/Ventas/carrito_cliente.css') }}" rel="stylesheet">
</head>

<body>
    <div id="contenedor">
        <?php
        $arrayProd = [];
        $precioT = 0;
        echo '<table class="productos"><thead><tr>';
        echo '<th>Nombre</th>';
        echo '<th>Cantidad</th>';
        echo '<th>Subtotal</th></tr></thead><tbody>';
        foreach ($productos as $key) {
            echo '<tr>';
            $sql = DB::select('SELECT calcular_precio(' . $key['id'] . ', ' . $key['cantidad'] . ') as Precio');
            $res = get_object_vars($sql[0])['Precio'];
            echo '<div class="producto" id="' .
                $key['nom'] .
                '">
                        <th>' .
                $key['nom'] .
                '</th>
                        <th>' .
                $key['cantidad'] .
                '</th>
                        <th>' .
                $res .
                'Bob</th>
                    </div>';
            $precioT += $res;
            $array = ['id' => $key['id'], 'nom' => $key['nom'], 'cantidad' => $key['cantidad'], 'precio' => $res];
            array_push($arrayProd, $array);
            echo '</tr>';
        }
        echo "<tr><th>Total</th><th>-</th><th>$precioT</th></tr>";
        echo '</tbody></table>';
        ?>
    </div>
    <br>
    <?php
    echo "<form class='formPago' action='pagar?orden=" . json_encode($arrayProd) . "' method='post'>"; ?>
    @csrf
    <?php
    echo '<input type="radio" class="radio" name="pago" value="efectivo"><label for="pago" value="efectivo">Efectivo</label><br>
        <input type="radio" class="radio" name="pago" value="tarjeta"><label for="pago" value="tarjeta">Tarjeta</label><br>';
    echo "<input type='submit' class='buttonGreen'/>";
    echo '</form>';
    ?>
</body>
