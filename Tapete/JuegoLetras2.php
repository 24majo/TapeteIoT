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
        <div style="margin-left: 750px; margin-top: -280px">
            <progress style="height: 80px; width:380px;" id="barra" max="10" value="0"></progress>
        </div>
        
        <div class="vidas">
            <div id="vida"></div>
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
    <!-- <script src="js/funciones/letras/adivinar.js"></script> -->

    <script src="js/Barra.js"></script>
    <script>
        const palabras = ["cereza", "chocolate", "fresa", "gato","helado","libro","manzana", "pastel", "pelota", "peluche","pera","perro","pizza","pollo","tortuga"]
        const letras = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
        var opciones = document.getElementsByClassName("opcion")
        var guion = []
        var respuesta 
        var result
        var palabras2 = palabras
        // Vidas
        var error = 3
        var vida = document.getElementById('vida');
        vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
        // Barra de progreso
        contador = 0
        document.getElementById("barra").value = contador
        document.getElementById("barra").innerHTML = contador
        var puntaje = 0

        Ayuda()

        function Progreso(progreso,puntaje){
            $.ajax({
                url: 'conexiones/actualizar_progreso_a.php',  
                type: 'POST',
                data: {
                    progreso: progreso, 
                    puntaje: puntaje,
                    num_juego: '<?php echo $num_juego; ?>',
                },
                success: function(response) {
                    console.log('Progreso actualizado');
                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar el progreso: ' + error);
                }
            });
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
                    document.getElementById("btnIniciar").innerHTML = "Empezar"
                    Reiniciar()
                } 
            });
        }

        function Reiniciar(){
            palabras2 = palabras
            error = 3
            vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
            contador = 0
            guion = []
            puntaje = 0
            imagen = ""
            document.getElementById("linea").innerHTML = guion
            document.getElementById("barra").value = contador
            document.getElementById("barra").innerHTML = contador
            Inicio()
        }

        function Inicio(){
            guion = []
            document.getElementById("linea").innerHTML = guion
            respuesta = palabras[Math.floor(Math.random() * palabras2.length)] // Elegir una palabra aleatoria
            var repetida = palabras2.indexOf(respuesta) // Identificar en el arreglo la respuesta
            palabras2.splice(repetida, 1) // Eliminar la respuesta del arreglo para evitar repetirse
            imagen = document.getElementById("figura") 
            imagen.src = "Visual/Material/Letras/Juego2/" + respuesta + ".png"

            for (var i = 0; i < respuesta.length; i++) { // Se dibujan guiones con base en la longitud de la respuesta
                guion[i] = "_";
            }

            document.getElementById("linea").innerHTML = guion.join(" ") // Se dibuja un espacio entre cada guion
            opcion(op = []) // Función de opciones para colocarlos en los círculos
            document.getElementById('circulos').style.display='block'
        }

        function opcion(op){ // Función recursiva para rellenar el arreglo hasta llegar a 4
            if(op.length == 4){
                if(guion.indexOf("_") != -1) { // Toma el primer guion que encuentre en la palabra
                    var e = op.includes(respuesta[guion.indexOf("_")]) // Evaluar si el arreglo incluye letras de la palabra
                    if(!e){ // Si no encuentra
                        let r = Math.floor(Math.random() * op.length)
                        op.splice(r, 1, respuesta[guion.indexOf("_")]) // Elegir una posición aleatoria de las opciones para reemplazarla por la nueva letra
                    }
                    for (let i = 0; i < opciones.length; i++){
                        opciones[i].innerHTML = op[i] // Se muestran las opciones en los círculos
                    }
                }
            } 

            else {
                let r = Math.floor(Math.random() * letras.length) // Se elige una letra aleatoria que se encuentra en el arreglo
                op.push(letras[r])  // Se agrega en las opciones
                result = op.filter((item,index)=>{ // Filtro para determinar si una letra elegida ya está en el arreglo y evitar duplicidad
                    return op.indexOf(item) === index;
                })
                return opcion(result)
            }
        }

        const replaceAt = (string, character, index) => {
            return string.substring(0, index) + character + string.substring(index + character.length);
        }

        function validar(letra){
            if(respuesta.indexOf(letra) != -1) {
                for(var i = 0; i < respuesta.length; i++) {
                    if(respuesta[i]==letra){
                        guion[i] = letra;
                    }
                }
                document.getElementById("linea").innerHTML = guion.join(" ")
            }

            else{ // Evaluacion de fallos y disminución de vidas
                error-- 
                if(error == 2){
                    puntaje = 6.6
                    vida.innerHTML = '<img src="Visual/Material/Iconos/corazon2.png" width="100">'
                }

                if(error == 1){
                    puntaje = 3.3
                    vida.innerHTML = '<img src="Visual/Material/Iconos/corazon1.png" width="100">'
                }

                if(error == 0){
                    puntaje = 0
                    vida.innerHTML = ""
                    swal({
                        title: "¡Oh no!",
                        text: "No te quedan más vidas. ¿Deseas salir o reintentar?",
                        icon: "Visual/Material/Animaciones/Generales/error.jpg",
                        buttons:  ["Reintentar", "Salir"] 
                    })
                    .then((reintento) => {
                        if (reintento) {
                            location.href = "JuegosLetras.html"
                        } 
                        else{
                            document.getElementById("btnIniciar").innerHTML = "Empezar"
                            Reiniciar()
                        }
                    })
                }
            }

            var e = guion.includes('_') // Validar que la palabra se haya completado

            if(!e){ // Si la palabra ya no tiene guiones, significa que ha ganado
                swal({
                    title: "Felicidades",
                    text: "Continuemos. Sigue así",
                    icon: "Visual/Material/Animaciones/Generales/PolloBien.gif"
                })

                .then((continuacion) => {
                    if (continuacion) {
                        document.getElementById("btnIniciar").innerHTML = "Continuar"
                        contador++
                        document.getElementById("barra").value = contador
                        document.getElementById("barra").innerHTML = contador
                        Progreso(contador, puntaje)

                        if(contador == 10){
                            Progreso(contador, puntaje)
                            swal({
                                title: "Felicidades",
                                text: "¿Quieres salir del juego o volver a intentarlo?",
                                icon: "Visual/Material/Animaciones/Generales/PolloBien (4).gif",
                                buttons:  ["Volver a jugar", "Salir"] 
                            })
                            .then((reintento) => {
                                if (reintento) {
                                    location.href = "JuegosLetras.html"
                                } 
                                else{
                                    document.getElementById("btnIniciar").innerHTML = "Empezar"
                                    Reiniciar()
                                }
                            })
                        }
                        else{
                            Inicio()
                        }
                    } 
                })
            }
        }

        window.addEventListener("keydown",(e)=>{
            let tecla = e.key
            switch(tecla){
            case 'ArrowUp':
                validar(result[0])
                break;
            case 'ArrowDown':
                validar(result[1])
                break;
            case 'ArrowLeft':
                validar(result[2])
                break;
            case 'ArrowRight':
                validar(result[3])
                break;
            default:
                break;
            }
        })

        window.addEventListener("keyup",(e)=>{
            let tecla = e.key

            switch(tecla){
                case 'ArrowUp':
                case 'ArrowDown':
                case 'ArrowLeft':
                case 'ArrowRight':
                    opcion(op = [])
                    break;
                default:
                    break;
            }
        })

        function Ayuda(){
            swal({
                title: "Tutorial",
                text: "Completa la palabra de acuerdo con la imagen. Elige la opción correcta por medio de las teclas ↑ ↓ → ← o los botones del tablero.",
                icon: "Visual/Material/Animaciones/Generales/teclas.jpg"
            })
        }
    </script>
</body>
</html>