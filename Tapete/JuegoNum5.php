<?php
    $num_juego = 5;
	include'conexiones/agregar_juego.php';
?>

<!DOCTYPE html>
<html lang="es">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/StyleJuegoNum5.css">
      <link rel="stylesheet" href="css/BarraLateral.css">
      <link rel="shortcut icon" href="Visual/Material/Numeros/Seleccion/ImgCompletarDecenas.jpg" type="image/x-icon">
      <script src="js/bootstrap.min.js"></script>
      <script src="js/jquery-3.7.1.min.js"></script>
      <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>

      <title>Completar decenas</title>
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
  
        <button class="boton" onclick="location.href = 'DificultadDecenas.html'">
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
        <div style="margin-left: 700px; margin-top: -340px">
            <progress style="height: 80px; width:380px;" id="barra" max="10" value="0"></progress>
        </div>

        <div class="vidas" id="vida"></div>

        <audio id="audio" preload="auto" loop >
				<source src="audio/audio1.mp3" type="audio/mpeg">
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
                <p><b>Completa la decena</b></p>
            </Font>
        </div>

        <!-- <div class="btnMenus">
            <a href="MenuSeleccion.html" class="btnInicio">
                <img src="Visual/Material/Iconos/MenuInicio.png" width="70px">
            </a>
            <a href="DificultadDecenas.html" class="btnAtras">
                <img src="Visual/Material/Iconos/Flecha.png" width="60px">
            </a>
        </div>
        
        <div style="margin-top: -180px;"> 
            <button class="btnAyuda" id="btnAyuda" onclick="Ayuda()"><b>?</b></button>
        </div> -->

        <img class="semaforo" id="semaforo" alt=""  width="100">
        <!--
        Fácil: Números del 1 al 49
        Medio: Números del 50 al 99
        Difícil: Revuelto
        -->
        <div class="peces">
            <img src="Visual/Material/Numeros/Juego5/PezUnidad.png" width="80" alt=""> × 1
            <img src="Visual/Material/Numeros/Juego5/PezDecena.png" width="80" alt=""> × 10
        </div>
    </nav>
      
    <section>
        <div class="dibujo">
            <div id="pecera"></div>
        </div>
    </section>


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
    <script src="js/funciones/numeros/juego5.js"></script>
  </body>
</html>