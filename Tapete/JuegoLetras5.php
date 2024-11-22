<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styleJuegoLetras5.css">

    <script src="js/bootstrap.min.js"></script>
	<script src="js/query-3.7.1.min.js"></script>
    <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Barra Lateral -->
    <link rel="stylesheet" href="css/BarraLateral.css">
    <title>Uso de R y RR</title>
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

        <button class="boton" onclick="location.href = 'DificultadUsoR.html'">
            <img class="modo" id="modo" src="Visual/Material/Recursos/Semaforo.png" width="50px">
            <span>Dificultad</span>
        </button>

        <button class="boton" onclick="location.href = 'JuegosUsoDe.html'">
            <img class="tipo" id="tipo" src="Visual/Material/Letras/Seleccion/ImgUsoDe.jpg" width="50px">
            <span>Modo de juego</span>
        </button>
        
        <button class="boton" onclick="Ayuda()">
            <img class="inicio" id="inicio" src="Visual/Material/Iconos/ayuda.png" width="40px">
            <span>Ayuda</span>
        </button>
    </div>
</font>
</div>
<!---------------------- Fin de barra lateral ----------------------------->

<div style="margin-left: 790px; margin-top: -350px">
    <progress style="height: 80px; width:380px;" id="barra" max="10" value="0"></progress>
</div>
<img  class="semaforo" id="semaforo" alt=""  width="100">

<div>
    <div  class="vidas" id="vida"></div>
</div>

    <nav class="titulo">
        <Font face="Century Gothic">
            <h1><b>Uso de R y RR</b></h1>
        </Font>
        <!-- <a href="MenuSeleccion.html" class="btnInicio">
            <img src="Visual/Material/Iconos/MenuInicio.png" width="70px">
        </a>
        <a href="JuegosLetras.html" class="btnAtras">
            <img src="Visual/Material/Iconos/Flecha.png" width="60px">
        </a> -->
        <!-- <button id="btnAyuda" onclick="Ayuda()"><b>?</b></button> -->
    </nav>
    

    <section>
        <article>
            <img class="imagen" id='figura' width="250px" height="250px">
            <font face="Century Gothic">
                <center>
                    <div class="palabra" id="linea"></div>
                </center>
                
            </font>
        
        </article>
    </section>


    <div class="botones">
        <font face="Century Gothic">
            <button id="btnIniciar" onclick="Empezar()"><b>Empezar</b></button>
            <button id="btnReiniciar" onclick="Reinicio()"><b>Reiniciar</b></button>
        </font>  
    </div>

    <div class="btnOpciones" id="aparecer">
        <div id="circulos" >
            <font face="MV Boli">
                <span id="opcionIzquierda" class="opcion"></span>
                <span id="opcionDerecha" class="opcion"></span>
            </font>
        </div>
    </div>
    <script src="js/funciones/letras/r-rr.js"></script>
    <script src="js/Barra.js"></script>

</body>
</html>