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

		$juego = "SELECT num_juego FROM JUEGOS WHERE num_juego = 9";
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
    <link rel="stylesheet" href="css/StyleJuegoLetras3.css">

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
    <!-- <script src="js/funciones/letras/comprension.js"></script> -->
    <script>
        // Vidas
var imagen = document.getElementById('vida');
imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
var error = 3

// Barra de progreso
var puntaje = 0
var contador2 = 0
var contador = 0
document.getElementById("barra").value = contador
document.getElementById("barra").innerHTML = contador

// Circulos de opciones
var opciones = document.getElementsByClassName("opcion")
var op = []

//Opciones de dificultad
var radios = document.getElementsByName("dificultad")

// Elementos generales
var semaforo = document.getElementById('semaforo')
var img_cuento = document.getElementById('cuento')
var aux_res = 0, resp1 = "", resp2 = "", arr_datos1, arr_datos2, arr_opciones = []
var num_parrafo = 0, aux = 0
const audioCorrecto = document.getElementById('audioCorrecto');
const audioIncorrecto = document.getElementById('audioIncorrecto');

// Variables de lectura
var preguntas = []
var preguntas_f = [
    { 
        p:"¿Qué oficio tenía el padre?", 
        res1: ["molinero", "carpintero", "herrero", "panadero", "zapatero"],
    },
    { 
        p:"¿A quién le dejó de herencia al gato?",
        res2: ["hijo menor", "hijo mayor", "unico hijo", "segundo hijo"]
    },
    { 
        p:"¿Qué animal cazó el gato?",
        res1: ["conejos", "aves", "ratones", "liebres"]
    },
    { 
        p:"¿De dónde era el Marqués?",
        res2: ["Carabás", "Alcarás", "Caravela", "Barabás", "Garabás"]
    },
    { 
        p:"¿Por dónde paseaba el rey?",
        res1: ["río", "arroyo","laguna", "manantial", "lago"]
    },
    { 
        p:"¿A dónde invitó el rey al Marqués?",
        res2: ["carruaje", "palacio", "castillo", "carroza"]
    },
    { 
        p:"¿A quién engañó el gato?",
        res1: ["un ogro", "una bruja", "un hechicero", "un duende"]
    },
    { 
        p:"¿De qué era propietario?",
        res2: ["tierras", "praderas", "sembradíos", "bosques"]
    },
    { 
        p:"¿En qué lugar se hizo la fiesta?",
        res1: ["bosque", "palacio", "lago", "castillo"]
    },
    { 
        p:"¿En dónde se quedó a vivir el gato?",
        res2: ["palacio", "hacienda", "castillo", "mansión"]
    }
]

var preguntas_m = [
    {
        p:"¿De qué color era el uniforme del soldadito?",
        res1: ["rojo", "azul", "morado", "negro", "verde", "café", "dorado", "blanco", "gris", "púrpura"]
    },
    {
        p:"¿De qué material era la bailarina?",
        res2: ["porcelana", "papel", "madera", "cerámica", "cartón", "arcilla", "tela", "plástico", "fieltro", "fomi"]
    },
    {
        p:"¿Por quién fue atrapado el soldadito?",
        res1: ["un niño", "dos niños", "tres niños", "un niño y una niña", "una niña", "dos niñas", "tres niñas", "unos hermanos", "unos gemelos", "tres hermanos"]
    },
    {
        p:"¿Cómo era el espíritu del soldadito?",
        res2: ["indomable", "rebelde", "valiente", "inquebrantable", "fuerte", "firme", "tenaz", "perseverante", "resistente", "irrompible"]
    },
    {
        p:"¿Por quién fue vendido el pescado que tenía al soldadito?",
        res1: ["el papá del pescador", "el mercader", "el mismo pescador", "la hija del pescador", "la esposa del pescador", "la mamá del pescador", "la amiga", "el amigo"]
    },
    {
        p:"¿En dónde colocaron de nuevo al soldadito?",
        res2: ["el estante", "el librero", "el anaquel", "la vitrina", "la alacena", "la repisa", "la mesa", "el buró", "la comoda"]
    },
    {
        p:"¿En qué parte de la habitación se encontraba la chimenea?",
        res1: ["el final", "en la esquina", "cerca de la ventana", "en medio", "por la puerta", "en la entrada", "por el sillón", "por la silla"]
    },
    {
        p:"¿Qué hizo el soldadito al ver que cayó a la chimenea?",
        res2: ["saltó tras ella", "se dejó caer", "usó la ráfaga", "se tambaleó", "saltó al vacío", "perdió el equilibrio", "se lanzó", "brincó al fuego"]
    },
    {
        p:"¿Quién encontró al soldadito y la bailarina?",
        res1: ["la criada", "la mucama", "la sirvienta", "la ama de llaves", "la nana", "el mayordomo", "el criado", "el sirviente", "el amo de llaves"]
    },
    {
        p:"¿Qué fue lo que quedó de la bailarina?",
        res2: ["la lentejuela", "el listón", "el tutú", "las zapatillas", "el leotardo", "la diadema", "la tiara", "el collar"]
    }
]

var preguntas_d = [
    {
        p:"¿Cómo estaba el día en que nació el patito?",
        res1: ["soleado", "brillante", "nublado", "gris", "cálido", "despejado", "claro", "radiante"]
    },
    {
        p:"¿Cómo era el patito feo?",
        res2: ["grande y torpe", "enorme y lento", "alto y despistado", "robusto y torpe", "grande y despistado", "gris y desalineado", "grande y gris", "desalineado y grande", "desproporcionado y torpe", "desproporcionado y despistado"]
    },
    {
        p:"¿En dónde se escondió el patito feo?",
        res1: ["laguna congelada", "estanque helado", "charca fría", "pantano helado", "lago congelado", "frío río", "río congelado", "fría laguna", "charca congelada", "frío lago"]
    },
    {
        p:"¿Quién encontró al patito feo?",
        res2: ["Una anciana", "Un anciano", "Una campesina", "Un campesino", "Una abuela", "Un abuelo", "Una aldeana", "Un aldeano", "Una niña", "Un niño"]
    },
    {
        p:"¿En dónde se escondió el patito feo?",
        res1: ["en un matorral", "en la maleza", "en un arbusto", "entre las hierbas", "entre lirios", "entre cañas", "entre el pasto", "entre las plantas"]
    },
    {
        p:"¿Cómo miraron los cisnes al patito feo?",
        res2: ["curiosidad", "interés", "atención", "inquietud", "extrañeza", "entusiasmo", "fascinación", "aprecio"]
    },
    {
        p:"¿En qué se había transformado el patito feo?",
        res1: ["cisne blanco y elegante", "cisne blanco y hermoso", "cisne blanco y bello", "cisne blanco y refinado", "cisne blanco y sofisticado", "cisne bello y hermoso", "cisne elegante y sofisticado", "cisne hermoso y elegante"]
    },
    {
        p:"¿Cómo le hicieron sentir los demás cisnes al patito?",
        res2: ["amado", "aceptado", "querido", "valorado", "estimado", "apreciado", "respetado", "considerado"]
    },
    {
        p:"¿Qué sintió el patito feo?",
        res1: ["libertad y felicidad", "entusiasmo y alegría", "gozo y alegría", "calidez y dicha", "determinación y plenitud", "gozo y calidez", "plenitud y felicidad", "entusiasmo y regocijo", "bienestar y felicidad", "euforia y calidez"]
    },
    {
        p:"¿Cómo vivió su vida el patito feo?",
        res2: ["plena y feliz", "entusiasta y cálida", "con dicha y felicidad", "plena y felicidad", "con bienestar y amor", "amorosa y feliz", "con dicha y amor", "con entusiasmo y alegría", "llena de alegría", "llena de amor"]
    }
]

function Progreso(progreso,puntaje){
    $.ajax({
        url: 'conexiones/actualizar_progreso_a.php',  
        type: 'POST',
        data: {
            progreso: progreso, 
            puntaje: puntaje,
            num_juego: 9,
        },
        success: function(response) {
            console.log('Progreso actualizado', response);
        },
        error: function(xhr, status, error) {
            console.error('Error al actualizar el progreso: ' + error);
        }
    });
}

function Empezar(){
    puntaje = 10
    document.getElementById('aparecer').style.display='block';
    //alert(valor)
    switch(valor){
        case 'facil':
            contador2 = 0
            preguntas = preguntas_f
            document.getElementById("titulo").innerHTML = "El gato con botas"
            //alert("Aux: " +aux)
            Opciones()
            Parrafos(resp1, resp2, num_parrafo)
            Pregunta()
            break

        case 'medio':
            contador2 = 3.3
            preguntas = preguntas_m
            document.getElementById("titulo").innerHTML = "Soldadito de plomo"
            Opciones()
            Parrafos(resp1, resp2, num_parrafo)
            Pregunta()
            break
        
        case 'dificil':
            contador2 = 6.6
            preguntas = preguntas_d
            document.getElementById("titulo").innerHTML = "El patito feo"
            Opciones()
            Parrafos(resp1, resp2, num_parrafo)
            Pregunta()
            break
    }
}

function Opciones(){
    if(resp1 == ""){
        //Repetidas(op)
        arr_datos1 = preguntas[aux_res][Object.keys(preguntas[aux_res])[1]];
        var final = Repetidas(arr_datos1, op = [], resp1)
        arr_opciones = final.opciones
        resp1 = final.respuesta
        //alert(resp1)
        //alert("Opciones en retorno: " + arr_opciones)
        return Opciones(resp1, resp2)
    }

    if(resp2 == ""){
        arr_datos2 = preguntas[aux_res+1][Object.keys(preguntas[aux_res+1])[1]];
        var final = Repetidas(arr_datos2, op = [], resp2)
        resp2 = final.respuesta
        arr_datos2 = final.opciones
        //alert(resp2)
        return Opciones(resp1, resp2)
    }
}

function Repetidas(op, vacio, resp){
    if(vacio.length == 4){
        //alert("Opciones en repetidas: " + vacio)
        resp = vacio[Math.floor(Math.random() * vacio.length)];
        return {
            arreglo: op,
            opciones: vacio,
            respuesta: resp
        }
    } 

    else {
        let r = Math.floor(Math.random() * op.length) // Se elige una letra aleatoria que se encuentra en el arreglo
        //alert(r)
        vacio.push(op[r]) 
        //alert(vacio.length) // Se agrega en las opciones
        result = vacio.filter((item,index)=>{ // Filtro para determinar si una letra elegida ya está en el arreglo y evitar duplicidad
            return vacio.indexOf(item) === index;
        })
        //alert(vacio)
        return Repetidas(op, result, resp)
    }
}

function Parrafos(res1, res2, num_parrafo){
    switch(valor){
        case 'facil':
            parrafo_f = [
                {pa: "Un " + res1 + " dejó a su "+ res2 + " un gato como herencia. Aunque decepcionado, el joven pensó que el gato era inútil. Sin embargo, el gato habló y prometió hacer de su dueño un hombre rico si le conseguía unas botas y un saco."},
                {pa: "Con sus nuevas botas, el astuto gato cazó "+ res1 + " que entregó al rey, diciendo que eran regalos de su amo, el Marqués de "+ res2 +". El rey, impresionado por las ofrendas, comenzó a interesarse por este noble 'marqués'."},
                {pa: "Un día, el gato supo que el rey pasearía cerca del "+ res1 +". Ordenó a su amo que se bañara allí. Cuando el rey pasó, el gato gritó que el marqués había sido robado. El rey, compadecido, ofreció al joven ropa elegante y lo invitó a su "+ res2 +"."},
                {pa: "Mientras viajaban, el gato corrió adelante y engañó a "+ res1 +", propietario de grandes "+ res2 +", para que se transformara en un ratón. Al hacerlo, el gato se lo comió, y sus tierras quedaron en posesión del supuesto marqués."},
                {pa: "Gracias a las astutas maniobras del gato, el joven se casó con la princesa en una gran fiesta cerca del "+ res1 +", convirtiéndose en un noble verdadero. El gato vivió una vida de comodidades en el "+ res2 +", orgulloso de haber asegurado la fortuna de su amo."}
            ]
            document.getElementById("parrafo").innerHTML = parrafo_f[num_parrafo].pa
            break

        case 'medio':
            parrafo_m = [
                {pa: "Había una vez un soldadito de plomo que tenía una sola pierna, pues fue el último de una serie y no alcanzó el plomo para darle dos. A pesar de esto, siempre mantenía la cabeza alta y el corazón valiente, luciendo elegante su uniforme color " + res1 +". Vivía en la habitación de un niño, junto con otros juguetes, pero lo que más amaba era una bailarina de "+ res2 +". Ella también se mantenía en un solo pie, lo que hacía que el soldadito sintiera que tenían algo en común."},
                {pa: "Un día, el soldadito cayó accidentalmente por la ventana y aterrizó en la calle. Fue arrastrado por la corriente de agua de una tormenta hasta una alcantarilla, donde fue atrapado por "+ res1 +" que lo colocaron en un barco de papel. El barco navegó por las aguas turbulentas hasta que finalmente fue tragado por un pez enorme. Sin embargo, el soldadito, con su espíritu "+ res2 +", siguió firme, esperando su destino con valor."},
                {pa: "El pez fue atrapado por un pescador y, sorprendentemente, vendido por "+ res1 +", en el mismo mercado donde vivía el soldadito. El pescado llegó a la cocina de la casa del niño, y cuando lo abrieron, encontraron al soldadito de plomo en su interior. El niño volvió a colocar al soldadito en su lugar en "+ res2 +", junto a la bailarina, lo que hizo que sintiera que su valentía había sido recompensada."},
                {pa: "Un día, mientras el soldado contemplaba a la bailarina, una ráfaga de viento sopló en la habitación y llevó a la bailarina hacia la chimenea encendida " + res1 + " de la habitación. El soldadito, con su coraje inquebrantable, " + res2 + ", decidido a seguirla donde fuera. Ambos cayeron en las llamas, pero justo antes de ser consumidos, el soldadito pudo ver cómo la bailarina mantenía su mirada en él."},
                {pa: "Al día siguiente, " + res1 +" entre las cenizas, se encontró un pequeño corazón de plomo, lo único que quedaba del soldadito, y "+ res2 +" de la bailarina. Aunque se habían desvanecido, su historia de amor y valentía quedó en la memoria de todos, recordando que, aunque pequeños y frágiles, el coraje y el amor pueden superar cualquier adversidad."},
            ]
            document.getElementById("parrafo").innerHTML = parrafo_m[num_parrafo].pa
            break

        case 'dificil':
            parrafo_d = [
                {pa: "En un "+ res1 +" día de verano, una madre pata esperaba ansiosamente a que sus huevos se rompieran. Uno a uno, los patitos comenzaron a salir de sus cascarones, excepto el más grande, que tardó en abrirse. Finalmente, el huevo se rompió, y de él salió un patito diferente. Era "+ res2 +", con plumas grises en lugar de amarillas. Al verlo, la madre pata y sus otros hijos se sorprendieron. Los animales del corral no tardaron en señalar su apariencia, llamándolo 'feo' y burlándose de él sin cesar. El pobre patito comenzó a sentirse muy triste y rechazado por todos."},
                {pa: "A medida que pasaban los días, las burlas y el desprecio crecían. El patito feo decidió que no podía soportarlo más, así que un día escapó del corral. Viajó solo a través de bosques y campos, encontrando refugio temporal aquí y allá, pero siempre sintiendo el peso de la soledad. Durante el invierno, luchó por sobrevivir al frío, escondiéndose en "+ res1 +". "+ res2 +" lo encontró un día y lo llevó a su casa para cuidarlo, pero el patito, asustado, se escapó de nuevo, prefiriendo estar solo que enfrentar el rechazo."},
                {pa: "Cuando la primavera llegó, el patito feo estaba más grande y fuerte, pero aún se sentía diferente y solo. Un día, mientras se escondía en "+res1+", vio un grupo de majestuosos cisnes nadando en un lago cercano. Fascinado por su belleza, se acercó lentamente, deseando poder ser como ellos, aunque estaba seguro de que lo rechazarían. Para su sorpresa, los cisnes no lo ahuyentaron. En cambio, lo miraron con "+res2+". Confuso, el patito se acercó al agua para ver su reflejo, y lo que vio lo dejó sin aliento."},
                {pa: "En el agua, no vio al patito feo que todos habían despreciado, sino un cisne blanco y "+res1+". Durante el invierno, había crecido y se había transformado en uno de los cisnes que tanto admiraba. Ahora entendía por qué siempre había sido diferente: no era un pato, sino un cisne. Su corazón se llenó de alegría al darse cuenta de que había encontrado su verdadera identidad. Los otros cisnes lo rodearon, dándole la bienvenida como uno de los suyos. Por primera vez, el patito feo se sintió "+res2+"."},
                {pa: "El nuevo cisne nadó con su grupo, sintiendo "+res1+". A partir de ese día, vivió entre los cisnes, disfrutando de la belleza de su nuevo hogar y la compañía de sus iguales. El recuerdo de su difícil pasado se desvaneció, reemplazado por la satisfacción de haber encontrado su lugar en el mundo. Así, el patito feo, que nunca había sido feo en realidad, vivió una vida " + res2 +", sabiendo que la verdadera belleza viene de entender quien eres realmete."},
            ]
            document.getElementById("parrafo").innerHTML = parrafo_d[num_parrafo].pa
            break
    }
}

function Pregunta(){
    // Sirve para llamar el elemento del arreglo compuesto sin poner directamente el nombre de la variable
    // Por ejemplo, quiero que se cambien los valores de las repsuestas, 
    //alert(preguntas[aux_res][Object.keys(preguntas[aux_res])[1]])
    document.getElementById("pregunta").innerHTML = preguntas[aux_res].p

    //alert("Opciones en funcion pregunta: " + arr_opciones)
    //alert(resp1)
    for(let i = 0; i < 4; i++){
        //opciones[i].innerHTML = preguntas[aux_res][Object.keys(preguntas[aux_res])[1]][i]
        opciones[i].innerHTML = arr_opciones[i]
    }
}

function validar(respuesta){
    if(aux == 0){
        if(respuesta == resp1){
            audioCorrecto.play(); // Iniciar audio correcto :D
            contador2 += 0.3
            Progreso(contador2, puntaje)
            aux++
            aux_res++
            arr_opciones = []
            //alert("Segundo arreglo: " + arr_datos2)
            arr_opciones = arr_datos2
            Felicidades()
            Pregunta()
        }
        else{
            audioIncorrecto.play(); // Iniciar audio incorrecto :c
            Fallo()
        }
    }
    else if(aux == 1){
        if(respuesta == resp2){
            contador2 += 0.3
            Progreso(contador2, puntaje)
            num_parrafo++
            aux_res++
            aux = 0
            resp1 = ""
            resp2 = ""
            arr_opciones = []
            Felicidades()
            Empezar()
        }
        else{
            Fallo()
        }
    }
    
}

window.addEventListener("keydown",(e)=>{
    let tecla = e.key
    switch(tecla){
    case 'ArrowUp':
        validar(arr_opciones[0])
        break;
    case 'ArrowDown':
        validar(arr_opciones[1])
        break;
    case 'ArrowLeft':
        validar(arr_opciones[2])
        break;
    case 'ArrowRight':
        validar(arr_opciones[3])
        break;
    default:
        break;
    }
})

function Ayuda(){
    swal({
        title: "Tutorial",
        text: "Lee la lectura detenidamente y contesta las preguntas. Elige la opción correcta por medio de las teclas ↑ ↓ → ← o los botones del tablero.",
        icon: "Visual/Material/Animaciones/Generales/teclas.jpg"
    })
}

Ayuda() // Tutorial al abrir la pestaña por primera vez

window.onload = function() {
    valor = localStorage.getItem('valorBoton');
    if(valor == 'facil'){
        semaforo.src = "Visual/Material/Recursos/SemaforoFacil.png"
        img_cuento.src = "Visual/Material/Letras/Juego3/GatoConBotas.png"
    }
        

    if(valor == 'medio'){
        semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
        img_cuento.src = "Visual/Material/Letras/Juego3/SoldaditoDePlomo.png"
    }
        

    if(valor == 'dificil'){
        semaforo.src = "Visual/Material/Recursos/SemaforoDificil.png"
        img_cuento.src = "Visual/Material/Letras/Juego3/PatitoFeo.png"
    }
}

function Fallo(){
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
            icon: "Visual/Material/Animaciones/Generales/triste.jpg",
            buttons:  ["Reintentar", "Salir"] 
        })
        .then((reintento) => {
            if (reintento) {
                location.href = "JuegosLetras.html"
            } 
            else{
                if(valor == 'facil'){
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
                                img_cuento.src = "Visual/Material/Letras/Juego3/SoldaditoDePlomo.png"
                            }

                            else if(valor == 'medio'){
                                valor = "facil"
                                semaforo.src = "Visual/Material/Recursos/SemaforoFacil.png"
                                img_cuento.src = "Visual/Material/Letras/Juego3/GatoConBotas.png"
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
                            valor == 'facil'
                            Reiniciar()
                        }
                    })
                }

                else{
                    swal({
                        title: "Felicidades",
                        text: "¿Quieres avanzar al siguiente nivel o salir del juego?",
                        icon: "Visual/Material/Animaciones/Generales/PolloBien (2).gif",
                        buttons:  ["Siguiente nivel", "Salir"] 
                    })
                    .then((reintento) => {
                        if (reintento) {
                            location.href = "JuegosLetras.html"
                        } 
                        else{
                            if(valor == 'facil'){
                                valor = 'medio'
                                semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
                                img_cuento.src = "Visual/Material/Letras/Juego3/SoldaditoDePlomo.png"
                                Reiniciar()
                            }

                            else{
                                if(valor == 'medio'){
                                    valor = 'dificil'
                                    semaforo.src = "Visual/Material/Recursos/SemaforoDificil.png"
                                    img_cuento.src = "Visual/Material/Letras/Juego3/PatitoFeo.png"
                                    Reiniciar()
                                }
                            }
                        }
                    })
                }
            }
        } 
    })
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

function Reiniciar(){
    puntaje = 0
    contador2 = 0
    Progreso(contador2, puntaje)
    error = 3
    vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
    contador = 0
    document.getElementById("barra").value = contador
    document.getElementById("barra").innerHTML = contador
    resp1 = ""
    resp2 = ""
    num_parrafo = 0
    aux = 0
    aux_res = 0
    arr_datos1 = []
    arr_datos2 = []
    Empezar()
}
    </script>
</body>
</html>