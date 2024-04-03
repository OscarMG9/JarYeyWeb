// Función para actualizar la cantidad disponible al seleccionar un nuevo producto
function actualizarCantidadDisponible() {
    var idProductoSeleccionado = document.getElementById("idProducto").value;

    // Verificar si se seleccionó un producto
    if (idProductoSeleccionado) {
        // Realizar una solicitud AJAX para obtener la cantidad disponible del producto seleccionado
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../backend/admin/inventario/obtener_cantidad_disponible.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Actualizar el valor del campo de cantidad disponible en el formulario
                document.getElementById("cantidad_disponible").value = xhr.responseText;
            }
        };
        xhr.send("idProducto=" + idProductoSeleccionado);
    } else {
        // Si no se seleccionó un producto, limpiar el campo de cantidad disponible
        document.getElementById("cantidad_disponible").value = "";
    }
}
