// Vidas
var imagen = document.getElementById('vida');
imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
var error = 3
// Barra de progreso
contador = 0
document.getElementById("barra").value = contador
document.getElementById("barra").innerHTML = contador
// Elementos generales
const palabras = ["cereza", "chocolate", "fresa", "gato","helado","libro","manzana", "pastel", "pelota", "peluche","pera","perro","pizza","pollo","tortuga"]
var palabras2 = palabras// Variable para eliminar las palabras del arreglo y evitar que se repitan
const vocales = ["a","e","i","o","u"]
var opciones = document.getElementsByClassName("opcion")
var respuesta = ""
var guion = ""
var op_arr = []
var puntaje = 10
const audioCorrecto = document.getElementById('audioCorrecto');
const audioIncorrecto = document.getElementById('audioIncorrecto');

Ayuda()

function Progreso(progreso,puntaje){
    $.ajax({
        url: 'conexiones/actualizar_progreso_a.php',  
        type: 'POST',
        data: {
            progreso: progreso, 
            puntaje: puntaje,
            num_juego: 7,
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
        icon: "Visual/Material/Animaciones/Generales/advertencia.jpg", // Indicar la ruta de las imágenes
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
    palabras2 = palabras // Recuperar las palabras originales
    error = 3
    vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
    contador = 0
    puntaje = 10
    document.getElementById("barra").value = contador
    document.getElementById("barra").innerHTML = contador
    guion = []
    document.getElementById("linea").innerHTML = guion
    Inicio()
}

function Inicio(){
    guion = []
    respuesta = palabras[Math.floor(Math.random() * palabras2.length)]
    guion = respuesta.replace(/a|e|i|o|u/g, "_") 
    var repetida = palabras2.indexOf(respuesta)
    palabras2.splice(repetida, 1)
    imagen = document.getElementById("figura") 
    imagen.src = "Visual/Material/Letras/Juego2/" + respuesta + ".png"
    document.getElementById("linea").innerHTML = guion
    opcion(op = [])
    document.getElementById('circulos').style.display='block';
}

function opcion(op){
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
        let r = Math.floor(Math.random() * vocales.length) // Se elige una vocal aleatoria 
        op.push(vocales[r])  // Se agrega en las opciones
        result = op.filter((item,index)=>{ // Filtro para determinar si una letra elegida ya está en el arreglo y evitar duplicidad
            return op.indexOf(item) === index;
        })
        return opcion(result)
    }
}

const replaceAt = (string, character, index) => {
    return string.substring(0, index) + character + string.substring(index + character.length);
}

function validar(vocal){
    if(respuesta.indexOf(vocal) != -1) {
        audioCorrecto.play(); // Iniciar audio correcto :D
        for(var i = 0; i < respuesta.length; i++) {
            if(respuesta[i]==vocal){
                guion = replaceAt(guion, vocal, i)
            }
        }
        document.getElementById("linea").innerHTML = guion
    }

    else{
        audioIncorrecto.play()  // Iniciar audio incorrecto :c
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

    var e = guion.includes('_')

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
                        icon: "Visual/Material/Animaciones/Generales/PolloBien (3).gif",
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
        text: "Elige la vocal correcta para completar la palabra. Elige la opción correcta por medio de las teclas ↑ ↓ → ← o los botones del tablero.",
        icon: "Visual/Material/Animaciones/Generales/teclas.jpg"
    })
}