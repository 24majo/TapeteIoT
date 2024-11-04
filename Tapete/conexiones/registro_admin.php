<?php
    include'conexion.php';
    
    if(isset($_POST['registro_a'])){
        $nombres = $_POST['nombres'];
        $paterno = $_POST['paterno'];
        $materno = $_POST['materno'];
        $correo = $_POST['correo'];
        $pass = $_POST['pass'];
        $conf_pass = $_POST['conf_pass'];
        $pregunta = $_POST['pregunta'];
        $respuesta = $_POST['respuesta'];
        $rol = $_POST['rol'];

        if (!preg_match("/^[\w\.-]+@[\w\.-]+\.\w{2,}$/", $correo)) {
            echo '<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>';
            echo 
            '<script>
                swal({
                    title: "Error",
                    text: "Formato de correo no válido",
                    icon: "error"
                })

                .then((Okay) => {
                    if (Okay) {
                        window.location.href = "../registro_admin.html";
                    } 
                });
            </script>';
        }

        else{
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
                            window.location.href = "../registro_admin.html";
                        } 
                    });
                </script>';
            }

            else{
                function Numero() {
                    $aleatorio = rand(0, 999);
                    $numero = str_pad($aleatorio, 3, '0', STR_PAD_LEFT);
                    return $numero;
                }

                function generarID($numero, $nombre, $paterno, $materno) {
                    $letraN = substr($nombre, 0, 2);
                    $letraP = substr($paterno, 0, 2);
                    $letraM = substr($materno, 0, 2);
                
                    $num_empleado = $numero . strtoupper($letraN . $letraP . $letraM);
                
                    return $num_empleado;
                }

                $numero = Numero();
                $num_empleado = generarID($numero, $nombres, $paterno, $materno);

                $pass_encryp = password_hash($pass, PASSWORD_DEFAULT);
                $resp_encryp = password_hash($respuesta, PASSWORD_DEFAULT);

                $sql = "INSERT INTO docentes (num_empleado, nombre, materno, paterno, correo, password, pregunta, respuesta, rol)
                VALUES ('$num_empleado', '$nombres', '$paterno', '$materno', '$correo', '$pass_encryp', '$pregunta', '$resp_encryp','$rol')";

                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo "Usuario registrado correctamente";
                    header("Location: ../registro_admin.html");
                } 
                
                else {
                    echo "Error al registrar el usuario";
                }
            }
        }
    }

    else{
        echo 'Error de conexión';
    }
?>