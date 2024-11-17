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

		$juego = "SELECT num_juego FROM JUEGOS WHERE num_juego = 5";
		$n_juego = $conn->query($juego);

		if ($n_juego && $n_juego->num_rows > 0) {
            $juego1 = $n_juego->fetch_assoc();
            $num_juego = $juego1['num_juego'];
        } 
		
		else {
            $num_juego = null;
        }

		if ($num_juego != null) {
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
      <link rel="stylesheet" href="css/StyleJuegoNum5.css">
      <link rel="stylesheet" href="css/BarraLateral.css">

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

        <button class="boton" onclick="location.href = 'MenuSeleccion.html'">
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
        <div style="margin-left: 750px; margin-top: -280px">
            <progress style="height: 80px; width:380px;" id="barra" max="10" value="0"></progress>
        </div>

        <div class="vidas" id="vida"></div>
        
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
    <!-- <script src="js/funciones/numeros/juego5.js"></script> -->
    <script src="js/Barra.js"></script>

    <script>
        // Vidas
        var imagen = document.getElementById('vida');
        imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
        var error = 3
        // Barra de progreso
        contador = 0
        document.getElementById("barra").value = contador
        document.getElementById("barra").innerHTML = contador
        // Circulos de opciones
        var opciones = document.getElementsByClassName("opcion")
        var op = []
        var pecera = document.getElementById("pecera")
        var respuesta = ""
        var ejercicio = 0
        var semaforo = document.getElementById('semaforo')
        contador2 = 0
        puntaje = 10

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

        window.onload = function() {
            valor = localStorage.getItem('valorBoton');
            if(valor == 'facil')
                semaforo.src = "Visual/Material/Recursos/SemaforoFacil.png"

            if(valor == 'medio')
                semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"

            if(valor == 'dificil')
                semaforo.src = "Visual/Material/Recursos/SemaforoDificil.png"
        }

        function Reiniciar(){
            error = 3
            contador = 0
            contador2 = 0
            puntaje = 10
            imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
            document.getElementById("barra").value = contador
            document.getElementById("barra").innerHTML = contador
            Empezar()
        }

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

        function Empezar(){
            document.getElementById('aparecer').style.display='block';
            
            switch(valor){
                case 'facil':
                    num = Math.floor(Math.random() * (50-1)+1)
                    pecera.innerHTML = '<img src="Visual/Material/Numeros/Juego5/'+ num +'.jpg" width="400">'
                    Completar(num)  
                    break

                case 'medio':
                    num = Math.floor(Math.random() * (99-51)+51)
                    pecera.innerHTML = '<img src="Visual/Material/Numeros/Juego5/'+ num +'.jpg" width="400">'
                    Completar(num)  
                    break
                
                case 'dificil':
                    num = Math.floor(Math.random() * (99-1)+1)
                    pecera.innerHTML = '<img src="Visual/Material/Numeros/Juego5/'+ num +'.jpg" width="400">'
                    Completar(num) 
                    break
            }
        }

        function Completar(num){
            decena = num - (num % 10) + 10
            respuesta = decena - num
            
            op = Opcion(arreglo = [])

            for(let i = 0; i < opciones.length; i++){
                opciones[i].innerHTML = op[i]
            }

        }

        function Opcion(arreglo){
            if(arreglo.length == 4){
                var res = arreglo.indexOf(respuesta)
                if(res == -1){
                    var r = Math.floor(Math.random() * arreglo.length) 
                    arreglo.splice(r, 1, respuesta)
                }
            }

            else{
                var r = Math.floor(Math.random() * ((10-1)+1))
                arreglo.push(r)
                        
                result = arreglo.filter((item,index)=>{
                    return arreglo.indexOf(item) === index;
                })
                
                Opcion(result)
            }
            return result
        }

        function Validar(num){
            if(num == respuesta){
                contador += 1
                document.getElementById("btnIniciar").innerHTML = "Continuar"
                document.getElementById("barra").value = contador
                document.getElementById("barra").innerHTML = contador

                if(contador == 10){
                    if(valor == "dificil"){
                        contador2 = 10
                        Progreso(contador2, puntaje)
                        swal({
                            title: "¡Ganador!",
                            text: "Completaste todos los niveles. ¿Deseas salir o reiniciar?",
                            icon: "Visual/Material/Animaciones/Generales/PolloBien (3).gif",
                            buttons:  ["Continuar", "Salir"],
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                location.href = "JuegosNumeros.html"
                            } 
                            else{
                                document.getElementById("btnIniciar").innerHTML = "Empezar"
                                Reiniciar()
                            }
                        })
                    }

                    else{
                        swal({
                            title: "¡Felicidades!",
                            text: "Completaste el nivel " + valor + ". ¿Deseas avanzar al siguiente nivel?",
                            icon: "Visual/Material/Animaciones/Generales/PolloBien (2).gif",
                            buttons: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                if(valor == 'facil'){
                                    contador2 = 3.5
                                    Progreso(contador2, puntaje)
                                    valor = 'medio'
                                    semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
                                    Reiniciar()
                                }

                                else{
                                    if(valor == 'medio'){
                                        contador2 = 7
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
            }
            else{
                error--
                if(error == 2){
                    puntaje -= 0.3
                    Progreso(contador2, puntaje)
                    imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon2.png" width="100">'
                }

                if(error == 1){
                    puntaje -= 0.3
                    Progreso(contador2, puntaje)
                    imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon1.png" width="100">'
                }

                if(error == 0){
                    puntaje -= 0.3
                    Progreso(contador2, puntaje)
                    imagen.innerHTML = ""
                    swal({
                        title: "¡Oh no!",
                        text: "No te quedan más vidas. ¿Deseas salir o reintentar?",
                        icon: "Visual/Material/Animaciones/Generales/triste.jpg",
                        buttons:  ["Reintentar", "Salir"] 
                    })
                    .then((reintento) => {
                        if (reintento) {
                            location.href = "JuegosNumeros.html"
                        } 
                        else{
                            swal({
                                title: "¿Deseas reintentar el nivel o elegir otra dificultad?",
                                icon: "Visual/Material/Animaciones/Generales/Chick.gif",
                                buttons:  ["Mantener", "Cambiar"] 
                            })
                            .then((cambiar) => {
                                if(cambiar){
                                    if(valor == 'dificil'){
                                        valor = "medio"
                                        semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
                                    }

                                    if(valor == 'medio'){
                                        valor = "facil"
                                        semaforo.src = "Visual/Material/Recursos/SemaforoFacil.png"
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
                    })
                }
            }
        }

        window.addEventListener("keydown",(e)=>{
            let tecla = e.key
            switch(tecla){
                case 'ArrowUp':
                    Validar(op[0])
                    break;

                case 'ArrowLeft':
                    Validar(op[1])
                    break;

                case 'ArrowDown':
                    Validar(op[2])
                    break;

                case 'ArrowRight':
                    Validar(op[3])
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
                    Empezar()
                    break;

                default:
                    break;
            }
        })

        function Ayuda(){
            swal({
                title: "Tutorial",
                text: "Identifica la cantidad de peces que se encuentran en la pecera. Deberás sumarlos para identificar cuanto falta para la siguiente decena. \nElige la opción correcta por medio de las teclas ↑ ↓ → ← o los botones del tablero.",
                icon: "Visual/Material/Animaciones/Generales/teclas.jpg"
            })
        }
    </script>
  </body>
</html>