// Vidas
var error = 3
var vida = document.getElementById('vida');
vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'

// Barra de progreso
contador = 0
document.getElementById("barra").value = contador
document.getElementById("barra").innerHTML = contador

// Elementos generales
const palabras_f = ["uva", "vela", "vaso", "viento", "volcán", "globo", "lombríz", "libro", "balón", "barco"]
const palabras_m = ["víbora", "vivir", "burbuja", "bebé", "beber", "babosa"]
var palabras
var opciones = document.getElementsByClassName("opcion")
var respuesta
var arreglo = []
var num_ejercicio = 0, num_opcion = 0
var palabras_d =[
    {
        frase: "Las vacas pueden volar.",
        valores: ["vacas", "volar"]
    },
    {
        frase: "Las abejas saben bailar.",
        valores: ["abejas", "bailar"]
    }
]

//Ayuda()

function Reinicio(){
    swal({
        title: "Reiniciar juego",
        text: "Si reinicias ahora, el progreso se perderá. ¿Deseas continuar?",
        icon: "warning",
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
    palabras = palabras_f
    error = 3
    vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
    contador = 0
    imagen = ""
    document.getElementById("linea").innerHTML = ""
    document.getElementById("barra").value = contador
    document.getElementById("barra").innerHTML = contador
    Empezar()
}

function Empezar(){
    switch(valor){
        case 'facil':
            arreglo = ["b", "v"]
            palabras = palabras_f
            respuesta = palabras[Math.floor(Math.random() * palabras.length)]
            var repetida = palabras.indexOf(respuesta)
            palabras.splice(repetida, 1)
            //alert(palabras)
            document.getElementById("linea").innerHTML = respuesta
            imagen = document.getElementById('figura') 
            imagen.src = "Visual/Material/Letras/Juego4/" + respuesta + ".png"
            
            if(respuesta.includes('b') == true || respuesta.includes('v') == true){
                document.getElementById("linea").innerHTML = respuesta.replaceAll(/b|v/g, "_")
            }

            for(let i = 0; i < arreglo.length; i++){
                opciones[i].innerHTML = arreglo[i]
            }
            
            document.getElementById('aparecer').style.display='block';
            break

        case 'medio':
            
            break
        
        case 'dificil':
            arr_res = palabras_d[num_ejercicio].valores
            respuesta = arr_res[num_opcion]
            alert(respuesta)

            if(num_opcion == 0){
                arr_res.forEach(valor => {
                    palabras_d[num_ejercicio].frase = palabras_d[num_ejercicio].frase.replaceAll(valor, "_______");
                });
            }
            
            document.getElementById("linea").innerHTML = palabras_d[num_ejercicio].frase

            if(respuesta.includes("b")){
                var palabra = respuesta.replace("b", "v");
                
                if(arreglo.length == 2){
                    arreglo[0] = palabra
                    arreglo[1] = respuesta
                }
                else{
                    arreglo.push(palabra)
                    arreglo.push(respuesta)
                }
            }
            else if(respuesta.includes("v")){
                var palabra = respuesta.replace("v", "b");
                if(arreglo.length == 2){
                    arreglo[0] = respuesta
                    arreglo[1] = palabra
                }
                else{
                    arreglo.push(respuesta)
                    arreglo.push(palabra)
                }
                
            }

            alert(arreglo)

            for (let i = 0; i < opciones.length; i++){
                    opciones[i].innerHTML = arreglo[i] // Se muestran las opciones en los círculos
            }

            document.getElementById('aparecer').style.display='block';
            // if(palabras_d[num_ejercicio].frase.includes(arr_res[0]) && palabras_d[num_ejercicio].frase.includes(arr_res[1])){
            //     document.getElementById("linea").innerHTML = palabras_d[num_ejercicio].frase.replaceAll(/arr_res[0]|arr_res[1]/g, "_")
            // }
            break
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
                break

            case 'medio':
                break

            case 'dificil':
                palabras_d[num_ejercicio].frase = palabras_d[num_ejercicio].frase.replace("_______", respuesta)
                document.getElementById("linea").innerHTML = palabras_d[num_ejercicio].frase
                num_opcion++

                if(num_opcion > 1){
                    num_ejercicio++
                    num_opcion = 0
                }
                break
        }
        
        swal({
            title: "¡Muy bien!",
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
                    Empezar()
                }
            } 
        })
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
}

window.addEventListener("keydown",(e)=>{
    let tecla = e.key
    switch(tecla){
    case 'ArrowLeft':
        //alert(arreglo[0])
        Comprobar(arreglo[0])
        break;
    case 'ArrowRight':
        //alert(arreglo[1])
        Comprobar(arreglo[1])
        break;
    default:
        break;
    }
})

window.addEventListener("keyup",(e)=>{
    let tecla = e.key

    switch(tecla){
        case 'ArrowRight':
            Empezar()
            break;
        case 'ArrowLeft':
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
        icon: "Visual/Material/Animaciones/Generales/teclado.gif"
    })
}

valor = "dificil"

// window.onload = function() {
//     valor = localStorage.getItem('valorBoton');
// }