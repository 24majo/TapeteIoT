<?php
    $num_juego = 1;
	include'conexiones/agregar_juego.php';
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Barra Lateral -->
		<link rel="stylesheet" href="css/BarraLateral.css">
		<link rel="stylesheet" href="css/StyleJuegoNum1.css">
		<link rel="shortcut icon" href="Visual/Material/Numeros/Seleccion/ImgAdivinaNum.jpg" type="image/x-icon">
		
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery-3.7.1.min.js"></script>
		<script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>
		<title>Selecciona el número</title>
	</head>
	
	<body background="Visual/Fondos/FondoJuegos.jpg">

		<!-- Inicio de barra lateral -->
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

					<!-- <button class="boton" onclick="location.href = 'DificultadLectura.html'">
						<img class="modo" id="modo" src="Visual/Material/Recursos/Semaforo.png" width="50px">
						<span>Dificultad</span>
					</button> -->
					
					<button class="boton" onclick="Ayuda()">
						<img class="inicio" id="inicio" src="Visual/Material/Iconos/ayuda.png" width="40px">
						<span>Ayuda</span>
					</button>
				</div>
			</font>
		</div>

		<nav>
			<div style="margin-left: 700px; margin-top: -300px">
				<progress style="height: 80px; width:380px;" id="barra" max="10" value="0"></progress>
			</div>
			
			<div id="vida" class="vidas"></div>	

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

			<div class="titulo" style="z-index: -10;">
				<font face="Century Gothic">
					<h1 class="font-weight-bold">¿Cuántas peces hay en la pecera?</h1>
				</font>
			</div>

			<div class="peces">
				<img src="Visual/Material/Numeros/Juego5/PezUnidad.png" width="80" alt=""> × 1
				<img src="Visual/Material/Numeros/Juego5/PezDecena.png" width="80" alt=""> × 10
			</div>
		</nav>

		<article>
			<section class="botones">
				<font face="Century Gothic">
					<button  id="btnIniciar" class="btnIniciar" onclick="Random()"><b>Empezar</b></button>
					<button class="btnReiniciar" onclick="Reinicio()"><b>Reiniciar</b></button>
				</font>
			</section>
				
			<section>
				<img class="imagen" id='img' width="400">
			</section>
		</article>
	
		<aside>
			<div class="btnOpciones">
				<b>
					<div id="aparecer">
						<font face="MV Boli">
							<div class="opciones">
								<span id="arr" class="opcion"></span>
								<span id="ab" class="opcion"></span>
								<span id="izq" class="opcion"></span>
								<span id="der" class="opcion"></span>
							</div>
						</font>
					</div>
				</b>
			</div>
		</aside>
		
		<script src="js/funciones/numeros/juego1.js"></script>
		<script src="js/Barra.js"></script>
		<script src="js/audio.js"></script>
	</body>
</html>

