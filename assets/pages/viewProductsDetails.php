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
        <link rel="stylesheet" href="../css/fondoInventario.css">
        <link rel="icon" href="./assets/img/logo2.png" type="image/png">
        <title>Detalles</title>
    </head>
    <body>
        <div class="container">
            <div class="row my-5">
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="card rounded-3 fondo" style="width: 60rem;">
                            <div class="row p-2">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <h1 class="p-3 bg-warning text-dark text-center rounded-top">Actualizar Producto: <?php echo $producto['nombreProducto']?></h1>
                                        </div>
                                    </div>
                                    <div class="row p-3 m-3 bg-primary">
                                        <div class="col-4 rounded-start">
                                            <div class="text-center"> <!-- Centra el contenido dentro de la columna -->
                                                <img src="data:<?php echo $producto['tipo']; ?>;base64,<?php echo base64_encode($producto['imagen']); ?>" class="card-img-top rounded mx-auto d-block" alt="<?php echo $producto['nombreProducto']?>" style="height: 290px;">
                                            </div>
                                        </div>
                                        <div class="col-8 rounded-end">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <div class="col-3">
                                                                <label for="">Articulo:</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input type="text" name="" id="" class="form-control fw-bold" value="<?php echo $producto['nombreProducto']?>" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-3">
                                                                <label for="">Descripción:</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input type="text" name="" id="" class="form-control fw-bold" value="<?php echo $producto['descripcionProducto']?>" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-3">
                                                                <label for="">Presentación:</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input type="text" name="" id="" class="form-control fw-bold" value="<?php echo $producto['nombrePresentacion']?>" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-3">
                                                                <label for="">Precio:</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input type="text" name="" id="" class="form-control fw-bold" value="<?php echo "$"?><?php echo $producto['precio']?><?php echo " MXN"?>" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-3">
                                                                <label for="">Cantidad:</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input type="text" name="" id="" class="form-control fw-bold" value="<?php echo $producto['cantidadProducto']?>" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center mb-3">
                                    <div class="col-12">
                                        <a class="btn btn-danger" href="./Dashboard.php">Regresar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
