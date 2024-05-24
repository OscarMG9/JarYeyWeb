<!DOCTYPE html>
<html>
    <head>
        <title>Generar reporte</title>
        <link rel="stylesheet" href="../css/fondoDashboard.css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="../img/logo.png">
    </head>
    <body>

        <div class="container mt-5">
            <h1 class="my-2 bg-warning text-dark text-center rounded">Generar reporte de ventas</h1>
            <form method="post" action="">
                <h2 class="my-2">Selecciona un rango de fechas</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="fecha_inicio">Fecha de Inicio:</label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                            </div>
                            <div class="col-6 form-group">
                                <label for="fecha_fin">Fecha de Fin:</label>
                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="../pagesEmpleado/Inventario.php" class="btn btn-secondary">Regresar</a>
            </form>

            <?php
            include("../backend/conexion.php");

            // Verificar si se han enviado las fechas desde el formulario
            if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
                // Obtener las fechas enviadas desde el formulario
                $fecha_inicio = $_POST['fecha_inicio'];
                $fecha_fin = $_POST['fecha_fin'];

                // Consulta SQL para obtener las ventas dentro del rango de fechas especificado
                $sql = "SELECT productos.nombreProducto, ventas.precio_producto, ventas.cantidad_producto, ventas.Dinero_recibido, ventas.Cambio, ventas.precio_total, cuentaspersonal.Usuario FROM ventas INNER JOIN cuentaspersonal ON ventas.idCuenta = cuentaspersonal.idCuenta 
                INNER JOIN productos ON ventas.idProducto = productos.idProducto
                WHERE fecha_venta BETWEEN '$fecha_inicio' AND '$fecha_fin'";

                // Ejecutar la consulta
                $result = $conexion->query($sql);

                // Verificar si hubo algún error en la consulta SQL
                if (!$result) {
                    echo "<div class='alert alert-danger' role='alert'>Error al ejecutar la consulta: " . $conexion->error . "</div>";
                } else {
                    // Verificar si hay resultados
                    if ($result->num_rows > 0) {
                        // Mostrar los datos de las ventas
                        echo "<h2 class='mt-4'>Ventas para el rango de fechas $fecha_inicio - $fecha_fin:</h2>";
                        echo "<div class='table-responsive'>
                                <table class='table mt-3 rounded'>
                                    <thead class='thead-dark'>
                                        <tr>
                                            <th>Producto Vendido</th>
                                            <th>Precio del Producto</th>
                                            <th>Cantidad vendida</th>
                                            <th>Dinero Recibido</th>
                                            <th>Cambio a dar</th>
                                            <th>Total pagado</th>
                                            <th>Lo vendio:</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["nombreProducto"] . "</td>
                                    <td>" . $row["precio_producto"] . "</td>
                                    <td>" . $row["cantidad_producto"] . "</td>
                                    <td>" . $row["Dinero_recibido"] . "</td>
                                    <td>" . $row["Cambio"] . "</td>
                                    <td>" . $row["precio_total"] . "</td>
                                    <td>" . $row["Usuario"] . "</td>
                                </tr>";
                        }
                        echo "</tbody>
                            </table>
                        </div>";
                        echo "<br>";
                        echo "<div class='text-center'>
                            <button class='btn btn-primary' onclick='window.print()'>Imprimir Resultados</button>
                        </div>";
                    } else {
                        echo "<div class='alert alert-info mt-4' role='alert'>No se encontraron ventas para el rango de fechas especificado.</div>";
                    }
                }

                // Cerrar conexión
                $conexion->close();
            }
            ?>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>
</html>
