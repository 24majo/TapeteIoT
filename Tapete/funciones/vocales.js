const palabras = ["capa", "paleta", "perro", "pollo", "gato", "arbol"]
const vocales = ["a", "e", "i", "o", "u"]
var respuesta = "" // Se guarda una de las palabras que están en el arreglo
var opciones = document.getElementsByClassName("opcion")
var apoyo = [] // Arreglo de apoyo para letras en circulos
var aux = 0

function seleccion(tecla){

}

window.addEventListener("keydown",(e)=>{
let tecla = e.key

    switch(tecla){
    case 'ArrowUp':
        document.getElementById("arr").style.backgroundColor = 'blue'
        seleccion(0)
        break;
    case 'ArrowDown':
        document.getElementById("ab").style.backgroundColor = 'blue'
        seleccion(1)
        break;
    case 'ArrowLeft':
        document.getElementById("izq").style.backgroundColor = 'blue'
        seleccion(2)
        break;
    case 'ArrowRight':
        document.getElementById("der").style.backgroundColor = 'blue'
        seleccion(3)
        break;
    default:
        break;
    }
})

function palabra(){
    var r = Math.floor(Math.random() * palabras.length) // Elegir un numero aleatorio 
    respuesta = palabras[r]
    document.getElementById("palabra").innerHTML = respuesta
    var identificar = respuesta.split(''); // Dividir cada letra de la palabra

    var lineas = [] // Arreglo para dibujar las lineas y completar la palabra
    for(var i = 0; i < identificar.length; i++){
        lineas[i] = identificar[i] // Aumentar el tamaño del arreglo de acuerdo a la longitud de la palabra aleatoria
        for(var j = 0; j < vocales.length; j++){
            if(identificar[i] == vocales[j]){ // Identificar las vocales que existen en una palabra
                lineas[i] = "_" // Si encuentra vocales, las reemplaza por un guion
            }
        }
    }

    document.getElementById("linea").innerHTML = lineas // Mostrar lineas en pantalla

    for(var i = 0; i < vocales.length; i++){
        let r = Math.floor(Math.random() * vocales.length)
        opciones[i].innerHTML = vocales[r]
    }

}