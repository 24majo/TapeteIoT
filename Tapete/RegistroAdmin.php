<?php
    include'conexiones/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styleRegistro.css">
    <link rel="shortcut icon" href="Visual/Material/Didit.png" type="image/x-icon">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>
    
    <title>Registro de administradores y docentes</title>
</head>
<body background="Visual/Fondos/FondoRegistro2.jpg">
    <div class="container">
    <form  class="formulario" method="post">
        <center>
            <font face="century gothic">
                <h3><b>Ingresa los datos</b></h3>
            </font>
        </center>
        <font face="century gothic">
            <span><b>Nombres: </b></span>
            <input type="text" name="nombres" id="nombres" placeholder="Nombres" required> <br>
            <span><b>Apellido paterno: </b></span>
            <input type="text" name="paterno" id="paterno" placeholder="Apellido" required> <br>
            <span><b>Apellido materno: </b></span>
            <input type="text" name="materno" id="materno" placeholder="Apellido" required> <br>
            <span><b>Correo: </b></span>
            <input type="text" name="correo" id="correo" placeholder="alguien@dominio.com" required> <br>
            <span><b>Contraseña: </b></span>
            <input type="password" id="pass" name="pass" placeholder="********" maxlength="50" required> <br>
            <span><b>Confirmar contraseña: </b></span>
            <input type="password" id="conf_pass" name="conf_pass" placeholder="********" max="50" required> <br>
            <span><b>En caso de olvido de contraseña: </b></span><br>
            <select name="pregunta" id="pregunta">
                <option value="¿Cuál es tu color favorito?">¿Cuál es tu color favorito?</option>
                <option value="¿Cuál es el nombre de tu primera mascota?">¿Cuál es el nombre de tu primera mascota?</option>
                <option value="¿En qué ciudad naciste?">¿En qué ciudad naciste?</option>
                <option value="¿Cuál es el nombre de tu mamá/papá?">¿Cuál es el nombre de tu mamá/papá?</option>
                <option value="¿Cuál es tu comida favorita?">¿Cuál es tu comida favorita?</option>
                <option value="¿Qué apodo tienes?">¿Qué apodo tienes?</option>
            </select><br>
            <span>Respuesta: </span>
            <input type="text" id="respuesta" name="respuesta" placeholder="Respuesta a la pregunta" max="100" required> <br>
            <span><b>Cargo: </b></span>
            <select name="rol" id="rol">
                <option value="admin">Administrador</option>
                <option value="docente">Docente</option>
            </select>
        </font>
        <center>
            <font face="century gothic">
                <button style="border: none;" class="botonRegistrar" onclick="window.location.href='MenuAdmin.php';">Regresar</button><br><br>
                <input name="registro_a" class="registro_a botonRegistrar" id="registro_a" type="submit" value="Registrar">
            </font>
         </center>
    </form>
</div>
<?php
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
                    echo '<script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                    echo 
                    '<script>
                        swal({
                            title: "Usuario registrado",
                            text: "El empleado se ha registrado con éxito.",
                            icon: "success"
                        })
                    </script>';
                    // echo "Usuario registrado correctamente";
                    // header("Location: ../registro_admin.html");
                } 
                
                else {
                    echo '<script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                    echo 
                    '<script>
                        swal({
                            title: "Error de registro",
                            text: "Los datos del usuario no han podido registrarse. Intente más tarde.",
                            icon: "error"
                        })
                    </script>';
                }
            }
        }
    }
?>
</body>
</html>