const palabras = ["dulces", "helado", "perro", "pollo", "gato", "arbol", "manzana"]
const vocales = ["a", "e", "i", "o", "u"]
var opciones = document.getElementsByClassName("opcion")

function Inicio(){
    var respuesta = palabras[Math.floor(Math.random()*palabras.length)] // Elegir una palabra al azar
    var guion = respuesta.replace(/a|e|i|o|u/g, "_") // Reemplazar vocales por guion
    document.getElementById("linea").innerHTML = guion // Mostrar la palabra incompleta
    var arr_op = [] // Arreglo para mostrar las opciones
    opcion(arr_op, 0, respuesta)
}

function opcion(arr_op, aux, respuesta){ 
    if(arr_op.length == 4){

        for (let i = 0; i < respuesta.length; i++){
            var a = respuesta.indexOf(vocales[i])
            if(a != -1)
                console.log(vocales[i])
            
        }

        for (let i = 0; i < opciones.length; i++)
            opciones[i].innerHTML = arr_op[i]
    }

    else{
        let r = Math.floor(Math.random() * vocales.length)
        arr_op.push(vocales[r])
        var result = arr_op.filter((item,index)=>{
            return arr_op.indexOf(item) === index;
        },aux++)
        return opcion(result, aux, respuesta)
    }
}

window.addEventListener("keydown",(e)=>{
    let tecla = e.key
    
        switch(tecla){
        case 'ArrowUp':
            document.getElementById("arr").style.backgroundColor = 'blue'
            break;
        case 'ArrowDown':
            document.getElementById("ab").style.backgroundColor = 'blue'
            break;
        case 'ArrowLeft':
            document.getElementById("izq").style.backgroundColor = 'blue'
            break;
        case 'ArrowRight':
            document.getElementById("der").style.backgroundColor = 'blue'
            break;
        default:
            break;
        }
    })

/*var respuesta = "" // Se guarda una de las palabras que están en el arreglo
var opciones = document.getElementsByClassName("opcion")
var apoyo = [] // Arreglo de apoyo para letras en circulos



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

function palabra(){
    var r = Math.floor(Math.random() * palabras.length) // Elegir un numero aleatorio 
    respuesta = palabras[r]
    document.getElementById("palabra").innerHTML = respuesta // Mostrar la palabra en pantalla
    var identificar = respuesta.split(''); // Separar cada letra de la palabra
    
    let vocal_aux = ["","","",""] // Auxiliar para guardar las vocales que existen en la palabra
    let n = 0
    var lineas = [] // Arreglo para dibujar las lineas y completar la palabra
    
    for(var i = 0; i < identificar.length; i++){
        lineas[i] = identificar[i] // Aumentar el tamaño del arreglo de acuerdo a la longitud de la palabra aleatoria
        for(var j = 0; j < vocales.length; j++){
            if(identificar[i] == vocales[j]){ // Identificar las vocales que existen en una palabra
                lineas[i] = "_" // Si encuentra vocales, las reemplaza por un guion
                vocal_aux[n] = identificar[i]
                n++
            }
        }
    }
    document.getElementById("linea").innerHTML = lineas // Mostrar lineas en pantalla
    console.log("Antes: ", vocal_aux)
    //return vocal_aux
}*/
    

/*    for(var i = vocal_aux.length -1; i >=0; i--){ // Eliminar elementos repetidos
        if(vocal_aux.indexOf(vocal_aux[i]) !== i) 
            vocal_aux.splice(i,1);
    }

    var op = ["", "", "", ""]
    for(var i = 0; i < op.length; i++){
        let r = Math.floor(Math.random() * vocales.length)
        op[i] = vocales[r]
    }

    for(var i = op.length -1; i >=0; i--){
        if(op.indexOf(op[i]) !== i)
            op.splice(i,1)
        opciones[i].innerHTML = op[i]
    }

    console.log(vocal_aux)
    console.log(op)*/