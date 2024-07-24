<?php
session_start();
include("../backend/conexion.php");

// Verificar si se ha enviado el formulario
if (isset($_POST['actualizar'])) {
    // Obtener datos del formulario
    $nombreArticulo = $_POST['nombreArticulo'];
    $descripcionArticulo = $_POST['descripcionArticulo'];
    $precioProducto = $_POST['precioProducto'];
    $presentacion = $_POST['presentacion'];
    $cantidadProducto = $_POST['cantidadProducto'];
    $idProducto = $_GET['idProducto'];

    // Verificar si se ha subido una nueva imagen
    if ($_FILES['imagen']['size'] > 0) {
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
        $imagenTipo = $_FILES['imagen']['type'];

        // Consulta para actualizar la información y la imagen
        $query = "UPDATE productos SET nombreProducto = ?, descripcionProducto = ?, precio = ?, idPresentacion = ?, cantidadProducto = ?, imagen = ?, tipo = ? WHERE idProducto = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('ssdisssi', $nombreArticulo, $descripcionArticulo, $precioProducto, $presentacion, $cantidadProducto, $imagen, $imagenTipo, $idProducto);
        $result = $stmt->execute();
        $stmt->close();
    } else {
        // Consulta para actualizar la información sin cambiar la imagen
        $query = "UPDATE productos SET nombreProducto = ?, descripcionProducto = ?, precio = ?, idPresentacion = ?, cantidadProducto = ? WHERE idProducto = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('ssdiii', $nombreArticulo, $descripcionArticulo, $precioProducto, $presentacion, $cantidadProducto, $idProducto);
        $result = $stmt->execute();
        $stmt->close();
    }

    // Establecer un mensaje de éxito o error en la sesión
    if ($result) {
        $_SESSION['mensaje'] = "Producto actualizado exitosamente.";
        $_SESSION['tipo_mensaje'] = "success";
    } else {
        $_SESSION['mensaje'] = "Error al actualizar el producto.";
        $_SESSION['tipo_mensaje'] = "danger";
    }

    // Redireccionar a la página de inventario después de la actualización
    header("Location: ./Inventario.php");
    exit();
}

// Obtener información del producto para prellenar el formulario
$idProducto = $_GET['idProducto'];
$query_producto = "SELECT * FROM productos WHERE idProducto = '$idProducto'";
$resultado_producto = mysqli_query($conexion, $query_producto);
$producto = mysqli_fetch_assoc($resultado_producto);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="../img/v2/logo2.png" type="image/png">
    <title>Actualizar Producto</title>
    <style>
        body {
            background-color: #D5EDF2;
            color: #011126;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        .form-container {
            background: #E8F0FE;
            border-radius: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), inset 0 4px 8px rgba(255, 255, 255, 0.4);
            padding: 30px;
            width: 90%;
            max-width: 900px;
        }
        .form-container h1 {
            background: #011126;
            color: #E8F0FE;
            padding: 15px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control-custom {
            background: #F9F9F9;
            border: none;
            border-radius: 12px;
            box-shadow: inset 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 12px;
            transition: box-shadow 0.3s ease;
        }
        .form-control-custom:focus {
            box-shadow: 0 0 0 2px #011126;
            outline: none;
        }
        .image-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }
        .image-upload input {
            display: none;
        }
        .image-upload label {
            background-color: #011126;
            border-radius: 5px;
            padding: 10px 20px;
            color: white;
            cursor: pointer;
            margin-bottom: 10px;
        }
        .image-preview {
            border: 3px solid #011126;
            border-radius: 5px;
            width: 290px;
            height: 290px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }
        .image-preview img {
            max-width: 100%;
            max-height: 100%;
            display: block;
        }
        .image-preview p {
            color: #011126;
            position: absolute;
            text-align: center;
            margin: 0;
            display: none;
        }
        .btn-custom {
            background-color: #011126;
            color: #E8F0FE;
            border-radius: 25px;
            padding: 12px 24px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #0D0D0D;
            color: #E8F0FE;
        }
        .btn-cancel {
            background-color: #E8F0FE;
            color: #011126;
            border: 2px solid #011126;
            border-radius: 25px;
            padding: 12px 24px;
            font-weight: bold;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .btn-cancel:hover {
            background-color: #011126;
            color: #E8F0FE;
        }
        .toast-header {
            background: #011126;
            color: #E8F0FE;
        }
        .toast-body {
            background: #F9F9F9;
            color: #011126;
        }
        .center-buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Actualizar Producto</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-6 image-upload">
                    <label for="imagenInput">Seleccionar imagen</label>
                    <input type="file" name="imagen" id="imagenInput">
                    <div class="image-preview" id="image-preview">
                        <img id="imagenPreview" src="<?php echo 'data:' . $producto['tipo'] . ';base64,' . base64_encode($producto['imagen']); ?>" alt="Previsualización de imagen">
                        <p id="image-preview-text">Solo imágenes con formato .png</p>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="nombreArticulo">Nombre del Artículo</label>
                    <input type="text" name="nombreArticulo" id="nombreArticulo" value="<?php echo $producto['nombreProducto']; ?>" class="form-control form-control-custom">
                    <small id="text-error-nombre" class="form-text text-danger"></small>

                    <label for="descripcionArticulo">Descripción</label>
                    <textarea name="descripcionArticulo" id="descripcionArticulo" class="form-control form-control-custom"><?php echo $producto['descripcionProducto']; ?></textarea>
                    <small id="text-error-descripcion" class="form-text text-danger"></small>

                    <label for="precioProducto">Precio</label>
                    <input type="text" name="precioProducto" id="precioProducto" value="<?php echo $producto['precio']; ?>" class="form-control form-control-custom">
                    <small id="text-error-precio" class="form-text text-danger"></small>

                    <label for="presentacion">Presentación</label>
                    <select name="presentacion" id="presentacion" class="form-control">
                        <?php
                            $query = "SELECT idPresentacion, nombrePresentacion FROM presentacion";
                            $ejecutar = mysqli_query($conexion, $query);
                            while ($fila = mysqli_fetch_array($ejecutar)) {
                                $selected = ($producto['idPresentacion'] == $fila['idPresentacion']) ? 'selected' : '';
                                echo "<option value='".$fila['idPresentacion']."' $selected>".$fila['nombrePresentacion']."</option>";
                            }
                        ?>
                    </select>
                    <small id="text-error-presentacion" class="form-text text-danger"></small>

                    <label for="cantidadProducto">Cantidad</label>
                    <input type="text" name="cantidadProducto" id="cantidadProducto" value="<?php echo $producto['cantidadProducto']; ?>" class="form-control form-control-custom">
                    <small id="text-error-cantidad" class="form-text text-danger"></small>
                </div>
            </div>
            <div class="center-buttons">
                <button type="submit" name="actualizar" class="btn btn-custom">Actualizar</button>
                <a href="./Inventario.php" class="btn btn-cancel ml-2">Cancelar</a>
            </div>
        </form>
    </div>

    <!-- Toast para mostrar mensajes -->
    <?php if (isset($_SESSION['mensaje'])): ?>
    <div class="toast" data-delay="5000" style="position: absolute; top: 20px; right: 20px;">
        <div class="toast-header">
            <strong class="mr-auto">Notificación</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body <?php echo $_SESSION['tipo_mensaje']; ?>">
            <?php echo $_SESSION['mensaje']; ?>
        </div>
    </div>
    <?php
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo_mensaje']);
    endif;
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Mostrar el toast si existe
            if ($('.toast').length) {
                $('.toast').toast('show');
            }
        });
    </script>
</body>
</html>
