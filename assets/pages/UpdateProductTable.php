<?php 
    include("../backend/conexion.php");

    // Obtener datos del producto a actualizar (suponiendo que se pasa el ID del producto a través de la URL)
    if(isset($_GET['idProducto'])) {
        $idProducto = $_GET['idProducto'];
        $query = "SELECT * FROM productos WHERE idProducto = $idProducto";
        $result = mysqli_query($conexion, $query);
        $producto = mysqli_fetch_assoc($result);
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/fondoDashboard.css">
    <title>Actualizar Producto</title>
</head>
<body>
    <h1 class="p-3 mb-2 bg-warning text-dark text-center">Actualizar Producto</h1>
    <div class="container mt-4 bg-secondary bg-gradient rounded p-5">
        <div class="row">
            <div class="col-12">
                <form action="../backend/admin/Inventario/updateProduct.php" method="POST" enctype="multipart/form-data" class="form-group">
                    <input type="hidden" name="idProducto" value="<?php echo $producto['idProducto']; ?>">
                    <div class="row">
                        <div class="col-4">
                            <label for="" class="text-dark">Imagen</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="imagen" id="imagenInput" accept="image/*">
                                <label class="custom-file-label" for="imagenInput">Selecciona archivo</label>
                            </div>
                            <img id="imagenPreview" src="<?php echo 'data:' . $producto['tipo'] . ';base64,' . base64_encode($producto['imagen']); ?>" alt="Previsualización de imagen" style="max-width: 100%; max-height: 200px; margin-top: 10px;">
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col-12">
                                    <label for="" class="text-dark">Articulo</label>
                                    <input type="text" name="nombreArticulo" id="nombreArticulo" value="<?php echo $producto['nombreProducto']; ?>" class="form-control">
                                    <small id="text-error-nombre" class="form-text text-danger"></small>
                                </div>
                                <div class="col-12">
                                    <label for="" class="text-dark">Descripcion</label>
                                    <textarea type="text" name="descripcionArticulo" id="descripcionArticulo" class="form-control"><?php echo $producto['descripcionProducto']; ?></textarea>
                                    <small id="text-error-nombre" class="form-text text-danger"></small>
                                </div>
                                <div class="col-6">
                                    <label for="" class="text-dark">Precio</label>
                                    <input type="text" name="precioProducto" id="precioProducto" value="<?php echo $producto['precio']; ?>" class="form-control">
                                    <small id="text-error-nombre" class="form-text text-danger"></small>
                                </div>
                                <div class="col-6">
                                    <label class="text-dark">Presentación</label>
                                    <select name="presentacion" id="presentacion" class="form-control">
                                        <?php
                                            $query = "SELECT idPresentacion, nombrePresentacion FROM presentacion";
                                            $ejecutar= mysqli_query($conexion, $query);
                                            foreach ($ejecutar as $opciones):
                                                $selected = ($opciones['idPresentacion'] == $producto['idPresentacion']) ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $opciones['idPresentacion'] ?>" <?php echo $selected ?>><?php echo $opciones['nombrePresentacion'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <small id="text-error-art" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success mb-2" name="actualizar">Actualizar</button>
                            <a type="button" class="btn btn-danger mb-2 text-light" href="./Inventario.php">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
