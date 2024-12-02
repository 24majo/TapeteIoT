<?php
    include('sesion_admin.php'); 
    $curp = $_GET['curp'];
    $numeros = "SELECT juegos.nombre, progreso_alumno.CURP, progreso_alumno.progreso, progreso_alumno.puntaje
            FROM progreso_alumno
            JOIN juegos
            ON progreso_alumno.num_juego = juegos.num_juego
            WHERE juegos.categoria = 'Números'
            AND progreso_alumno.CURP = ?";

    $stmt = $conn->prepare($numeros);
    $stmt->bind_param("s", $curp);
    $stmt->execute();
    $result_numeros = $stmt->get_result();

    echo "<table>
            <thead>
                <tr>
                    <th>Juego</th>
                    <th>Progreso</th>
                    <th>Puntaje</th>
                </tr>
            </thead>
        <tbody>";

    if ($result_numeros->num_rows > 0) {
        while ($row = $result_numeros->fetch_assoc()) {
            echo "<tr>";
            echo "<td  style='width: 250px;'>" . $row['nombre'] . "</td>";
            echo '<td> <progress style="height: 80px; width:380px;"  id="barra" max="10" value="'.$row['progreso'].'"></progress></td>';
            echo "<td style='text-align: center;'>" . $row['puntaje'] . "</td>";
            echo "</tr>";
        }
    } 
    
    else {
        echo "<tr><td colspan='3'>No hay resultados para la categoría 'Números'</td></tr>";
    }

    $letras = "SELECT juegos.nombre, progreso_alumno.CURP, progreso_alumno.progreso, progreso_alumno.puntaje
            FROM progreso_alumno
            JOIN juegos
            ON progreso_alumno.num_juego = juegos.num_juego
            WHERE juegos.categoria = 'Letras' 
            AND progreso_alumno.CURP = ?";

    $stmt = $conn->prepare($letras);
    $stmt->bind_param("s", $curp);
    $stmt->execute();
    $result_letras = $stmt->get_result();

    echo "<table>
            <thead>
                <tr>
                    <th>Juego</th>
                    <th>Progreso</th>
                    <th>Puntaje</th>
                </tr>
            </thead>
        <tbody>";

    if ($result_letras->num_rows > 0) {
        while ($row = $result_letras->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo '<td> <progress style="height: 80px; width:380px;"  id="barra" max="10" value="'.$row['progreso'].'"></progress></td>';
            echo "<td>" . $row['puntaje'] . "</td>";
            echo "</tr>";
        }
    } 
    
    else {
        echo "<tr><td colspan='3'>No hay resultados para la categoría 'Letras'</td></tr>";
    }
    $stmt->close();
?>