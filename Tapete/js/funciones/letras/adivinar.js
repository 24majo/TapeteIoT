const palabras = ["tortuga", "perro", "pollo", "gato"]
const letras = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
var opciones = document.getElementsByClassName("opcion")
var guion = ""
var respuesta 
var op = []
var n = 0

function Inicio(){
    respuesta = palabras[Math.floor(Math.random() * palabras.length)] 
    console.log("Respuesta: ",respuesta)
    guion = respuesta.replace(/./g, "_ ")
    document.getElementById("linea").innerHTML = guion
    opcion(op)

    
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
                        opciones[i].innerHTML = op[i]
                    }

                    break
                }
            }
        }
    }

    else {
        let r = Math.floor(Math.random() * letras.length) 
        op.push(letras[r]) 
        var result = op.filter((item,index)=>{ 
            return op.indexOf(item) === index;
        })
        return opcion(result)
    }
}

function validar(letra){
    console.log(letra)
}

window.addEventListener("keydown",(e)=>{
    let tecla = e.key

    switch(tecla){
    case 'ArrowUp':
        validar(op[0])
        break;
    case 'ArrowDown':
        validar(op[1])
        break;
    case 'ArrowLeft':
        validar(op[2])
        break;
    case 'ArrowRight':
        validar(op[3])
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