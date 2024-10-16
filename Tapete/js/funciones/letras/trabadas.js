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
var respuesta = ""
var imagen = document.getElementById('imagen') 
var tabla1 = document.getElementsByClassName("tabla1")
var tabla2 = document.getElementsByClassName("tabla2")
var t1 = 0, t2 = 0

function ValoresTabla(){
    if(encabezado == "b"){
        document.getElementById("opcion1").textContent = "Bl"
        document.getElementById("opcion2").textContent = "Br"
        palabras = ["hablar", "nublado", "mueble", "oblea", "ombligo", "biblioteca", "pueblo", "establo", "bloque", "blusa", 
            "sombra", "cebra", "sombrero", "libreta", "lombriz", "colibrí", "libro", "hombro", "bruja", "brújula"]
        //palabras = ["libro"]
        op = ["bl", "br"]
        OpcionesCirculos(op)
    }
    if(encabezado == "c"){
        document.getElementById("opcion1").textContent = "Cl"
        document.getElementById("opcion2").textContent = "Cr"
        palabras = ["clavo", "chancla", "bicicleta", "chicle", "eclipse", "clip", "cíclope", "triciclo", "club", "exclusivo",
            "cráneo", "crayón", "crema", "secreto", "escribir", "cristal", "microbio", "micrófono", "crucero", "crucigrama"
        ]
        op = ["cl", "cr"]
        OpcionesCirculos(op)
    }
    if(encabezado == 'f'){
        document.getElementById("opcion1").textContent = "Fl"
        document.getElementById("opcion2").textContent = "Fr"
        palabras = ["frasco", "disfraz", "fresa", "cofre", "frijol", "fritura", "frontera", "frotar", "frutas", "disfrutar",
            "flan", "flauta", "flama", "fleco", "flecha", "chiflido", "flor", "flojo", "flujo", "fluido"
        ]
        op = ["fl", "fr"]
        OpcionesCirculos(op)
    }
    if(encabezado == 'g'){
        document.getElementById("opcion1").textContent = "Gl"
        document.getElementById("opcion2").textContent = "Gr"
        palabras = ["claciar", "regla", "iglesia", "inglés", "globo", "gloria", "iglú", "glúteos", "glotón", "jeroglífico",
            "grano", "gratis", "greñas", "cangrejo", "ogro", "logro", "grúa", "gruñón", "grieta", "gripe"
        ]
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
        palabras = ["atleta", "atlántico", "tlacuache", "tlacoyo", "tlaxcala", "atlas", "náhuatl", "chipotle", "atletismo", "tlatelolco",
            "traje", "maestra", "tren", "estrella", "trineo", "trigo", "trompeta", "trono", "trompo", "trueno"
        ]
        op = ["tl", "tr"]
        OpcionesCirculos(op)
    }
}

function Empezar(){
    respuesta = palabras[Math.floor(Math.random() * palabras.length)]
    var repetida = palabras.indexOf(respuesta)
    palabras.splice(repetida, 1)
    imagen.src = "Visual/Material/Letras/Juego8/" + respuesta + ".png"
    document.getElementById("prueba").innerHTML = respuesta
}

function Comprobar(arreglo){
    if(respuesta.indexOf(arreglo) > -1){
        if(arreglo == op[0]){
            tabla1[t1].src = "Visual/Material/Letras/Juego8/" + respuesta + ".png"
            t1++
        }

        if(arreglo == op[1]){
            tabla2[t2].src = "Visual/Material/Letras/Juego8/" + respuesta + ".png"
            t2++
        }
        Felicidades()
    }

    else{
        Fallo()
    }
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
        Comprobar(op[0])
        break;
    case 'ArrowRight':
        Comprobar(op[1])
        break;
    default:
        break;
    }
})

function Reinicio(){
    swal({
        title: "Reiniciar juego",
        text: "Si reinicias ahora, el progreso se perderá. ¿Deseas continuar?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })

      .then((willDelete) => {
        if (willDelete) {
            document.getElementById("btnIniciar").innerHTML = "Empezar"
            Reiniciar()
        } 
    });
}

function Reiniciar(){
    error = 3
    vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
    contador = 0
    respuesta = ""
    document.getElementById("prueba").innerHTML = respuesta
    document.getElementById("barra").value = contador
    document.getElementById("barra").innerHTML = contador

    for(var i = 0; i < tabla1.length; i++){
        tabla1[i].src = ""
        tabla2[i].src = ""
    }
    
    t1 = 0
    t2 = 0

    ValoresTabla()
    Empezar()
}

function Fallo(){
    error-- 
    if(error == 2){
        vida.innerHTML = '<img src="Visual/Material/Iconos/corazon2.png" width="100">'
    }

    if(error == 1){
        vida.innerHTML = '<img src="Visual/Material/Iconos/corazon1.png" width="100">'
    }

    if(error == 0){
        vida.innerHTML = ""
        swal({
            title: "¡Oh no!",
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

function Felicidades(){
    swal({
        title: "¡Muy bien!",
        text: "Continuemos. Sigue así",
        icon: "Visual/Material/Animaciones/Generales/echeleganas.png"
    })

    .then((continuacion) => {
        if (continuacion) {
            document.getElementById("btnIniciar").innerHTML = "Continuar"
            contador++
            document.getElementById("barra").value = contador
            document.getElementById("barra").innerHTML = contador

            if(contador == 20){
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
                Empezar()
            }
        } 
    })
}

Ayuda()
ValoresTabla()

function Ayuda(){
    swal({
        title: "Tutorial",
        text: "Determina en qué columna va la imagen. \n Elige la opción correcta por medio de las teclas ← → o los botones del tablero.",
        icon: "Visual/Material/Animaciones/Generales/teclado.gif"
    })
}