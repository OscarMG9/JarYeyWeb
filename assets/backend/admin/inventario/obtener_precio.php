<?php
// Incluir el archivo de conexión a la base de datos
include("../../conexion.php");

// Verificar si se proporcionó un ID de producto en la solicitud POST
if(isset($_POST['idProducto'])) {
    // Obtener el ID de producto desde la solicitud POST
    $idProducto = $_POST['idProducto'];

    // Consultar la base de datos para obtener el precio del producto
    $consulta = "SELECT precio FROM productos WHERE idProducto = $idProducto";
    $resultado = mysqli_query($conexion, $consulta);

    // Verificar si la consulta fue exitosa
    if($resultado) {
        // Obtener el resultado de la consulta
        $fila = mysqli_fetch_assoc($resultado);
        // Devolver el precio del producto como respuesta
        echo $fila['precio'];
    } else {
        // Si la consulta falla, devolver un mensaje de error
        echo "Error al obtener el precio del producto";
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
} else {
    // Si no se proporciona un ID de producto, devolver un mensaje de error
    echo "ID de producto no proporcionado en la solicitud";
}
?>
