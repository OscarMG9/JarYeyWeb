<?php
    include("../../conexion.php");

    // Verificar si se ha proporcionado un término de búsqueda en la URL
    if(isset($_GET['search'])) {
        // Obtener el término de búsqueda de la URL
        $searchTerm = $_GET['search'];

        // Consulta base para buscar productos que coincidan con el término de búsqueda
        $sql = "SELECT * FROM productos WHERE nombreProducto LIKE '%$searchTerm%' OR descripcionProducto LIKE '%$searchTerm%'";

        // Ejecutar la consulta y verificar errores
        $result = $conexion->query($sql);
        if (!$result) {
            die('Error en la consulta: ' . $conexion->error);
        }

        // Cerrar conexión
        $conexion->close();
    } else {
        // Si no se proporciona un término de búsqueda, redirigir a la página principal o mostrar un mensaje de error
        header("Location: ../../../pagesEmpleado/Dashboard.php"); // Cambia 'index.php' con la URL de tu página principal
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../css/fondoDashboard.css">
    <link rel="shortcut icon" href="../../../img/logo.png">
</head>
<body>
<div class="container my-4">
        <div class="row justify-content-center">
            <div class="text-center">
                <h1 class="my-2 bg-warning text-dark text-center rounded">Resultados de la búsqueda: <?php echo $searchTerm; ?></h1>
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
                                <a class="btn btn-primary" href="../../../pagesEmpleado/viewProductsDetails.php?idProducto=<?php echo $row['idProducto'] ?>">Detalles</a>
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
            <a href="../../../pagesEmpleado/Dashboard.php" class="btn btn-primary mb-3">Página principal</a>
            </div>
</div>


</body>
</html>
