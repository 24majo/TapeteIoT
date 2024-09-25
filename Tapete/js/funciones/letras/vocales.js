import Swal from './node_modules/sweetalert2/dist/sweetalert2.all.js';
// Vidas
var imagen = document.getElementById('vida');
imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
var error = 3
// Barra de progreso
contador = 0
document.getElementById("barra").value = contador
document.getElementById("barra").innerHTML = contador

const palabras = ["Cereza", "Chocolate", "Fresa", "Gato","Helado","Libro","Manzana", "Pastel", "Pelota", "Peluche","Pera","Perro","Pizza","Pollo","Tortuga"]
const vocales = ["a", "e", "i", "o", "u"]
var opciones = document.getElementsByClassName("opcion")

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
    swal({
        title: "Reiniciar juego",
        text: "Si reinicias ahora, el progreso se perderá. ¿Deseas continuar?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })

      .then((Reinicio) => {
        if (Reinicio) {
            document.getElementById("btnIniciar").innerHTML = "Empezar"
            Reiniciar()
        } 
    });
}

function Reiniciar(){
    error = 3
    contador = 0
    document.getElementById("btnIniciar").innerHTML = "Empezar"
    imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
    document.getElementById("barra").value = contador
    document.getElementById("barra").innerHTML = contador
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
    for(var i = 0; i < objetos.resp.length; i++){
        if(objetos.resp[i] == objetos.opc_arr[valor]){
            objetos.guion = replaceAt(objetos.guion, objetos.opc_arr[valor], i)
            break
        }

        else{
            if(i == objetos.resp.length - 1){
                //alert("Entra")
                error--
                if(error == 2){
                    imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon2.png" width="100">'
                }
        
                if(error == 1){
                    imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon1.png" width="100">'
                }
        
                if(error == 0){
                    imagen.innerHTML = ""
                    swal({
                        title: "Oh no!",
                        text: "No te quedan más vidas. ¿Deseas salir o reintentar?",
                        icon: "error",
                        buttons:  ["Reintentar", "Salir"] 
                    })
                    .then((reintento) => {
                        if (reintento) {
                            location.href = "JuegosLetras.html"
                        } 
                        else{
                            document.getElementById("btnIniciar").innerHTML = "Empezar"
                            Reiniciar()
                        }
                    })
                }
            }
        }
    }

    document.getElementById("linea").innerHTML = objetos.guion
    var e = objetos.guion.includes('_')
    
    if(!e){
        swal({
            title: "Felicidades",
            text: "Continuemos. Sigue así",
            icon: "Visual/Material/Animaciones/Generales/echeleganas.png"
        })

        .then((continuacion) => {
            if (continuacion) {
                document.getElementById("btnIniciar").innerHTML = "Continuar"
                contador++
                document.getElementById("barra").value = contador
                document.getElementById("barra").innerHTML = contador

                if(contador == 10){
                    swal({
                        title: "Felicidades",
                        text: "¿Quieres salir del juego o volver a intentarlo?",
                        icon: "Visual/Material/Animaciones/Generales/pollo.gif",
                        buttons:  ["Volver a jugar", "Salir"] 
                    })
                    .then((reintento) => {
                        if (reintento) {
                            location.href = "JuegosLetras.html"
                        } 
                        else{
                            document.getElementById("btnIniciar").innerHTML = "Empezar"
                            Reiniciar()
                        }
                    })
                }
                else{
                    Inicio()
                }
            } 
        })
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

function Ayuda(){
    swal("Tutorial", 
        "Elige la vocal correcta para completar la palabra.");
}

