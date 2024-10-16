// Vidas
var error = 3
var vida = document.getElementById('vida');
vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'

// Barra de progreso
contador = 0
document.getElementById("barra").value = contador
document.getElementById("barra").innerHTML = contador

// Elementos generales
var encabezado = localStorage.getItem("valor") // Envío de valor de acuerdo con el modo de juego
var palabras = []
var opciones = document.getElementsByClassName("opcion")
var op = []
//alert(encabezado)

if(encabezado == "b"){
    document.getElementById("opcion1").textContent = "Bl"
    document.getElementById("opcion2").textContent = "Br"
    palabras = ["hablar", "nublado", "mueble", "oblea", "ombligo", "biblioteca", "pueblo", "establo", "bloque", "blusa", 
        "sombra", "cebra", "sombrero", "libreta", "lombriz", "colibrí", "libro", "hombro", "bruja", "brújula"]
    op = ["bl", "br"]
    OpcionesCirculos(op)
}
if(encabezado == "c"){
    document.getElementById("opcion1").textContent = "Cl"
    document.getElementById("opcion2").textContent = "Cr"
    op = ["cl", "cr"]
    OpcionesCirculos(op)
}
if(encabezado == 'f'){
    document.getElementById("opcion1").textContent = "Fl"
    document.getElementById("opcion2").textContent = "Fr"
    op = ["fl", "fr"]
    OpcionesCirculos(op)
}
if(encabezado == 'g'){
    document.getElementById("opcion1").textContent = "Gl"
    document.getElementById("opcion2").textContent = "Gr"
    op = ["gl", "gr"]
    OpcionesCirculos(op)
}
if(encabezado == 'p'){
    document.getElementById("opcion1").textContent = "Pl"
    document.getElementById("opcion2").textContent = "Pr"
    palabras = ["planta", "planeta", "empleo", "cumpleaños", "suplicar", "soplido", "explorador", "templo", "pluma", "plutón", 
        "compra", "temprano", "precio", "aprender", "príncipe", "exprimir", "profesor", "producto", "prueba", "compruebo"]
    op = ["pl", "pr"]
        OpcionesCirculos(op)
}
if(encabezado == 't'){
    document.getElementById("opcion1").textContent = "Tl"
    document.getElementById("opcion2").textContent = "Tr"
    op = ["tl", "tr"]
    OpcionesCirculos(op)
}

function OpcionesCirculos(op){
    for(var i = 0; i < opciones.length; i++){
        opciones[i].innerHTML = op[i]
    }
}

window.addEventListener("keydown",(e)=>{
    let tecla = e.key
    switch(tecla){
    case 'ArrowLeft':
        //alert(arreglo[0])
            Comprobar(arreglo[0])
        break;
    case 'ArrowRight':
        //alert(arreglo[1])
            Comprobar(arreglo[1])
        break;
    default:
        break;
    }
})

//Ayuda()

function Ayuda(){
    swal({
        title: "Tutorial",
        text: "Determina en qué columna va la imagen. \n Elige la opción correcta por medio de las teclas ← → o los botones del tablero.",
        icon: "Visual/Material/Animaciones/Generales/teclado.gif"
    })
}