const palabras = ["cereza", "chocolate", "fresa", "gato","helado","libro","manzana", "pastel", "pelota", "peluche","pera","perro","pizza","pollo","tortuga"]
const letras = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
var opciones = document.getElementsByClassName("opcion")
var guion = []
var respuesta 
var result
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
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })

    .then((Reinicia) => {
        if (Reinicia) {
            document.getElementById("btnIniciar").innerHTML = "Empezar"
            Reiniciar()
        } 
    });
}

function Reiniciar(){
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
    respuesta = palabras[Math.floor(Math.random() * palabras.length)] // Elegir una palabra aleatoria
    imagen = document.getElementById("figura") 
    imagen.src = "Visual/Material/Letras/Juego2/" + respuesta + ".png"

    for (var i = 0; i < respuesta.length; i++) {
        guion[i] = "_";
    }
    document.getElementById("linea").innerHTML = guion.join(" ")
    // guion = respuesta.replace(/./g, "_ ")
    // document.getElementById("linea").innerHTML = guion
    opcion(op = [])
    document.getElementById('circulos').style.display='block'
}

function opcion(op){
    if(op.length == 4){
        if(guion.indexOf("_") != -1) {
            //alert(respuesta[guion.indexOf("_")])
            //alert("Arreglo antes: "+op)
            var e = op.includes(respuesta[guion.indexOf("_")])
            if(!e){
                let r = Math.floor(Math.random() * op.length)
                op.splice(r, 1, respuesta[guion.indexOf("_")])
                //alert("Arreglo después: "+op)
            }
            for (let i = 0; i < opciones.length; i++){
                opciones[i].innerHTML = op[i]
            }
        }
    } 

    else {
        let r = Math.floor(Math.random() * letras.length) 
        op.push(letras[r]) 
        result = op.filter((item,index)=>{ 
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
    // for(let i = 0; i < respuesta.length; i++){
    //     if(respuesta[i] == letra){
    //         guion = replaceAt(guion, letra, i)
    //     }
    // }

    // document.getElementById("linea").innerHTML = guion
    var e = guion.includes('_') // Validar que la palabra se haya completado

    if(!e){
        document.getElementById("btnIniciar").innerHTML = "Continuar"
        contador++
        document.getElementById("barra").value = contador
        document.getElementById("barra").innerHTML = contador
        Inicio()
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
    swal("Tutorial", 
"Completa la palabra de acuerdo con la imagen y las opciones mostradas.")
}