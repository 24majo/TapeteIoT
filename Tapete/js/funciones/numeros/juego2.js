var opciones = document.getElementsByClassName("opcion")
var secuencia = []
var adivinar = []
var respuesta
var result
var op = []
var contador = 0

function Reinicio(){
    contador = 0
    document.getElementById("contador").innerHTML = "Aciertos: " + contador
    document.getElementById("btnIniciar").innerHTML = "Empezar"
}

function Empezar(){
    document.getElementById('aparecer').style.display='block';
    
    var num1 = Math.floor(Math.random() * 2+1)
    console.log("Número inicial: ", num1)
    
    for(let i = 0; i < 10; i++){
        secuencia[i] = num1 * (i+1)
        adivinar[i] = num1 * (i+1)
    }

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
    op = Opcion(arreglo = [])

    for(let i = 0; i < opciones.length; i++){
        opciones[i].innerHTML = op[i]
    }
}

function Opcion(arreglo){
    if(arreglo.length == 4){
        var res = arreglo.indexOf(respuesta)
        if(res == -1){
            let r = Math.floor(Math.random() * arreglo.length) 
            arreglo.splice(r, 1, respuesta)
        }
    }
    else{
        let r = Math.floor(Math.random() * secuencia.length) 
        arreglo.push(secuencia[r])
    
        result = arreglo.filter((item,index)=>{ // Se evita que las vocales aleatorias se repitan
            return arreglo.indexOf(item) === index;
        })
        Opcion(result)
    }
    return result
}

function Opciones(num){
    if(num == respuesta){
        for(let i = 0; i < secuencia.length; i++){
            if(adivinar[i] == "_"){
                adivinar.splice(i, 1, respuesta)
                break
            }
        }
        document.getElementById("linea").innerHTML = adivinar

        var e = adivinar.includes('_')
        if(!e){
            contador++
            document.getElementById("contador").innerHTML = "Aciertos: " + contador
            document.getElementById("btnIniciar").innerHTML = "Continuar"
        }
    }
}

window.addEventListener("keydown",(e)=>{
    let tecla = e.key

    switch(tecla){
    case 'ArrowUp':
        Opciones(op[0])
        break;
    case 'ArrowDown':
        Opciones(op[1])
        break;
    case 'ArrowLeft':
        Opciones(op[2])
        break;
    case 'ArrowRight':
        Opciones(op[3])
        break;
    default:
        break;
    }
})

window.addEventListener("keyup",(e)=>{
    let tecla = e.key

    switch(tecla){
        case 'ArrowUp':
            Acciones()
            break;

        case 'ArrowDown':
            Acciones()
            break;

        case 'ArrowLeft':
            Acciones()
            break;

        case 'ArrowRight':
            Acciones()
            break;

        default:
            break;
    }
})

