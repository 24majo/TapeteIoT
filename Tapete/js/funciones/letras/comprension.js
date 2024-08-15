// Vidas
var imagen = document.getElementById('vida');
imagen.innerHTML = '<img src="Visual/Material/Numeros/Juego1/3.jpg" width="100">'
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
var lugar = ["una pradera", "un sendero", "un bosque", "una granja"]
var flores = ["los girasoles", "las rosas", "los tulipanes", "los narcisos"]
var lugar2 = ["las montañas", "los matorrales", "los árboles", "las hierbas"]
var emocion = ["asustada", "emocionada", "aturdida", "inquieta", "desconfiada"]
var animal = ["los peces", "las ranas"]
var construir = ["un puente", "un camino"]
var materiales = ["ramas", "troncos", "rocas"]
var flores = ["flores", "mariposas", "animales"]
var tiempo = ["amanecer", "atardecer", "anochecer"]


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
                document.getElementById("titulo").innerHTML = "El lugar especial"
                document.getElementById("parrafo").innerHTML = "En una pradera vivían una vaca llamada Clara y un cordero llamado Tito. Clara era tranquila y siempre disfrutaba de los girasoles, mientras que Tito era aventurero y le encantaba explorar cada rincón. "
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

function Ayuda(){
    swal("Tutorial", 
        "Lee la lectura detenidamente y contesta las preguntas.");
}
