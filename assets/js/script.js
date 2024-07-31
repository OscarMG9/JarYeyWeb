function validarUsuario() {
    var usuario = document.getElementById('usuario').value;

    console.log(usuario)

    if(usuario === ''){
        document.getElementById('text-error-usuario').innerHTML = 'El usuario es requerido.';
        return false;
    }
    else{
        document.getElementById('text-error-usuario').innerHTML = '';
        return true;
    }
}

function validarContrasena() {
    var password = document.getElementById('pass').value;
    console.log(password)

    if(password === ''){
        document.getElementById('text-error-pass').innerHTML = 'La contraseña es requerida.';
        return false;
    }
    else{
        document.getElementById('text-error-pass').innerHTML = '';
        return true;
    }
}

function validarFormulario() {
    // Llama a todas las funciones de validación y verifica si todas son exitosas
    var esValido = validarUsuario() && validarContrasena();

    // Si esValido es true, el formulario se enviará; de lo contrario, se detendrá el envío.
    if (!esValido) {
        // Detener el envío del formulario
        event.preventDefault(); // Esto detendrá el envío del formulario
    }

    return esValido;
}

function validarDatosVenta() {
    let producto = document.getElementById('idProducto').value;
    console.log(producto)
    if(producto === '' || producto === "Seleccione un producto"){
        document.getElementById('text-error-producto').innerHTML = 'Seleccione un producto.';
    }
    else{
        document.getElementById('text-error-producto').innerHTML = '';
    }

    let vendedor = document.getElementById('idCuenta').value;
    console.log(vendedor)
    if(vendedor === '' || vendedor === 'Elige un vendedor'){
        document.getElementById('text-error-vendedor').innerHTML = 'Seleccione un vendedor.';
    }
    else{
        document.getElementById('text-error-vendedor').innerHTML = '';
    }

    let fecha = document.getElementById('fecha_venta').value;
    console.log(fecha);
    if (fecha === '') {
        document.getElementById('text-error-fecha').innerHTML = 'Seleccione una fecha.';
    }
    else{
        document.getElementById('text-error-fecha').innerHTML = "";
    }

    let cantidadVender = document.getElementById('cantidad').value;
    console.log(cantidadVender);
    if (cantidadVender === '') {
        document.getElementById('text-error-cantidad').innerHTML = 'Ingrese la cantidad a vender';
    } else {
        document.getElementById('text-error-cantidad').innerHTML = '';
    }

    let dineroRecibido = document.getElementById('cantidad_recibida').value;
    console.log(dineroRecibido);
    if (dineroRecibido === '') {
        document.getElementById('text-error-dinero').innerHTML = 'Ingrese la cantidad de dinero recibido';
    } else {
        document.getElementById('text-error-dinero').innerHTML = '';
    }
}