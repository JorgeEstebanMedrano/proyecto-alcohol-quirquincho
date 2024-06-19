let ordenes = []; // Variable global para almacenar las órdenes

// Función para agregar productos a la orden
function agregarProducto() {
    const empleadoSelect = document.getElementById('empleados');
    const proveedorSelect = document.getElementById('proveedores');
    const productoSelect = document.getElementById('productos');
    const cantidad = parseFloat(document.querySelector('input[name="cantidad"]').value);
    const tipoPago = document.querySelector('input[name="tipo_pago"]').value;

    const empleado = window.empleados.find(e => e.id == empleadoSelect.value);
    const proveedor = window.proveedores.find(p => p.id == proveedorSelect.value);
    const producto = window.productos.find(p => p.id == productoSelect.value);

    const precio = parseFloat(productoSelect.options[productoSelect.selectedIndex].getAttribute('data-precio'));
    const totalProducto = precio * cantidad;

    const ordenExistente = ordenes.find(o => o.id_prod === producto.id);

    if (ordenExistente) {
        ordenExistente.cantidad += cantidad;
        ordenExistente.total += totalProducto;
    } else {
        const orden = {
            id: ordenes.length + 1,
            empleado_id: empleado.id,
            empleado: empleado.empleado,
            proveedor_id: proveedor.id,
            proveedor: proveedor.proveedor,
            fecha: new Date().toLocaleDateString(),
            producto: producto.producto_precio,
            id_prod: producto.id,
            cantidad: cantidad,
            tipo_pago: tipoPago,
            total: totalProducto,
            precio: precio
        };

        ordenes.push(orden);
    }

    renderTabla();
    actualizarTotal();
}

// Función para renderizar la tabla de órdenes
function renderTabla() {
    const ordenTabla = document.getElementById('ordenTabla');
    ordenTabla.innerHTML = '';

    ordenes.forEach(orden => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${orden.id}</td>
            <td>${orden.empleado}</td>
            <td>${orden.proveedor}</td>
            <td>${orden.fecha}</td>
            <td>${orden.producto}</td>
            <td>${orden.cantidad}</td>
            <td>${orden.tipo_pago}</td>
            <td>${orden.total.toFixed(2)}</td>
            <td><button onclick="eliminarProducto(${orden.id})">ELIMINAR</button></td>
        `;
        ordenTabla.appendChild(tr);
    });
}

// Función para actualizar el total a pagar
function actualizarTotal() {
    const totalPagar = ordenes.reduce((sum, orden) => sum + orden.total, 0);
    document.getElementById('totalPagar').innerText = totalPagar.toFixed(2);
}

// Función para eliminar un producto de la orden
function eliminarProducto(id) {
    ordenes = ordenes.filter(orden => orden.id !== id);
    renderTabla();
    actualizarTotal();
}

// Función para deshabilitar selecciones
function disableSelect(id) {
    document.getElementById(id).disabled = true;
}

// Event listener para enviar la orden al servidor
document.getElementById('confirmarOrden').addEventListener('click', () => {
    console.log('Datos a enviar:', JSON.stringify(ordenes));
    fetch('/orden', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ ordenes })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Respuesta del servidor:', data);
        if (data.success) {
            alert('Orden realizada con éxito');
            ordenes = [];
            renderTabla();
            actualizarTotal();
            location.reload(); // Recargar la página para limpiar el formulario y la tabla
        } else {
            alert('Hubo un problema al realizar la orden: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al conectar con el servidor');
    });
});

// Event listener para inicializar la página
document.addEventListener('DOMContentLoaded', () => {
    // Lógica de inicialización, si es necesario
});
