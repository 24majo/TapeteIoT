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

// const objetos = {
//     resp: undefined,
//     opc_arr: [],
//     guion: undefined
// }

Ayuda()

function Reinicio(){
    swal({
        title: "Reiniciar juego",
        text: "Si reinicias ahora, el progreso se perderá. ¿Deseas continuar?",
        icon: "warning", // Indicar la ruta de las imágenes
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
    document.getElementById("barra").value = contador
    document.getElementById("barra").innerHTML = contador
    guion = []
    document.getElementById("linea").innerHTML = guion
    Inicio()
}

function Inicio(){
    guion = []
    respuesta = palabras[Math.floor(Math.random() * palabras2.length)]
    // alert(respuesta)
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
        for(var i = 0; i < respuesta.length; i++) {
            if(respuesta[i]==vocal){
                guion = replaceAt(guion, vocal, i)
            }
        }
        document.getElementById("linea").innerHTML = guion
    }

    else{
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
                icon: "error",
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
            icon: "Visual/Material/Animaciones/Generales/echeleganas.png"
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
                        icon: "Visual/Material/Animaciones/Generales/pollo.gif",
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

// function Inicio(){
//     document.getElementById("btnIniciar").innerHTML = "Siguiente"
//     var respuesta = palabras[Math.floor(Math.random() * palabras.length)] 
//     var guion = respuesta.replace(/a|e|i|o|u/g, "_") 
//     var imagen = document.getElementById("figura")
//     imagen.src = "Visual/Material/Letras/Juego1/" + respuesta + ".png"
//     objetos.guion = guion
//     document.getElementById("linea").innerHTML = objetos.guion
//     opcion(arr_op = [], 0, respuesta)
//     document.getElementById('circulos').style.display='block';
// }

// function Reiniciar(){
//     error = 3
//     contador = 0
//     document.getElementById("btnIniciar").innerHTML = "Empezar"
//     imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
//     document.getElementById("barra").value = contador
//     document.getElementById("barra").innerHTML = contador
//     Inicio()
// }

// function opcion(arr_op, aux, respuesta){ // Función recursiva
//     if(arr_op.length == 4){ // Si el arreglo llega a 4 opciones
//         for (let i = 0; i <= respuesta.length; i++){
//             var a = respuesta.indexOf(vocales[i])
//             if(a != -1){ // Cuando es diferente de -1 significa que si existe
//                 var e = arr_op.includes(vocales[i]) // Se evalúa si la vocal existente está entre las opciones
//                 if(!e){ // Si no existe, se elige una posición aleatoria de las opciones y se agrega
//                     let r = Math.floor(Math.random() * arr_op.length)
//                     arr_op.splice(r, 1, vocales[i])
//                 }
//             }
//         }

//         for (let i = 0; i < opciones.length; i++){ // Se muestran las opciones en pantalla
//             opciones[i].innerHTML = arr_op[i]
//         }
//         objetos.resp = respuesta
//         objetos.opc_arr = arr_op
//         console.log(objetos.opc_arr)
//     }

//     else{
//         let r = Math.floor(Math.random() * vocales.length) // Se eligen vocales aleatorias... 
//         arr_op.push(vocales[r]) //... para ponerlas como opciones
//         var result = arr_op.filter((item,index)=>{ // Se evita que las vocales aleatorias se repitan
//             return arr_op.indexOf(item) === index;
//         })
//         return opcion(result, aux+1, respuesta) // Se retorna a la función para realizarlo hasta llegar a 4 opciones
//     }
// }

// const replaceAt = (string, character, index) => {
//     return string.substring(0, index) + character + string.substring(index + character.length);
// }

// function validar(valor){
//     for(var i = 0; i < objetos.resp.length; i++){
//         if(objetos.resp[i] == objetos.opc_arr[valor]){
//             objetos.guion = replaceAt(objetos.guion, objetos.opc_arr[valor], i)
//             break
//         }

//         else{
//             if(i == objetos.resp.length - 1){
//                 //alert("Entra")
//                 error--
//                 if(error == 2){
//                     imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon2.png" width="100">'
//                 }
        
//                 if(error == 1){
//                     imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon1.png" width="100">'
//                 }
        
//                 if(error == 0){
//                     imagen.innerHTML = ""
//                     swal({
//                         title: "Oh no!",
//                         text: "No te quedan más vidas. ¿Deseas salir o reintentar?",
//                         icon: "error",
//                         buttons:  ["Reintentar", "Salir"] 
//                     })
//                     .then((reintento) => {
//                         if (reintento) {
//                             location.href = "JuegosLetras.html"
//                         } 
//                         else{
//                             document.getElementById("btnIniciar").innerHTML = "Empezar"
//                             Reiniciar()
//                         }
//                     })
//                 }
//             }
//         }
//     }

//     document.getElementById("linea").innerHTML = objetos.guion
//     var e = objetos.guion.includes('_')
    
//     if(!e){
//         contador++
//         document.getElementById("btnIniciar").innerHTML = "Continuar"
//         document.getElementById("barra").value = contador
//         document.getElementById("barra").innerHTML = contador
//         //document.getElementById("contador").innerHTML = "Aciertos: " + contador
//     }
// }

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
        text: "Elige la vocal correcta para completar la palabra. Elige la opción correcta por medio de las teclas ↑ ↓ → ← o los botones del tablero.",
        icon: "Visual/Material/Animaciones/Generales/teclado.gif"
    })
}