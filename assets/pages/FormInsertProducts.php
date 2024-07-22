<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="icon" href="../img/v2/logo2.png" type="image/png">
    <title>Agregar nuevo producto</title>
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
            background: #011126; /* Color sólido más fuerte */
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
            border: none; /* Sin bordes */
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
            border: 3px solid #011126; /* Contorno más grueso y visible */
            border-radius: 5px;
            width: 290px;
            height: 290px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative; /* Posicionamiento relativo para contener el mensaje */
        }
        .image-preview img {
            max-width: 100%;
            max-height: 100%;
            display: none;
        }
        .image-preview p {
            color: #011126;
            position: absolute; /* Posicionamiento absoluto para centrar el mensaje */
            text-align: center;
            margin: 0;
            display: block; /* Asegura que el mensaje esté visible por defecto */
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
            color: #E8F0FE; /* Mantener el color del texto constante */
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
        <h1>Agregar Nuevo Producto</h1>
        <form id="product-form" action="../backend/admin/insert.php" method="POST" enctype="multipart/form-data" class="form-group">
            <div class="row">
                <div class="col-md-6 my-3">
                    <div class="image-upload">
                        <label for="imagenInput">Seleccionar Imagen</label>
                        <input id="imagenInput" type="file" name="imagen" accept="image/png" onchange="previewImage(event)" required>
                        <div class="image-preview" id="image-preview">
                            <img id="image-preview-img" alt="Vista previa de la imagen">
                            <p id="image-preview-text">Solo imágenes con formato .png</p> <!-- Mensaje con ID -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6 my-3">
                    <label for="nombreArticulo">Artículo</label>
                    <input type="text" name="nombreArticulo" id="nombreArticulo" placeholder="Nombre del artículo" class="form-control form-control-custom" required>
                    <small id="text-error-nombre" class="form-text text-danger"></small>

                    <label for="descripcionArticulo">Descripción</label>
                    <textarea name="descripcionArticulo" id="descripcionArticulo" placeholder="Escriba una descripción máxima de 10 palabras" class="form-control form-control-custom" required></textarea>
                    <small id="text-error-descripcion" class="form-text text-danger"></small>

                    <label for="precioProducto">Precio</label>
                    <input type="text" name="precioProducto" id="precioProducto" placeholder="00.00" class="form-control form-control-custom" required>
                    <small id="text-error-precio" class="form-text text-danger"></small>

                    <label for="presentacion">Presentación</label>
                    <select name="presentacion" id="presentacion" class="form-control form-control-custom" required>
                        <option value="">Elige una opción</option>
                        <?php
                        include("../backend/conexion.php");
                        $query = "SELECT idPresentacion, nombrePresentacion FROM presentacion";
                        $ejecutar = mysqli_query($conexion, $query);
                        while ($opciones = mysqli_fetch_assoc($ejecutar)): ?>
                            <option value="<?php echo $opciones['idPresentacion'] ?>"><?php echo $opciones['nombrePresentacion'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <small id="text-error-presentacion" class="form-text text-danger"></small>

                    <label for="cantidadArticulos">Cantidad</label>
                    <input type="number" min="0" max="100" name="cantidadArticulos" id="cantidadArticulos" placeholder="0" class="form-control form-control-custom" required>
                    <small id="text-error-cantidad" class="form-text text-danger"></small>
                </div>
            </div>
            <div class="center-buttons">
                <button type="submit" class="btn btn-custom mb-2">Guardar</button>
                <a class="btn btn-cancel mb-2" href="../pages/Inventario.php">Cancelar</a>
            </div>
        </form>
    </div>

    <!-- Toasts -->
    <div class="toast" id="toast-success" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; bottom: 20px; right: 20px;">
        <div class="toast-header">
            <strong class="me-auto">Éxito</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toast-success-message"></div>
    </div>

    <div class="toast" id="toast-error" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; bottom: 20px; right: 20px;">
        <div class="toast-header">
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toast-error-message"></div>
    </div>

    <div class="toast" id="toast-warning" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; bottom: 20px; right: 20px;">
        <div class="toast-header">
            <strong class="me-auto">Advertencia</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toast-warning-message"></div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const imagePreview = document.getElementById('image-preview-img');
            const imagePreviewText = document.getElementById('image-preview-text');
            const imagePreviewContainer = document.getElementById('image-preview');

            if (file && file.type === 'image/png') {
                const reader = new FileReader();

                reader.onload = function() {
                    imagePreview.src = reader.result;
                    imagePreview.style.display = 'block';
                    imagePreviewText.style.display = 'none'; // Ocultar el mensaje
                };

                reader.readAsDataURL(file);
                imagePreviewContainer.style.display = 'flex'; // Mostrar vista previa
            } else {
                alert('Por favor, seleccione una imagen en formato PNG.');
                event.target.value = ''; // Limpiar el campo de entrada
                imagePreview.style.display = 'none'; // Ocultar la vista previa
                imagePreviewText.style.display = 'block'; // Mostrar el mensaje
            }
        }

        document.getElementById('product-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita que el formulario se envíe de la manera tradicional

            fetch('../backend/admin/insert.php', {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showToast('success', data.message);
                    document.getElementById('product-form').reset();
                    document.getElementById('image-preview-img').style.display = 'none'; // Ocultar la vista previa de la imagen
                    document.getElementById('image-preview-text').style.display = 'block'; // Mostrar el mensaje
                } else {
                    showToast('error', data.message);
                }
            })
            .catch(error => {
                showToast('error', 'Ha ocurrido un error');
            });
        });

        function showToast(type, message) {
            var toastId = '#toast-' + type;
            var toastMessageId = '#toast-' + type + '-message';
            $(toastMessageId).text(message);
            var toastElement = document.querySelector(toastId);
            var toast = new bootstrap.Toast(toastElement, {
                delay: 5000 // Duración del toast en milisegundos (5 segundos)
            });
            toast.show();
        }
    </script>
</body>
</html>
