<?php include("../navigation/navbar.php")?>
<!DOCTYPE html>
<html lang="en">
    <html lang="en">
        <head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <link rel="stylesheet" href="../css/font.css">
            <style>
                /* #tabla-productos {
                    border-collapse: collapse;
                    width: 50%;
                    margin: 0 auto;
                } */
        
                .button-container {
                    text-align: center;
                    margin-bottom: 20px;
                }

                th, td {
                    width: 100px;
                    word-wrap: break-word;
                }
            </style>
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
                                    <tbody>
                                        <tr>
                                            <th>Articulo</th>
                                            <th>Detalles</th>
                                            <th>Stock</th>
                                            <th>Acciones</th>
                                        </tr>
                                        <tr>
                                            <td>Axión</td>
                                            <td>Botella de 2 litros</td>
                                            <td>10</td>
                                            <td>
                                                <a href="./FormUpdate.html" class="btn btn-primary">Actualizar</a>
                                                <input type="reset" value="Borrar" class="btn btn-danger">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Cloro</td>
                                            <td>Botella de 2 litros</td>
                                            <td>3</td>
                                            <td>
                                                <a href="./FormUpdate.php
                                                " class="btn btn-primary">Actualizar</a>
                                                <input type="reset" value="Borrar" class="btn btn-danger">
                                            </td>
                                        </tr>
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
                                <a class="btn btn-warning" href="./FormInsertProducts.html">Reporte</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    <script>
        function mostrarOpciones() {
            var opciones = document.getElementById('opciones');
            if (opciones.style.display === "none") {
                opciones.style.display = "block";
            } else {
                opciones.style.display = "none";
            }
        }
    
        function agregarProducto() {
            var nombre = document.getElementById('producto').value;
            var detalles = document.getElementById('detalles').value;
            var table = document.getElementById('tabla-productos');
            var row = table.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            cell1.innerHTML = '<input type="text" value="' + nombre + '">';
            cell2.innerHTML = '<input type="text" value="' + detalles + '">';
        }
    
        function generarReporte() {
            // Lógica para generar el reporte
            alert("Reporte generado");
        }
    </script>
    
    
    </body></html>