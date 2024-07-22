<?php
include("../conexion.php");

$nombreArticulo = $_POST['nombreArticulo'];
$descripcion = $_POST['descripcionArticulo'];
$cantidad = $_POST['cantidadArticulos'];
$presentacion = $_POST['presentacion'];
$precio = $_POST['precioProducto'];

$response = array();

if (isset($_FILES['imagen']['name']) && !empty($_FILES['imagen']['name'])) {
    $tipoArchivo = $_FILES['imagen']['type'];
    $nombreArchivo = $_FILES['imagen']['name'];
    $tamanoArchivo = $_FILES['imagen']['size'];
    $imagenSubida = fopen($_FILES['imagen']['tmp_name'], 'r');
    $binariosImagen = fread($imagenSubida, $tamanoArchivo);
    $binariosImagen = mysqli_escape_string($conexion, $binariosImagen);

    $query = "INSERT INTO productos(nombreProducto, precio, cantidadProducto, descripcionProducto, nombreImagen, imagen, tipo, idPresentacion) VALUES
                                    ('$nombreArticulo','$precio','$cantidad','$descripcion','$nombreArchivo','$binariosImagen','$tipoArchivo','$presentacion')";

    if (mysqli_query($conexion, $query)) {
        $response['status'] = 'success';
        $response['message'] = 'Producto insertado correctamente.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error al insertar el producto.';
    }
} else {
    $response['status'] = 'warning';
    $response['message'] = 'No se ha seleccionado una imagen.';
}

echo json_encode($response);
?>
