<?php
$conn = new mysqli("localhost", "root", "", "tapeteiot");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} 
else {
    echo '<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>';
    echo 
    '<script>
        swal({
            title: "Conexión exitosa",
            text: "Bienvenido",
            icon: "success"
        })
    </script>';
}
?>
