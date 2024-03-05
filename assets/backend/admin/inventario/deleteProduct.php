<?php include("../../conexion.php") ?>

<?php
    $id= ($_GET["idProducto"]);
    $query = "DELETE FROM productos WHERE idProducto = $id";

    $result = mysqli_query($conexion, $query);

    if(!$result){
        die("FALLO CONSULTA");
    }

    header("location: ../../../pages/Dashboard.php");
?>