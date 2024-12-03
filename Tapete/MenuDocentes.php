<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="Visual/Material/Didit.png" type="image/x-icon">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/StyleMenuDocente.css">
    <link rel="stylesheet" href="css/BarraLateral.css">

    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>

    <title>Menú docentes</title>
</head>

<body background="Visual/Fondos/FondoDocente.jpg">
    <div>
        <nav>
            <?php 
                include('conexiones/sesion_admin.php'); 
                echo "<h1>¡Bienvenido, " . $name . "!</h1>";
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
            <!-- ESCRITO GRUPO -->
            <div class="grupo">
                <span>Grupo: <?php echo $n_grupo; ?></span>
            </div>

            <div class="cerrar">
                <button class="btnPass"  onclick="window.location.href='ContraseñaDocente.php'">Cambiar contraseña</button>
                <a href="conexiones/cerrar_sesion.php">Cerrar sesión</a>
            </div> 
        </nav>

        <Section>
            <aside>
            <!-- PHP código promedios -->
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
                    }
                    else{
                        echo "No existe un promedio";
                    }
                ?>
            <!--FIN PHP código promedios -->   

            <!-- Circulos promedios -->
                <div class="cartas">
                    <div class="general">
                        <div class="status">
                            <div class="info">
                                <h3>Promedio general</h3>
                            </div>
                            <div class="grafica">
                                <svg>
                                    <circle cx="45" cy="38" r="36"
                                        style="stroke-dasharray: <?php echo (2 * 3.1416) * 36; ?>; 
                                        stroke-dashoffset: <?php echo (2 * 3.1416) * 36 * (1 - ($pro_gen * 10 / 100)); ?>;">
                                    </circle>
                                </svg>
                                <div class="numero">
                                    <p><?php echo $pro_gen ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="numeros">
                        <div class="status">
                            <div class="info">
                                <h3>Promedio números</h3>
                            </div>
                            <div class="grafica">
                                <svg>
                                    <circle cx="45" cy="38" r="36"
                                        style="stroke-dasharray: <?php echo (2 * 3.1416) * 36; ?>; 
                                        stroke-dashoffset: <?php echo (2 * 3.1416) * 36 * (1 - ($pro_num  * 10 / 100)); ?>;">
                                    </circle>
                                </svg>
                                <div class="numero">
                                    <p><?php echo $pro_num; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="letras">
                        <div class="status">
                            <div class="info">
                                <h3>Promedio letras</h3>
                            </div>
                            <div class="grafica">
                                <svg>
                                    <circle cx="45" cy="38" r="36"
                                        style="stroke-dasharray: <?php echo (2 * 3.1416) * 36; ?>; 
                                        stroke-dashoffset: <?php echo (2 * 3.1416) * 36 * (1 - ($pro_let * 10 / 100)); ?>;">
                                    </circle>
                                </svg>
                                <div class="numero">
                                    <p><?php echo $pro_let ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!--Fin Circulos promedios -->
            </aside>

            <article>
                <!-- TABLA ALUMNOS -->
                <br><br>
                <div class="table-container tablaAlumnos"> 
                    <table class="table table-bordered text-center">
                        <thead style="background-color: #EAA724; color: white;">
                            <tr>
                                <th>Apellidos</th>
                                <th>Nombres</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <div>
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
                            </div>
                        </tbody>
                    </table>
                </div>
                <!--FIN TABLA ALUMNOS -->
            </article>
        </Section>

        <div class="identificar" >
            <div  id="detalle-alumno"></div>
        </div>
    </div>
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