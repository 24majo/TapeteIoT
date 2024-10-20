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
var linea
var imagen = document.getElementById('imagen') 
var tabla1 = document.getElementsByClassName("tabla1")
var tabla2 = document.getElementsByClassName("tabla2")
var t1 = 0, t2 = 0

function ValoresTabla(){
    if(encabezado == "b"){
        document.getElementById("opcion1").textContent = "Bl"
        document.getElementById("opcion2").textContent = "Br"
        palabras = ["nublado", "mueble", "ombligo", "establo", "blusa", "pueblo",
            "cebra", "cobra", "lombriz", "libro", "bruja","embrujado"]
        //palabras = ["libro"]
        op = ["bl", "br"]
        OpcionesCirculos(op)
    }
    if(encabezado == "c"){
        document.getElementById("opcion1").textContent = "Cl"
        document.getElementById("opcion2").textContent = "Cr"
        palabras = ["chancla", "chicle", "eclipse", "cíclope", "club",
            "cráneo", "secreto", "escribir", "microbio", "crucero"]
        op = ["cl", "cr"]
        OpcionesCirculos(op)
    }
    if(encabezado == 'f'){
        document.getElementById("opcion1").textContent = "Fl"
        document.getElementById("opcion2").textContent = "Fr"
        palabras = ["disfraz", "fresa", "fritura", "frotar", "frutas",
            "flan", "flauta", "flama", "flecha", "flor"]
        op = ["fl", "fr"]
        OpcionesCirculos(op)
    }
    if(encabezado == 'g'){
        document.getElementById("opcion1").textContent = "Gl"
        document.getElementById("opcion2").textContent = "Gr"
        palabras = ["regla", "iglesia", "globo", "iglú", "jeroglífico",
            "grano", "greñas", "cangrejo", "ogro", "grúa"]
        op = ["gl", "gr"]
        OpcionesCirculos(op)
    }
    if(encabezado == 'p'){
        document.getElementById("opcion1").textContent = "Pl"
        document.getElementById("opcion2").textContent = "Pr"
        palabras = ["planta","cumpleaños", "explorador", "templo", "pluma",
            "compra", "aprender", "príncipe", "exprimir", "prueba"]
        op = ["pl", "pr"]
            OpcionesCirculos(op)
    }
    if(encabezado == 't'){
        document.getElementById("opcion1").textContent = "Tl"
        document.getElementById("opcion2").textContent = "Tr"
        palabras = ["Atleta", "Atlántico", "Tlacoyo", "Atlas", "Chipotle",
            "Traje", "Tren", "Estrella", "Trompeta", "Trueno"]
        op = ["tl", "tr"]
        OpcionesCirculos(op)
    }
}

function Empezar(){
    respuesta = palabras[Math.floor(Math.random() * palabras.length)]
    var repetida = palabras.indexOf(respuesta)
    palabras.splice(repetida, 1)
    imagen.src = "Visual/Material/Letras/Juego8/" + respuesta + ".jpg"

    if(encabezado == "b"){
        linea = respuesta.replace(/bl|br/g, "_ _")
    }
    if(encabezado == "c"){
        linea = respuesta.replace(/cl|cr/g, "_ _")
    }
    if(encabezado == 'f'){
        linea = respuesta.replace(/fl|fr/g, "_ _")
    }
    if(encabezado == 'g'){
        linea = respuesta.replace(/gl|gr/g, "_ _")
    }
    if(encabezado == 'p'){
        linea = respuesta.replace(/pl|pr/g, "_ _")
    }
    if(encabezado == 't'){
        linea = respuesta.replace(/tl|tr/g, "_ _")
    }

    document.getElementById("linea").innerHTML = linea
}

function Comprobar(arreglo){
    if(respuesta.indexOf(arreglo) > -1){
        if(arreglo == op[0]){
            if(encabezado == "b"){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == "c"){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == 'f'){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == 'g'){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == 'p'){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == 't'){
                linea = respuesta.replace("_ _", arreglo)
            }
            tabla1[t1].src = "Visual/Material/Letras/Juego8/" + respuesta + ".jpg"
            t1++
        }

        if(arreglo == op[1]){
            if(encabezado == "b"){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == "c"){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == 'f'){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == 'g'){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == 'p'){
                linea = respuesta.replace("_ _", arreglo)
            }
            if(encabezado == 't'){
                linea = respuesta.replace("_ _", arreglo)
            }
            tabla2[t2].src = "Visual/Material/Letras/Juego8/" + respuesta + ".jpg"
            t2++
        }
        document.getElementById("linea").innerHTML = linea
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
    imagen.src = ""
    contador = 0
    respuesta = ""
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