// Vidas
var error = 3
var vida = document.getElementById('vida');
vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'

// Barra de progreso
contador = 0
document.getElementById("barra").value = contador
document.getElementById("barra").innerHTML = contador

// Elementos generales
const op_palabras = ["uva", "vela", "vaso", "viento", "volcán", "globo", "lombríz", "libro", "balón", "barco"]
var palabras = op_palabras
var opciones = document.getElementsByClassName("opcion")
var respuesta
var arreglo = ["b", "v"]

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
    palabras = op_palabras
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
        document.getElementById("linea").innerHTML = respuesta
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
            //Empezar()
            break;
        case 'ArrowLeft':
            //Empezar()
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

window.onload = function() {
    valor = localStorage.getItem('valorBoton');
}