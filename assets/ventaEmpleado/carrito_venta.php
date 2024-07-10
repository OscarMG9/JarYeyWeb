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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Ventas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/fondoDashboard.css">
    <link rel="icon" href="./assets/img/logo2.png" type="image/png">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="my-2 bg-warning text-dark text-center rounded">Seleccionar Producto</h2>
                <form action="../backend/admin/ventaEmpleado/venta.php" id="formulario-venta" method="POST">
                    <div class="row">
                        <div class="col-4 form-group">
                            <label for="idProducto">Producto:</label>
                            <select class="form-control" id="idProducto" name="idProducto" placeholder="Seleccione un producto" onchange="actualizarDatosProducto()">
                                <option value="">Seleccione un producto</option>
                                <?php
                                    $consulta_productos = "SELECT idProducto, nombreProducto, precio FROM productos";
                                    $resultado_productos = mysqli_query($conexion, $consulta_productos);

                                    while ($fila_producto = mysqli_fetch_assoc($resultado_productos)) {
                                        $selected = ($fila_producto['idProducto'] == $_POST['idProducto']) ? "selected" : "";
                                        echo "<option value='" . $fila_producto['idProducto'] . "' data-precio='" . $fila_producto['precio'] . "' $selected>" . $fila_producto['nombreProducto'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-4 form-group">
                            <label class="text-dark">Vendedor</label>
                            <select name="idCuenta" id="idCuenta" class="form-control">
                                <option value="idCuenta">Elige una opción</option>
                                <?php
                                    $query = "SELECT idCuenta, Usuario FROM cuentaspersonal";
                                    $ejecutar= mysqli_query($conexion, $query)
                                ?>
                                <?php foreach ($ejecutar as $opciones): ?>
                                <option value="<?php echo $opciones['idCuenta']?>"><?php echo $opciones['Usuario']?></option>
                                <?php endforeach  ?>
                            </select> 
                        </div>
                        <div class="col-4 form-group">
                            <label for="fecha_venta">Fecha de venta:</label>
                            <?php
                                $fecha_actual = date("Y-m-d");
                            ?>
                            <input type="date" class="form-control" id="fecha_venta" name="fecha_venta" min="<?php echo $fecha_actual; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 form-group">
                            <label for="costo_producto">Costo del Producto:</label>
                            <input type="text" class="form-control" id="costo_producto" name="costo_producto" readonly>
                        </div>
                        <div class="col-4 form-group">
                            <label for="cantidad_disponible">Cantidad Disponible:</label>
                            <input type="text" class="form-control" id="cantidad_disponible" name="cantidad_disponible" value="<?php echo $cantidad_disponible; ?>" readonly>
                        </div>
                        <div class="col-4 form-group">
                            <label for="cantidad">Cantidad a vender:</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" oninput="calcularPrecioFinal()" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="precio_total">Precio Total:</label>
                            <input type="text" class="form-control" id="precio_total" name="precio_total" readonly>
                        </div>
                        <div class="col-4">
                            <label for="cantidad_recibida">Cantidad Recibida:</label>
                            <input type="number" class="form-control" id="cantidad_recibida" name="cantidad_recibida" min="0" step="0.01" oninput="calcularCambio()" required>
                        </div>
                        <div class="col-4">
                            <label for="cambio">Cambio:</label>
                            <input type="text" class="form-control" id="cambio" name="cambio" readonly>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success" name="vender">Vender</button>
                        <button type="reset" class="btn btn-dark">Vaciar compra</button>
                        <a href="../pagesEmpleado/Dashboard.php" class="btn btn-danger">Regresar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
</html>