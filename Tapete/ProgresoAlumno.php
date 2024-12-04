<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="Visual/Material/Didit.png" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styleProgresoAlum.css">

    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>

    <title>Progreso</title>

    <style>
        :root{
            --color-primary: #6C9BCF;
            --color-danger: #FF0060;
            --color-success: #1B9C85;
            --color-info-dark: #7d8da1;
            --color-dark: #363949;
            --color-light: rgba(132, 139, 200, 0.18);
            --color-dark-variant: #677483;
            --color-background: #f6f6f9;
            --card-border-radius: 2rem;
            --border-radius-1: 0.4rem;
            --border-radius-2: 1.2rem;
            --card-padding: 1.8rem;
            --padding-1: 1.2rem;
            --box-shadow: 0 2rem 3rem var(--color-light);
        }

        .cartas{
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.6rem;
        }

        .cartas > div{
            background-color: #fff;
            padding: var(--card-padding);
            border-radius: var(--card-border-radius);
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
        }

        .cartas > div:hover{
            box-shadow: none;
        }

        .cartas > div .status{
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cartas h3{
            margin-left: 0.1rem;
            font-size: 1rem;
        }

        .cartas .grafica{
            position: relative;
            width: 92px;
            height: 80px;
            border-radius: 50%;
        }

        .cartas svg{
            width: 35rem;
            height: 7rem;
        }

        .cartas svg circle{
            fill: none;
            stroke-width: 10;
            stroke-linecap: round;
            transform: translate(5px, 5px) rotate(-90deg);
        }

        .cartas .general svg circle{
            stroke: var(--color-success);
        }

        .cartas .numeros svg circle{
            stroke: var(--color-danger);
        }

        .cartas .letras svg circle{
            stroke: var(--color-primary);
        }

        .cartas .grafica .numero{
            position: absolute;
            top: 8px;
            left: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            width: 100%;
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
                <button class="btnPass"  onclick="window.location.href='ContraseñaAlumno.php'">Cambiar contraseña</button>
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
        <!-- <span><b>General:</b></span>&nbsp; -->
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
                    $pro_gen = array_sum($puntaje) / count($puntaje);
                    $pro_gen = number_format($pro_gen, 1); 
                } 
            } 
            else {
                $pro_gen = 0;
                // echo "<span>Sin datos de este alumno</span>";
            }
        ?>
        <br>
        <!-- <span><b>Números:</b></span>&nbsp; -->
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
                    $pro_num = array_sum($puntaje) / count($puntaje);
                    $pro_num = number_format($pro_num, 1); 
                } 
            } 
            else {
                $pro_num = 0;
                // echo "<span>Sin datos de este alumnok</span>";
            }
        ?>
        <br>
        <!-- <span><b>Letras:</b></span>&nbsp; -->
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
                    $pro_let = array_sum($puntaje) / count($puntaje);
                    $pro_let = number_format($pro_let, 1); 
                } 
            } 
            else {
                $pro_let = 0;
                // echo "<span>Sin datos de este alumno</span>";
            }
        ?>

        <!-- Circulos promedios -->
        <div class="cartas">
                    <div class="general">
                        <div class="status">
                            <div class="info">
                                <h3>General</h3>
                            </div>
                            <div class="grafica">
                                <svg>
                                    <circle cx="-37" cy="47" r="36"
                                        style="stroke-dasharray: <?php echo 2 * 3.1416 * 36; ?>; 
                                        stroke-dashoffset: <?php echo 2 * 3.1416 * 36 * (1 - ($pro_gen * 10 / 100)); ?>;">
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
                                <h3>Números</h3>
                            </div>
                            <div class="grafica">
                                <svg>
                                    <circle cx="-37" cy="47" r="36"
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
                                <h3>Letras</h3>
                            </div>
                            <div class="grafica">
                                <svg>
                                    <circle cx="-37" cy="47" r="36"
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

