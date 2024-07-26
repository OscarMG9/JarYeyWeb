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
        header("Location: ../../../pages/Dashboard.php"); // Cambia 'index.php' con la URL de tu página principal
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
    <link rel="stylesheet" href="../../../css/menu.css">
    <link rel="shortcut icon" href="../../../img/v2/logo2.png">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="../js/Menu.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
