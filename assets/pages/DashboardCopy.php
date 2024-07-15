<?php
session_start();

// Verificar sesión al inicio
if (!isset($_SESSION['usuario'])) {
    echo '<script>alert("Por favor, debes iniciar sesión"); window.location = "../../index.php";</script>';
    session_destroy();
    die(); // Asegúrate de que no haya salida aquí antes de la redirección
}

// Función para obtener la respuesta del archivo JSON
function getResponse($message) {
    // Lee el contenido del archivo JSON
    $json = file_get_contents('responses.json');
    // Verifica si hubo un error al leer el archivo JSON
    if ($json === false) {
        return 'Error al leer el archivo JSON.';
    }
    // Decodifica el JSON en un array asociativo
    $responses = json_decode($json, true);
    // Verifica si hubo un error al decodificar el JSON
    if ($responses === null) {
        return 'Error al decodificar el archivo JSON.';
    }
    // Convierte el mensaje a minúsculas para la búsqueda
    $message = strtolower($message);
    // Busca la respuesta en el array decodificado
    if (array_key_exists($message, $responses)) {
        return $responses[$message];
    } else {
        return 'Lo siento, no entiendo tu mensaje.';
    }
}

// Verifica si se recibió una solicitud POST para el chat
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    // Obtiene el mensaje del usuario desde la solicitud POST
    $userMessage = $_POST['message'];
    // Llama a la función para obtener la respuesta del archivo JSON
    echo getResponse($userMessage);
    exit; // Termina la ejecución del script después de enviar la respuesta
}

// Incluir archivos necesarios
include("../navigation/navbar.php");
include("../backend/conexion.php");

// Consulta a la base de datos u otras operaciones PHP aquí
$mostrar = "SELECT idProducto, nombreProducto, descripcionProducto, cantidadProducto, nombreImagen, imagen, tipo FROM productos;";
$result = mysqli_query($conexion, $mostrar);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página principal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            margin: 0;
        }
        .container-fluid {
            flex: 1;
            display: flex;
            padding: 0;
        }
        .sticky-sidebar {
            position: sticky;
            top: 20px;
            height: calc(100vh - 40px);
            overflow-y: auto;
            transition: width 0.3s ease, margin-right 0.3s ease;
            padding-right: 0; /* Eliminar padding derecho */
            margin-right: 5px; /* Reducir separación */
        }
        .sticky-sidebar.collapsed {
            width: 60px;
            margin-right: 5px; /* Ajustar el margen cuando está colapsado */
        }
        .sticky-sidebar.expanded {
            width: 180px; /* Ajustar el ancho del menú expandido */
            margin-right: 0px; /* Ajustar el margen cuando está expandido */
        }
        .content-container {
            flex: 1;
            transition: margin-left 0.3s ease;
            padding-left: 0; /* Eliminar padding izquierdo */
        }
        .content-container.expanded {
            margin-left: 185px; /* Ajustar margen para que coincida con el ancho del menú */
        }
        .content-container.collapsed {
            margin-left: 65px; /* Ajustar margen para el menú colapsado */
        }
        .range-slider {
            display: flex;
            align-items: center;
        }
        #price-range {
            width: 100%;
            margin: 0 10px;
        }
        .range-slider span {
            width: 50px;
            text-align: center;
        }
        .is-hidden {
            display: none;
        }
        .list-group-item a {
            display: flex;
            align-items: center;
        }
        .list-group-item i {
            margin-right: 10px;
        }
        .collapsed .expanded-text {
            display: none;
        }
        .expanded .expanded-text {
            display: inline;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="sticky-sidebar expanded" id="sidebar" onmouseover="expandSidebar()" onmouseout="collapseSidebar()">
            <h5 class="text-primary"><i class="fas fa-search"></i> <span class="expanded-text">Explorar por</span></h5>
            <ul class="list-group">
                <li class="list-group-item">
                    <a class="text-decoration-none" href="https://prezxochiitzel.wixsite.com/a-punto-de-venta/category/all-products">
                        <i class="fas fa-globe-americas"></i>
                        <span class="expanded-text">Todos los productos</span>
                    </a>
                </li>
            </ul>
        
            <aside class="mb-3">
                <h5 class="text-primary"><i class="fas fa-filter"></i> <span class="expanded-text">Filtrar por</span></h5>
                <ul class="list-group">
                    <li class="list-group-item">
                        <button class="btn btn-light w-100 mb-2" onclick="toggleContent(document.getElementById('priceFilter'))">
                            <i class="fas fa-dollar-sign"></i>
                            <span class="expanded-text">Precio</span>
                        </button>
                        <div class="content is-hidden" id="priceFilter">
                            <div class="range-slider">
                                <span id="price-min">$7.50</span>
                                <div id="price-range"></div>
                                <span id="price-max">$130.00</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <button class="btn btn-light w-100 mb-2" onclick="toggleContent(document.getElementById('colorFilter'))">
                            <i class="fas fa-palette"></i>
                            <span class="expanded-text">Color</span>
                        </button>
                        <div class="content is-hidden" id="colorFilter">
                            <div class="d-flex flex-wrap">
                                <span class="badge bg-brown mx-1" style="background-color: rgb(120, 63, 4);"></span>
                                <span class="badge bg-grey mx-1" style="background-color: rgb(128, 128, 128);"></span>
                                <span class="badge bg-black mx-1" style="background-color: rgb(0, 0, 0);"></span>
                                <span class="badge bg-white mx-1" style="background-color: rgb(255, 255, 255);"></span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <button class="btn btn-light w-100 mb-2" onclick="toggleContent(document.getElementById('sizeFilter'))">
                            <i class="fas fa-expand-arrows-alt"></i>
                            <span class="expanded-text">Tamaño</span>
                        </button>
                        <div class="content is-hidden" id="sizeFilter">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="large">
                                <label class="form-check-label" for="large">Grande</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="medium">
                                <label class="form-check-label" for="medium">Mediano</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="one-size">
                                <label class="form-check-label" for="one-size">One size</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="small">
                                <label class="form-check-label" for="small">Pequeño</label>
                            </div>
                        </div>
                    </li>
                </ul>
            </aside>
        </div>
        <div class="content-container expanded" id="mainContent">
            <div class="container my-3">
                <div class="row">
                    <!-- Aquí se genera dinámicamente el contenido principal -->
                    <?php 
                    $count = 0; 
                    while ($row = mysqli_fetch_array($result)) { 
                        if ($count % 4 == 0) {
                            echo '</div><div class="row">';
                        }
                    ?>
                    <div class="col-md-3 mb-4">
                        <div class="card text-bg-light mb-3 h-100" style="max-width: 16rem;">
                            <div>
                                <img src="data:<?php echo $row['tipo']; ?>;base64,<?php echo base64_encode($row['imagen']); ?>" class="card-img-top" alt="..." style="height: 290px;">   
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title text-center"><?php echo $row['nombreProducto'] ?></h5>
                                <p class="card-text"><?php echo $row['descripcionProducto']?></p>
                                <a class="btn btn-primary" href="./viewProductsDetails.php?idProducto=<?php echo $row['idProducto'] ?>">Detalles</a>
                            </div>
                        </div>
                    </div>
                    <?php 
                        $count++;
                    } 
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.js"></script>
    <script>
        var sidebar = document.getElementById('sidebar');
        var mainContent = document.getElementById('mainContent');

        function expandSidebar() {
            sidebar.classList.remove('collapsed');
            sidebar.classList.add('expanded');
            mainContent.classList.remove('collapsed');
            mainContent.classList.add('expanded');
        }

        function collapseSidebar() {
            sidebar.classList.remove('expanded');
            sidebar.classList.add('collapsed');
            mainContent.classList.remove('expanded');
            mainContent.classList.add('collapsed');
        }

        function toggleContent(content) {
            content.classList.toggle('is-hidden');
        }

        var slider = document.getElementById('price-range');
        var priceMin = document.getElementById('price-min');
        var priceMax = document.getElementById('price-max');

        noUiSlider.create(slider, {
            start: [7.5, 130],
            connect: true,
            range: {
                'min': 7.5,
                'max': 130
            },
            step: 0.5,
            tooltips: [true, true],
            format: {
                to: function (value) {
                    return '$' + value.toFixed(2);
                },
                from: function (value) {
                    return Number(value.replace('$', ''));
                }
            }
        });

        slider.noUiSlider.on('update', function (values, handle) {
            if (handle === 0) {
                priceMin.innerHTML = values[0];
            } else {
                priceMax.innerHTML = values[1];
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
