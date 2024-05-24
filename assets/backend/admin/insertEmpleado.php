<?php include("../conexion.php")?>

<?php

$nombreArticulo= $_POST['nombreArticulo'];
$descripcion = $_POST['descripcionArticulo'];
$cantidad = $_POST['cantidadArticulos'];
$presentacion = $_POST['presentacion'];
$imagen = $_POST['imagen']['name'];
$precio  = $_POST['precioProducto'];

if (isset($_REQUEST['guardar'])) {
    if (isset($_FILES['imagen']['name'])) {
        $tipoArchivo = $_FILES['imagen']['type'];
        $nombreArchivo = $_FILES['imagen']['name'];
        $tamanoArchivo = $_FILES['imagen']['size'];
        $imagenSubida = fopen($_FILES['imagen']['tmp_name'], 'r');
        $binariosImagen = fread($imagenSubida, $tamanoArchivo);
        $binariosImagen =  mysqli_escape_string($conexion, $binariosImagen);

        $query = "INSERT INTO productos(nombreProducto, precio, cantidadProducto, descripcionProducto, nombreImagen, imagen, tipo, idPresentacion) values
                                        ('$nombreArticulo','$precio','$cantidad','$descripcion','$nombreArchivo','$binariosImagen','$tipoArchivo','$presentacion')";

        $res = mysqli_query($conexion, $query);

        header("location: ../../pagesEmpleado/FormInsertProducts.php");
    }
}


if($res){
    echo "Insertado correctamente";
} else {
    echo "Error";
}

?>







                //     if(isset($_REQUEST['guardar'])){
                //         if(isset($_FILES['foto']['name'])){
                //             $tipoArchivo=$_FILES['foto']['type'];
                //             $nombreArchivo=$_FILES['foto']['name'];
                //             $tamanoArchivo=$_FILES['foto']['size'];
                //             $imagenSubida=fopen($_FILES['foto']['tmp_name'],'r');
                //             $binariosImagen=fread($imagenSubida, $tamanoArchivo);
                //             include_once "db_jaryey.php";
                //             $binariosImagen=mysqli_escape_string($conexion, $binariosImagen);
                //             $query="INSERT INTO pr"
                //             $res=mysqli_query($conexion, $query);
                //         }
                //     }
                // 