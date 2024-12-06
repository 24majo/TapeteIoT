<?php
    include'conexiones/conexion.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Alumno</title>
</head>
<body>
    <form action="" method="get">
        <span>CURP</span><br>
        <input type="text" name="curp" id="curp" disabled><br><br>
        <span>Nombre</span><br>
        <input type="text" name="nombre" id="nombre" disabled><br><br>
        <span>Apellidos</span><br>
        <input type="text" name="apellidos" id="apellidos" disabled><br><br>
    </form>
    
</body>
</html>