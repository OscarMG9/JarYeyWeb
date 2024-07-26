<?php include("../backend/conexion.php")?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="shortcut icon" href="../img/logo.png">
    <style>
        .navbarcito {
            background-color: #0D0D0D;
            color: #D5EDF2 !important; /* Color deseado */
        }
        .navbarcito .btn {
            background-color: #0D0D0D;
            color: #D5EDF2;
            border-color: #D5EDF2;
        }
        .navbarcito .btn:hover {
            background-color: #D5EDF2;
            color: #0D0D0D;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbarcito">
        <div class="container-fluid">
        <a>NEW BYTE</a>
            <a href="../backend/admin/CerrarSesion.php" class="btn">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </a>
        </div>
    </nav>
</body>
</html>
