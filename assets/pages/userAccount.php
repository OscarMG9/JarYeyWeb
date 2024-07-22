<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/selectAccount2.css">
    <link rel="stylesheet" href="../css/fondo.css">
    <style>
        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-box {
            display: flex;
            width: 60%;
            background-color: #f7f7f7;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        .login-image {
            flex: 1;
            background-image: url(../img/v2/logo21.png);
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .login-form {
            flex: 1;
            padding: 20px;
            background-color: #D5EDF2;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5);
            background-size: 50%, 50%;
            border-radius: 50%;
        }
        .back-button {
            position: absolute;
            bottom: 120px; /* Ajusta la distancia desde la parte inferior según necesites */
            left: 50%;
            transform: translateX(-50%);
            color: #fff; /* Color del texto */
            font-size: 15px; /* Tamaño del icono */
            text-decoration: none; /* Eliminar subrayado de enlace */
        }
        .back-button i {
            margin-right: 10px; /* Espacio entre el icono y el texto */
        }
    </style>
</head>
<body>
    <div class="container-fluid login-container">
        <div class="login-box border border-dark">
            <div class="login-image text-center">
                <a id="backButton" class="back-button btn text-light" href="../../index.php">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    Regresar</a>
            </div>
            <div class="login-form">
                <h2 class="text-center">Iniciar Sesión</h2>
                <div id="roleCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="d-flex flex-column align-items-center">
                                <img src="../img/v2/admin.png" class="d-block w-25 rounded-circle mt-3" alt="Administrador">
                                <h5 class="mt-4">Administrador</h5>
                                <form id="adminForm" action="../backend/admin/logueo.php" method="POST" class="text-center" onsubmit="return validarUsuario('admin');">
                                    <div class="form-group">
                                        <label for="usuario">Nombre usuario:</label>
                                        <input type="text" id="usuario" name="usuario" class="form-control bg-transparent border border-dark" required>
                                        <small id="text-error-usuario" class="form-text text-danger"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="contrasena">Contraseña:</label>
                                        <input type="password" id="pass" name="contrasena" class="form-control bg-transparent border border-dark" required>
                                        <small id="text-error-pass" class="form-text text-danger"></small>
                                    </div>
                                    <button type="submit" class="btn boton" name="entrar">Entrar</button>
                                </form>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-flex flex-column align-items-center">
                                <img src="../img/v2/employe.png" class="d-block w-25 rounded-circle mt-3" alt="Empleado">
                                <h5 class="mt-4">Empleado</h5>
                                <form id="employeeForm" action="../backend/empleado/logueo.php" method="POST" class="text-center" onsubmit="return validarUsuario('emp');">
                                    <div class="form-group">
                                        <label for="usuario">Nombre usuario:</label>
                                        <input type="text" id="usuarioE" name="usuario" class="form-control bg-transparent border border-dark" required>
                                        <small id="text-error-usuarioE" class="form-text text-danger"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="contrasena">Contraseña:</label>
                                        <input type="password" id="contrasena" name="contrasena" class="form-control bg-transparent border border-dark" required>
                                        <small id="text-error-contrasena" class="form-text text-danger"></small>
                                    </div>
                                    <button type="submit" class="btn boton" name="entrar">Entrar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#roleCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#roleCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
