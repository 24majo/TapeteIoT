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

		if($sexo == "M"){
			$imagen = "Visual/Material/Recursos/SesionNiña.png";
		}
		else if ($sexo == "H"){
			$imagen = "Visual/Material/Recursos/SesionNiño.png";
		}

        $sql = "SELECT juegos.nombre, progreso_alumno.progreso, progreso_alumno.puntaje
                FROM progreso_alumno 
                JOIN juegos
                ON progreso_alumno.num_juego = juegos.num_juego
                WHERE progreso_alumno.CURP = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $curp);
        $stmt->execute();
        $result = $stmt->get_result();

        // Actualizar el juego 
        $progreso = $_POST['progreso'];
        $puntaje = $_POST['puntaje'];
        $num_juego = $_POST['num_juego'];
        
        $sql = "UPDATE progreso_alumno 
        SET progreso = ?, puntaje = ?
        WHERE CURP = ? AND num_juego = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ddsi", $progreso, $puntaje, $curp, $num_juego); // d double, s string, i int
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Progreso actualizado correctamente.";
            } else {
                echo "No se pudo actualizar el progreso.";
            }

            $stmt->close();
        } 
        
        else {
            echo "Error en la consulta SQL: " . $conn->error;
        }

    } 
    else {
        echo "<h3>No has iniciado sesión. Por favor, <a href= '../index.html'>inicia sesión</a>.</h3>";
        exit; 
    }
?>