<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progreso</title>
</head>
<body>
    <?php 
        include'conexiones/conexion.php';
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
        }
    ?>
    <img class="sexo" id="sexo" src="<?php echo $imagen; ?>" width="40px">
    <h2><?php echo $name; ?></h2>

    <table>
        <thead>
            <tr>
                <th>Nombre del juego</th>
                <th>Progreso</th>
                <th>Calificación</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo '<td> <progress style="height: 80px; width:380px;"  id="barra" max="10" value="'.$row['progreso'].'"></progress></td>';
                    echo "<td>" . $row['puntaje'] . "</td>";
                    echo "</tr>";
                }
            } 
            else {
                echo "<tr><td colspan='4'>Aún no has jugado</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

