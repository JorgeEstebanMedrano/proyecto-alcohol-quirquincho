<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style_prov.css') }}">
    <title>ORDENES</title>
</head>

<body>
    <div class="users-form">
        <h1>ORDENES DE INSUMOS</h1>
        <nav class="sidebar">
            <a href="{{ route('almacen') }}">ALMACEN GENERAL</a>
            <a href="{{ route('Reporte') }}">REPORTE DE COMPRAS</a>
            <a href="{{ route('pedidos') }}">PEDIDOS DE INSUMOS</a>
            <a href="{{ route('detalle') }}">DETALLE COMPRA</a>
        </nav>
        <!-- FORMULARIO DE ORDEN DE COMPRA A PROVEEDORES -->
        <form id="ordenForm">
            <!-- COMBO BOX DE EMPLEADOS  -->
            <select name="empleado_id" id="empleados" required onchange="disableSelect('empleados')">
                <option value="" disabled selected>Seleccionar Empleado</option>
                @foreach ($empleados as $empleado)
                    <option value="{{ $empleado['id'] }}">
                        {{ $empleado['empleado'] }}
                    </option>
                @endforeach
            </select>
            <!-- COMBO BOX DE PROVEEDORES  -->
            <select name="proveedor_id" id="proveedores" required onchange="disableSelect('proveedores')">
                <option value="" disabled selected>Seleccionar Proveedor</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor['id'] }}">
                        {{ $proveedor['proveedor'] }}
                    </option>
                @endforeach
            </select>
            <!-- COMBO BOX DE PRODUCTOS  -->
            <select name="producto" id="productos" required>
                <option value="" disabled selected>Productos</option>
                @foreach ($productos as $producto)
                    <option value="{{ $producto['id'] }}" data-precio="{{ $producto['producto_precio'] }}">
                        {{ $producto['producto_precio'] }}
                    </option>
                @endforeach
            </select>

            <input type="text" name="cantidad" placeholder="Cantidad" required>
            <input type="text" name="tipo_pago" placeholder="Tipo de pago" required>
            <button type="button" onclick="agregarProducto()">Agregar Producto</button>
        </form>
    </div>
    @csrf
    <div class="users-table">
        <h2>O - R - D - E - N</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>EMPLEADO</th>
                    <th>PROVEEDOR</th>
                    <th>FECHA</th>
                    <th>PRODUCTO</th>
                    <th>CANTIDAD</th>
                    <th>METODO PAGO</th>
                    <th>TOTAL</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="ordenTabla">
                <!-- Aquí se añadirán las filas de la tabla virtual -->
            </tbody>
        </table>
        <div class="total">
            <h3>Total a Pagar: $<span id="totalPagar">0.00</span></h3>
        </div>
        <br><br>
        <button id="confirmarOrden">REALIZAR PEDIDO</button>
        <button><a href="{{ route('detalle') }}">VER COMPRA</a></button>
    </div>

    <script src="{{ asset('js/custom.js')}}"></script>
    <script>
        // Convertir datos de PHP a JavaScript de manera segura
        window.empleados = JSON.parse('{!! addslashes(json_encode($empleados)) !!}');
        window.proveedores = JSON.parse('{!! addslashes(json_encode($proveedores)) !!}');
        window.productos = JSON.parse('{!! addslashes(json_encode($productos)) !!}');
    </script>
</body>

</html>
