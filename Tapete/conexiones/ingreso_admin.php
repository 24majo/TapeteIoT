<?php
    include'conexion.php';
    session_start();
    $pregunta ="";

    if (isset($_POST['ingresar_d'])) {
        $num_empleado = $_POST['num_empleado'];
        $pass = $_POST['pass'];
    
        $sql = "SELECT password FROM docentes WHERE num_empleado = '$num_empleado'";
        $rol = "SELECT rol FROM docentes where num_empleado = '$num_empleado'";
        $result = $conn->query($sql);
        $res_rol = $conn->query($rol);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $contra = $row['password'];
    
            if (password_verify($pass, $contra)) {

                if($res_rol -> num_rows > 0){
                    $roles = $res_rol->fetch_assoc();
                    $rolF = $roles['rol'];
                    //echo $rolF;
                    if($rolF == 'admin'){
                        $_SESSION['num_empleado'] = $num_empleado;
                        header("Location: ../MenuAdmin.php");
                    }
                    else if ($rolF == 'docente'){
                        $_SESSION['num_empleado'] = $num_empleado;
                        header("Location: ../MenuDocentes.php");
                    }
                } 

                else {
                    echo '<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                    echo 
                    '<script>
                        swal({
                            title: "Rol no asignado",
                            text: "Verifica que el usuario ingresado trnga asignado un rol de privilegios.",
                            icon: "info"
                        })

                        .then((Okay) => {
                            if (Okay) {
                                window.location.href = "../../index.php";
                            } 
                        });
                    </script>';
                }
            }
                
            
            else {
                echo '<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                echo 
                '<script>
                    swal({
                        title: "Contraseña incorrecta",
                        text: "Verifica que tu contraseña sea correcta",
                        icon: "error"
                    })

                    .then((Okay) => {
                        if (Okay) {
                            window.location.href = "../../index.php";
                        } 
                    });
                </script>';
            }
        } 
        
        else {
            echo '<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>';
            echo 
            '<script>
                swal({
                    title: "Usuario incorrecto",
                    text: "Verifica que el número de empleado sea correcto o esté registrado en el sistema.",
                    icon: "error"
                })

                .then((Okay) => {
                    if (Okay) {
                        window.location.href = "../../index.php";
                    } 
                });
            </script>';
        }
    } 

    if (isset($_GET['num_e'])) {
        $num_e = $_GET['num_e'];
        $sql = "SELECT pregunta FROM docentes WHERE num_empleado = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $num_e);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $pregunta = $row['pregunta'];
            echo $pregunta;
            header("../../index.php");
            exit;
        } 
        else {
            $pregunta = 'Pregunta no encontrada';
        }
        exit;
    }

    if(isset($_POST["verificar_d"])){
        $num_e = $_POST['num_empleado'];
        $respuesta = $_POST['respuesta_d'];
        $sql = "SELECT respuesta FROM docentes WHERE num_empleado = '$num_e'";
        $rol = "SELECT rol FROM docentes where num_empleado = '$num_e'";
        $result = $conn->query($sql);
        $res_rol = $conn->query($rol);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $res = $row['respuesta'];
    
            if (password_verify($respuesta, $res)) {
                $_SESSION['num_empleado'] = $num_empleado;
                if($res_rol -> num_rows > 0){
                    $roles = $res_rol->fetch_assoc();
                    $rolF = $roles['rol'];
                    if($rolF == 'admin'){
                        $_SESSION['num_empleado'] = $num_empleado;
                        header("Location: ../MenuAdmin.php");
                    }
                    else if ($rolF == 'docente'){
                        $_SESSION['num_empleado'] = $num_empleado;
                        header("Location: ../MenuDocentes.php");
                    }
                } 
                exit;
            } 
            else {
                echo '<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                echo 
                '<script>
                    swal({
                        title: "Respuesta incorrecta",
                        text: "Verifica que tu respuesta sea correcta",
                        icon: "error"
                    })

                    .then((Okay) => {
                        if (Okay) {
                            window.location.href = "../../index.php";
                        } 
                    });
                </script>';
            }
        }
    }
    
    else {
        echo '<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>';
        echo 
        '<script>
            swal({
                title: "Error de ingreso",
                text: "Ingresa los datos correspondientes para acceder.",
                icon: "error"
            })

            .then((Okay) => {
                if (Okay) {
                    window.location.href = "../../index.php";
                } 
            });
        </script>';
    }
?>