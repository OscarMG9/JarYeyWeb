<?php include("../backend/conexion.php")?>

<html lang="en"><!-- Agrega el enlace al archivo de estilo de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
                    
                    <button type="submit" class="btn btn-primary" name="entrar">Entrar</button>
                    <a type="button" class="btn btn-danger btn-cancelar" href="./userAccount.php">Cancelar</a>
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