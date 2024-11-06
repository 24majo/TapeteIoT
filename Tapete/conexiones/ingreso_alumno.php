<?php
    include'conexion.php';

    if (isset($_POST['ingresar_a'])) {
        $curp = $_POST['curp'];
        $pass = $_POST['pass_a'];
    
        $sql = "SELECT Pass FROM usuarios WHERE CURP = '$curp'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $contra = $row['Pass'];
    
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
                    text: "Verifica que la CURP sea correcto o que el alumno esté registrado.",
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