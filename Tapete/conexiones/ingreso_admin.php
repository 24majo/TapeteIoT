<?php
    include'conexion.php';

    if (isset($_POST['ingresar_d'])) {
        $num_empleado = $_POST['num_empleado'];
        $pass = $_POST['pass'];
    
        $sql = "SELECT password FROM docentes WHERE num_empleado = '$num_empleado'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $contra = $row['password'];
    
            if (password_verify($pass, $contra)) {
                header("Location: ../MenuSeleccion.html");
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
                            window.location.href = "../../index.html";
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
                        window.location.href = "../../index.html";
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
                title: "Error de ingreso",
                text: "Ingresa los datos correspondientes para acceder.",
                icon: "error"
            })

            .then((Okay) => {
                if (Okay) {
                    window.location.href = "../../index.html";
                } 
            });
        </script>';
    }
?>