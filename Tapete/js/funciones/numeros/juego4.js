// Vidas
var imagen = document.getElementById('vida');
imagen.innerHTML = '<img src="Visual/Material/Numeros/Juego1/3.jpg" width="100">'
var error = 3
// Barra de progreso
contador = 0
document.getElementById("barra").value = contador
document.getElementById("barra").innerHTML = contador
// Circulos de opciones
var opciones = document.getElementsByClassName("opcion")
var op = []
//Opciones de dificultad
var radios = document.getElementsByName("dificultad")
// Elementos generales
var resultado = 0
var arreglo = []

function Empezar(){
    if(!document.querySelector('input[name="dificultad"]:checked')){
        alert("Selecciona algo ptm")
    }

    else{
        // for(let y = 0; y < 3; y++){
        //     radios[y].disabled = true
        // }
        valor = document.querySelector('input[name="dificultad"]:checked').value
        document.getElementById('aparecer').style.display='block';

        switch(valor){
            case 'facil':
                num1 = Math.floor(Math.random() * (50-1)+1)
                num2 = Math.floor(Math.random() * (num1-1)+1)
                Random(num1, num2)  
                break

            case 'medio':
                num1 = Math.floor(Math.random() * (100-50)+50)
                num2 = Math.floor(Math.random() * (num1-50)+50)
                Random(num1, num2)  
                break
            
            case 'dificil':
                num1 = Math.floor(Math.random() * (100-1)+1)
                num2 = Math.floor(Math.random() * (num1-1)+1)
                //alert("Num1: " + num1 + " num2: " + num2)
                Random(num1, num2) 
                break
        }
    }
}

function Reinicio(){

}

// Eventos del teclado compatibles con botones
window.addEventListener("keydown",(e)=>{
    let tecla = e.key
    switch(tecla){
        case 'ArrowUp':
            RCorrecto(op[0])
            break;

        case 'ArrowDown':
            RCorrecto(op[1])
            break;

        case 'ArrowLeft':
            RCorrecto(op[2])
            break;

        case 'ArrowRight':
            RCorrecto(op[3])
            break;

        default:
            break;
    }
})

window.addEventListener("keyup",(e)=>{
    let tecla = e.key
    switch(tecla){
        case 'ArrowUp':
            Random(0)
            break;

        case 'ArrowDown':
            Random(1)
            break;

        case 'ArrowLeft':
            Random(2)
            break;

        case 'ArrowRight':
            Random(3)
            break;

        default:
            break;
    }
})