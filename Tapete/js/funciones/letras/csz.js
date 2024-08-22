// Vidas
var error = 3
var vida = document.getElementById('vida');
vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
// Barra de progreso
contador = 0
document.getElementById("barra").value = contador
document.getElementById("barra").innerHTML = contador
// Elementos generales
const palabras = ["uva", "vela", "vaso", "viento", "volcán", "globo", "lombríz"]
var opciones = document.getElementsByClassName("opcion")

Ayuda()

function Reinicio(){

}

function Reiniciar(){

}

function Inicio(){
    
}

window.addEventListener("keydown",(e)=>{
    let tecla = e.key
    switch(tecla){
    case 'ArrowLeft':
        
        break;
    case 'ArrowRight':
        
        break;
    default:
        break;
    }
})

window.addEventListener("keyup",(e)=>{
    let tecla = e.key

    switch(tecla){
        case 'ArrowLeft':
            
            break;
        case 'ArrowRight':
            
            break;
        default:
            break;
    }
})

function Ayuda(){
    swal("Tutorial", 
        "Completa la palabra con la letra correcta.");
}