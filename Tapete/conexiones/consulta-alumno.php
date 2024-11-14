<?php
    include 'conexion.php';
    $pregunta = "";
    session_start();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['curp'])) {
        $curp = $_POST['curp'];
        $sql = "SELECT Pregunta FROM usuarios WHERE CURP = '$curp'";
        $r_nombre = $conn -> query($sql);
        $nombreF = $r_nombre->fetch_assoc();
        $name = $nombreF['Pregunta'];
        echo $name;
    }

    else{
        echo $curp;
    }
    $conn->close();
?>