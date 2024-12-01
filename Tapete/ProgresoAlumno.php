<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progreso</title>

    <style>
    @keyframes rellenar{
        to{
            stroke-dasharray: var(--porcentaje) 100;
        }
    }

    .porcentajes{
        position:relative;
    }
    .porcentajes span{
        position: absolute;
        top: 0%;
        left: 0%;
        bottom: 0%;
        right: 0%;
        display: flex;
        align-items: center;
        justify-content: center;
        font: 25px/1em Verdana;
    }

    circle{
        fill: none;
        stroke-width: 20;
        transform: rotate(-90deg);
        transform-origin: 50%;
        stroke-dasharray: 100 100;
        stroke: #AAA;
    }
    circle:nth-child(2){ /* el segundo círculo, es el que se ve por encima del anterior y debe tener el color mas intenso y el area del porcentaje */
        stroke: var(--color);
        stroke-dasharray: 0 100;
        animation: rellenar .35s linear forwards;
    }
  </style>
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
        }
        else {
            echo "<h3>No has iniciado sesión. Por favor, <a href= '../index.php'>inicia sesión</a>.</h3>";
            exit; 
        }
    ?>
    <img class="sexo" id="sexo" src="<?php echo $imagen; ?>" width="40px">
    <h2><?php echo $name; ?></h2>
    
    <span>Juego de números</span>
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
                $sql = "SELECT juegos.nombre, progreso_alumno.progreso, progreso_alumno.puntaje
                FROM progreso_alumno 
                JOIN juegos
                ON progreso_alumno.num_juego = juegos.num_juego
                WHERE progreso_alumno.CURP = ? AND juegos.categoria = 'Números'";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $curp);
                $stmt->execute();
                $result = $stmt->get_result();

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

    <span>Juego de Letras</span>
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
                $letras = "SELECT juegos.nombre, progreso_alumno.progreso, progreso_alumno.puntaje
                FROM progreso_alumno 
                JOIN juegos
                ON progreso_alumno.num_juego = juegos.num_juego
                WHERE progreso_alumno.CURP = ? AND juegos.categoria = 'Letras'";
                $stmt = $conn->prepare($letras);
                $stmt->bind_param("s", $curp);
                $stmt->execute();
                $r_letras = $stmt->get_result();

                if ($r_letras->num_rows > 0) {
                    while($row = $r_letras->fetch_assoc()) {
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

    <span>Promedios</span><br>
    <span>General:</span>
    <?php
        $sql = "SELECT puntaje FROM progreso_alumno where CURP = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $curp);
        $stmt->execute();
        $result = $stmt->get_result();
        $puntaje = [];

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $puntaje[] = $row['puntaje'];
            }

            if (count($puntaje) > 0) {
                $promedio = array_sum($puntaje) / count($puntaje);
                echo number_format($promedio, 1);
                if ($promedio < 6) {
                    $color = 'red';
                } elseif ($promedio >= 6.1 && $promedio <= 8) {
                    $color = 'green'; 
                } else {
                    $color = 'blue';
                }
                echo
                    '<div class="porcentajes" style="--porcentaje: '.number_format($promedio, 1).'; --color: '.$color.'">
                        <svg width="150" height="150">
                            <circle r="65" cx="50%" cy="50%" pathlength="10" />
                            <circle r="65" cx="50%" cy="50%" pathlength="10" />
                        </svg>
                    </div>';
            } 
        } 
        else {
            echo "<span>Sin datos de este alumno</span>";
        }
    ?>
    <br>
    <span>Números</span>
    <?php
        $sql = "SELECT progreso_alumno.puntaje
                FROM progreso_alumno
                JOIN juegos
                ON progreso_alumno.num_juego = juegos.num_juego
                WHERE progreso_alumno.CURP = ? 
                AND juegos.categoria = 'Números'";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $curp);
        $stmt->execute();
        $result = $stmt->get_result();
        $puntaje = [];

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $puntaje[] = $row['puntaje'];
            }

            if (count($puntaje) > 0) {
                $promedio = array_sum($puntaje) / count($puntaje);
                echo number_format($promedio, 1); 
                if ($promedio < 6) {
                    $color = 'red';
                } elseif ($promedio >= 6.1 && $promedio <= 8) {
                    $color = 'green'; 
                } else {
                    $color = 'blue';
                }
                echo
                    '<div class="porcentajes" style="--porcentaje: '.number_format($promedio, 1).'; --color: '.$color.'">
                        <svg width="150" height="150">
                            <circle r="65" cx="50%" cy="50%" pathlength="10" />
                            <circle r="65" cx="50%" cy="50%" pathlength="10" />
                        </svg>
                    </div>';
            } 
        } 
        else {
            echo "<span>Sin datos de este alumno</span>";
        }
    ?>
    <br>
    <span>Letras:</span>
    <?php
        $sql = "SELECT progreso_alumno.puntaje
                FROM progreso_alumno
                JOIN juegos
                ON progreso_alumno.num_juego = juegos.num_juego
                WHERE progreso_alumno.CURP = ? 
                AND juegos.categoria = 'Letras'";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $curp);
        $stmt->execute();
        $result = $stmt->get_result();
        $puntaje = [];

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $puntaje[] = $row['puntaje'];
            }

            if (count($puntaje) > 0) {
                $promedio = array_sum($puntaje) / count($puntaje);
                echo number_format($promedio, 1); 
                if ($promedio < 6) {
                    $color = 'red';
                } elseif ($promedio >= 6.1 && $promedio <= 8) {
                    $color = 'green'; 
                } else {
                    $color = 'blue';
                }
                echo
                    '<div class="porcentajes" style="--porcentaje: '.number_format($promedio, 1).'; --color: '.$color.'">
                        <svg width="150" height="150">
                            <circle r="65" cx="50%" cy="50%" pathlength="10" />
                            <circle r="65" cx="50%" cy="50%" pathlength="10" />
                        </svg>
                    </div>';
            } 
        } 
        else {
            echo "<span>Sin datos de este alumno</span>";
        }
    ?>
    <button onclick="window.history.back()">Regresar</button><br>
    <a href="conexiones/cerrar_sesion.php">Cerrar sesión</a>
</body>
</html>

