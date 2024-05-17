const palabras = ["tortuga", "perro", "pollo", "gato"]
const letras = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
var opciones = document.getElementsByClassName("opcion")
var guion = ""
var respuesta 
var n = 0
var result
var contador = 0

function Inicio(){
    contador = 0
    respuesta = palabras[Math.floor(Math.random() * palabras.length)] 
    var imagen = document.getElementById("figura")
    imagen.src = "Visual/Material/Letras/Juego1/Animales/" + respuesta + ".png"
    console.log("Respuesta: ",respuesta)
    guion = respuesta.replace(/./g, "_ ")
    document.getElementById("linea").innerHTML = guion
    opcion(op = [])
}

function opcion(op){
    if(op.length == 4){
        for(var i = 0; i < guion.length; i++){
            var a = guion.charAt(i)
            if(a == '_'){
                var e = op.includes(respuesta[n]) 
                if(!e){
                    let r = Math.floor(Math.random() * op.length)
                    op.splice(r, 1, respuesta[n])
                    n++
                    console.log(op)

                    for (let i = 0; i < opciones.length; i++){ // Se muestran las opciones en pantalla
                        opciones[i].innerHTML = result[i]
                    }
                    break
                }
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
    for(let i = 0; i < respuesta.length; i++){
        if(respuesta[i] == letra){
            guion = replaceAt(guion, letra, i*2)
        }
    }

    document.getElementById("linea").innerHTML = guion
    var e = guion.includes('_')

    if(!e){
        contador++
        document.getElementById("contador").innerHTML = "Aciertos: " + contador
        console.log("Contador: ", contador)
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