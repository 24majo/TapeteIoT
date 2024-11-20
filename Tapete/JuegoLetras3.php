<?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "tapeteiot");

	if ($conn->connect_error) {
		die("Error de conexión: " . $conn->connect_error);
	}

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

		$juego = "SELECT num_juego FROM JUEGOS WHERE num_juego = 9";
		$n_juego = $conn->query($juego);
		if ($n_juego && $n_juego->num_rows > 0) {
            $juego1 = $n_juego->fetch_assoc();
            $num_juego = $juego1['num_juego'];
        } 
		
		else {
            $num_juego = null;
        }

		if ($num_juego != null) {
            // Verificar si el registro ya existe en la tabla 'registro_juegos'
            $consulta = "SELECT COUNT(*) FROM progreso_alumno WHERE CURP = ? AND num_juego = ?";
            $stmt = $conn->prepare($consulta);
            $stmt->bind_param("si", $curp, $num_juego);
            $stmt->execute();
            $stmt->bind_result($exists);
            $stmt->fetch();
            $stmt->close();

            if ($exists == 0) {
                $progreso = 0; 
                $puntaje = 0; 

                $insertar = "INSERT INTO progreso_alumno (CURP, num_juego, progreso, puntaje) 
                            VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($insertar);
                $stmt->bind_param("siii", $curp, $num_juego, $progreso, $puntaje);

                if ($stmt->execute()) {
                    echo "Progreso guardado.";
                } 
				else {
                    echo "Error al registrar los datos del juego: " . $stmt->error;
                }

                $stmt->close();
            } 
        } 
		
		else {
            echo "No se ha encontrado un juego para este usuario.";
        }
    } 
    
    else {
        echo "<h3>No has iniciado sesión. Por favor, <a href= '../index.php'>inicia sesión</a>.</h3>";
        exit; 
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/StyleJuegoLetras3.css">

    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/funciones/letras/comprension.js"></script>
    <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Barra Lateral -->
		<link rel="stylesheet" href="css/BarraLateral.css">

    <title>Comprensión lectora</title>
</head>


<body background="Visual/Fondos/FondoJuegos.jpg">
 <!----------------- Barra lateral --------------------------------->
<div class="barraM" >
    <div class="mini-barra" style="position: relative; z-index: 103;">
        <font face="Century Gothic">
        <div class="nombre-pagina">
            <img class="menu" id="menu" src="Visual/Material/Iconos/barra-menu.png" width="50px">
            <span>DiDit</span>
        </div>
        <button class="boton" onclick="location.href = 'MenuSeleccion.php'">
            <img class="inicio" id="inicio" src="Visual/Material/Iconos/MenuInicio.png" width="50px">
            <span>Inicio</span>
        </button>

        <button class="boton" onclick="location.href = 'JuegosLetras.html'">
            <img class="regresar" id="regresar" src="Visual/Material/Iconos/Flecha.png" width="40px">
            <span>Menú de letras</span>
        </button>

        <button class="boton" onclick="location.href = 'DificultadLectura.html'">
            <img class="modo" id="modo" src="Visual/Material/Recursos/Semaforo.png" width="50px">
            <span>Dificultad</span>
        </button>
        
        <button class="boton" onclick="Ayuda()">
            <img class="inicio" id="inicio" src="Visual/Material/Iconos/ayuda.png" width="40px">
            <span>Ayuda</span>
        </button>
    </div>
</font>
</div>
<!---------------------- Fin de barra lateral ----------------------------->

<!-- Barra de progreso, atributos -->
 <div style="margin-left: 790px; margin-top: -280px">
    <progress style="height: 80px; width:380px;" id="barra" max="10" value="0"></progress>
</div>
<!-- Vidas -->
<div>
    <div class="vidas" id="vida"></div>
</div>

<img  class="semaforo" id="semaforo" alt=""  width="100">

<div class="botones">
    <font face="Century Gothic">
        <button id="btnIniciar" class="btn" onclick="Empezar()"><b>Empezar</b></button>
        <button id="btnReiniciar" onclick="Reinicio()"><b>Reiniciar</b></button>
    </font>
</div>

<nav>
        <div class="titulo">
            <Font face="Century Gothic">
                <p>Lee la lectura y contesta la preguntas<p>
            </Font>
        </div>
        
            <div class="pregunta">
                <font face="Century Gothic">
                    <span  id="pregunta"></span>
                </font>
            </div>
    
        </nav>
        <main>
                <div class="tituloCuento" style="z-index: -1000;">
                    <font face="Century Gothic">
                        <b><span id="titulo"></span></b>
                    </font>
                </div>

                <div class="btnOpciones" id="aparecer">
                    <div style="margin-top: 100px;">
                        <font face="MV Boli">
                            <span id="opcionArriba" class="opcion"></span>
                            <span id="opcionAbajo" class="opcion"></span>
                            <span id="opcionIzquierda" class="opcion"></span>
                            <span id="opcionDerecha" class="opcion"></span>
                        </font>
                    </div>
                    
                    <div>
                        <img class="dibujo" id="cuento" alt="" width="200">
                    </div>
                </div>

                <section class="parrafo" style="z-index: -100">
                    <font face="Century Gothic">
                        <p id="parrafo"></p>
                    </font>
                </section>
        </main>

   
        <div class="btnOpciones" id="aparecer">
            <div style="margin-top: 100px;">
                <font face="MV Boli">
                    <span id="opcionArriba" class="opcion"></span>
                    <span id="opcionAbajo" class="opcion"></span>
                    <span id="opcionIzquierda" class="opcion"></span>
                    <span id="opcionDerecha" class="opcion"></span>
                </font>
            </div>
            
        </div>
        
    <script src="js/Barra.js"></script>        
    <script src="js/funciones/letras/comprension.js"></script>
</body>
</html>