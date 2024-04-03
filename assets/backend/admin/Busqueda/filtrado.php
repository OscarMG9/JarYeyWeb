<?php
include("../../conexion.php");

// Verificar si se ha proporcionado un término de búsqueda en la URL
if(isset($_GET['idPresentacion'])) {
    // Obtener el ID de la presentación de la URL
    $idPresentacion = $_GET['idPresentacion'];

    // Consulta para buscar productos que coincidan con la presentación
    $sql = "SELECT * FROM productos WHERE idPresentacion = $idPresentacion";

    // Ejecutar la consulta y verificar errores
    $result = $conexion->query($sql);
    if (!$result) {
        die('Error en la consulta: ' . $conexion->error);
    }

    // Obtener el nombre de la presentación
    $presentacionQuery = "SELECT nombrePresentacion FROM presentacion WHERE idPresentacion = $idPresentacion";
    $presentacionResult = $conexion->query($presentacionQuery);
    if (!$presentacionResult) {
        die('Error al obtener el nombre de la presentación: ' . $conexion->error);
    }
    $presentacionRow = $presentacionResult->fetch_assoc();
    $nombrePresentacion = $presentacionRow['nombrePresentacion'];

    // Cerrar conexión
    $conexion->close();
} else {
    // Si no se proporciona un ID de presentación, redirigir a la página principal o mostrar un mensaje de error
    header("Location: ../../../pages/Dashboard.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Filtrado</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="../../../css/fondoDashboard.css">
        <link rel="shortcut icon" href="../../../img/logo.png">
    </head>
    <body>
        <div class="container my-4">
            <div class="row justify-content-center">
                <div class="text-center">
                    <h1 class="my-2 bg-warning text-dark text-center rounded">Resultados del filtrado: <?php echo $nombrePresentacion; ?></h1>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <?php 
                    $count = 0; 
                    while ($row = mysqli_fetch_array($result)) { 
                        if ($count % 4 == 0) {
                            echo '</div><div class="row justify-content-center">';
                        }
                        ?>
                        <div class="col-md-3 mb-4 text-center">
                            <div class="card text-bg-light mb-3 h-100" style="max-width: 16rem;">
                                <div>
                                    <?php 
                                    $imagen = "data:" . $row['tipo'] . ";base64," . base64_encode($row['imagen']);
                                    ?>
                                    <img src="<?php echo $imagen; ?>" class="card-img-top" alt="..." style="height: 290px;">   
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title text-center"><?php echo $row['nombreProducto'] ?></h5>
                                    <p class="card-text"><?php echo $row['descripcionProducto']?></p>
                                    <a class="btn btn-primary" href="../../../pages/viewProductsDetails.php?idProducto=<?php echo $row['idProducto'] ?>">Detalles</a>
                                </div>
                            </div>
                        </div>
                        <?php 
                        $count++;
                    } 
                    ?>
                </div>
            </div>
            <div class="text-center">
                <a href="../../../pages/Dashboard.php" class="btn btn-primary mb-3">Página principal</a>
            </div>
        </div>
    </body>
</html>
