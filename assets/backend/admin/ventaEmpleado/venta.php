<?php
include("../../conexion.php");

if(isset($_POST['vender'])) {
    $idProducto = $_POST['idProducto'];
    $idCuenta = $_POST['idCuenta'];
    $costoProducto = $_POST['costo_producto'];
    $cantidad = $_POST['cantidad'];
    $fecha_venta = $_POST["fecha_venta"];
    $precioTotal = $_POST['precio_total'];
    $CantidadRecibido = $_POST['cantidad_recibida'];
    $Cambio_a_Regresar = $_POST['cambio'];

    // Insertar los datos en la tabla de ventas
    $query = "INSERT INTO ventas (idProducto, precio_producto, cantidad_producto, precio_total, Dinero_recibido, Cambio, fecha_venta, idCuenta) 
              VALUES ('$idProducto', '$costoProducto', '$cantidad', '$precioTotal', '$CantidadRecibido','$Cambio_a_Regresar','$fecha_venta', '$idCuenta')";
    
    if (mysqli_query($conexion, $query)) {
        header("location: ../../../ventaEmpleado/carrito_venta.php");
        echo "Los datos se han guardado correctamente.";
    } else {
        echo "Error al guardar los datos: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
} else {
    echo "Todos los campos del formulario son requeridos.";
}
?>
