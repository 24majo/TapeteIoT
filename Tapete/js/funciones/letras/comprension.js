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

//Opciones de dificultad
var radios = document.getElementsByName("dificultad")

// Elementos generales
var resultado = 0
var arreglo = []

// Variables de lectura
var profesion = ["un molinero", "un carpintero", "un herrero", "un panadero"]
var hijo = ["hijo menor", "hijo mayor", "unico hijo", "segundo hijo"]
var animalCaza = ["conejos", "aves", "ratones", "liebres"]
var nombreMarques = ["Carabás", "emocionada", "aturdida", "inquieta", "desconfiada"]
var lugar = ["los peces", "las ranas"]
var invitacion = ["un puente", "un camino"]
var criaturaMagica = ["ramas", "troncos", "rocas"]
var lugar2 = ["flores", "mariposas", "animales"]
var lugarfiesta = ["amanecer", "atardecer", "anochecer"]
var casaGato = ["amanecer", "atardecer", "anochecer"]

var res1, res2

Ayuda() // Tutorial al abrir la pestaña por primera vez

function Empezar(){
    if(!document.querySelector('input[name="dificultad"]:checked')){
        swal({
            title: "Advertencia",
            text: "Elige una dificultad para iniciar el juego",
            icon: "warning", 
        })
    } 

    else{
        // for(let y = 0; y < 3; y++){
        //     radios[y].disabled = true
        // }
        valor = document.querySelector('input[name="dificultad"]:checked').value
        document.getElementById('aparecer').style.display='block';

        switch(valor){
            case 'facil':
                document.getElementById("titulo").innerHTML = "El gato con botas"
                res1 = profesion[Math.floor(Math.random() * profesion.length)]
                res2 = hijo[Math.floor(Math.random() * hijo.length)]
                document.getElementById("parrafo").innerHTML = "En " + res1 + " vivían una vaca llamada Clara y un cordero llamado Tito. Clara era tranquila y siempre disfrutaba de "+ res2 +", mientras que Tito era aventurero y le encantaba explorar cada rincón. "
                Pregunta()

                
                break

            case 'medio':
                document.getElementById("titulo").innerHTML = "Soldadito de plomo"
                document.getElementById("parrafo").innerHTML = "2.1"
                break
            
            case 'dificil':
                document.getElementById("titulo").innerHTML = "El patito feo"
                document.getElementById("parrafo").innerHTML = "3.1"
                break
        }
    }
}

function Pregunta(){
    if(Math.floor(Math.random() * 2) == 1){
        document.getElementById("pregunta").innerHTML = "¿Qué flores le gustan a Clara?"
    }
    else{
        document.getElementById("pregunta").innerHTML = "¿En qué profesion viven Clara y Tito?"
    }
    
}

window.addEventListener("keydown",(e)=>{
    let tecla = e.key
    switch(tecla){
    case 'ArrowUp':
        break;
    case 'ArrowDown':
        break;
    case 'ArrowLeft':
        break;
    case 'ArrowRight':
        break;
    default:
        break;
    }
})

window.addEventListener("keyup",(e)=>{
    let tecla = e.key

    switch(tecla){
        case 'ArrowUp':
            break;
        case 'ArrowDown':
            break;
        case 'ArrowLeft':
            break;
        case 'ArrowRight':
            break;
        default:
            break;
    }
})

function Ayuda(){
    swal("Tutorial", 
        "Lee la lectura detenidamente y contesta las preguntas.");
}
