<?php include("../navigation/navbar.php")?>
<?php include("../backend/conexion.php")?>

<?php
    session_start();

    if(!isset($_SESSION['usuario'])){
        echo '
            <script>
                alert("Por favor, debes de iniciar sesión");
                window.location = "../../index.php";
            </script>
        ';
        session_destroy();
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/fondoDashboard.css">
    <link rel="stylesheet" href="../css/chat.css">
    <title>Página principal</title>
</head>
<body>
    <?php
        $mostrar = "SELECT idProducto, nombreProducto, descripcionProducto, cantidadProducto, nombreImagen, imagen, tipo FROM productos;";
        $result = mysqli_query($conexion, $mostrar);
    ?>

    <div class="text-center mt-3">
        <a class="btn btn-primary" href="./Inventario.php">Inventario</a>
        <a href="../venta/carrito_venta.php" class="btn btn-warning"><i class="fa fa-shopping-cart fa-3x"></i></a>
    </div>

    <div class="container my-4">
        <div class="row">
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
    <div class="chat-toggle-button" onclick="toggleChat()">Chat</div>
    <div class="chat-container" id="chat-container">
        <div class="chat-box" id="chat-box">
            <div class="message bot-message">Hola, ¿en qué puedo ayudarte hoy?</div>
        </div>
        <div class="container mb-3">
            <input class="mt-3" type="text" id="user-input" placeholder="Escribe tu mensaje...">
            <button class="btn btn-outline-info rounded" onclick="sendMessage()">Enviar</button>
        </div>
    </div>
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
        xhr.open('POST', '', true);
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
</script>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: text/plain');
    $userMessage = $_POST['message'];
    echo getResponse($userMessage);
    exit;
}

function getResponse($message) {
    // Leer el archivo JSON y decodificarlo
    $json = file_get_contents('responses.json');
    $responses = json_decode($json, true);
    
    // Convertir el mensaje a minúsculas
    $message = strtolower($message);
    
    // Buscar la respuesta en el array decodificado
    if (array_key_exists($message, $responses)) {
        return $responses[$message];
    } else {
        return 'No entiendo tu mensaje.';
    }
}
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>