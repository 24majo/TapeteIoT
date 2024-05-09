var opciones = document.getElementsByClassName("opcion")
var secuencia = []
var adivinar = []
var respuesta

function Empezar(){
    var num1 = Math.floor(Math.random() * 9+1)
    console.log("Número inicial: ", num1)
    
    for(let i = 0; i < 10; i++){
        secuencia[i] = num1 * (i+1)
        adivinar[i] = num1 * (i+1)
    }
    console.log(secuencia)

    for(let i = 0; i < 4; i++){
        var num2 = Math.floor(Math.random() * 9+1)
        adivinar.splice(num2, 1, "_")
    }
    document.getElementById("linea").innerHTML = adivinar

    Acciones()

}

function Acciones(){
    for(let i = 0; i < secuencia.length; i++){
        if(adivinar[i] == "_"){
            respuesta = secuencia[i]
            break
        }
    }
    console.log("Respuesta: ", respuesta)
    //console.log("Opciones: ", arr_op)

    console.log(option_arr(arr_op = []))
}

function option_arr(arr_op){
    for(let i = 0; i < 4; i++){
        let r = Math.floor(Math.random() * secuencia.length)
        arr_op.push(secuencia[r])
    }

    var result = arr_op.filter((item,index)=>{ // Se evita que las vocales aleatorias se repitan
        return arr_op.indexOf(item) === index;
    })

    if(arr_op.length == 3){
        console.log("caca")
        arr_op.push(respuesta)
        option_arr(arr_op)
    }

    else if(arr_op < 4){
        console.log("pop")
        option_arr(arr_op)
    }

    return result
}


function Opciones(numero){
    
}



window.addEventListener("keydown",(e)=>{
    let tecla = e.key

    switch(tecla){
    case 'ArrowUp':
        Opciones(0)
        break;
    case 'ArrowDown':
        Opciones(1)
        break;
    case 'ArrowLeft':
        Opciones(2)
        break;
    case 'ArrowRight':
        Opciones(3)
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

