<?php
    include'conexion.php';
    
    $curp = $conn->real_escape_string($_POST['curp']);
    $nombres = $conn->real_escape_string($_POST['nombres']);
    $paterno = $conn->real_escape_string($_POST['paterno']);
    $materno = $conn->real_escape_string($_POST['materno']);
    $pass = $_POST['pass'];
    $pregunta = $conn->real_escape_string($_POST['pregunta']);
    $respuesta = $conn->real_escape_string($_POST['respuesta']);

    $pass_encrypted = password_hash($pass, PASSWORD_DEFAULT);
    var_dump($pass_encrypted);

    $sql = "INSERT INTO usuarios (CURP, Nombres, Materno, Paterno, Password, Pregunta, Respuesta)
            VALUES ('$curp', '$nombres', '$paterno', '$materno', '$pass_encrypted', '$pregunta', '$respuesta')";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "Usuario registrado correctamente";
        header("Location: ../Tapete/registro_alumno.html");
    } 
    
    else {
        echo "Error al registrar el usuario";
    }
?>