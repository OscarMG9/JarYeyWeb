<?php
    include("../../conexion.php");
// Verificar si se ha enviado el formulario de actualización
    if(isset($_POST['actualizar'])) {

        // Obtener los datos del formulario
        $idProducto = $_POST['idProducto'];
        $nombreArticulo = $_POST['nombreArticulo'];
        $descripcionArticulo = $_POST['descripcionArticulo'];
        $precioProducto = $_POST['precioProducto'];
        $idPresentacion = $_POST['presentacion'];

        // Actualizar el producto en la base de datos
        $query = "UPDATE productos SET nombreProducto = '$nombreArticulo', descripcionProducto = '$descripcionArticulo', precio = '$precioProducto', idPresentacion = '$idPresentacion' WHERE idProducto = $idProducto";
        $resultado = mysqli_query($conexion, $query);

        if($resultado) {
            // Redirigir a la página de Dashboard después de la actualización
            header("location: ../../../pages/FormInsertProducts.php");
            exit; // Finalizar el script después de la redirección
        } else {
            // Manejar el caso en que la actualización falle
            echo "Error al actualizar el producto.";
        }
    }
?>

