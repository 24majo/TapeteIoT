<?php
    $num_juego = 9;
	include'conexiones/agregar_juego.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/StyleJuegoLetras3.css">
    <link rel="shortcut icon" href="Visual/Material/Letras/Seleccion/ImgLectura.jpg" type="image/x-icon">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
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
 <div style="margin-left: 700px; margin-top: -350px">
    <progress style="height: 80px; width:380px;" id="barra" max="10" value="0"></progress>
</div>
<!-- Vidas -->
<div>
    <div class="vidas" id="vida"></div>
</div>

<audio id="audio" preload="auto" loop >
				<source src="audio/lectura.mp3" type="audio/mpeg">
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
    <script src="js/audio.js"></script>        
    <script src="js/funciones/letras/comprension.js"></script>
</body>
</html>