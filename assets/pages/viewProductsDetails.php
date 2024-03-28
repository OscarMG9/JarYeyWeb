<?php include("../backend/conexion.php")?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/fondoDashboard.css">
    <title>Document</title>
</head>
<body>
    <h1 class="p-3 mb-2 bg-warning text-dark text-center">Producto</h1>
    <div class="container mt-4 bg-secondary bg-gradient rounded p-5">
        <br>
        <div class="row">
            <div class="col-12">
            <?php
                $sql = "SELECT
                `idProducto`,
                `nombreProducto`,
                `precio`,
                `cantidadProducto`,
                `descripcionProducto`,
                `imagen`,
                `idPresentacion`
                FROM `productos`
                WHERE `idProducto`='" . $_GET['idProducto'] . "'
                ;
                ";
    
                $resultSet = mysqli_query($conexion, $sql);
                $row = mysqli_fetch_array($resultSet, MYSQLI_ASSOC);
            ?>
                <form action="../backend/admin/inventario/updateProduct.php" method="GET" enctype="multipart/form-data" class="form-group">
                    <div class="form-row">
                        <div class="col-4">
                            <label for="" class="text-dark">Articulo</label>
                            <input type="text" name="nombreArticulo" id="nombreArticulo" placeholder="Nombre del articulo" class="form-control" value="<?php echo $row['nombreProducto']?>" disabled>
                            <small id="text-error-nombre" class="form-text text-danger"></small>
                        </div>
                        <div class="col-6">
                        <label for="" class="text-dark">Descripcion</label>
                            <input type="text" name="descripcionArticulo" id="descripcionArticulo" placeholder="Nombre del articulo" class="form-control" value="<?php echo $row['descripcionProducto']?>" disabled></input>
                            <small id="text-error-nombre" class="form-text text-danger"></small>
                        </div>
                        <div class="col-2">
                            <label for="" class="text-dark">Cantidad</label>
                            <input type="number" min="0" max="100" name="cantidadArticulos" id="cantidadArticulos" placeholder="0" class="form-control" value="<?php echo $row['cantidadProducto']?>" disabled>
                            <small id="text-error-nombre" class="form-text text-danger"></small>
                        </div>
                    </div>

                    <?php
                        $sqlPresentacion = ("SELECT * FROM presentacion");
                        $dataPresentacion = mysqli_query($conexion, $sqlPresentacion);
                    ?>

                    <div class="form-row">
                        <div class="col-4">
                            <label class="text-dark">Presentación</label>
                                <select name="presentacion" id="presentacion" class="form-control">
                                <?php foreach ($dataPresentacion as $opciones): ?>
                                    <option value="<?php echo $opciones['idPresentacion']?>"><?php echo $opciones['nombrePresentacion']?></option>
                                    <?php endforeach  ?>
                                </select>  
                                <small id="text-error-art" class="form-text text-danger"></small>  
                        </div>
                        <div class="col-4">
                            <label for="" class="text-dark">Imagen</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="imagen" accept="image/*"  required="">
                                <label class="custom-file-label" for="validatedCustomFile">Selecciona archivo</label>
                            </div>
                            <!-- <input type="file" name="imagen" accept="image/*" required> -->
                        </div>
                        
                        <div class="col-4">
                            <label for="" class="text-dark">Precio</label>
                            <input type="text" name="precioProducto" id="precioProducto" placeholder="00.00" class="form-control" value="<?php echo $row['precio']?>" disabled>
                            <small id="text-error-nombre" class="form-text text-danger"></small>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success mb-2" name="guardar" onclick="validarLogin()">Actualizar</button>
                            <a type="reset" class="btn btn-info mb-2 text-light" href="../pages/Dashboard.php">Regresar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>