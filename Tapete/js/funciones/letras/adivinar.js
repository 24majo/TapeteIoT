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

Ayuda()

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
    // guion = respuesta.replace(/./g, "_ ")
    // document.getElementById("linea").innerHTML = guion
    opcion(op = []) // Función de opciones para colocarlos en los círculos
    document.getElementById('circulos').style.display='block'
}

function opcion(op){ // Función recursiva para rellenar el arreglo hasta llegar a 4
    if(op.length == 4){
        if(guion.indexOf("_") != -1) { // Toma el primer guion que encuentre en la palabra
            //alert(respuesta[guion.indexOf("_")])
            //alert("Arreglo antes: "+op)
            var e = op.includes(respuesta[guion.indexOf("_")]) // Evaluar si el arreglo incluye letras de la palabra
            if(!e){ // Si no encuentra
                let r = Math.floor(Math.random() * op.length)
                op.splice(r, 1, respuesta[guion.indexOf("_")]) // Elegir una posición aleatoria de las opciones para reemplazarla por la nueva letra
                //alert("Arreglo después: "+op)
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
            vida.innerHTML = '<img src="Visual/Material/Iconos/corazon2.png" width="100">'
        }

        if(error == 1){
            vida.innerHTML = '<img src="Visual/Material/Iconos/corazon1.png" width="100">'
        }

        if(error == 0){
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
    // for(let i = 0; i < respuesta.length; i++){
    //     if(respuesta[i] == letra){
    //         guion = replaceAt(guion, letra, i)
    //     }
    // }

    // document.getElementById("linea").innerHTML = guion
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

                if(contador == 10){
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
            opcion(op = [])
            break;
        case 'ArrowDown':
            opcion(op = [])
            break;
        case 'ArrowLeft':
            opcion(op = [])
            break;
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