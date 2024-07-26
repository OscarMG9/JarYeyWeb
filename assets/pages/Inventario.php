<?php 
session_start(); // Asegúrate de iniciar la sesión
include("../navigation/navbarCopy.php");
include("../backend/conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Productos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/fondoInventario.css">
    <link rel="stylesheet" href="../css/Menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        /* Estilos personalizados */
        table.dataTable {
            background-color: transparent !important;
            border: none;
            color: #011126;
        }
        table.dataTable thead {
            background-color: transparent !important;
            border: none;
            color: #011126;
        }
        table.dataTable thead th {
            background-color: transparent !important;
            color: #011126 !important;
            border: none;
            color: #011126;
        }
        table.dataTable tbody tr {
            background-color: transparent !important;
            border: none;
            color: #011126;
        }
        table.dataTable tbody tr:nth-child(even) {
            background-color: transparent !important;
            border: none;
            color: #011126;
        }
        table.dataTable tbody tr:hover {
            background-color: transparent !important;
            border: none;
            color: #011126;
        }
        table.dataTable tbody td {
            color: #011126 !important;
            background-color: transparent !important;
            border: none;
            color: #011126;
        }

        /* Estilo personalizado para botones de paginación */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background-color: #011126;
            color: #D5EFF2 !important;
            border: none;
            padding: 5px 10px;
            margin: 2px;
            border-radius: 5px;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #0D0D0D;
            color: #D5EFF2 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #D5EFF2 !important;
            color: #011126;
        }

        /* Estilos para los iconos */
        .icon-colored {
            color: #011126;
        }
        .icon-colored2 {
            color:  #D5EDF2;
        }

        /* Estilo personalizado para el botón Agregar */
        .btn-agregar {
            background-color: #5CC8F2;
            color: #011126;
            border: none; /* Eliminado borde */
        }

        /* Estilo personalizado para el botón Reporte */
        .btn-reporte {
            background-color: #011126;
            color: #D5EDF2; /* Corregido */
        }

        .btn-regresar {
            background-color: #0D0D0D;
            color: #D5EDF2; /* Corregido */
        }

        .btn-reporte:hover .icon-colored2 {
            color: #011126; /* Cambia el color del icono al pasar el apuntador */
        }

        /* Nuevo estilo para el botón regresar */
        .btn-regresar:hover .icon-colored2 {
            color: #011126; /* Cambia el color del icono al pasar el apuntador */
        }
    </style>
</head>
<body style="background-color: #D5EDF2;">
<div class="barra-lateral">
        <div class="mb-2">
            <div class="nombre-pagina">
                <img src="../img/v2/logo2.png" class="logo">
                <span>JARYEY</span>
            </div>
        </div>
        <nav class="navegacion">
            <ul>
                <li>
                    <a  href="./Dashboard.php">
                        <ion-icon name="home-outline"></ion-icon>
                        <span>Inicio</span>
                    </a>
                </li>
                <li>
                    <a  href="./Inventario.php">
                        <ion-icon name="file-tray-stacked-outline"></ion-icon>
                        <span>Inventario</span>
                    </a>
                </li>
                <li>
                    <a href="../venta/carrito_venta.php">
                        <ion-icon name="cart-outline"></ion-icon>
                        <span>Carrito</span>
                    </a>
                </li>
                <li>
                    <a href="../reportes/reporte.php">
                        <ion-icon name="newspaper-outline"></ion-icon>
                        <span>Reporte</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div>
            <div class="usuario">
                <img src="../img/v2/admin.png" alt="">
                <div class="info-usuario">
                    <div class="nombre-email">
                        <span class="nombre">Jhampier</span>
                        <span class="email">jhampier@gmail.com</span>
                    </div>
                    <ion-icon name="ellipsis-vertical-outline"></ion-icon>
                </div>
            </div>
        </div>
    </div>

    <main>
    <h2 class="text-center mt-4" style="color: #011126;">Inventario</h2>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-10">
                        <div class="reporte-container text-center">
                            <table id="tabla-productos" class="table table-bordered display">
                                <thead>
                                    <tr>
                                        <th>Articulo</th>
                                        <th>Detalles</th>
                                        <th>Presentación</th>
                                        <th>Stock</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $query = "SELECT Productos.idProducto, Productos.nombreProducto, Productos.descripcionProducto, Productos.cantidadProducto, presentacion.nombrePresentacion FROM productos INNER JOIN presentacion ON Productos.idPresentacion = presentacion.idPresentacion;";
                                        $result = mysqli_query($conexion, $query);

                                        while ($row = mysqli_fetch_array($result)){ ?>
                                            <tr>
                                                <td><?php echo $row['nombreProducto'] ?></td> 
                                                <td style="color: #011126;"><?php echo $row['descripcionProducto'] ?></td>
                                                <td style="color: #011126;"><?php echo $row['nombrePresentacion']?></td>
                                                <td><?php echo $row['cantidadProducto'] ?></td>
                                                <td>
                                                    <a class="btn" href="./updateProductTable.php?idProducto=<?php echo $row['idProducto'] ?>">
                                                        <i class="bi bi-pencil icon-colored"></i>
                                                    </a>
                                                    <a class="btn" href="../backend/admin/inventario/deleteProduct.php?idProducto=<?php echo $row['idProducto']?>" onclick="return confirm('¿Estás seguro de que deseas borrar este producto?');">
                                                        <i class="bi bi-trash icon-colored"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-2 text-center">
                        <div class="button-container">
                            <a class="btn btn-agregar" href="./FormInsertProducts.php">
                                <i class="bi bi-plus-lg icon-colored"></i> Agregar
                            </a>
                        </div>
                        <div class="botones-reportes mt-3">
                            <a class="btn btn-reporte" href="../reportes/reporte.php"> <!-- Aplicada clase btn-reporte -->
                                <i class="bi bi-file-earmark-text icon-colored2"></i> Reporte
                            </a>
                        </div>
                        <br>
                        <div>
                            <a class="btn btn-regresar" href="./Dashboard.php">
                                <i class="bi bi-arrow-left-circle icon-colored2"></i> Regresar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast para notificaciones -->
    <div aria-live="polite" aria-atomic="true" style="position: relative;">
        <div class="toast position-fixed bottom-0 right-0 m-3" style="z-index: 11;" data-delay="5000">
            <div class="toast-header">
                <strong class="mr-auto">Notificación</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                <?php
                if (isset($_SESSION['mensaje'])) {
                    echo $_SESSION['mensaje'];
                    unset($_SESSION['mensaje']);
                    unset($_SESSION['tipo_mensaje']);
                } else {
                    echo "No hay mensajes.";
                }
                ?>
            </div>
        </div>
    </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="../js/Menu.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tabla-productos').DataTable({
                "pageLength": 10, 
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todo"]], 
                "searching": true, 
                "ordering": true,
                "info": true,
                "paging": true,
                "language": {
                    "lengthMenu": "Mostrar _MENU_ entradas por página",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ entradas totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });

            // Mostrar el toast si existe
            if ($('.toast .toast-body').text().trim() !== "No hay mensajes.") {
                $('.toast').toast('show');
            }
        });
    </script>
</body>
</html>
