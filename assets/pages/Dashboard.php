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
$mostrar = "SELECT idProducto, nombreProducto, descripcionProducto, precio,cantidadProducto, nombreImagen, imagen, tipo FROM productos;";
$result = mysqli_query($conexion, $mostrar);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/fondoDashboard.css">
    <link rel="stylesheet" href="../css/chat.css">
    <link rel="icon" href="./assets/img/logo2.png" type="image/png">
    <link rel="stylesheet" href="../css/Menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.css">
    <title>Página principal</title>
</head>
<body>

    <div class="barra-lateral">
        <div class="mb-2">
            <div class="nombre-pagina">
                <img src="../img/v2/logo2.png" class="logo">
                <span>JARYEY</span>
            </div>
        </div>
        <nav class="navegacion">
            <ul>
                <li class="menu-item">
                    <a href="#" onclick="toggleContent(document.getElementById('priceFilter'))">
                        <ion-icon name="cash-outline"></ion-icon>
                        <span>Precio</span>
                        <ion-icon class="chevron-icon" name="chevron-down-outline"></ion-icon>
                    </a>
                    <div class="content is-hidden" id="priceFilter">
                        <div class="range-slider">
                            <span id="price-min">$7.50</span>
                                <div id="price-range"></div>
                            <span id="price-max">$130.00</span>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="#">
                        <ion-icon name="options-outline"></ion-icon>
                        <span>Presentación</span>
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
    <div class="container my-2">
        <div class="row">
            <?php 
            $count = 0; 
            while ($row = mysqli_fetch_array($result)) { 
                if ($count % 4 == 0) {
                    echo '</div><div class="row">';
                }
            ?>
            <div class="col-md-3 mb-2">
                <a href="./viewProductsDetails.php?idProducto=<?php echo $row['idProducto'] ?>" class="card-link">
                    <div class="card-custom text-bg-light mb-3 h-100 shadow-lg" style="max-width: 16rem;">
                        <div>
                            <img src="data:<?php echo $row['tipo']; ?>;base64,<?php echo base64_encode($row['imagen']); ?>" class="card-img-top" alt="..." style="height: 290px;">
                        </div>
                        <div class="card-body text-center">
                            <br>
                            <h5 class="card-title text-center"><?php echo $row['nombreProducto'] ?></h5>
                            <p class="card-text"><?php echo $row['descripcionProducto']?></p>
                            <p class="card-text ">$<?php echo $row['precio']?></p>
                            <!-- Puedes quitar el botón si deseas que toda la tarjeta sea clicable -->
                        </div>
                    </div>
                </a>
            </div>

            <?php 
                $count++;
            } 
            ?>
        </div>
    </div>
    <div class="chat-container" id="chat-container">
        <div class="chat-box" id="chat-box">
            <div class="message bot-message">Hola, ¿en qué puedo ayudarte hoy?</div>
        </div>
        <div class="container mb-3">
            <input class="mt-3" type="text" id="user-input" placeholder="Escribe tu mensaje...">
            <button class="btn btn-outline-info rounded" onclick="sendMessage()">Enviar</button>
        </div>
    </div>
</main>


    <button class="icono boton-flotante" onclick="toggleChat()">
        <img src="../img/v2/yeyito.png" class="yeyito" alt="">
    </button>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.js"></script>
    <script>
        function sendMessage() {
            var userInput = document.getElementById('user-input').value;
            if (userInput === '') return;
            var chatBox = document.getElementById('chat-box');
            // Mostrar el mensaje del usuario
            var userMessage = document.createElement('div');
            userMessage.className = 'message user-message';
            userMessage.textContent = userInput;
            chatBox.appendChild(userMessage);
            // Limpiar el input
            document.getElementById('user-input').value = '';
            // Hacer una solicitud al servidor
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true); // La solicitud se envía al mismo archivo PHP
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var botMessage = document.createElement('div');
                    botMessage.className = 'message bot-message';
                    botMessage.textContent = xhr.responseText;
                    chatBox.appendChild(botMessage);
                    // Desplazarse hacia abajo
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            };
            xhr.send('message=' + encodeURIComponent(userInput));
        }

        function toggleChat() {
            var chatContainer = document.getElementById('chat-container');
            if (chatContainer.style.display === "none" || chatContainer.style.display === "") {
                chatContainer.style.display = "block";
            } else {
                chatContainer.style.display = "none";
            }
        }
        document.querySelectorAll('.menu-item > a').forEach(menuLink => {
        menuLink.addEventListener('click', function(event) {
            event.preventDefault();
            const parentLi = this.parentElement;
            if (parentLi.classList.contains('active')) {
                parentLi.classList.remove('active');
            } else {
                document.querySelectorAll('.menu-item').forEach(li => li.classList.remove('active'));
                parentLi.classList.add('active');
            }
        });
    });
    document.querySelectorAll('.menu-item').forEach(item => {
    item.addEventListener('click', function(event) {
        event.preventDefault(); // Evita el comportamiento predeterminado del enlace

        // Alternar la clase activa
        this.classList.toggle('active');

        // Cambia el ícono del chevron
        const chevronIcon = this.querySelector('.chevron-icon');
        if (this.classList.contains('active')) {
            chevronIcon.setAttribute('name', 'chevron-up-outline');
        } else {
            chevronIcon.setAttribute('name', 'chevron-down-outline');
        }
    });
});

document.querySelectorAll('.menu-item').forEach(item => {
    item.addEventListener('click', function(event) {
        event.preventDefault(); // Evita el comportamiento predeterminado del enlace

        // Alternar la clase activa
        this.classList.toggle('active');

        // Cambia el ícono del chevron
        const chevronIcon = this.querySelector('.chevron-icon');
        if (this.classList.contains('active')) {
            chevronIcon.setAttribute('name', 'chevron-up-outline');
        } else {
            chevronIcon.setAttribute('name', 'chevron-down-outline');
        }
    });
});
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

        function toggleContent(content) {
            content.classList.toggle('is-hidden');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="../js/Menu.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</body>
</html>