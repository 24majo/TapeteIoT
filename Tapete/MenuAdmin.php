<?php
include'conexiones/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrador</title>
    <link rel="stylesheet" href="jquery/jquery-ui.css">
    <link rel="stylesheet" href="jquery/jquery-ui.structure.css">
    <link rel="stylesheet" href="jquery/jquery-ui.theme.css">
    <link rel="stylesheet" href="css/StyleMenuAdmin.css">

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
    <button onclick="window.location.href = 'registro_admin.html'">Registrar personal</button>
    <button onclick="window.location.href='registro_alumno.html'">Registrar alumno</button><br><br>
    
    <form method="GET">
        <select name="generacion">
        <option value="" disabled selected>Generación</option> 
        <!-- Sirve para mostrar las generaciones que están registradas en la BD -->
        <?php
            $generacion = "SELECT * FROM generaciones";
            $result = $conn->query($generacion);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['generacion'] . "'>" . $row['generacion'] . "</option>";
                }
            } 
            else {
                echo "<option value=''>Generación no disponible</option>";
            }
        ?>
        </select>
        <button type="submit">Mostrar</button>
    </form>
    
    <!-- PHP para cambiar los datos de acuerdo a la generación para futuros registros  -->
    <?php
        if (isset($_GET['generacion'])) {
            $generacion = $_GET['generacion'];
            
            $promedio_gen = "SELECT grupos.nombre AS grupo, 
                             AVG(progreso_alumno.puntaje) AS promedio_g,
                             AVG(CASE WHEN juegos.categoria = 'Números' THEN progreso_alumno.puntaje END) AS promedio_n, 
                             AVG(CASE WHEN juegos.categoria = 'Letras' THEN progreso_alumno.puntaje END) AS promedio_l
                             FROM progreso_alumno 
                             JOIN usuarios 
                             ON progreso_alumno.CURP = usuarios.CURP
                             INNER JOIN grupos 
                             ON usuarios.id_grupo = grupos.id_grupo
                             JOIN juegos 
                             ON progreso_alumno.num_juego = juegos.num_juego
                             WHERE grupos.generacion = ?
                             GROUP BY grupos.nombre";
            
            $general = $conn->prepare($promedio_gen);
            $general->bind_param("i", $generacion);
            $general->execute();
            $pro_gen = $general->get_result();
            
            if ($pro_gen->num_rows > 0) {
                while ($row = $pro_gen->fetch_assoc()) {
                    $p_general = round($row['promedio_g'], 1);
                    $p_numeros = round($row['promedio_n'], 1);
                    $p_letras = round($row['promedio_l'], 1);

                    if ($p_general < 6) {
                        $color = 'red';
                    } elseif ($p_general >= 6.1 && $p_general <= 8) {
                        $color = 'green'; 
                    } else {
                        $color = 'blue';
                    }

                    // echo "<span><strong>Grupo " . $row['grupo'] . "</strong></span><br>
                    // <span><strong>Promedio general: </strong>" . $p_general . "</span><br>
                    // <span><strong>Promedio números: </strong>" . $p_numeros . "</span><br>
                    // <span><strong>Promedio letras: </strong>" . $p_letras . "</span><br><br>";

                    echo "<span><strong>Grupo " . $row['grupo'] . "</strong></span><br>";

                    echo
                    '<span><strong>Promedio general: </strong>'. $p_general . '</span><br>
                    <div class="porcentajes" style="--porcentaje: '.number_format($p_general, 1).'; --color: '.$color.'">
                        <svg width="150" height="150">
                            <circle r="65" cx="50%" cy="50%" pathlength="10" />
                            <circle r="65" cx="50%" cy="50%" pathlength="10" />
                        </svg>
                    </div>';

                    if ($p_numeros < 6) {
                        $color = 'red';
                    } elseif ($p_numeros >= 6.1 && $p_numeros <= 8) {
                        $color = 'green'; 
                    } else {
                        $color = 'blue';
                    }

                    echo
                    '<span><strong>Promedio números: </strong>'. $p_numeros .'</span><br>
                    <div class="porcentajes" style="--porcentaje: '.number_format($p_numeros, 1).'; --color: '.$color.'">
                        <svg width="150" height="150">
                            <circle r="65" cx="50%" cy="50%" pathlength="10" />
                            <circle r="65" cx="50%" cy="50%" pathlength="10" />
                        </svg>
                    </div>';

                    if ($p_letras < 6) {
                        $color = 'red';
                    } elseif ($p_letras >= 6.1 && $p_letras <= 8) {
                        $color = 'green'; 
                    } else {
                        $color = 'blue';
                    }

                    echo
                    '<span><strong>Promedio letras: </strong> '. $p_letras .' </span><br><br>
                    <div class="porcentajes" style="--porcentaje: '.number_format($p_letras, 1).'; --color: '.$color.'">
                        <svg width="150" height="150">
                            <circle r="65" cx="50%" cy="50%" pathlength="10" />
                            <circle r="65" cx="50%" cy="50%" pathlength="10" />
                        </svg>
                    </div>';
                }
            } 
            else {
                echo "No hay datos disponibles para esta generación.";
            }

        } 
        
        else {
            echo "Selecciona una generación para ver los resultados.";
        }
    ?>

    <br><br>
    <a href="conexiones/cerrar_sesion.php">Cerrar sesión</a>
</body>
</html>