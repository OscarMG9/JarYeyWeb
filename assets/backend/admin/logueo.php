<?php
    session_start();

    include '../conexion.php';

    $user = $_POST['usuario'];
    $passwordLogin = $_POST['contrasena'];
    // $passwordLogin = hash('sha512', $passwordLogin);

    $checkLogin = mysqli_query($conexion, "SELECT * FROM cuentaspersonal WHERE usuario = '$user' AND contrasena = '$passwordLogin'");

    if(mysqli_num_rows($checkLogin) > 0){
        $_SESSION['usuario'] = $user;
        header("location: ../../pages/Dashboard.php");
        exit;
    } else{
        echo '
            <script>
                alert("Usuario no encontrado, verifica tus datos");
                window.location = "../../index.html";
            </script>
        ';
      exit;
    }
?>