const palabras = ["Cereza", "Chocolate", "Fresa", "Gato","Helado","Libro","Manzana", "Pastel", "Pelota", "Peluche","Pera","Perro","Pizza","Pollo","Tortuga"]
const vocales = ["a", "e", "i", "o", "u"]
var opciones = document.getElementsByClassName("opcion")
var contador = 0
const objetos = {
    resp: undefined,
    opc_arr: [],
    guion: undefined
}

function Inicio(){
    document.getElementById("btnIniciar").innerHTML = "Siguiente"
    var respuesta = palabras[Math.floor(Math.random() * palabras.length)] 
    var guion = respuesta.replace(/a|e|i|o|u/g, "_") 
    var imagen = document.getElementById("figura")
    imagen.src = "Visual/Material/Letras/Juego1/" + respuesta + ".png"
    objetos.guion = guion
    document.getElementById("linea").innerHTML = objetos.guion
    opcion(arr_op = [], 0, respuesta)
    document.getElementById('circulos').style.display='block';
}

function Reinicio(){
    contador = 0
    document.getElementById("btnIniciar").innerHTML = "Empezar"
    document.getElementById("contador").innerHTML = "Aciertos: "
    Inicio()
}

function opcion(arr_op, aux, respuesta){ // Función recursiva
    if(arr_op.length == 4){ // Si el arreglo llega a 4 opciones
        for (let i = 0; i <= respuesta.length; i++){
            var a = respuesta.indexOf(vocales[i])
            if(a != -1){ // Cuando es diferente de -1 significa que si existe
                var e = arr_op.includes(vocales[i]) // Se evalúa si la vocal existente está entre las opciones
                if(!e){ // Si no existe, se elige una posición aleatoria de las opciones y se agrega
                    let r = Math.floor(Math.random() * arr_op.length)
                    arr_op.splice(r, 1, vocales[i])
                }
            }
        }

        for (let i = 0; i < opciones.length; i++){ // Se muestran las opciones en pantalla
            opciones[i].innerHTML = arr_op[i]
        }
        objetos.resp = respuesta
        objetos.opc_arr = arr_op
        console.log(objetos.opc_arr)
    }

    else{
        let r = Math.floor(Math.random() * vocales.length) // Se eligen vocales aleatorias... 
        arr_op.push(vocales[r]) //... para ponerlas como opciones
        var result = arr_op.filter((item,index)=>{ // Se evita que las vocales aleatorias se repitan
            return arr_op.indexOf(item) === index;
        })
        return opcion(result, aux+1, respuesta) // Se retorna a la función para realizarlo hasta llegar a 4 opciones
    }
}

const replaceAt = (string, character, index) => {
    return string.substring(0, index) + character + string.substring(index + character.length);
}

function validar(valor){
    for(let i = 0; i < objetos.resp.length; i++){
        if(objetos.resp[i] == objetos.opc_arr[valor]){
            objetos.guion = replaceAt(objetos.guion, objetos.opc_arr[valor], i)
        }
    }
    document.getElementById("linea").innerHTML = objetos.guion
    var e = objetos.guion.includes('_')
    
    if(!e){
        contador++
        document.getElementById("contador").innerHTML = "Aciertos: " + contador
    }
}

window.addEventListener("keydown",(e)=>{
    let tecla = e.key

    switch(tecla){
    case 'ArrowUp':
        validar(0)
        break;
    case 'ArrowDown':
        validar(1)
        break;
    case 'ArrowLeft':
        validar(2)
        break;
    case 'ArrowRight':
        validar(3)
        break;
    default:
        break;
    }
})

window.addEventListener("keyup",(e)=>{
    let tecla = e.key

    switch(tecla){
        case 'ArrowUp':
            opcion(arr_op = [], 0, objetos.resp)
            break;

        case 'ArrowDown':
            opcion(arr_op = [], 0, objetos.resp)
            break;

        case 'ArrowLeft':
            opcion(arr_op = [], 0, objetos.resp)
            break;

        case 'ArrowRight':
            opcion(arr_op = [], 0, objetos.resp)
            break;

        default:
            break;
    }
})



