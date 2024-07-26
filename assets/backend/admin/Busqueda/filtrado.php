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
        <link rel="stylesheet" href="../../../css/menu.css">
        <link rel="shortcut icon" href="../../../img/v2/logo2.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.css">
    </head>
    <body>
    <div class="barra-lateral">
        <div class="mb-2">
            <div class="nombre-pagina">
                <img src="../../../img/v2/logo2.png" class="logo">
                <span>JARYEY</span>
            </div>
        </div>
        <nav class="navegacion">
            <ul>
                <li>
                    <a  href="../../../pages/Dashboard.php">
                        <ion-icon name="home-outline"></ion-icon>
                        <span>Inicio</span>
                    </a>
                </li>
                <li>
                    <a  href="../../../pages/Inventario.php">
                        <ion-icon name="file-tray-stacked-outline"></ion-icon>
                        <span>Inventario</span>
                    </a>
                </li>
                <li>
                    <a href="../../../venta/carrito_venta.php">
                        <ion-icon name="cart-outline"></ion-icon>
                        <span>Carrito</span>
                    </a>
                </li>
                <li>
                    <a href="../../../reportes/reporte.php">
                        <ion-icon name="newspaper-outline"></ion-icon>
                        <span>Reporte</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div>
            <div class="usuario">
                <img src="../../../img/v2/admin.png" alt="">
                <div class="info-usuario">
                    <div class="nombre-email">
                        <span class="nombre">Jhampier</span>
                        <span class="email">jhampier@gmail.com</span>
                    </div>
                    <ion-icon name="ellipsis-vertical-outline"></ion-icon>
                </div>
            </div>
        </div>
    </div>
        <main>
        <div class="container my-2">
        <div class="row">
            <?php 
            $count = 0; 
            while ($row = mysqli_fetch_array($result)) { 
                if ($count % 4 == 0) {
                    echo '</div><div class="row">';
                }
            ?>
            <div class="col-md-3 mb-2">
                <a href="../../../pages/viewProductsDetails.php?idProducto=<?php echo $row['idProducto'] ?>" class="card-link">
                    <div class="card-custom text-bg-light mb-3 h-100 shadow-lg" style="max-width: 16rem;">
                        <div>
                            <img src="data:<?php echo $row['tipo']; ?>;base64,<?php echo base64_encode($row['imagen']); ?>" class="card-img-top" alt="..." style="height: 290px;">
                        </div>
                        <div class="card-body text-center">
                            <br>
                            <h5 class="card-title text-center"><?php echo $row['nombreProducto'] ?></h5>
                            <p class="card-text"><?php echo $row['descripcionProducto']?></p>
                            <p class="card-text ">$<?php echo $row['precio']?></p>
                        </div>
                    </div>
                </a>
            </div>

            <?php 
                $count++;
            } 
            ?>
        </div>
    </div>
        </main>
    </body>
</html>
<script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="../js/Menu.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</script>
