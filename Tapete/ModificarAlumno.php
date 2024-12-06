<?php
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); // Linea que sirve para ocultar advertencias
    include'conexiones/conexion.php';
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $curp = $_POST['curp'];
        $paterno = $_POST['paterno'];
        $materno = $_POST['materno'];
        $nombre = $_POST['nombre'];
        $generacion = $_POST['gen'];
    }

    $grupo = "SELECT id_grupo, nombre 
              FROM grupos
              WHERE generacion = '$generacion'
              ";
    $id_g = [];
    $group = [];
    $r_grupo = $conn->query($grupo);
    if($r_grupo->num_rows > 0){
        while($fila = $r_grupo->fetch_assoc()){
            $id_g[] = $fila['id_grupo'];
            $group[] = $fila['nombre'];
        }
    }
    else{
        $group[] = "Grupo no disponible";
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Alumno</title>
</head>
<body>
    <form method="post">
        <span>CURP</span><br>
        <input type="text" name="curp" id="curp" value="<?php echo $curp; ?>" readonly><br><br>
        <span>Nombre</span><br>
        <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" readonly><br><br>
        <span>Apellidos</span><br>
        <input type="text" name="apellidos" id="apellidos" value="<?php echo $paterno . " " . $materno; ?>" readonly><br><br>
        <span><b>Cambio de grupo:</b></span>
        <select name="grupo">
            <option value="" disabled selected>-- Grupo --</option>
            <?php
                foreach ($group as $index => $n_group) {
                    $id_grup = $id_g[$index];
                    echo "<option value='" . $id_grup . "'>" . $n_group . "</option>";
                }
            ?>
        </select>    
        <button name="cambio" id="btn_cambiar">Cambiar de grupo</button>
    </form>
    <button onclick="window.location.href='RegistroGrupo.php';">Regresar</button>

    <?php
        if(isset($_POST['cambio'])){
            $curp = $_POST['curp'];
            $grupo = $_POST['grupo'];

            $actualizar = "UPDATE usuarios set id_grupo = ? WHERE CURP = '$curp'";
            if ($stmt = $conn->prepare($actualizar)) {
                $stmt->bind_param("s", $grupo); // d double, s string, i int
                $stmt->execute();
    
                if ($stmt -> affected_rows > 0) {
                    echo '<script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                    echo 
                    '<script>
                        swal({
                            title: "Actualización exitosa",
                            text: "El alumno se ha cambiado de grupo.",
                            icon: "success"
                        })
                    </script>';
                } 
                else {
                    echo '<script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                    echo 
                    '<script>
                        swal({
                            title: "Error de ctualización",
                            text: "No se ha podido actualizar el grupo del alumno. Inténtelo más tarde.",
                            icon: "error"
                        })
                    </script>';
                }
            }
        }
    ?>
</body>
</html>