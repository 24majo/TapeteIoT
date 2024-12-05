<?php
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); // Linea que sirve para ocultar advertencias
    include'conexiones/conexion.php';

    $grupo = "SELECT id_grupo, nombre FROM grupos";
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

    $generacion = "SELECT * FROM generaciones";
    $gen = [];
    $result = $conn->query($generacion);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $gen[] = $row['generacion'];
        }
    } 
    else {
        $gen[] = "Generación no disponible.";
    }

    $docente = "SELECT num_empleado, nombre, materno, paterno FROM docentes WHERE rol = 'docente'";
    $id_d = [];
    $nombre_d = [];
    $r_docente = $conn->query($docente);
    if($r_docente -> num_rows > 0){
        while($file = $r_docente -> fetch_assoc()){
            $id_d[] = $file['num_empleado'];
            $nombre_d[] = $file['nombre'] . ' ' . $file['paterno'] . ' ' . $file['materno'];
        }
    }
    else{
        $nombre_d[] = "Docentes no disponibles";
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="Visual/Material/Didit.png" type="image/x-icon">
    <title>Grupos</title>
</head>
<body>
    <button onclick="window.location.href='RegistroAlumno.php'">Registrar alumno</button>
    <br><br>

    <form method="post">
        <span><b>Grupos:</b></span>
        <select name="grupo">
            <option value="" disabled selected>-- Grupo --</option>
            <?php
                foreach ($group as $index => $n_group) {
                    $id_grup = $id_f[$index];
                    echo "<option value='" . $n_group . "'>" . $n_group . "</option>";
                }
            ?>
        </select>    
        <br><br>
        <span><b>Generación:</b></span>
        <select name="generacion">
            <option value="" disabled selected>-- Año --</option>
            <?php
                foreach ($gen as $año) {
                    echo "<option value='" . $año . "'>" . $año . "</option>";
                }
            ?>
        </select>
        <br><br>
        <span><b>Docente:</b></span>
        <select name="docente">
            <option value="" disabled selected>-- Nombre docente --</option>
            <?php
                foreach ($nombre_d as $index => $nombre) {
                    $id = $id_d[$index]; 
                    echo "<option value='" . $id . "'>" . $nombre . "</option>";
                }
            ?>
        </select>
        <br><br>
        <button name = "btn_registrar">Registrar</button>
        <button name = "btn_ver">Ver grupos</button>
    </form>

    <?php
        if(isset($_POST['btn_registrar'])){
            $n_gru = $_POST['grupo'];
            $gen = $_POST['generacion'];
            $n_doc = $_POST['docente'];

            // echo 'Grupo: '. $n_gru . '<br>';
            // echo 'Generación: '. $gen . '<br>';
            // echo 'num_empleado: '. $n_doc . '<br>';

            $comprobar = "SELECT nombre, generacion FROM grupos
                        WHERE nombre = '$n_gru' AND generacion = '$gen'";
            $r_comprobar = $conn->query(query: $comprobar);

            if ($r_comprobar->num_rows > 0) {

                $sql_g = "SELECT id_grupo FROM grupos WHERE nombre = '$n_gru' AND generacion = '$gen'";
                $res_g = $conn->query($sql_g);
                $id_grupo = $res_g->fetch_assoc();
                $num_g = $id_grupo['id_grupo'];

                // echo 'ID_grupo: '. $num_g . '<br>';

                echo '<script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                echo 
                '<script>
                    swal({
                        title: "Grupo existente",
                        text: "El grupo ya está registrado. ¿Deseas actualizar al docente asignado?",
                        icon: "info",
                        buttons:  ["Cancelar", "Actualizar"] 
                    })
                    .then((actualizar) => {
                        if (actualizar) {
                            '.
                            $actualizar = "UPDATE grupos SET num_empleado = ? WHERE id_grupo = '$num_g'";
                            if ($stmt = $conn->prepare($actualizar)) {
                                $stmt->bind_param("s", $n_doc); // d double, s string, i int
                                $stmt->execute();
                    
                                if ($stmt -> affected_rows > 0) {
                                    echo '<script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                                    echo 
                                    '<script>
                                        swal({
                                            title: "Actualización exitosa",
                                            text: "El docente se ha actualizado.",
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
                                            text: "No se ha podido actualizar la información del grupo. Inténtelo más tarde.",
                                            icon: "error"
                                        })
                                    </script>';
                                }
                    
                                $stmt->close();
                            } ;
                            '
                        } 
                    });    
                </script>';
            } 
            else{
                echo '<script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                echo 
                '<script>
                    swal({
                        title: "Grupo no registrado",
                        text: "El grupo ingresado no existe en el registro. ¿Deseas agregarlo?",
                        icon: "info",
                        buttons:  ["Cancelar", "Agregar"] 
                    })
                    .then((agregar) => {
                        if (agregar) {

                            '.
                                $insertar = "INSERT INTO grupos (nombre, num_empleado, generacion)
                                            VALUES ('$n_gru', '$n_doc', '$gen')";

                                $agrega = mysqli_query($conn, $insertar);
                                if ($agrega) {
                                    echo '<script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                                    echo 
                                    '<script>
                                        swal({
                                            title: "Grupo agregado",
                                            text: "El nuevo grupo con su generación se ha agregado correctamente.",
                                            icon: "success"
                                        })
                                    </script>';
                                } 

                                else {
                                    echo '<script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                                    echo 
                                    '<script>
                                        swal({
                                            title: "Error inesperado.",
                                            text: "El grupo no ha podido agregarse. Inténtelo más tarde.",
                                            icon: "error"
                                        })
                                    </script>';
                                }
                            '
                        }
                    });
                </script>';
            }
        }
    ?>

    <?php
        if(isset($_POST['btn_ver'])){
            $n_gru = $_POST['grupo'];
            $gen = $_POST['generacion'];
            $n_doc = $_POST['docente'];
            $alumnos = [];
        
            $ver = "SELECT grupos.nombre AS G_nombre, 
                    docentes.paterno, docentes.materno, docentes.nombre, 
                    usuarios.Paterno, usuarios.Materno, usuarios.Nombres 
                    FROM usuarios
                    JOIN grupos
                    ON usuarios.id_grupo = grupos.id_grupo
                    JOIN docentes 
                    ON grupos.num_empleado = docentes.num_empleado
                    WHERE grupos.nombre = '$n_gru' 
                        AND grupos.num_empleado = '$n_doc' 
                        AND usuarios.generacion = '$gen' 
                        AND grupos.generacion = '$gen'";

            $resultado = mysqli_query($conn, $ver);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                while ($row = mysqli_fetch_assoc($resultado)) {
                    $g_grupo = $row['G_nombre'];
                    $n_docente = $row['paterno'] . ' ' . $row['materno'] . ' ' . $row['nombre']; 
                    $alumnos[] = [
                        'Paterno' => $row['Paterno'],
                        'Materno' => $row['Materno'],
                        'Nombre' => $row['Nombres']
                    ];
                }
            } 
            else {
                echo "No se encontraron resultados.";
            }
        }
    ?>

    <table>
        <thead>
            <tr>
                <th colspan="2" style="text-align: center;">Grupo: <?php echo $g_grupo ?></th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th colspan="2" style="text-align: center;">Docente: <?php echo $n_docente ?></th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th>Apellidos</th>
                <th>Nombre</th>
                <th>Modificar</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($alumnos as $alumno) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($alumno['Paterno']) . " " . htmlspecialchars($alumno['Materno']) . "</td>";
                    echo "<td>" . htmlspecialchars($alumno['Nombre']) . "</td>"; 
                    echo "<td style='text-align: center;'><button onclick=\"window.location.href='ModificarAlumno.php'\">M</button></td>"; 
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>
