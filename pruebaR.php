<!DOCTYPE html>
<html>
    <head>
        <title>Generar reporte</title>
        <link rel="stylesheet" href="../css/fondoDashboard.css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="icon" href="./assets/img/logo2.png" type="image/png">
    </head>
    <body>

    <div class="col-md-3 mb-2">
                <a href="./viewProductsDetails.php?idProducto=<?php echo $row['idProducto'] ?>" class="card-link">
                    <div class="card-custom text-bg-light mb-3 h-100 shadow-lg" style="max-width: 16rem;">
                        <div>
                            <img src="data:<?php echo $row['tipo']; ?>;base64,<?php echo base64_encode($row['imagen']); ?>" class="card-img-top" alt="..." style="height: 290px;">
                        </div>
                        <div class="card-body text-center">
                            <br>
                            <h5 class="card-title text-center"><?php echo $row['nombreProducto'] ?></h5>
                            <p class="card-text"><?php echo $row['descripcionProducto']?></p>
                            <p class="card-text ">$<?php echo $row['precio']?></p>
                            <!-- Puedes quitar el botón si deseas que toda la tarjeta sea clicable -->
                        </div>
                    </div>
                </a>
            </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>
</html>
