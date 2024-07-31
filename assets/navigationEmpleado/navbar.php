<?php include("../backend/conexion.php")?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="shortcut icon" href="../img/V2/logo2.png">
    <script>
        $(document).ready(function() {
            $('#searchButton').click(function(event) {
                event.preventDefault(); // Evitar el envío del formulario predeterminado
                var searchTerm = $('#searchInput').val();
                var selectedPresentation = $('#idPresentacion').val(); // Obtener la presentación seleccionada
                window.location.href = '../backend/admin/BusquedaEmpleado/resultados_busqueda.php?search=' + searchTerm + '&presentation=' + selectedPresentation;
            });
        });

        $(document).ready(function() {
            $('#filterButton').click(function(event) {
                event.preventDefault(); // Evitar el envío del formulario predeterminado
                var selectedPresentation = $('#idPresentacion').val(); // Obtener la presentación seleccionada
                window.location.href = '../backend/admin/BusquedaEmpleado/filtrado.php?idPresentacion=' + selectedPresentation;
            });
        });

        function verificarSeleccion() {
            var selectPresentacion = document.getElementById('idPresentacion');
            var boton = document.getElementById('filterButton');

            if (selectPresentacion.value === '') {
                boton.disabled = true;
            } else {
                boton.disabled = false;
            }
        }
    </script>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }
        body {
            padding-top: 60px; /* Ajustar según la altura real del navbar */
        }
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
        .container {
            padding: 0; /* Eliminar padding adicional */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbarcito fixed-top">
        <div class="container-fluid">
            <!-- <a class="navbar-brand" href="../pages/Dashboard.php"><img src="../img/v2/logo2.png" alt="" width="50px"></a> -->
             <a>NEW BYTE</a>
            <form id="searchForm" class="d-flex" role="search">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group mb-2">
                            <button class="btn btn-primary btn-sm" id="searchButton">
                                <i class="fas fa-search"></i>
                            </button>
                            <input id="searchInput" class="form-control me-3" type="search" name="search" placeholder="Nombre del producto" aria-label="Search">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group mb-2">
                            <select name="idPresentacion" id="idPresentacion" class="form-control" onchange="verificarSeleccion();">
                                <option value="">Elige una opción</option>
                                <?php
                                    $query = "SELECT idPresentacion, nombrePresentacion FROM presentacion";
                                    $result = mysqli_query($conexion, $query);
                                    if(mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='".$row['idPresentacion']."'>".$row['nombrePresentacion']."</option>";
                                        }
                                    }
                                ?>
                            </select>
                            <button class="btn btn-primary btn-sm" id="filterButton" disabled>
                                <i class="fas fa-filter"></i> Filtrar
                            </button>  
                        </div>
                    </div>
                </div>
            </form>
            <a href="../backend/admin/CerrarSesion.php" class="btn">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </a>
        </div>
    </nav>
</body>
</html>
