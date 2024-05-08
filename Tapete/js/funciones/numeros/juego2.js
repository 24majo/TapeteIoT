var secuencia = []
var adivinar = []

function Empezar(){
    var num1 = Math.floor(Math.random() * 9+1)
    console.log("Número inicial: ", num1)
    
    for(let i = 0; i < 10; i++){
        secuencia[i] = num1 * (i+1)
    }
    console.log(secuencia)
    adivinar = secuencia

    for(let i = 0; i < 4; i++){
        var num2 = Math.floor(Math.random() * 9+1)
        adivinar.splice(num2, 1, "_")
    }
    document.getElementById("linea").innerHTML = adivinar
}

function Acciones(){
    
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

