<?php include("../backend/conexion.php")?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="shortcut icon" href="../img/logo.png">
    <script>
        $(document).ready(function() {
            $('#searchButton').click(function(event) {
                event.preventDefault(); // Evitar el envío del formulario predeterminado
                var searchTerm = $('#searchInput').val();
                var selectedPresentation = $('#idPresentacion').val(); // Obtener la presentación seleccionada
                window.location.href = '../backend/admin/Busqueda/resultados_busqueda.php?search=' + searchTerm + '&presentation=' + selectedPresentation;
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Evento click para el botón de filtrado por presentación
            $('#filterButton').click(function(event) {
                event.preventDefault(); // Evitar el envío del formulario predeterminado
                var selectedPresentation = $('#idPresentacion').val(); // Obtener la presentación seleccionada
                // Redirigir a la página de resultados de búsqueda con la presentación como parámetro
                window.location.href = '../backend/admin/Busqueda/filtrado.php?idPresentacion=' + selectedPresentation;
            });
        });
    </script>

</head>
<body>
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../pages/Dashboard.php"><img src="../img/logo.png" alt="" width="50px"></a>
            <form id="searchForm" class="d-flex" role="search">
            <div class="row">
                <div class="col-sm-6">
                    <div class="input-group mb-2">
                        <button class="btn btn-primary btn-sm" id="searchButton">Buscar</button>
                        <input id="searchInput" class="form-control me-3" type="search" name="search" placeholder="Nombre del producto" aria-label="Search">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="input-group mb-2">
                        <select name="idPresentacion" id="idPresentacion" class="form-control">
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
                        <button class="btn btn-primary btn-sm" id="filterButton">Filtrar</button>  
                    </div>
                </div>
            </div>
            </form>
            <a href="../backend/admin/CerrarSesion.php" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </nav>
</body>
</html>
