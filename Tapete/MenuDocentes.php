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

    <a href="conexiones/cerrar_sesion.php">Cerrar sesión</a>

    <script>
        function Progreso(nombre){
            alert(nombre)
        }
    </script>
</body>
</html>