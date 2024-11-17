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

		$juego = "SELECT num_juego FROM JUEGOS WHERE num_juego = 1";
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
		<!-- Barra Lateral -->
		<link rel="stylesheet" href="css/BarraLateral.css">
		<link rel="stylesheet" href="css/StyleJuegoNum1.css">
		
		
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
			<div style="margin-left: 750px; margin-top: -250px">
				<progress style="height: 80px; width:380px;" id="barra" max="10" value="0"></progress>
			</div>
			
			<div id="vida" class="vidas"></div>	

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
					<button class="btnIniciar" onclick="Random()"><b>Empezar</b></button>
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
		
		<!-- <script src="js/funciones/numeros/juego1.js"></script> -->
		<script src="js/Barra.js"></script>
		<script>
			var correcta = 0
			var arreglo_f = []
			var opciones = document.getElementsByClassName("opcion")
			contador = 0
			var imagen = document.getElementById('vida');
			imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
			var error = 3
			var puntaje = 10
			
			Ayuda()

			function Progreso(progreso,puntaje){
			    $.ajax({
			        url: 'conexiones/actualizar_progreso_a.php',  
			        type: 'POST',
			        data: {
			            progreso: progreso, 
						puntaje: puntaje,
			            num_juego: <?php echo $num_juego; ?>,
			        },
			        success: function(response) {
			            console.log('Progreso actualizado');
			        },
			        error: function(xhr, status, error) {
			            console.error('Error al actualizar el progreso: ' + error);
			        }
			    });
			}

			function apretar(numero){
				if(arreglo_f[numero]== correcta){
					//opciones[numero].style.backgroundColor = '#f958a5'
					contador++
					document.getElementById("barra").value = contador
					document.getElementById("barra").innerHTML = contador

					Progreso(contador, puntaje)

					if(contador == 10){
						Progreso(contador, puntaje)
						swal({
							title: "¡Ganador!",
							text: "Has superado la prueba. ¿Deseas salir o reiniciar el juego?",
							icon: "Visual/Material/Animaciones/Generales/PolloBien (2).gif",
							buttons:  ["Continuar", "Salir"],
						})
						.then((willDelete) => {
							if (willDelete) {
								location.href = "JuegosNumeros.html"
							} 
							else{
								Reiniciar()
							}
						})
						//alert("Ganaste")
					}
					//document.getElementById("cont").innerHTML = "Aciertos: " + contador
				}

				else{
					error--
					if(error == 2){
						imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon2.png" width="100">'
						puntaje = 6.6
					}

					if(error == 1){
						imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon1.png" width="100">'
						puntaje = 3.3
					}

					if(error == 0){
						imagen.innerHTML = ""
						puntaje = 0

						swal({
							title: "Perdiste:(",
							text: "Has perdido todas tus vidas. ¿Deseas salir o reiniciar?",
							icon: "Visual/Material/Animaciones/Generales/error.jpg",
							buttons:  ["Reintentar", "Salir"],
							dangerMode: true,
						})
						.then((willDelete) => {
							if (willDelete) {
								location.href = "JuegosNumeros.html"
							} 
							else{
								//document.getElementById("btnIniciar").innerHTML = "Empezar"
								Reiniciar()
							}
						})
					}
					// error -= 1
					// document.getElementById("error").innerHTML = "Errores: " + error 

					// if(error == 0){
					//     alert("Chin")
					//     Random()
					// }
				}
			}

			function Reinicio(){
				swal({
					title: "Reiniciar juego",
					text: "Si reinicias ahora, el progreso se perderá. ¿Deseas continuar?",
					icon: "Visual/Material/Animaciones/Generales/advertencia.jpg", // En este apartado se puede poner la ruta de las imágenes
					buttons: true, // Como si fuera arreglo, se pueden agregar más botones con texto 
					dangerMode: true, // Botón rojo
				})

				.then((Reinicia) => {
					if (Reinicia) {
						Reiniciar()
					} 
				});
			}

			function Reiniciar(){
				contador = 0
				error = 3
				//document.getElementById("cont").innerHTML = "Aciertos: " + 
				document.getElementById("barra").value = contador
				document.getElementById("barra").innerHTML = contador
				imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
				//document.getElementById("error").innerHTML = "Errores: 3"
				Random()
			}

			function Random(){
				var arreglo = OpRandom()
				console.log("Arreglo: ", arreglo)

				for(var i = 0; i < arreglo.length; i++){
					//opciones[i].style.backgroundColor = '#ff99ff' 
					opciones[i].innerHTML = arreglo[i]
				} 

				document.getElementById('aparecer').style.display='block';
			}

			window.addEventListener("keydown",(e)=>{
				let tecla = e.key
				switch(tecla){
					case 'ArrowUp':
						apretar(0)
						break;

					case 'ArrowDown':
						apretar(1)
						break;

					case 'ArrowLeft':
						apretar(2)
						break;

					case 'ArrowRight':
						apretar(3)
						break;

					default:
						break;
				}
			})

			window.addEventListener("keyup",(e)=>{
				let tecla = e.key

				switch(tecla){
					case 'ArrowUp':
						repetir = Random()
						break;

					case 'ArrowDown':
						repetir = Random()
						break;

					case 'ArrowLeft':
						repetir = Random()
						break;

					case 'ArrowRight':
						repetir = Random()
						break;

					default:
						break;
				}
				
			})

			function OpRandom(){ // Asignar 4 números aleatorios a los círculos
				var arreglo = [] // Arreglo de apoyo 
				var aux = 0
				var resultado = Math.floor(Math.random() * (99-1)+1)
				var ex = false
				
				while (arreglo.length < 4){
					var existe = false
					var n = Math.floor(Math.random() * (99-1)+1)// Valores random del 1 al 9
					
					for(var i = 0; i <arreglo.length; i++){
						if(arreglo[i] == n){ // Si el numero random se encuentra en el arreglo
							existe = true
							break
						}
					}
					
					if(!existe){
						arreglo.push(n) // Se agrega el numero random al arreglo para evitar repetirse
						aux++
					}
				}
				
				for(var i = 0; i <arreglo.length; i++){
					if(arreglo[i] == resultado){
						ex = true
						break
					}
				}
				
				if(!ex){
					var num = Math.floor(Math.random() * 4)
					arreglo[num] = resultado
				}
				
				var imagen = document.getElementById("img")
				imagen.src = "Visual/Material/Numeros/Juego5/" + resultado + ".jpg"
				arreglo_f = arreglo
				correcta = resultado
				return arreglo
			}

			function Ayuda(){
				swal({
					title: "Tutorial",
					text: "Cuenta la cantidad de peces que están en la pecera. Elige la opción correcta por medio de las teclas ↑ ↓ → ← o los botones del tablero.",
					icon: "Visual/Material/Animaciones/Generales/teclas.jpg"
				})
				// swal("Tutorial", 
				//     "Realiza la resta de dos números y elige la opción correcta con los botones o las flechas del teclado.");
			}

		</script>
	</body>
</html>

