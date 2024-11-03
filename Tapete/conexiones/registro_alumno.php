<?php
    include'conexion.php';
    
    if(isset($_POST['registro_a'])){
        $curp = $_POST['curp'];
        $nombres = $_POST['nombres'];
        $paterno = $_POST['paterno'];
        $materno = $_POST['materno'];
        $pass = $_POST['pass'];
        $pregunta = $_POST['pregunta'];
        $respuesta = $_POST['respuesta'];

        $pass_encrypted = password_hash($pass, PASSWORD_DEFAULT);
        var_dump($pass_encrypted);

        $sql = "INSERT INTO usuarios (CURP, Nombres, Materno, Paterno, Pass, Pregunta, Respuesta)
                VALUES ('$curp', '$nombres', '$paterno', '$materno', '$pass_encrypted', '$pregunta', '$respuesta')";

        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "Usuario registrado correctamente";
            header("Location: ../registro_alumno.html");
        } 
        
        else {
            echo "Error al registrar el usuario";
        }
    }

    else{
        echo "Error de envío de datos";
    }
?>