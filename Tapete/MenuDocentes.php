<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Docentes</title>
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
        include('conexiones/sesion_admin.php'); 
        echo "<h2>¡Bienvenido, " . $name . "!</h2>";
        $sql = "SELECT nombre FROM grupos WHERE num_empleado = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $num_e);
        $stmt->execute();
        $grupo = $stmt->get_result();

        if ($row = $grupo->fetch_assoc()) {
            $n_grupo = $row['nombre']; 
        } 
        else {
            echo "Desconocido";
        }
    ?>

    <span>Grupo: <?php echo $n_grupo; ?></span>
    <br><br>
    <table>
        <thead>
            <tr>
                <th>Apellidos</th>
                <th>Nombres</th>
            </tr>
        </thead>
        <tbody>
            <?php
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

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<tr onclick="Progreso(\'' . $row["CURP"] . '\')">';
                    echo "<td>" . $row['Paterno'] ." ". $row['Materno']. "</td>";
                    echo "<td>" . $row['Nombres'] . "</td>";
                    echo "</tr>";
                }
            } 
            else {
                echo "<tr><td colspan='4'>No hay registros disponibles</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
        // Promedio general
        $promedio_gen = "SELECT AVG(progreso_alumno.puntaje) AS promedio 
                         FROM progreso_alumno 
                         JOIN usuarios
                         ON progreso_alumno.CURP = usuarios.CURP
                         INNER JOIN grupos
                         ON usuarios.id_grupo = grupos.id_grupo
                         WHERE grupos.nombre = '$n_grupo'";

        $promedio_g = $conn -> query($promedio_gen);

        if ($promedio_g->num_rows > 0) {
            $promediog = $promedio_g->fetch_assoc();
            $pro_gen = number_format($promediog['promedio'], 1);

            if ($pro_gen < 6) {
                $color = 'red';
            } elseif ($pro_gen >= 6.1 && $pro_gen <= 8) {
                $color = 'green'; 
            } else {
                $color = 'blue';
            }
        }
        else{
            echo "No existe un promedio";
        }

        // Promedio números
        $promedio_num = "SELECT AVG(progreso_alumno.puntaje) AS promedio 
                        FROM progreso_alumno 
                        JOIN usuarios
                        ON progreso_alumno.CURP = usuarios.CURP
                        INNER JOIN grupos
                        ON usuarios.id_grupo = grupos.id_grupo
                        JOIN juegos
                        ON progreso_alumno.num_juego = juegos.num_juego
                        WHERE grupos.nombre = '$n_grupo' AND juegos.categoria = 'Números'";

        $promedio_n = $conn -> query($promedio_num);

        if ($promedio_n->num_rows > 0) {
            $promedio = $promedio_n->fetch_assoc();
            $pro_num = number_format($promedio['promedio'], 1);

            if ($pro_num < 6) {
                $color = 'red';
            } elseif ($pro_num >= 6.1 && $pro_num <= 8) {
                $color = 'green'; 
            } else {
                $color = 'blue';
            }
        }
        else{
            echo "No existe un promedio";
        }

        // Promedio letras
        $promedio_let = "SELECT AVG(progreso_alumno.puntaje) AS promedio 
                        FROM progreso_alumno 
                        JOIN usuarios
                        ON progreso_alumno.CURP = usuarios.CURP
                        INNER JOIN grupos
                        ON usuarios.id_grupo = grupos.id_grupo
                        JOIN juegos
                        ON progreso_alumno.num_juego = juegos.num_juego
                        WHERE grupos.nombre = '$n_grupo' AND juegos.categoria = 'Letras'";

        $promedio_l = $conn -> query($promedio_let);

        if ($promedio_l->num_rows > 0) {
            $promediol = $promedio_l->fetch_assoc();
            $pro_let = number_format($promediol['promedio'], 1);
            
            if ($pro_let < 6) {
                $color = 'red';
            } elseif ($pro_let >= 6.1 && $pro_let <= 8) {
                $color = 'green'; 
            } else {
                $color = 'blue';
            }
        }
        else{
            echo "No existe un promedio";
        }
    ?>
    <br><br>
    <span>Promedio general: <?php echo $pro_gen; ?></span><br>
    <div class="porcentajes" style="--porcentaje: '.number_format(<?php echo $pro_gen; ?>, 1).'; --color: '.<?php echo $color; ?>.'">
        <svg width="150" height="150">
            <circle r="65" cx="50%" cy="50%" pathlength="10" />
            <circle r="65" cx="50%" cy="50%" pathlength="10" />
        </svg>
    </div>
    <span>Promedio juego números: <?php echo $pro_num; ?></span><br>
    <div class="porcentajes" style="--porcentaje: '.number_format(<?php echo $pro_num; ?>, 1).'; --color: '.<?php echo $color; ?>.'">
        <svg width="150" height="150">
            <circle r="65" cx="50%" cy="50%" pathlength="10" />
            <circle r="65" cx="50%" cy="50%" pathlength="10" />
        </svg>
    </div>
    <span>Promedio juego letras: <?php echo $pro_let; ?></span><br>
    <div class="porcentajes" style="--porcentaje: '.number_format(<?php echo $pro_let; ?>, 1).'; --color: '.<?php echo $color; ?>.'">
        <svg width="150" height="150">
            <circle r="65" cx="50%" cy="50%" pathlength="10" />
            <circle r="65" cx="50%" cy="50%" pathlength="10" />
        </svg>
    </div>

    <div id="detalle-alumno"></div>
    <a href="conexiones/cerrar_sesion.php">Cerrar sesión</a>
</body>
<script>
    function Progreso(curp) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "conexiones/obtener_datos_a.php?curp=" + curp, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("detalle-alumno").innerHTML = xhr.responseText;
            }
        }
        xhr.send();
    }
</script>   
</html>