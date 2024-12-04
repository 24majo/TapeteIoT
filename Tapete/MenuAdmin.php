<?php
include'conexiones/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/StyleMenuAdmin.css">
    <link rel="shortcut icon" href="Visual/Material/Didit.png" type="image/x-icon">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
</head>

<body background="Visual/Fondos/fondoMenuAdmin.jpg">

    <div class="barra-superior">
        <span>Administrador</span>
        <button class="btnPass" onclick="window.location.href='ContraseñaDocente.php'">Cambiar contraseña</button>
        <a href="conexiones/cerrar_sesion.php">Cerrar sesión</a>
    </div>

    <div class="botones">
        <button onclick="window.location.href = 'registro_admin.html'">Registrar personal</button>
        <button onclick="window.location.href='registro_alumno.html'">Registrar alumno</button>
        <button onclick="window.location.href = 'registro_admin.html'">Modificar personal</button>
        <button onclick="window.location.href='modificar_alumno.php'">Modificar alumno</button>
    </div>

    <div class="selector-generacion">
        <form method="GET">
            <select name="generacion">
                <option value="" disabled selected>Generación</option>
                <?php
                // Conexión a la BD
                $generacion = "SELECT * FROM generaciones";
                $result = $conn->query($generacion);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['generacion'] . "'>" . $row['generacion'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Generación no disponible</option>";
                }
                ?>
            </select>
            <button type="submit">Mostrar</button>
        </form>
    </div>

    <!--Progreso -->
    <div class="contenedor-progreso">
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
                    $circulo = 2 * M_PI * 36;
                    $p_g = $circulo * (1 - ($p_general * 10 / 100));
                    $p_n = $circulo * (1 - ($p_numeros * 10 / 100));
                    $p_l = $circulo * (1 - ($p_letras * 10 / 100));
                    
                    echo "<br><br><span class='grupo'><strong>Grupo: " . $row['grupo'] . "</strong></span><br><br>";
                    echo 
                    '<div class="cartas">
                        <div class="general">
                            <div class="status">
                                <div class="info">
                                    <h3>General</h3>
                                </div>
                                <div class="grafica">
                                    <svg>
                                        <circle cx="-37" cy="47" r="36"
                                            style="stroke-dasharray: '.$circulo.'; 
                                            stroke-dashoffset: '.$p_g.'">
                                        </circle>
                                    </svg>
                                    <div class="numero">
                                        <p>'.$p_general .'</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="numeros">
                            <div class="status">
                                <div class="info">
                                    <h3>Números</h3>
                                </div>
                                <div class="grafica">
                                    <svg>
                                        <circle cx="-37" cy="47" r="36"
                                            style="stroke-dasharray: '.$circulo.'; 
                                            stroke-dashoffset: '.$p_n.'">
                                        </circle>
                                    </svg>
                                    <div class="numero">
                                        <p>'.$p_numeros.'</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="letras">
                            <div class="status">
                                <div class="info">
                                    <h3>Letras</h3>
                                </div>
                                <div class="grafica">
                                
                                    <svg>
                                        <circle cx="-37" cy="47" r="36"
                                            style="stroke-dasharray: ' .$circulo .'; 
                                            stroke-dashoffset: '.$p_l.'">
                                        </circle>
                                    </svg>
                                    <div class="numero">
                                        <p>'. $p_letras . '</p>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    </div>
</body>
</html>