<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoja de Carga</title>
    <link rel="stylesheet" href="{{ asset('css/hoja_carga.css') }}">
</head>
<body>
    @if(session('success'))
        <script>alert('{{ session('success') }}');</script>
    @endif

    @if(session('error'))
        <script>alert('{{ session('error') }}');</script>
    @endif

    <h1 style="color: #ffffff;">Añadir Nueva Orden</h1>
    <br>
    <div class="body-hoja">
        <h2>Hoja de Carga # {{ $sig_id }}</h2>
        <br>
        <div class="informacion-1">
            <div class="info">
                <!-- Primer Formulario -->
                <form action="{{ route('insert_hca') }}" method="POST">
                    @csrf
                    <span>Fecha asignada</span><br>
                    <label class="label">
                        <input type="date" name="fecha_asignada" id="fecha_asignada" value="{{ $fecha_actual }}" readonly class="insert_hca" required>
                    </label><br>
                    <label class="label">
                        <span>Empleado que lo Distribuirá:</span><br>
                        <select name="nombre_empleado" id="nombre_empleado">
                            @foreach ($empleadosDistribucion as $empleado)
                                <option value="{{ $empleado->nombre_edn . ' ' . $empleado->apellido_edn }}">{{ $empleado->nombre_edn . ' ' . $empleado->apellido_edn }}</option>
                            @endforeach
                        </select>
                    </label><br>
                    <span>Fecha de Entrega:</span><br>
                    <label class="label">
                        <input type="date" name="fecha_entrega" min="{{ date('Y-m-d') }}" class="insert_hca" id="fecha_entrega" required>
                    </label><br>
                    <br>
                    <div class="hoja-tabla">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID Orden</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($ordenesPorHojaCarga as $orden)
                                <tr>
                                    <td>{{ $orden->orden_id }}</td>
                                    <td><a href="{{ route('eliminar_pedido', ['id' => $orden->orden_id]) }}" class="hoja-tabla-ver eliminar" onclick="return confirm('¿Estás seguro de eliminar esta orden?')">Eliminar</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <input type="submit" value="Grabar" class="hoja-tabla-ver">
                </form>
            </div>
        </div>           
        <br> 
        <div class="informacion-1">
            <div class="info">
                <!-- Segundo Formulario -->
                <form action="{{ route('insertar_varios_pedido') }}" method="POST">                
                    @csrf
                    <label class="label">
                        <span style="color: #ffffff;">Orden ID:</span><br>
                        <select name="orden_id" id="orden_id" onchange="updateHiddenField(this)">
                            @foreach ($ordenes as $orden)
                                <option value="{{ $orden->orden_id }}">{{ $orden->orden_id }}</option>
                            @endforeach
                        </select>
                    </label><br>
                    <input type="submit" value="Insertar" class="hoja-tabla-ver"><br>
                </form>
            </div>            
        </div>
    </div>
</body>
</html>
