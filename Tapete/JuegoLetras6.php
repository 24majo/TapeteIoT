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

		$juego = "SELECT num_juego FROM JUEGOS WHERE num_juego = 12";
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
                    echo '<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>';
                    echo 
                    '<script>
                        swal({
                            title: "success",
                            text: "Juego guardado",
                            icon: "Ahora este alumno tiene un nuevo objetivo."
                        })
                    </script>';
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
    <link rel="stylesheet" href="css/styleJuegoLetras6.css">

    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery-3.7.1.min.js"></script>
    <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Barra Lateral -->
    <link rel="stylesheet" href="css/BarraLateral.css">

    <title>Uso de LL y Y</title>
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

        <button class="boton" onclick="location.href = 'DificultadUsodeYLL.html'">
            <img class="modo" id="modo" src="Visual/Material/Recursos/Semaforo.png" width="50px">
            <span>Dificultad</span>
        </button>

        <button class="boton" onclick="location.href = 'JuegosUsoDe.html'">
            <img class="tipo" id="tipo" src="Visual/Material/Letras/Seleccion/ImgUsoDe.jpg" width="40px">
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

<div style="margin-left: 720px; margin-top: -400px">
    <progress style="height: 80px; width:380px;" id="barra" max="10" value="0"></progress>
</div>
   
    <nav >

        <div>
            <div class="vidas" id="vida"></div>
        </div>

    <audio id="audio" preload="auto" loop >
		<source src="audio/audio3.mp3" type="audio/mpeg">
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
                <h1><b>Uso de LL y Y</b></h1>
            </Font>
        </div>
        

        <img class="semaforo" id="semaforo" alt=""  width="100">
        
        <!-- <a href="MenuSeleccion.html" class="btnInicio">
            <img src="Visual/Material/Iconos/MenuInicio.png" width="70px">
        </a>
        <a href="JuegosLetras.html" class="btnAtras">
            <img src="Visual/Material/Iconos/Flecha.png" width="60px">
        </a> -->
    </nav>

  

    <section>
        <article>
            <img class="imagen" id='figura' width="250px" height="250px">
            <center>
                <div class="palabra" id="linea"></div>
            </center>
            
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
    <!-- <script src="js/funciones/letras/y-ll.js"></script> -->
    <script src="js/Barra.js"></script>
    <script src="js/audio.js"></script>
    <script>
        // Vidas
var error = 3
var vida = document.getElementById('vida');
vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'

// Barra de progreso
contador = 0
var puntaje = 10
var contador2 = 0
document.getElementById("barra").value = contador
document.getElementById("barra").innerHTML = contador

// Elementos generales
const audioCorrecto = document.getElementById('audioCorrecto');
const audioIncorrecto = document.getElementById('audioIncorrecto');
var semaforo = document.getElementById('semaforo')
var imagen = document.getElementById('figura') 
var palabras_f = ["ayuda", "rayo", "coyote", "yogur", "yegua", "llave", "llama", "lluvia", "pollo", "estrella"]
var palabras_m = ["yoyo", "llanta", "yate", "olla", "muelle", "yema", "collar", "calle", "botella", "sillón"]
var palabras = []
var opciones = document.getElementsByClassName("opcion")
var respuesta, respuesta_m = []
var arreglo = []
var num_ejercicio = 0, num_opcion = 0
var palabras_d =[
    {
        frase: "La llama se mojó en la lluvia.",
        valores: ["llama", "lluvia"],
        ruta: "Visual/Material/Letras/Juego6/LlamaLluvia.jpg"
    },
    {
        frase: "El caldo de pollo se pone en la olla.",
        valores: ["pollo", "olla"],
        ruta: "Visual/Material/Letras/Juego6/PolloOlla.jpg"
    },
    {
        frase:"Un rayo cayó sobre una montaña.",
        valores: ["rayo", "cayó"],
        ruta: "Visual/Material/Letras/Juego6/RayoCayó.jpg"
    },
    {
        frase:"La gallina se cruzó la calle.",
        valores: ["gallina", "calle"],
        ruta: "Visual/Material/Letras/Juego6/GallinaCalle.jpg"
    },
    {
        frase:"El coyote mira las estrellas.",
        valores: ["coyote", "estrellas"],
        ruta: "Visual/Material/Letras/Juego6/CoyoteEstrellas.jpg"
    },
    {
        frase:"La botella se llenó con agua.",
        valores: ["botella", "llenó"],
        ruta: "Visual/Material/Letras/Juego6/BotellaLlenó.jpg"
    },
    {
        frase:"Desde el muelle se observó una ballena.",
        valores: ["muelle", "ballena"],
        ruta: "Visual/Material/Letras/Juego6/MuelleBallena.jpg"
    },
    {
        frase:"Las cebollas están llorando.",
        valores: ["cebollas", "llorando"],
        ruta: "Visual/Material/Letras/Juego6/CebollaLlorando.jpg"
    },
    {
        frase:"El caballo se está comiendo mi galleta.",
        valores: ["caballo", "galleta"],
        ruta: "Visual/Material/Letras/Juego6/CaballoGalleta.jpg"
    },
    {
        frase:"La yegua tiene una larga cabellera.",
        valores: ["yegua", "cabellera"],
        ruta: "Visual/Material/Letras/Juego6/YeguaCabellera.jpg"
    }
]

Ayuda()

function Reinicio(){
    swal({
        title: "Reiniciar juego",
        text: "Si reinicias ahora, el progreso se perderá. ¿Deseas continuar?",
        icon: "Visual/Material/Animaciones/Generales/advertencia.jpg",
        buttons: true,
        dangerMode: true,
      })

      .then((willDelete) => {
        if (willDelete) {
            document.getElementById("btnIniciar").innerHTML = "Empezar"
            Reiniciar()
        } 
    });
}

function Reiniciar(){
    document.getElementById("linea").innerHTML = "" 
    for(let i = 0; i < opciones.length; i++){
        opciones[i].innerHTML = ""
    }
    if(valor == 'facil')
        palabras_f = ["ayuda", "rayo", "coyote", "yogur", "yegua", "llave", "llama", "lluvia", "pollo", "estrella"]

    if (valor == "medio")
        palabras_m = ["yoyo", "llanta", "yate", "olla", "muelle", "yema", "collar", "calle", "botella", "sillón"]
    
    palabras = []
    error = 3
    vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
    contador = 0
    imagen.src = ""
    document.getElementById("barra").value = contador
    document.getElementById("barra").innerHTML = contador
    num_ejercicio = 0
    num_opcion = 0
    respuesta_m = []
    Empezar()
}

function Progreso(progreso,puntaje){
    $.ajax({
        url: 'conexiones/actualizar_progreso_a.php',  
        type: 'POST',
        data: {
            progreso: progreso, 
            puntaje: puntaje,
            num_juego: 12,
        },
        success: function(response) {
            console.log('Progreso actualizado. ', response);
        },
        error: function(xhr, status, error) {
            console.error('Error al actualizar el progreso: ' + error);
        }
    });
}

function Empezar(){
    switch(valor){
        case 'facil':
            arreglo = ["ll", "y"]
            palabras = palabras_f
            respuesta = palabras[Math.floor(Math.random() * palabras.length)]
            var repetida = palabras.indexOf(respuesta)
            palabras.splice(repetida, 1)
            document.getElementById("linea").innerHTML = respuesta
            imagen.src = "Visual/Material/Letras/Juego6/" + respuesta + ".jpg"
            
            if(respuesta.includes('y') == true || respuesta.includes('l') == true){
                document.getElementById("linea").innerHTML = respuesta.replaceAll(/l|y/g, "_")
            }

            for(let i = 0; i < arreglo.length; i++){
                opciones[i].innerHTML = arreglo[i]
            }
            
            document.getElementById('aparecer').style.display='block';
            break

        case 'medio':
            arreglo = ["ll", "y"]
            palabras = palabras_m

            if(!respuesta_m.includes("_")){
                respuesta = palabras[Math.floor(Math.random() * palabras.length)]
                var repetida = palabras.indexOf(respuesta)
                palabras.splice(repetida, 1)

                if(respuesta.includes('y') == true || respuesta.includes('l') == true){
                    respuesta_m = respuesta.replaceAll(/l|y/g, "_")
                    imagen.src = "Visual/Material/Letras/Juego6/" + respuesta + ".jpg"
                    document.getElementById("linea").innerHTML = respuesta_m
                }
            }

            for(let i = 0; i < arreglo.length; i++){
                opciones[i].innerHTML = arreglo[i]
            }
            
            document.getElementById('aparecer').style.display='block';
            break
        
        case 'dificil':
            arr_res = palabras_d[num_ejercicio].valores
            respuesta = arr_res[num_opcion]
            //alert(respuesta)

            if(num_opcion == 0){
                arr_res.forEach(valor => {
                    palabras_d[num_ejercicio].frase = palabras_d[num_ejercicio].frase.replaceAll(valor, "_______");
                    imagen.src = palabras_d[num_ejercicio].ruta
                });
            }

            document.getElementById("linea").innerHTML = palabras_d[num_ejercicio].frase

            if(respuesta.includes("y")){
                var palabra = respuesta.replace("y", "ll");
                
                if(arreglo.length == 2){
                    arreglo[0] = palabra
                    arreglo[1] = respuesta
                }
                else{
                    arreglo.push(palabra)
                    arreglo.push(respuesta)
                }
            }

            else if(respuesta.includes("ll")){
                var palabra = respuesta.replace("ll", "y");
                if(arreglo.length == 2){
                    arreglo[0] = respuesta
                    arreglo[1] = palabra
                }
                else{
                    arreglo.push(respuesta)
                    arreglo.push(palabra)
                }
            }

            //alert(arreglo)

            for (let i = 0; i < opciones.length; i++){
                    opciones[i].innerHTML = arreglo[i] // Se muestran las opciones en los círculos
            }

            document.getElementById('aparecer').style.display='block';
            // }
            break
    }
}

function ComprobarM(letra){
    if(respuesta.includes(letra)) {
        for(var i = 0; i < respuesta.length; i++){
            if(respuesta_m[i] == "_"){
                if(respuesta[i] == letra){
                    if(respuesta[i] == 'l'){
                        respuesta_m = respuesta_m.replaceAll("_", letra)
                        break
                    }
                    else{
                        respuesta_m = respuesta_m.replace("_", letra)
                        break
                    }
                    break
                }

                else{
                    Fallo()
                    break
                }
                break
            }
        }
        document.getElementById("linea").innerHTML = respuesta_m

        if(!respuesta_m.includes("_")){
            Felicidades()
        }
    }

    else{
        Fallo()
    }
}

function Comprobar(letra){
    if(respuesta.includes(letra)) {
        for(var i = 0; i < respuesta.length; i++) {
            if(respuesta[i]==letra){
                respuesta[i] == letra
                break
            }
        }

        switch(valor){
            case 'facil':
                document.getElementById("linea").innerHTML = respuesta
                Felicidades()
                break

            case 'dificil':
                palabras_d[num_ejercicio].frase = palabras_d[num_ejercicio].frase.replace("_______", respuesta)
                document.getElementById("linea").innerHTML = palabras_d[num_ejercicio].frase
                num_opcion++

                if(num_opcion > 1 && num_ejercicio < 10){
                    num_ejercicio++
                    num_opcion = 0
                    Felicidades()
                }
                break
        }
    }
    
    else{
        Fallo()
    }
}

function Fallo(){
    audioIncorrecto.play(); // Iniciar audio incorrecto :c
    error-- 
    if(error == 2){
        puntaje -= 0.3
        Progreso(contador2, puntaje)
        vida.innerHTML = '<img src="Visual/Material/Iconos/corazon2.png" width="100">'
    }

    if(error == 1){
        puntaje -= 0.3
        Progreso(contador2, puntaje)
        vida.innerHTML = '<img src="Visual/Material/Iconos/corazon1.png" width="100">'
    }

    if(error == 0){
        puntaje -= 0.3
        Progreso(contador2, puntaje)
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
                if(valor == 'facil'){
                    palabras_f = ["ayuda", "rayo", "coyote", "yogur", "yegua", "llave", "llama", "lluvia", "pollo", "estrella"]
                    palabras = palabras_f
                    //alert(palabras)
                    document.getElementById("btnIniciar").innerHTML = "Empezar"
                    Reiniciar()
                }

                else{
                    swal({
                        title: "¿Deseas reintentar el nivel o elegir otra dificultad?",
                        icon: "Visual/Material/Animaciones/Generales/advertencia(1).jpg",
                        buttons:  ["Mantener", "Cambiar"] 
                    })
                    .then((cambiar) => {
                        if(cambiar){
                            if(valor == 'dificil'){
                                valor = "medio"
                                semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
                                palabras_m = ["yoyo", "llanta", "yate", "olla", "muelle", "yema", "collar", "calle", "botella", "sillón"]
                                palabras = palabras_m
                                //alert(palabras)
                            }

                            if(valor == 'medio'){
                                valor = "facil"
                                semaforo.src = "Visual/Material/Recursos/SemaforoFacil.png"
                                palabras_f = ["ayuda", "rayo", "coyote", "yogur", "yegua", "llave", "llama", "lluvia", "pollo", "estrella"]
                                palabras = palabras_f
                                //alert(palabras)
                            }
                            
                            document.getElementById("btnIniciar").innerHTML = "Empezar"
                            Reiniciar()
                        }
                        else{
                            document.getElementById("btnIniciar").innerHTML = "Empezar"
                            Reiniciar()
                        }
                    })
                }
            }
        })
    }
}

function Felicidades(){
    audioCorrecto.play(); // Iniciar audio correcto :D
    contador2 += 0.3
    console.log(contador2)
    Progreso(contador2, puntaje)
    swal({
        title: "¡Muy bien!",
        text: "Continuemos. Sigue así",
        icon: "Visual/Material/Animaciones/Generales/PolloBien (2).gif"
    })

    .then((continuacion) => {
        if (continuacion) {
            document.getElementById("btnIniciar").innerHTML = "Continuar"
            contador++
            document.getElementById("barra").value = contador
            document.getElementById("barra").innerHTML = contador

            if(contador == 10){
                if(valor == "dificil"){
                    contador2 = 10
                    Progreso(contador2, puntaje)
                    swal({
                        title: "Felicidades",
                        text: "Has completado todos los niveles. ¿Quieres reiniciar todo o salir?",
                        icon: "Visual/Material/Animaciones/Generales/PolloBien (3).gif",
                        buttons:  ["Reintentar todo", "Salir"] 
                    })
                    .then((reintento) => {
                        if (reintento) {
                            location.href = "JuegosLetras.html"
                        } 
                        else{
                            valor = 'facil'
                            semaforo.src = "Visual/Material/Recursos/SemaforoFacil.png"
                            palabras_f = ["uva", "vela", "vaso", "viento", "volcán", "globo", "lombríz", "libro", "balón", "barco"]
                            palabras = palabras_f
                            document.getElementById("btnIniciar").innerHTML = "Empezar"
                            Reiniciar()
                        }
                    })
                }

                else{
                    swal({
                        title: "Felicidades",
                        text: "¿Quieres avanzar al siguiente nivel o salir del juego?",
                        icon: "Visual/Material/Animaciones/Generales/PolloBien (4).gif",
                        buttons:  ["Siguiente nivel", "Salir"] 
                    })
                    .then((reintento) => {
                        if (reintento) {
                            location.href = "JuegosLetras.html"
                        } 
                        else{
                            if(valor == 'facil'){
                                contador2 = 3.3
                                Progreso(contador2, puntaje)
                                valor = 'medio'
                                semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
                                Reiniciar()
                            }

                            else{
                                if(valor == 'medio'){
                                    contador2 = 6.6
                                    Progreso(contador2, puntaje)
                                    valor = 'dificil'                                    
                                    semaforo.src = "Visual/Material/Recursos/SemaforoDificil.png"
                                    Reiniciar()
                                }
                            }
                        }
                    })
                }
            }
            else{
                Empezar()
            }
        } 
    })
}

window.addEventListener("keydown",(e)=>{
    let tecla = e.key
    switch(tecla){
    case 'ArrowLeft':
        if(valor == 'medio'){
            ComprobarM('l')
        }
        else{
            Comprobar(arreglo[0])
        }
        break;
    case 'ArrowRight':
        if(valor == 'medio'){
            ComprobarM(arreglo[1])
        }
        else{
            Comprobar(arreglo[1])
        }
        break;
    default:
        break;
    }
})

window.addEventListener("keyup",(e)=>{
    let tecla = e.key

    switch(tecla){
        case 'ArrowRight':
        case 'ArrowLeft':
            if(valor == 'dificil')
                Empezar()
            break;
        default:
            break;
    }
})

function Ayuda(){
    swal({
        title: "Tutorial",
        text: "Completa la palabra con la letra correcta.\n Elige la opción correcta por medio de las teclas ↑ ↓ → ← o los botones del tablero.",
        icon: "Visual/Material/Animaciones/Generales/teclas.jpg"
    })
}

window.onload = function() {
    valor = localStorage.getItem('valorBoton');
    if(valor == 'facil'){
        contador2 = 0
        semaforo.src = "Visual/Material/Recursos/SemaforoFacil.png"
    }

    if(valor == 'medio'){
        contador2 = 3.3
        semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
    }

    if(valor == 'dificil'){
        contador2 = 6.6
        semaforo.src = "Visual/Material/Recursos/SemaforoDificil.png"
    }
    console.log("carga: " + contador2)
}
    </script>
</body>
</html>