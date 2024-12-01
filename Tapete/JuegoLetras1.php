<?php
    $num_juego = 7;
	include'conexiones/agregar_juego.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styleJuegoLetras1.css">
    <link rel="stylesheet" href="css/BarraLateral.css">

    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery-3.7.1.min.js"></script>
    <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>

    <title>Vocales</title>
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
    </div>
  </font>
  </div>
<!---------------------- Fin de barra lateral ----------------------------->
    
    <nav>

        <div style="margin-left: 700px; margin-top: -350px">
            <progress style="height: 80px; width:380px;" id="barra" max="10" value="0"></progress>
        </div>
    
        <div class="vidas">
            <div id="vida"></div>
        </div>

        <audio id="audio" preload="auto" loop >
            <source src="audio/audio4.mp3" type="audio/mpeg">
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
                <h1><b>Completa la palabra</b></h1>
            </Font>
        </div>
<!--         
        <div  class="btnMenus">
            <a href="MenuSeleccion.html">
                <img src="Visual/Material/Iconos/MenuInicio.png" class="btnInicio" width="70px">
            </a>
            <a href="JuegosComPalab.html" >
                <img src="Visual/Material/Iconos/Flecha.png" class="btnAtras" width="60px">
            </a>  
            <button style="margin-top: 10px;" id="btnAyuda" class="btnAyuda" onclick="Ayuda()"><b>?</b></button>  
        </div> -->
    </nav>

   
    <section>
        <article class="dibujo">
            <img class="imagen" id='figura' width="250px" height="250px">
        </article>
    </section>

    <div class="palabraCompletar">
        <font face="Century Gothic">
            <span id="palabra"></span>
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
    <script src="js/funciones/letras/vocales.js">
    </script>
</body>
</html>