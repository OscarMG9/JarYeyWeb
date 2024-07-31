function limpiarVenta(){
    document.getElementById('text-error-producto').innerHTML = '';
    document.getElementById('text-error-vendedor').innerHTML = '';
    document.getElementById('text-error-fecha').innerHTML = "";
    document.getElementById('text-error-cantidad').innerHTML = '';
    document.getElementById('text-error-dinero').innerHTML = '';
}

limpiarVenta();

function validarDatosVenta() {
    let producto = document.getElementById('idProducto').value;
    let vendedor = document.getElementById('idCuenta').value;
    let fecha = document.getElementById('fecha_venta').value;
    let cantidadVender = document.getElementById('cantidad').value;
    let dineroRecibido = document.getElementById('cantidad_recibida').value;

    let error = false;

    if (producto === '' || producto === 'Seleccione un producto') {
        document.getElementById('text-error-producto').innerHTML = 'Seleccione un producto.';
        error = true;
    } else {
        document.getElementById('text-error-producto').innerHTML = '';
    }

    if (vendedor === '' || vendedor === 'Elige un vendedor') {
        document.getElementById('text-error-vendedor').innerHTML = 'Seleccione un vendedor.';
        error = true;
    } else {
        document.getElementById('text-error-vendedor').innerHTML = '';
    }

    if (fecha === '') {
        document.getElementById('text-error-fecha').innerHTML = 'Seleccione una fecha.';
        error = true;
    } else {
        document.getElementById('text-error-fecha').innerHTML = "";
    }

    if (cantidadVender === '') {
        document.getElementById('text-error-cantidad').innerHTML = 'Ingrese la cantidad a vender';
        error = true;
    } else {
        document.getElementById('text-error-cantidad').innerHTML = '';
    }

    if (dineroRecibido === '') {
        document.getElementById('text-error-dinero').innerHTML = 'Ingrese la cantidad de dinero recibido';
        error = true;
    } else {
        document.getElementById('text-error-dinero').innerHTML = '';
    }

    return !error; // Retorna true si no hay errores, false si hay errores
}