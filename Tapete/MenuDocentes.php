<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Docentes</title>
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
            echo "<span>Grupo: ".$n_grupo."</span>";
        } 
        else {
            echo "<span>Sin datos de este alumno</span>";
        }
    ?>
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
                            JOIN generaciones
                            ON usuarios.generacion = generaciones.generacion
                            JOIN grupos
                            ON generaciones.generacion = grupos.generacion
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
                            JOIN generaciones
                            ON usuarios.generacion = generaciones.generacion
                            JOIN grupos
                            ON generaciones.generacion = grupos.generacion
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
                            JOIN generaciones
                            ON usuarios.generacion = generaciones.generacion
                            JOIN grupos
                            ON generaciones.generacion = grupos.generacion
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

    <span>Promedio general: <?php echo $pro_gen; ?></span><br>
    <span>Promedio juego números: <?php echo $pro_num; ?></span><br>
    <span>Promedio juego letras: <?php echo $pro_let; ?></span><br>

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