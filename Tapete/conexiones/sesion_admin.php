<?php
    include'conexion.php';
    session_start();

    if (isset($_SESSION['num_empleado'])) {
        $num_e = $_SESSION['num_empleado'];
        $nombre = "SELECT nombre from docentes WHERE num_empleado = '$num_e'";
        $r_nombre = $conn -> query($nombre);
        $nombreF = $r_nombre->fetch_assoc();
        $name = $nombreF['nombre'];
        echo "<h2>¡Bienvenido, " . $name . "!</h2>";

        $sql = "SELECT usuarios.CURP, usuarios.Nombres, usuarios.Paterno, usuarios.Materno
                FROM usuarios 
                join grupos
                on usuarios.id_grupo = grupos.id_grupo
                join docentes
                on grupos.num_empleado = docentes.num_empleado
                WHERE grupos.num_empleado = ?
                ORDER BY Paterno ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $num_e);
        $stmt->execute();
        $result = $stmt->get_result();
    } 
    else {
        echo "<h3>No has iniciado sesión. Por favor, <a href= '../index.php'>inicia sesión</a>.</h3>";
        exit; 
    }
?>