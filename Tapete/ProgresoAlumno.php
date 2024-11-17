<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progreso</title>
</head>
<body>
    <?php 
        include'conexiones/progreso_alumno.php';
    ?>
    <img class="sexo" id="sexo" src="<?php echo $imagen; ?>" width="40px">
    <h2><?php echo $name; ?></h2>

    <table>
        <thead>
            <tr>
                <th>Nombre del juego</th>
                <th>Progreso</th>
                <th>Puntaje</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo "<td>" . $row['progreso'] . "</td>";
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

