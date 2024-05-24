<?php include("../navigationEmpleado/navbar.php")?>
<?php include("../backend/conexion.php")?>

<?php
    session_start();

    if(!isset($_SESSION['usuario'])){
        echo '
            <script>
                alert("Por favor, debes de iniciar sesión");
                window.location = "../../index.php";
            </script>
        ';
        session_destroy();
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/fondoDashboard.css">
    <title>Página principal</title>
</head>
<body>
    <?php
        $mostrar = "SELECT idProducto, nombreProducto, descripcionProducto, cantidadProducto, nombreImagen, imagen, tipo FROM productos;";
        $result = mysqli_query($conexion, $mostrar);
    ?>

    <div class="text-center mt-3">
        <a class="btn btn-primary" href="./Inventario.php">Inventario</a>
        <a href="../ventaEmpleado/carrito_venta.php" class="btn btn-warning"><i class="fa fa-shopping-cart fa-3x"></i></a>
    </div>

    <div class="container my-4">
        <div class="row">
            <?php 
                $count = 0; 
                while ($row = mysqli_fetch_array($result)) { 
                    if ($count % 4 == 0) {
                        echo '</div><div class="row">';
                    }
                    ?>
                    <div class="col-md-3 mb-4">
                        <div class="card text-bg-light mb-3 h-100" style="max-width: 16rem;">
                            <div>
                                <img src="data:<?php echo $row['tipo']; ?>;base64,<?php echo base64_encode($row['imagen']); ?>" class="card-img-top" alt="..." style="height: 290px;">   
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title text-center"><?php echo $row['nombreProducto'] ?></h5>
                                <p class="card-text"><?php echo $row['descripcionProducto']?></p>
                                <a class="btn btn-primary" href="./viewProductsDetails.php?idProducto=<?php echo $row['idProducto'] ?>">Detalles</a>
                            </div>
                        </div>
                    </div>
                    <?php 
                    $count++;
                } 
            ?>
        </div>
    </div>

</body>
</html>