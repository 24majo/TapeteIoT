<?php
    include'conexion.php';
    session_start();

    if (isset($_SESSION['CURP'])) {
        $curp = $_SESSION['CURP'];
        $nombre = "SELECT Nombres from usuarios WHERE CURP = '$curp'";
        $r_nombre = $conn -> query($nombre);
        $nombreF = $r_nombre->fetch_assoc();
        $name = $nombreF['Nombres'];
       

        $sexo = substr($curp, -8, 1);
    } 
    
    else {
        echo "<h3>No has iniciado sesión. Por favor, <a href= '../index.html'>inicia sesión</a>.</h3>";
        exit; 
    }
?>