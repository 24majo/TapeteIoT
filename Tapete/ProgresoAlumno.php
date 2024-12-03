<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="Visual/Material/DiDitV2.png" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styleProgresoAlum.css">

    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>

    <title>Progreso</title>

    <style>
    @keyframes rellenar{
        to{
            stroke-dasharray: var(--porcentaje) 100;
        }
    }

    .porcentajes{
        position:relative;
    }
    .porcentajes span{
        position: absolute;
        top: 0%;
        left: 0%;
        bottom: 0%;
        right: 0%;
        display: flex;
        align-items: center;
        justify-content: center;
        font: 25px/1em Verdana;
    }

    circle{
        fill: none;
        stroke-width: 20;
        transform: rotate(-90deg);
        transform-origin: 50%;
        stroke-dasharray: 100 100;
        stroke: #AAA;
    }
    circle:nth-child(2){ /* el segundo círculo, es el que se ve por encima del anterior y debe tener el color mas intenso y el area del porcentaje */
        stroke: var(--color);
        stroke-dasharray: 0 100;
        animation: rellenar .35s linear forwards;
    }
  </style>
</head>
<body background="Visual/Fondos/FondoPerfilUsuario.jpg">
    <?php 
        include'conexiones/conexion.php';
        session_start();
    
        if (isset($_SESSION['CURP'])) {
            $curp = $_SESSION['CURP'];
            $nombre = "SELECT Nombres from usuarios WHERE CURP = '$curp'";
            $r_nombre = $conn -> query($nombre);
            $nombreF = $r_nombre->fetch_assoc();
            $name = $nombreF['Nombres'];
    
            $sexo = substr($curp, -8, 1);
    
            if($sexo == "M"){
                $imagen = "Visual/Material/Recursos/SesionNiña.png";
            }
            else if ($sexo == "H"){
                $imagen = "Visual/Material/Recursos/SesionNiño.png";
            }
        }
        else {
            echo "<h3>No has iniciado sesión. Por favor, <a href= '../index.html'>inicia sesión</a>.</h3>";
            exit; 
        }
    ?>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div style="background-color:#FF931E; height:80px; margin-top:-6px;" class="container-fluid">
            <img style="margin-left:5%;" class="sexo" id="sexo" src="<?php echo $imagen; ?>" width="60px">&nbsp;&nbsp;    
            <span  style="color:white; font-size: 28px;" class="navbar-brand">Mi perfil</span>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
            
            </div>
                <button onclick="window.location.href='ContraseñaAlumno.php'">Cambiar contraseña</button>
                <a style="color:white; font-size: 20px; margin-left:65%;" href="conexiones/cerrar_sesion.php">Cerrar sesión</a>
            </div>
        </div>
    </nav>

    <section>
        <div class="titulo">
            <h1 style="font-size: 50px;"><?php echo $name; ?></h1>
        </div>

       <!-- PROMEDIOS CIRCULOS: -->
       <div class="container text-center">
        <span class="tituloProm">Promedios</span><br><br>
        <div  class="row justify-content-md-center">
        <span><b>General:</b></span>&nbsp;
        <?php
            $sql = "SELECT puntaje FROM progreso_alumno where CURP = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $curp);
            $stmt->execute();
            $result = $stmt->get_result();
            $puntaje = [];

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $puntaje[] = $row['puntaje'];
                }

                if (count($puntaje) > 0) {
                    $promedio = array_sum($puntaje) / count($puntaje);
                    echo number_format($promedio, 1);
                    if ($promedio < 6) {
                        $color = '#FF0060';
                    } elseif ($promedio >= 6.1 && $promedio <= 8) {
                        $color = '#37b83d'; 
                    } else {
                        $color = '#6C9BCF';
                    }
                    echo
                        '<div class="col-md-auto porcentajes" style="--porcentaje: '.number_format($promedio, 1).'; --color: '.$color.'">
                            <svg width="150" height="150">
                                <circle r="65" cx="50%" cy="50%" pathlength="10" />
                                <circle r="65" cx="50%" cy="50%" pathlength="10" />
                            </svg>
                        </div>';
                } 
            } 
            else {
                echo "<span>Sin datos de este alumno</span>";
            }
        ?>
        <br>
        <span><b>Números:</b></span>&nbsp;
        <?php
            $sql = "SELECT progreso_alumno.puntaje
                    FROM progreso_alumno
                    JOIN juegos
                    ON progreso_alumno.num_juego = juegos.num_juego
                    WHERE progreso_alumno.CURP = ? 
                    AND juegos.categoria = 'Números'";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $curp);
            $stmt->execute();
            $result = $stmt->get_result();
            $puntaje = [];

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $puntaje[] = $row['puntaje'];
                }

                if (count($puntaje) > 0) {
                    $promedio = array_sum($puntaje) / count($puntaje);
                    echo number_format($promedio, 1); 
                    if ($promedio < 6) {
                        $color = '#FF0060';
                    } elseif ($promedio >= 6.1 && $promedio <= 8) {
                        $color = '#37b83d'; 
                    } else {
                        $color = '#6C9BCF';
                    }
                    echo
                        '<div class="col-md-auto porcentajes" style="--porcentaje: '.number_format($promedio, 1).'; --color: '.$color.'">
                            <svg width="150" height="150">
                                <circle r="65" cx="50%" cy="50%" pathlength="10" />
                                <circle r="65" cx="50%" cy="50%" pathlength="10" />
                            </svg>
                        </div>';
                } 
            } 
            else {
                echo "<span>Sin datos de este alumno</span>";
            }
        ?>
        <br>
        <span><b>Letras:</b></span>&nbsp;
        <?php
            $sql = "SELECT progreso_alumno.puntaje
                    FROM progreso_alumno
                    JOIN juegos
                    ON progreso_alumno.num_juego = juegos.num_juego
                    WHERE progreso_alumno.CURP = ? 
                    AND juegos.categoria = 'Letras'";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $curp);
            $stmt->execute();
            $result = $stmt->get_result();
            $puntaje = [];

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $puntaje[] = $row['puntaje'];
                }

                if (count($puntaje) > 0) {
                    $promedio = array_sum($puntaje) / count($puntaje);
                    echo number_format($promedio, 1); 
                    if ($promedio < 6) {
                        $color = '#FF0060';
                    } elseif ($promedio >= 6.1 && $promedio <= 8) {
                        $color = '#37b83d'; 
                    } else {
                        $color = '#6C9BCF';
                    }
                    echo
                        '<div class="col-md-auto porcentajes" style="--porcentaje: '.number_format($promedio, 1).'; --color: '.$color.'">
                            <svg width="150" height="150">
                                <circle r="65" cx="50%" cy="50%" pathlength="10" />
                                <circle r="65" cx="50%" cy="50%" pathlength="10" />
                            </svg>
                        </div>';
                } 
            } 
            else {
                echo "<span>Sin datos de este alumno</span>";
            }
        ?>
        </div>
     </div>
     <!-- FIN PROMEDIO CIRCULOS -->
    
        

    <!-- INICIO TABLA NUMEROS-->
     <br><br><br>
     <div class="tablaNum">
        <div class="tituloJuegos">
            <span>Juego de números</span>
        </div>
        <br>
    <div class="tablaPNum">
   <table >
        <thead>
            <tr>
                <th>Nombre del juego</th>
                <th>Progreso</th>
                <th>Calificación</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT juegos.nombre, progreso_alumno.progreso, progreso_alumno.puntaje
                FROM progreso_alumno 
                JOIN juegos
                ON progreso_alumno.num_juego = juegos.num_juego
                WHERE progreso_alumno.CURP = ? AND juegos.categoria = 'Números'";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $curp);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo "<td>" . $row['nombre'] . "</td>";
                        echo '<td> <progress style="height: 80px; width:320px;"  id="barra" max="10" value="'.$row['progreso'].'"></progress></td>';
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
   </div>
   </div>
    <!-- FIN TABLA NUMEROS -->

    <!-- INICIO TABLA LETRAS -->
     <div class="tablaLet">
    <div class="tituloJuegos"> 
        <span>Juego de Letras</span>
    </div>
    <br>
    <div class="tablaPNum">
    <table>
        <thead>
            <tr>
                <th>Nombre del juego</th>
                <th>Progreso</th>
                <th>Calificación</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $letras = "SELECT juegos.nombre, progreso_alumno.progreso, progreso_alumno.puntaje
                FROM progreso_alumno 
                JOIN juegos
                ON progreso_alumno.num_juego = juegos.num_juego
                WHERE progreso_alumno.CURP = ? AND juegos.categoria = 'Letras'";
                $stmt = $conn->prepare($letras);
                $stmt->bind_param("s", $curp);
                $stmt->execute();
                $r_letras = $stmt->get_result();

                if ($r_letras->num_rows > 0) {
                    while($row = $r_letras->fetch_assoc()) {
                        echo '<tr>';
                        echo "<td>" . $row['nombre'] . "</td>";
                        echo '<td> <progress style="height: 80px; width:320px;"  id="barra" max="10" value="'.$row['progreso'].'"></progress></td>';
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
    </div>
    </div>
    <!-- FIN TABLA LETRAS -->
    </section>
</body>
</html>

