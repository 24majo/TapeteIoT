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

        if (isset($_POST['jugar'])) {
            $juego = $_POST['jugar'];
            echo "num_juego: " . $juego;
        }

		$juego = "SELECT num_juego FROM JUEGOS WHERE num_juego = 14";
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
     <!-- Barra Lateral -->
     <link rel="stylesheet" href="css/BarraLateral.css">
     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="css/styleJuegoLetras8.css">

    <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery-3.7.1.min.js"></script>

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

        <button class="boton" onclick="location.href = 'JuegosTrabados.html'">
            <img class="modo" id="modo" src="Visual/Material/Letras/Seleccion/ImgSilabasTrabadas.jpg" width="40px">
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

    <div style="margin-left: 700px; margin-top: -380px">
        <progress style="height: 80px; width:380px;" id="barra" max="12" value="0"></progress>
    </div>

    <nav>
        <div>
            <div class="vidas" id="vida"></div>
        </div>

        <audio id="audio" preload="auto" loop >
            <source src="audio/audio5.mp3" type="audio/mpeg">
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

        <div  class="titulo">
            <font face="Century Gothic">
                <h1><b>¿Cómo se escribe la palabra?</b></h1>
            </font>
        </div>
       
    </nav>

    <article>
        <section>
            <center>
                <img style="z-index:-1;" class="imagen" id='imagen' width="150px" height="150px">
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
    <script src="js/audio.js"></script>
    <!-- <script src="js/funciones/letras/trabadas.js"></script> -->
     <script>
        // Vidas
var error = 3
var vida = document.getElementById('vida');
vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'

// Barra de progreso
contador = 0
var puntaje = 10
document.getElementById("barra").value = contador
document.getElementById("barra").innerHTML = contador

// Elementos generales
const audioCorrecto = document.getElementById('audioCorrecto');
const audioIncorrecto = document.getElementById('audioIncorrecto');
var encabezado = localStorage.getItem("valor") // Envío de valor de acuerdo con el modo de juego
var palabras = []
var opciones = document.getElementsByClassName("opcion")
var op = []
var respuesta = ""
var linea
var imagen = document.getElementById('imagen') 
var tabla1 = document.getElementsByClassName("tabla1")
var tabla2 = document.getElementsByClassName("tabla2")
var t1 = 0, t2 = 0



function ValoresTabla(){
    if(encabezado == "b"){
        document.getElementById("opcion1").textContent = "bl"
        document.getElementById("opcion2").textContent = "br"
        palabras = ["nublado", "mueble",  "ombligo", "establo", "blusa", "pueblo",
            "cebra", "cobra", "lombríz", "libro", "bruja","embrujado"]
        //palabras = ["libro"]
        op = ["bl", "br"]
        OpcionesCirculos(op)
    }
    if(encabezado == "c"){
        document.getElementById("opcion1").textContent = "cl"
        document.getElementById("opcion2").textContent = "cr"
        palabras = ["chancla", "chicle", "eclipse", "cíclope", "club", "bicicleta", 
            "cráneo", "secreto", "escribir", "microbio", "crucero", "crayón"]
        op = ["cl", "cr"]
        OpcionesCirculos(op)
    }
    if(encabezado == 'f'){
        document.getElementById("opcion1").textContent = "fl"
        document.getElementById("opcion2").textContent = "fr"
        palabras = ["disfraz", "fresa", "fritura", "frotar", "frutas", "frasco",
            "flan", "flauta", "flama", "flecha", "flor", "flojo"]
        op = ["fl", "fr"]
        OpcionesCirculos(op)
    }
    if(encabezado == 'g'){
        document.getElementById("opcion1").textContent = "gl"
        document.getElementById("opcion2").textContent = "gr"
        palabras = ["regla", "iglesia", "globo", "iglú", "jeroglífico", "glaciar",
            "grano", "greñas", "cangrejo", "ogro", "grúa", "logro"]
        op = ["gl", "gr"]
        OpcionesCirculos(op)
    }
    if(encabezado == 'p'){
        document.getElementById("opcion1").textContent = "pl"
        document.getElementById("opcion2").textContent = "pr"
        palabras = ["planta","cumpleaños", "explorador", "templo", "pluma", "planeta",
            "compra", "aprender", "príncipe", "exprimir", "prueba", "temprano"]
        op = ["pl", "pr"]
            OpcionesCirculos(op)
    }
    if(encabezado == 't'){
        document.getElementById("opcion1").textContent = "tl"
        document.getElementById("opcion2").textContent = "tr"
        palabras = ["atleta", "atlántico", "tlacoyo", "atlas", "chipotle", "tlacuache",
            "traje", "tren", "estrella", "trompeta", "trueno", "trompo"]
        op = ["tl", "tr"]
        OpcionesCirculos(op)
    }
}

function Empezar(){
    respuesta = palabras[Math.floor(Math.random() * palabras.length)]
    var repetida = palabras.indexOf(respuesta)
    palabras.splice(repetida, 1)
    imagen.src = "Visual/Material/Letras/Juego8/" + respuesta + ".jpg"

    if(encabezado == "b"){
        linea = respuesta.replace(/bl|br/g, "_ _")
    }
    if(encabezado == "c"){
        linea = respuesta.replace(/cl|cr/g, "_ _")
    }
    if(encabezado == 'f'){
        linea = respuesta.replace(/fl|fr/g, "_ _")
    }
    if(encabezado == 'g'){
        linea = respuesta.replace(/gl|gr/g, "_ _")
    }
    if(encabezado == 'p'){
        linea = respuesta.replace(/pl|pr/g, "_ _")
    }
    if(encabezado == 't'){
        linea = respuesta.replace(/tl|tr/g, "_ _")
    }

    document.getElementById("linea").innerHTML = linea
}

function Comprobar(arreglo){
    if(respuesta.indexOf(arreglo) > -1){
        if(arreglo == op[0]){
            if(encabezado == "b"){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == "c"){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == 'f'){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == 'g'){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == 'p'){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == 't'){
                linea = respuesta.replace("_ _", arreglo)
            }
            tabla1[t1].src = "Visual/Material/Letras/Juego8/" + respuesta + ".jpg"
            t1++
        }

        if(arreglo == op[1]){
            if(encabezado == "b"){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == "c"){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == 'f'){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == 'g'){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == 'p'){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == 't'){
                linea = respuesta.replace("_ _", arreglo)
            }
            tabla2[t2].src = "Visual/Material/Letras/Juego8/" + respuesta + ".jpg"
            t2++
        }
        document.getElementById("linea").innerHTML = linea
        Felicidades()
    }

    else{
        Fallo()
    }
}

function OpcionesCirculos(op){
    for(var i = 0; i < opciones.length; i++){
        opciones[i].innerHTML = op[i]
    }
}

window.addEventListener("keydown",(e)=>{
    let tecla = e.key
    switch(tecla){
    case 'ArrowLeft':
        Comprobar(op[0])
        break;
    case 'ArrowRight':
        Comprobar(op[1])
        break;
    default:
        break;
    }
})

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
    error = 3
    vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
    imagen.src = ""
    contador = 0
    respuesta = ""
    document.getElementById("barra").value = contador
    document.getElementById("barra").innerHTML = contador

    for(var i = 0; i < tabla1.length; i++){
        tabla1[i].src = ""
        tabla2[i].src = ""
    }
    
    t1 = 0
    t2 = 0

    ValoresTabla()
    Empezar()
}

function Fallo(){
    audioIncorrecto.play(); // Iniciar audio incorrecto :c
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
            icon: "Visual/Material/Animaciones/Generales/triste.jpg",
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

function Felicidades(){
    audioCorrecto.play(); // Iniciar audio correcto :D
    swal({
        title: "¡Muy bien!",
        text: "Continuemos. Sigue así",
        icon: "Visual/Material/Animaciones/Generales/PolloBien.gif"
    })

    .then((continuacion) => {
        if (continuacion) {
            document.getElementById("btnIniciar").innerHTML = "Continuar"
            contador++
            document.getElementById("barra").value = contador
            document.getElementById("barra").innerHTML = contador

            if(contador == 12){
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
                Empezar()
            }
        } 
    })
}

Ayuda()
ValoresTabla()

function Ayuda(){
    swal({
        title: "Tutorial",
        text: "Determina en qué columna va la imagen. \n Elige la opción correcta por medio de las teclas ← → o los botones del tablero.",
        icon: "Visual/Material/Animaciones/Generales/teclas.jpg"
    })
}
     </script>
</html>