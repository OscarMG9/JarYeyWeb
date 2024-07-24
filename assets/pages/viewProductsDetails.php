<?php include("../backend/conexion.php");

    $idProducto = $_GET['idProducto'];
    $query_producto = "SELECT p.idProducto, p.nombreProducto, p.descripcionProducto, p.precio, p.cantidadProducto, p.nombreImagen, p.imagen, p.tipo, pr.nombrePresentacion FROM productos as p INNER JOIN presentacion as pr ON p.idPresentacion = pr.idPresentacion WHERE idProducto = '$idProducto'";
    $resultado_producto = mysqli_query($conexion, $query_producto);
    $producto = mysqli_fetch_assoc($resultado_producto);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/viewProductsDetails.css">
        <link rel="icon" href="./assets/img/v2/logo2.png" type="image/png">
        <title>Detalles</title>
    </head>
    <body>
    <div class="container">
        <h1>Producto: <?php echo $producto['nombreProducto']?></h1>
            <form id="product-form" action="../backend/admin/insert.php" method="POST" enctype="multipart/form-data" class="form-group">
                <div class="row">
                    <div class="col-md-6 my-3">
                        <div class="image-upload">
                            <div class="image-preview" id="image-preview">
                            <img src="data:<?php echo $producto['tipo']; ?>;base64,<?php echo base64_encode($producto['imagen']); ?>" class="card-img-top rounded mx-auto d-block" alt="<?php echo $producto['nombreProducto']?>" style="height: 290px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 my-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nombreArticulo">Artículo</label>
                                <input type="text" name="" id="" class="custom-file-input form-control fw-bold" value="<?php echo $producto['nombreProducto']?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="presentacion">Presentación</label>
                                <input type="text" name="" id="" class="custom-file-input form-control fw-bold" value="<?php echo $producto['nombrePresentacion']?>" disabled>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="precioProducto">Precio</label>
                                <input type="text" name="" id="" class="custom-file-input form-control fw-bold" value="<?php echo "$"?><?php echo $producto['precio']?><?php echo " MXN"?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="cantidadArticulos">Cantidad</label>
                                <input type="text" name="" id="" class="custom-file-input form-control fw-bold" value="<?php echo $producto['cantidadProducto']?>" disabled>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="descripcionArticulo">Descripción</label>
                            <input type="text" name="" id="" class="custom-file-input form-control fw-bold" value="<?php echo $producto['descripcionProducto']?>" disabled>
                        </div>
                    </div>
                </div>
            <div class="text-center mt-4">
                <a class="btn btn-cancel mb-2" href="../pages/Dashboard.php">Regresar</a>
            </div>
        </form>
    </div>

    <!-- Toasts -->
    <div class="toast" id="toast-success" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; bottom: 20px; right: 20px;">
        <div class="toast-header">
            <strong class="me-auto">Éxito</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toast-success-message"></div>
    </div>

    <div class="toast" id="toast-error" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; bottom: 20px; right: 20px;">
        <div class="toast-header">
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toast-error-message"></div>
    </div>

    <div class="toast" id="toast-warning" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; bottom: 20px; right: 20px;">
        <div class="toast-header">
            <strong class="me-auto">Advertencia</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toast-warning-message"></div>
    </div>
    </body>
</html>
