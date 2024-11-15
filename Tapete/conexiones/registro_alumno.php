<?php
    include'conexion.php';

    if(isset($_POST['registro_a'])){
        $curp = $_POST['curp'];
        $nombres = $_POST['nombres'];
        $paterno = $_POST['paterno'];
        $materno = $_POST['materno'];
        $grupo = $_POST['grupo'];
        $generacion = $_POST['generacion'];
        $pass = $_POST['pass'];
        $conf_pass = $_POST['conf_pass'];
        $pregunta = $_POST['pregunta'];
        $respuesta = $_POST['respuesta'];

        $pass_encryp = password_hash($pass, PASSWORD_DEFAULT);
        $resp_encryp = password_hash($respuesta, PASSWORD_DEFAULT);

        if($pass != $conf_pass){
            echo '<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>';
            echo 
            '<script>
                swal({
                    title: "Error",
                    text: "Comprueba que las contraseñas sean iguales",
                    icon: "error"
                })

                .then((Okay) => {
                    if (Okay) {
                        window.location.href = "../registro_alumno.html";
                    } 
                });
            </script>';
        }

        else {
            echo $grupo;
            $sql = "INSERT INTO usuarios (CURP, Nombres, Paterno, Materno, id_grupo, generacion, Pass, Pregunta, Respuesta)
            VALUES ('$curp', '$nombres', '$paterno', '$materno', 
            (SELECT id_grupo FROM grupos WHERE nombre = '$grupo'),
            '$generacion','$pass_encryp', '$pregunta', '$resp_encryp')";

            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "Usuario registrado correctamente";
                header("Location: ../registro_alumno.html");
            } 
            
            else {
                echo "Error al registrar el usuario";
            }
        }
        
    }

    else{
        echo "Error de envío de datos";
    }
?>