<?php
    include("../backend/conexion.php");

    // Definir una variable para almacenar la cantidad disponible
    $cantidad_disponible = "";
    if(isset($_POST['cantidad']) && !empty($_POST['cantidad']) && isset($_POST['idProducto']) && !empty($_POST['idProducto'])) {
        $cantidad_a_vender = $_POST['cantidad'];
        $idProductoSeleccionado = $_POST['idProducto'];
    
        // Consultar la cantidad disponible del producto seleccionado
        $consulta_cantidad = "SELECT cantidadProducto FROM productos WHERE idProducto = $idProductoSeleccionado";
        $resultado_cantidad = mysqli_query($conexion, $consulta_cantidad);
    
        if ($resultado_cantidad === false) {
            echo "Error en la consulta: " . mysqli_error($conexion);
        } else {
            // Verificar si se encontró el producto y obtener la cantidad disponible
            if(mysqli_num_rows($resultado_cantidad) > 0) {
                $fila_cantidad = mysqli_fetch_assoc($resultado_cantidad);
                $cantidad_disponible = $fila_cantidad['cantidadProducto'];
    
                // Verificar si hay suficiente cantidad disponible para vender
                if($cantidad_a_vender > $cantidad_disponible) {
                    echo "No hay suficiente cantidad disponible para vender.";
                } else {
                    // Actualizar la cantidad disponible en la base de datos
                    $nueva_cantidad = $cantidad_disponible - $cantidad_a_vender;
                    $consulta_actualizar_cantidad = "UPDATE productos SET cantidadProducto = $nueva_cantidad WHERE idProducto = $idProductoSeleccionado";
                    $resultado_actualizar_cantidad = mysqli_query($conexion, $consulta_actualizar_cantidad);
    
                    // Verificar si la actualización se realizó correctamente
                    if ($resultado_actualizar_cantidad === false) {
                        echo "Error al actualizar la cantidad disponible: " . mysqli_error($conexion);
                    } else {
                        // Obtener la cantidad actualizada después de la venta
                        $consulta_cantidad_actualizada = "SELECT cantidadProducto FROM productos WHERE idProducto = $idProductoSeleccionado";
                        $resultado_cantidad_actualizada = mysqli_query($conexion, $consulta_cantidad_actualizada);
                        if ($resultado_cantidad_actualizada === false) {
                            echo "Error en la consulta: " . mysqli_error($conexion);
                        } else {
                            $fila_cantidad_actualizada = mysqli_fetch_assoc($resultado_cantidad_actualizada);
                            $cantidad_disponible = $fila_cantidad_actualizada['cantidadProducto'];
                            echo $cantidad_disponible; // Esto puede ser un indicador para la actualización en el frontend
                            $_POST['cantidad'] = "";
                        }
                    }
                }
            } else {
                $cantidad_disponible = "No disponible"; // Si no se encuentra el producto, mostrar un mensaje
            }
        }
    }
    include("../navigation/navbarCopy.php");
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Carrito de Ventas</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/carrito.css">
        <link rel="stylesheet" href="../css/Menu.css">
        <link rel="icon" href="./assets/img/v2/logo2.png" type="image/png">
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
                        <a  href="../pages/inventario.php">
                            <ion-icon name="file-tray-stacked-outline"></ion-icon>
                            <span>Inventario</span>
                        </a>
                    </li>
                    <li>
                        <a href="./carrito_venta.php">
                            <ion-icon name="cart-outline"></ion-icon>
                            <span>Vender</span>
                        </a>
                    </li>
                    <li>
                        <a href="../reportes/reporte.php">
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
                            <span class="nombre">Administrador</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <main>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="my-2">Seleccionar Producto</h1>
                    <form action="../backend/admin/venta/venta.php" id="formulario-venta" method="POST" onsubmit="return validarDatosVenta()">
                        <div class="row">
                            <div class="col-4 form-group">
                                <label for="idProducto">Producto:</label>
                                <select class="form-control" id="idProducto" name="idProducto" placeholder="Seleccione un producto" onchange="actualizarDatosProducto()" style="border-bottom: 2px solid #0D0D0D;background-color: #ffffff;">
                                    <option value="Seleccione un producto">Seleccione un producto</option>
                                    <?php
                                        $consulta_productos = "SELECT idProducto, nombreProducto, precio FROM productos";
                                        $resultado_productos = mysqli_query($conexion, $consulta_productos);

                                        while ($fila_producto = mysqli_fetch_assoc($resultado_productos)) {
                                            $selected = ($fila_producto['idProducto'] == $_POST['idProducto']) ? "selected" : "";
                                            echo "<option value='" . $fila_producto['idProducto'] . "' data-precio='" . $fila_producto['precio'] . "' $selected>" . $fila_producto['nombreProducto'] . "</option>";
                                        }
                                    ?>
                                </select>
                                <small id="text-error-producto" class="form-text text-danger"></small>
                            </div>
                            <div class="col-4 form-group">
                                <label class="text-dark">Vendedor</label>
                                <select name="idCuenta" id="idCuenta" class="form-control" style="border-bottom: 2px solid #0D0D0D;background-color: #ffffff;">
                                    <option value="Elige un vendedor">Elige un vendedor</option>
                                    <?php
                                        $query = "SELECT idCuenta, idRole, usuario FROM cuentaspersonal WHERE idRole = 1";
                                        $ejecutar= mysqli_query($conexion, $query)
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?>
                                    <option value="<?php echo $opciones['idCuenta']?>"><?php echo $opciones['usuario']?></option>
                                    <?php endforeach  ?>
                                </select>
                                <small id="text-error-vendedor" class="form-text text-danger"></small>
                            </div>
                            <div class="col-4 form-group">
                                <label for="fecha_venta">Fecha de venta:</label>
                                <?php
                                    $fecha_actual = date("Y-m-d");
                                ?>
                                <input type="date" class="form-control" id="fecha_venta" name="fecha_venta" min="<?php echo $fecha_actual; ?>" style="border-bottom: 2px solid #0D0D0D;background-color: #ffffff;">
                                <small id="text-error-fecha" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 form-group">
                                <label for="costo_producto">Costo del Producto:</label>
                                <input type="text" class="form-control" id="costo_producto" name="costo_producto" style="border-bottom: 2px solid #0D0D0D;background-color: #ffffff;" readonly >
                            </div>
                            <div class="col-4 form-group">
                                <label for="cantidad_disponible">Cantidad Disponible:</label>
                                <input type="text" class="form-control" id="cantidad_disponible" name="cantidad_disponible" value="<?php echo $cantidad_disponible; ?>" style="border-bottom: 2px solid #0D0D0D;background-color: #ffffff;" readonly>
                            </div>
                            <div class="col-4 form-group">
                                <label for="cantidad">Cantidad a vender:</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" oninput="calcularPrecioFinal()" style="border-bottom: 2px solid #0D0D0D;background-color: #ffffff;">
                                <small id="text-error-cantidad" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="precio_total">Precio Total:</label>
                                <input type="text" class="form-control" id="precio_total" name="precio_total" style="border-bottom: 2px solid #0D0D0D;background-color: #ffffff;" readonly>
                            </div>
                            <div class="col-4">
                                <label for="cantidad_recibida">Cantidad Recibida:</label>
                                <input type="number" class="form-control" id="cantidad_recibida" name="cantidad_recibida" min="0" step="0.01" oninput="calcularCambio()"style="border-bottom: 2px solid #0D0D0D;background-color: #ffffff;">
                                <small id="text-error-dinero" class="form-text text-danger"></small>
                            </div>
                            <div class="col-4">
                                <label for="cambio">Cambio:</label>
                                <input type="text" class="form-control" id="cambio" name="cambio"style="border-bottom: 2px solid #0D0D0D;background-color: #ffffff;" readonly>
                            </div>
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="submit" class="botoncito" name="vender">Vender</button>
                            <button type="reset" class="botoncito" onclick=limpiarVenta();>Limpiar</button>
                            <a href="../pages/Dashboard.php" class="btn botoncito">Regresar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </main>
        <script src="../js/validacionesVentas.js"></script>
        <script>
            function actualizarDatosProducto() {
                var idProducto = document.getElementById('idProducto').value;
                var precioProducto = document.getElementById('idProducto').options[document.getElementById('idProducto').selectedIndex].getAttribute('data-precio');
                if (idProducto !== '') {
                    document.getElementById('costo_producto').value = precioProducto;
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '../backend/admin/inventario/obtener_cantidad_disponible.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            document.getElementById('cantidad_disponible').value = xhr.responseText;
                        }
                    };
                    xhr.send('idProducto=' + idProducto);
                } else {
                    document.getElementById('costo_producto').value = '';
                    document.getElementById('cantidad_disponible').value = '';
                }
            }

            function obtenerPrecioProducto(idProducto) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '../backend/admin/inventario/obtener_precio.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        document.getElementById('precio_producto').value = xhr.responseText;
                    }
                };
                xhr.send('idProducto=' + idProducto);
            }

            function calcularPrecioFinal() {
                var cantidad = parseFloat(document.getElementById('cantidad').value);
                var precioProducto = parseFloat(document.getElementById('costo_producto').value);
                var precioTotal = cantidad * precioProducto;
                document.getElementById('precio_total').value = precioTotal.toFixed(2);
            }

            function calcularCambio() {
                var cantidadRecibida = parseFloat(document.getElementById('cantidad_recibida').value);
                var precioTotal = parseFloat(document.getElementById('precio_total').value);
                var cambio = cantidadRecibida - precioTotal;
                document.getElementById('cambio').value = cambio.toFixed(2);
            }

        </script>
        <script>
            // Obtener la fecha actual
            var today = new Date();

            // Ajustar al huso horario de México (UTC-6)
            today.setHours(today.getHours() - 6);

            // Formatear la fecha como yyyy-mm-dd (necesario para el campo de fecha)
            var formattedDate = today.toISOString().slice(0, 10);

            // Establecer la fecha mínima en el campo de fecha de venta
            document.getElementById("fecha_venta").setAttribute("min", formattedDate);
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.js"></script>
    </body>
</html>