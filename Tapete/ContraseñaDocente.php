<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        include'conexiones/conexion.php';
        session_start();
        $num_e = $_SESSION['num_empleado'];
        // echo $curp;
        $sql = "SELECT pregunta FROM docentes WHERE num_empleado = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $num_e);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $pregunta = $row['pregunta'];
        } 
        else {
            $pregunta = 'Pregunta no encontrada';
        }
    ?>
    <form method="POST">
        <span>Contraseña actual</span><br>
        <input type="password" placeholder="Ingrese su contraseña actual" name="a_pass" id="a_pass" required><br><br>
        <span>Nueva contraseña</span><br>
        <input type="password" placeholder="Mínimo 8 dígitos" minlength="8" name="n_pass" id="n_pass" required><br><br>
        <span>Responda a la pregunta de seguridad para continuar</span><br>
        <span>Pregunta</span><br>
        <input type="text" value="<?php echo $pregunta;?>" name="pregunta" id="prgunta" readonly><br><br>
        <span>Respuesta</span><br>
        <input type="text" placeholder="Escribe la respuesta correcta" name="respuesta" id="respuesta" required><br><br>
        <button name="cambiar">Cambiar contraseña</button>
    </form>
    <?php
        if(isset($_POST['cambiar'])){
            $pass_a = $_POST['a_pass'];
            $pass_n = $_POST['n_pass'];
            $respuesta = $_POST['respuesta'];

            $sql = "SELECT password FROM docentes WHERE num_empleado = '$num_e'";
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $contra = $row['password'];
        
                if (password_verify($pass_a, $contra)) {
                    $res = "SELECT respuesta FROM docentes WHERE num_empleado = '$num_e'";
                    $res_res = $conn->query($res);

                    if ($res_res->num_rows > 0) {
                        $re = $res_res->fetch_assoc();
                        $r = $re['respuesta'];

                        if(password_verify($respuesta, $r)){
                            $pass_encryp = password_hash($pass_n, PASSWORD_DEFAULT);
                            $cambio = "UPDATE docentes SET password = ? WHERE num_empleado = ?";
    
                            if ($stmt = $conn->prepare($cambio)) {
                                $stmt->bind_param("ss", $pass_encryp, $num_e);
                        
                                if ($stmt->execute()) {
                                    echo '<script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                                    echo 
                                    '<script>
                                        swal({
                                            title: "Contraseña actualizada",
                                            text: "La contraseña se ha modificado correctamente.",
                                            icon: "success"
                                        })
                                    </script>';
                                } 
                                
                                else {
                                    echo '<script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                                    echo 
                                    '<script>
                                        swal({
                                            title: "Error de actualización",
                                            text: "La contraseña no ha podido modificarse.Inténtalo más tarde.",
                                            icon: "error"
                                        })
                                    </script>';
                                }
                        
                            } 
                            
                            else {
                                echo "Error en la preparación de la consulta.";
                            }
                        }

                        else{
                            echo '<script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                            echo 
                            '<script>
                                swal({
                                    title: "Respuesta incorrecta",
                                    text: "Verifica que la respuesta a la pregunta sea correcta.",
                                    icon: "error"
                                })
                            </script>';
                        }
                    } 
                }   

                else {
                    echo '<script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                    echo 
                    '<script>
                        swal({
                            title: "Contraseña incorrecta",
                            text: "Verifica que la contraseña sea correcta.",
                            icon: "error"
                        })
                    </script>';
                }
            } 
        }
    ?>
</body>
</html>