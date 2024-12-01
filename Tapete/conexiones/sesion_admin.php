<?php
    include'conexion.php';
    session_start();

    if (isset($_SESSION['num_empleado'])) {
        $num_e = $_SESSION['num_empleado'];
        $nombre = "SELECT nombre from docentes WHERE num_empleado = '$num_e'";
        $r_nombre = $conn -> query($nombre);
        $nombreF = $r_nombre->fetch_assoc();
        $name = $nombreF['nombre'];
    } 
    else {
        echo "<h3>No has iniciado sesión. Por favor, <a href= '../index.html'>inicia sesión</a>.</h3>";
        exit; 
    }
?>