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

		$juego = "SELECT num_juego FROM juegos WHERE num_juego = 8";
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
    <link rel="stylesheet" href="css/styleJuegoLetras2.css">
    <link rel="stylesheet" href="css/BarraLateral.css">
    
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery-3.7.1.min.js"></script>
    <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>
    
    <title>Palabras</title>
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

        <button class="boton" onclick="location.href = 'ProgresoAlumno.php'">
            <img class="usuario" id="usuario" src="<?php echo $imagen; ?>" width="40px">
            <span>Usuario</span>
        </button>

        <button class="boton" onclick="location.href = 'MenuSeleccion.php'">
            <img class="inicio" id="inicio" src="Visual/Material/Iconos/MenuInicio.png" width="50px">
            <span>Inicio</span>
        </button>

        <button class="boton" onclick="location.href = 'JuegosLetras.html'">
            <img class="regresar" id="regresar" src="Visual/Material/Iconos/Flecha.png" width="40px">
            <span>Menú de letras</span>
        </button>
  
        <button class="boton" onclick="location.href = 'JuegosComPalab.html'">
            <img class="modo" id="modo" src="Visual/Material/Recursos/CambioLV.png" width="40px">
            <span>Dificultad</span>
        </button>
        
        <button class="boton" onclick="Ayuda()">
            <img class="inicio" id="inicio" src="Visual/Material/Iconos/ayuda.png" width="40px">
            <span>Ayuda</span>
        </button>
        </font>
    </div>
  </div>
<!---------------------- Fin de barra lateral ----------------------------->
    
    <nav>
        <div style="margin-left: 700px; margin-top: -350px">
            <progress style="height: 80px; width:380px;" id="barra" max="10" value="0"></progress>
        </div>
        
        <div class="vidas">
            <div id="vida"></div>
        </div>

        <div class="vidas" id="vida"></div>

    <audio id="audio" preload="auto" loop >
            <source src="audio/audio2.mp3" type="audio/mpeg">
        </audio>

        <audio id="audioCorrecto" preload="auto">
            <source src="audio/correcto.mp3" type="audio/mpeg">
        </audio>
        <audio id="audioIncorrecto" preload="auto">
            <source src="audio/incorrecto.mp3" type="audio/mpeg">
        </audio>

        <div>
            <img  id="silenciar" class="imgVolumen" src="Visual/Material/Recursos/ConVolumen.png" alt="">
            <input class="rango" type="range" id="volumen" min="0" max="1" step="0.1" value="1">
        </div>

        <div class="titulo">
            <Font face="Century Gothic">
                <p><b>Adivina la palabra</b></p>
            </Font>
        </div>
        
        <!-- <div class="btnMenus">
            <a href="MenuSeleccion.html" class="btnInicio">
                <img src="Visual/Material/Iconos/MenuInicio.png" width="70px">
            </a>
            <a href="JuegosComPalab.html" class="btnAtras">
                <img src="Visual/Material/Iconos/Flecha.png" width="60px">
            </a>
            <button class="btnAyuda" id="btnAyuda" onclick="Ayuda()"><b>?</b></button>
        </div> -->
     
    </nav>

    <section>
        <article class="dibujo">
            <img class="imagen" id='figura' width="250px" height="250px">
        </article>
    </section>

    <div class="palabraCompletar">
        <font face="Century Gothic">
            <span id="linea"></span>
        </font>
    </div>

    <div class="letras">
        <font face="Century Gothic">
            <button id="btnIniciar" onclick="Inicio()"><b>Empezar</b></button>
            <button id="btnReiniciar" onclick="Reinicio()"><b>Reiniciar</b></button>
            
        </font>  
    </div>

    <div id="circulos">
        <font face="MV Boli">
            <span id="opcionArriba" class="opcion"></span>
            <span id="opcionAbajo" class="opcion"></span>
            <span id="opcionIzquierda" class="opcion"></span>
            <span id="opcionDerecha" class="opcion"></span>
        </font>
    </div>
    

    <script src="js/Barra.js"></script>
    <script src="js/audio.js"></script>
    <script src="js/funciones/letras/adivinar.js"></script>
</body>
</html>