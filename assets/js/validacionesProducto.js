function limpiarFormulario(){
    document.getElementById('text-error-nombre').innerHTML = '';
    document.getElementById('text-error-descripcion').innerHTML = '';
    document.getElementById('text-error-precio').innerHTML = "";
    document.getElementById('text-error-presentacion').innerHTML = '';
    document.getElementById('text-error-cantidad').innerHTML = '';
}

limpiarFormulario();

function validarDatosRegistro() {
    let articulo = document.getElementById('nombreArticulo').value;
    let descripcion = document.getElementById('descripcionArticulo').value;
    let precio = document.getElementById('precioProducto').value;
    let presentacion = document.getElementById('idPresentacion').value;
    let cantidad = document.getElementById('cantidadArticulos').value;

    let error = false;

    if (articulo === '') {
        document.getElementById('text-error-nombre').innerHTML = 'Ingrese el nombre del producto.';
        error = true;
    } else {
        document.getElementById('text-error-nombre').innerHTML = '';
    }

    if (descripcion === '') {
        document.getElementById('text-error-descripcion').innerHTML = 'Agrega una descripción.';
        error = true;
    } else {
        document.getElementById('text-error-descripcion').innerHTML = '';
    }

    if (precio === '') {
        document.getElementById('text-error-precio').innerHTML = 'Agrega un precio al producto.';
        error = true;
    } else {
        document.getElementById('text-error-precio').innerHTML = "";
    }

    if (presentacion === '' || presentacion === 'Elige una opción') {
        document.getElementById('text-error-presentacion').innerHTML = 'Elige la presentación del producto';
        error = true;
    } else {
        document.getElementById('text-error-presentacion').innerHTML = '';
    }

    if (cantidad === '') {
        document.getElementById('text-error-cantidad').innerHTML = 'Ingrese la cantidad de dinero recibido';
        error = true;
    } else {
        document.getElementById('text-error-cantidad').innerHTML = '';
    }

    return !error;
}