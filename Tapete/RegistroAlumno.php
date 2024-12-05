<?php
    include'conexiones/conexion.php';
    $generacion = "SELECT * FROM generaciones";
    $gen = [];
    $result = $conn->query($generacion);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $gen[] = $row['generacion'];
        }
    } 
    else {
        echo "Generación no disponible.";
    }
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
    <title>Registro de alumnos</title>
</head>
<body background="Visual/Fondos/FondoRegistro.jpg">
     <div class="container">
       
        <form  class="formulario" method="POST">
            <center>
                <font face="century gothic">
                    <h3><b>Ingresa los datos del alumno</b></h3>
                </font>
            </center>

            <font face="century gothic">
            <span><b>CURP: </b> </span>
            <input type="text" id="curp" name="curp" placeholder="18 caracteres" maxlength="18" required> <br>
            <span><b>Nombres: </b></span>
            <input type="text" id="nombres" name="nombres" placeholder="Nombres" maxlength="50" required> <br>
            <span><b>Apellido paterno: </b></span>
            <input type="text" id="paterno" name="paterno" placeholder="Apellido" maxlength="50" required> <br>
            <span><b>Apellido materno: </b></span>
            <input type="text" id="materno" name="materno" placeholder="Apellido" maxlength="50" required> <br>
            <span><b>Grupo: </b></span>
            <select name="grupo" id="grupo">
                <option value="1A">1A</option>
                <option value="1B">1B</option>
                <option value="1C">1C</option>
            </select><br>
            <span><b>Generación: </b></span>
            <select name="generacion">
                <option value="" disabled selected>Selecciona una generación</option>
                <?php
                    foreach ($gen as $año) {
                        echo "<option value='" . $año . "'>" . $año . "</option>";
                    }
                ?>
            </select>
            <!-- <input type="text" name="generacion" id="generacion" placeholder="Año" maxlength="4" required> <br> -->
            <span><b>Contraseña: </b></span>
            <input type="password" id="pass" name="pass" placeholder="********" minlength="8" maxlength="50" required> <br>
            <span><b>Confirmar contraseña: </b></span>
            <input type="password" id="conf_pass" name="conf_pass" placeholder="********" minlength="8" maxlength="50" required> <br>
            <span><b>En caso de olvido de contraseña: </b></span><br>
            <select name="pregunta" id="pregunta">
                <option value="¿Cuál es tu color favorito?">¿Cuál es tu color favorito?</option>
                <option value="¿Cuál es el nombre de tu primera mascota?">¿Cuál es el nombre de tu primera mascota?</option>
                <option value="¿En qué ciudad naciste?">¿En qué ciudad naciste?</option>
                <option value="¿Cuál es el nombre de tu mamá/papá?">¿Cuál es el nombre de tu mamá/papá?</option>
                <option value="¿Cuál es tu comida favorita?">¿Cuál es tu comida favorita?</option>
                <option value="¿Qué apodo tienes?">¿Qué apodo tienes?</option>
            </select>
            <span><b>Respuesta: </b></span>
            <input type="text" id="respuesta" name="respuesta" placeholder="Respuesta a la pregunta" max="100" required> 
            </font>
            <center>
                <font face="century gothic">
                    <button style="border: none;" class="botonRegistrar" onclick="window.location.href='MenuAdmin.php';" type="button">Regresar</button><br><br>
                    <input name="registro_a" class="registro_a botonRegistrar" id="registro_a" type="submit" value="Registrar">
                </font>
                </center>
        </form>
    </div>

    <?php
    include'conexiones/conexion.php';

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
            echo '<script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>';
            echo 
            '<script>
                swal({
                    title: "Error",
                    text: "Comprueba que las contraseñas sean iguales.",
                    icon: "error"
                })
            </script>';
        }

        else {
            $sql = "INSERT INTO usuarios (CURP, Nombres, Paterno, Materno, id_grupo, generacion, Pass, Pregunta, Respuesta)
            VALUES ('$curp', '$nombres', '$paterno', '$materno', 
            (SELECT id_grupo FROM grupos WHERE nombre = '$grupo' AND generacion = '$generacion'),
            '$generacion','$pass_encryp', '$pregunta', '$resp_encryp')";

            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo '<script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                echo 
                '<script>
                    swal({
                        title: "Usuario registrado",
                        text: "El alumno se ha registrado con éxito.",
                        icon: "success"
                    })
                </script>';
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
?>
</body>
</html>