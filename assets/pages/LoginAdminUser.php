<?php include("../backend/conexion.php")?>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administrador</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/fondoDashboard.css">
        <link rel="shortcut icon" href="../img/logo.png">
    </head>
    <body>
        <div class="container-lg mt-5">
            
            <div class="login-form text-center">
                <h2>Administrador</h2>
                <img src="../img/Admin-Profile-PNG-Clipart.png" alt="Usuario 1" height="150" width="150">

                <form action="../backend/admin/logueo.php" method="post">
                    <label for="usuario">Nombre usuario:</label>
                    <input type="text" id="usuario" name="usuario" class="form-control" required="">
                    <small id="text-error-usuario" class="form-text text-danger"></small>

                    <label for="contrasena">Contraseña:</label>
                    <input type="password" id="pass" name="contrasena" class="form-control" required="">
                    <small id="text-error-pass" class="form-text text-danger"></small>
                    <br>
                    <button type="submit" class="btn btn-primary" name="entrar">Entrar</button>
                    <a type="button" class="btn btn-danger btn-cancelar" href="./userAccount.php">Cancelar</a>
                </form>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="../js/script.js"></script>
    </body>
</html>