<?php
    $num_juego = 3;
	include'conexiones/agregar_juego.php';
?>

<!DOCTYPE html>
<html lang="es">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/StyleJuegoNum3.css">
       <!-- Barra Lateral -->
       <link rel="stylesheet" href="css/BarraLateral.css">
       <link rel="shortcut icon" href="Visual/Material/Numeros/Seleccion/ImgSumas.jpg" type="image/x-icon">
      <script src="js/bootstrap.min.js"></script>
      <script src="js/jquery-3.7.1.min.js"></script>
      <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>

      <title>Sumas</title>
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
  
        <button class="boton" onclick="location.href = 'JuegosNumeros.html'">
            <img class="regresar" id="regresar" src="Visual/Material/Iconos/Flecha.png" width="40px">
            <span>Menú de números</span>
        </button>
  
        <button class="boton" onclick="location.href = 'DificultadSumas.html'">
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

    <nav>
        <div style="margin-left: 700px; margin-top: -350px">
            <progress style="height: 80px; width:380px;" id="barra" max="10" value="0"></progress>
        </div>
    
        <div id="vida" class="vidas"></div>

        <audio id="audio" preload="auto" loop >
				<source src="audio/sumas.mp3" type="audio/mpeg">
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
                <h1><b>Realiza las siguientes sumas</b></h1>
          </Font>
          </div>
        
          <!-- <div style="margin-top: -140px; margin-left: 330px;">
            <button class="btnAyuda" id="Ayuda" onclick="Ayuda()"><b>?</b></button>
          </div> 
          <div class="btnMenus">
            <a href="MenuSeleccion.html" class="btnInicio">
                <img src="Visual/Material/Iconos/MenuInicio.png" width="70px">
            </a>
            <a href="DificultadSumas.html" class="btnAtras">
                <img src="Visual/Material/Iconos/Flecha.png" width="60px">
            </a>
          </div> -->

          <img class="semaforo" id="semaforo" alt=""  width="100">
        
    </nav>
    
    <div class="numSumas">
        <font face="Century Gothic">
            <span class="linea" id="linea_s"></span>
            <br>
            <span class="linea" id="linea_i" style="margin: -40px;"></span>
            <br>
        </font>
    </div>

    <div id="espera" class="polloEspera"></div>
    <div id="acierto" class="desaparecer polloBien"></div>
    <div id="incorrecto" class="desaparecer polloMal"></div>
      
    <div class="botones">   
        <font face="Century Gothic">
            <button id="btnIniciar" class="btn" onclick="Empezar()"><b>Empezar</b></button>
            <button id="btnReiniciar" onclick="Reinicio()"><b>Reiniciar</b></button>
        </font>
    </div>

    
      
    <div class="btnOpciones" id="aparecer">
        <font face="MV Boli">
            <span id="opcionArriba" class="opcion"></span>
            <span id="opcionAbajo" class="opcion"></span>
            <span id="opcionIzquierda" class="opcion"></span>
            <span id="opcionDerecha" class="opcion"></span>
        </font>
    </div>
    
    <script src="js/Barra.js"></script>
    <script src="js/audio.js"></script>
    <script src="js/funciones/numeros/juego3.js"></script>
  </body>
</html>