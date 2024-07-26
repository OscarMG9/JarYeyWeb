<?php
session_start();

// Verificar sesión al inicio
if (!isset($_SESSION['usuario'])) {
    echo '<script>alert("Por favor, debes iniciar sesión"); window.location = "../../index.php";</script>';
    session_destroy();
    die(); // Asegúrate de que no haya salida aquí antes de la redirección
}
include("../navigation/navbar.php");

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Generar reporte</title>
        <link rel="stylesheet" href="../css/fondoDashboard.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="icon" href="./assets/img/logo2.png" type="image/png">
        <link rel="stylesheet" href="../css/reporte.css">
        <link rel="stylesheet" href="../css/Menu.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.css">
    </head>
    <body>
    <div class="barra-lateral">
        <div class="mb-2">
            <div class="nombre-pagina">
                <img src="../img/v2/logo2.png" class="logo">
                <span>JARYEY</span>
            </div>
        </div>
        <nav class="navegacion">
            <ul>
                <li>
                    <a  href="../pages/Dashboard.php">
                        <ion-icon name="home-outline"></ion-icon>
                        <span>Inicio</span>
                    </a>
                </li>
                <li>
                    <a  href="../pages/Inventario.php">
                        <ion-icon name="file-tray-stacked-outline"></ion-icon>
                        <span>Inventario</span>
                    </a>
                </li>
                <li>
                    <a href="../venta/carrito_venta.php">
                        <ion-icon name="cart-outline"></ion-icon>
                        <span>Carrito</span>
                    </a>
                </li>
                <li>
                    <a href="./reporte.php">
                        <ion-icon name="newspaper-outline"></ion-icon>
                        <span>Reporte</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div>
            <div class="usuario">
                <img src="../img/v2/admin.png" alt="">
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
    <main style="display: flex;">
        <div class="container mt-5 my-2">
            <h1>Generar reporte de ventas</h1>
            <form method="post" action="" class="mt-4">
                <h2 class="my-2 mb-3"><strong>Selecciona un rango de fechas</strong></h2>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="fecha_inicio">Fecha de Inicio:</label>
                                <input type="date" class="form-control" id="fecha_inicio" style="border-bottom: 2px solid #0D0D0D;" name="fecha_inicio">
                            </div>
                            <div class="col-6 form-group">
                                <label for="fecha_fin">Fecha de Fin:</label>
                                <input type="date" class="form-control" id="fecha_fin" style="border-bottom: 2px solid #0D0D0D;" name="fecha_fin">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn botoncito">Buscar</button>
                    <a href="../pages/Inventario.php" class="btn botoncito">Regresar</a>
                </div>
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
    </main>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="../js/Menu.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.js"></script>
    </body>
</html>
