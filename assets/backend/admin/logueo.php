<?php
    session_start();

    include '../conexion.php';

    $user = $_POST['usuario'];
    $passwordLogin = $_POST['contrasena'];
    // $passwordLogin = hash('sha512', $passwordLogin);

    $checkLogin = mysqli_query($conexion, "SELECT * FROM cuentaspersonal WHERE usuario = '$user' AND contrasena = '$passwordLogin'");
    $filas = mysqli_fetch_array($checkLogin);
    
    if(mysqli_num_rows($checkLogin) > 0){
        $_SESSION['usuario'] = $user;
        if($filas['idRole'] == 1){
            header("location: ../../pages/Dashboard.php");
            exit;
        } elseif($filas['idRole'] == 2){
            header("location: ../../pagesEmpleado/Dashboard.php");
            exit;
        }
    } else{
        echo '
            <script>
                alert("Usuario no encontrado, verifica tus datos");
                window.location = "../../index.php";
            </script>
        ';
      exit;
    }
?>