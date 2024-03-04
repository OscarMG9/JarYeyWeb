<?php include("../backend/conexion.php")?>

<html lang="en"><!-- Agrega el enlace al archivo de estilo de Bootstrap -->
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="../css/font.css">
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Login de Administrador</title>
    </head>
    <body>
        <div class="container mt-5">
            <!-- Formulario de Login para Administrador -->
            <div class="login-form text-center">
                <h2>Empleado</h2>
                <img src="../img/employe.png" alt="Usuario 1" height="150" width="150">
        
                <form action="assets\backend\admin\logueo.php" method="post">
                    <label for="usuario">Nombre usuario:</label>
                    <input type="text" id="usuario" name="usuario" class="form-control" required="">
                    <small id="text-error-usuario" class="form-text text-danger"></small>

                    <label for="contrasena">Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena" class="form-control" required="">
                    <small id="text-error-usuario" class="form-text text-danger"></small>
                    
                    <a type="submit" class="btn btn-primary btn-entrar" href="./Dashboard.php" onclick="validarFormulario()">Entrar</a>
                    <a type="button" class="btn btn-danger btn-cancelar" href="./userAccount.html">Cancelar</a>
                </form>
            </div>
        </div>
        
        <!-- Agrega los enlaces a los scripts de Bootstrap y jQuery al final del body para un rendimiento óptimo -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="../js/script.js"></script>
    </body>
</html>