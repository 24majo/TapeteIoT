<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Barra Lateral -->
     <link rel="stylesheet" href="css/BarraLateral.css">
     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="css/styleJuegoLetras8.css">

    <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/query-3.7.1.min.js"></script>

    <title>Sílabas trabadas</title>
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

        <button class="boton" onclick="location.href = 'JuegosTrabados.html'">
            <img class="modo" id="modo" src="Visual/Material/Letras/Seleccion/ImgSilabasTrabadas.jpg" width="40px">
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

    
   
    <div style="margin-left: 800px; margin-top: -280px">
        <progress style="height: 80px; width:380px;" id="barra" max="12" value="0"></progress>
    </div>

    <nav>
        <div>
            <div class="vidas" id="vida"></div>
        </div>

        <div  class="titulo">
            <font face="Century Gothic">
                <h1><b>¿Cómo se escribe la palabra?</b></h1>
            </font>
        </div>
       
    </nav>

    <article>
        <section>
            <center>
                <img class="imagen" id='imagen' width="150px" height="150px">
                <font>
                    <div class="palabra" id="linea"></div>
                </font>
                
            </center>
            
            
        </section>

        <div class="botones">
            <font face="Century Gothic">
                <button id="btnIniciar" onclick="Empezar()"><b>Empezar</b></button>
                <button id="btnReiniciar" onclick="Reinicio()"><b>Reiniciar</b></button>
            </font>  
        </div>
    </article>

            <center>
                <div class="tabla">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2" id="opcion1">Valor 1</th>
                                <th colspan="2" id="opcion2">Valor 2</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <tr>
                                <td><img class="tabla1" src="" width="100px" height="100px" alt=""></td>
                                <td><img class="tabla1" src="" width="100px" height="100px" alt=""></td>
                                <td><img class="tabla2" src="" width="100px" height="100px" alt=""></td>
                                <td><img class="tabla2" src="" width="100px" height="100px" alt=""></td>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                                <td><img class="tabla1" src="" width="100px" height="100px" alt=""></td>
                                <td><img class="tabla1" src="" width="100px" height="100px" alt=""></td>
                                <td><img class="tabla2" src="" width="100px" height="100px" alt=""></td>
                                <td><img class="tabla2" src="" width="100px" height="100px" alt=""></td>
                            </tr>

                            <tr>
                                <td><img class="tabla1" src="" width="100px" height="100px" alt=""></td>
                                <td><img class="tabla1" src="" width="100px" height="100px" alt=""></td>
                                <td><img class="tabla2" src="" width="100px" height="100px" alt=""></td>
                                <td><img class="tabla2" src="" width="100px" height="100px" alt=""></td>
                            </tr>

                            <tr>
                                
                            </tr> 
                        </tbody>
                    
                    </table>
                    </div>
            </center>
       
            <div class="btnOpciones">
                <div id="circulos" >
                    <font face="MV Boli">
                        <span id="opcionIzquierda" class="opcion"></span>
                        <span id="opcionDerecha" class="opcion"></span>
                    </font>
                </div>
            </div>
</body>

    <script src="js/Barra.js"></script>
    <script src="js/funciones/letras/trabadas.js"></script>
</html>