<?php include("../navigation/navbar.php")?>
<?php include("../backend/conexion.php")?>

<!DOCTYPE html>
<html lang="en">
    <html lang="en">
        <head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <link rel="stylesheet" href="../css/tables.css">
            <link rel="stylesheet" href="../css/fondoDashboard.css">
    </head>
    <body>
        <h2 class="text-center">Tabla de Productos</h2>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-10">
                            <div class="reporte-container text-center">
                                <table id="tabla-productos" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Articulo</th>
                                            <th>Detalles</th>
                                            <th>Stock</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $query = "SELECT idProducto, nombreProducto, descripcionProducto, cantidadProducto FROM productos;";
                                        $result = mysqli_query($conexion, $query);

                                        while ($row = mysqli_fetch_array($result)){ ?>
                                            <tr>
                                                <td><?php echo $row['nombreProducto'] ?></td> 
                                                <td><?php echo $row['descripcionProducto'] ?></td> 
                                                <td><?php echo $row['cantidadProducto'] ?></td>
                                                <td>
                                                    <a class="btn btn-primary" href="./updateProductTable.php?idProducto=<?php echo $row['idProducto'] ?>">Actualizar</a>
                                                    <a class="btn btn-danger" href="../backend/admin/inventario/deleteProduct.php?idProducto=<?php echo $row['idProducto']?>" onclick="confirmar();">Borrar</a>
                                                </td>
                                            </tr>

                                        <?php }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div id="opciones" style="display: none;">
                                <label for="producto">Producto:</label>
                                <input type="text" id="producto" name="producto"><br><br>
                                <label for="detalles">Detalles:</label>
                                <input type="text" id="detalles" name="detalles"><br><br>
                                <button onclick="agregarProducto()">Guardar</button>
                            </div>
                        </div>
                        <div class="col-2 text-center">
                            <div class="button-container">
                                <!-- <button onclick="mostrarOpciones()">Agregar</button> -->
                                <a class="btn btn-primary" href="./FormInsertProducts.php">Agregar</a>
                            </div>
                            <div class="botones-reportes">
                                <a class="btn btn-warning" href="./FormInsertProducts.php">Reporte</a>
                            </div>
                            <br>
                            <div>
                                <a class="btn btn-secondary" href="./Dashboard.php">Regresar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>