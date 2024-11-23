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

        if ($grupo->num_rows > 0) {
            while($ngrupo = $grupo->fetch_assoc()) {
                echo "<span>Grupo: ".$ngrupo['nombre']."</span>";
            }
            $stmt->close();
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