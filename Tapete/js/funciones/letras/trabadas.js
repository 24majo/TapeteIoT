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
        document.getElementById("opcion1").textContent = "bl"
        document.getElementById("opcion2").textContent = "br"
        palabras = ["nublado", "mueble",  "ombligo", "establo", "blusa", "pueblo",
            "cebra", "cobra", "lombríz", "libro", "bruja","embrujado"]
        //palabras = ["libro"]
        op = ["bl", "br"]
        OpcionesCirculos(op)
    }
    if(encabezado == "c"){
        document.getElementById("opcion1").textContent = "cl"
        document.getElementById("opcion2").textContent = "cr"
        palabras = ["chancla", "chicle", "eclipse", "cíclope", "club", "bicicleta", 
            "cráneo", "secreto", "escribir", "microbio", "crucero", "crayón"]
        op = ["cl", "cr"]
        OpcionesCirculos(op)
    }
    if(encabezado == 'f'){
        document.getElementById("opcion1").textContent = "fl"
        document.getElementById("opcion2").textContent = "fr"
        palabras = ["disfraz", "fresa", "fritura", "frotar", "frutas", "frasco",
            "flan", "flauta", "flama", "flecha", "flor", "flojo"]
        op = ["fl", "fr"]
        OpcionesCirculos(op)
    }
    if(encabezado == 'g'){
        document.getElementById("opcion1").textContent = "gl"
        document.getElementById("opcion2").textContent = "gr"
        palabras = ["regla", "iglesia", "globo", "iglú", "jeroglífico", "glaciar",
            "grano", "greñas", "cangrejo", "ogro", "grúa", "logro"]
        op = ["gl", "gr"]
        OpcionesCirculos(op)
    }
    if(encabezado == 'p'){
        document.getElementById("opcion1").textContent = "pl"
        document.getElementById("opcion2").textContent = "pr"
        palabras = ["planta","cumpleaños", "explorador", "templo", "pluma", "planeta",
            "compra", "aprender", "príncipe", "exprimir", "prueba", "temprano"]
        op = ["pl", "pr"]
            OpcionesCirculos(op)
    }
    if(encabezado == 't'){
        document.getElementById("opcion1").textContent = "tl"
        document.getElementById("opcion2").textContent = "tr"
        palabras = ["atleta", "atlántico", "tlacoyo", "atlas", "chipotle", "tlacuache",
            "traje", "tren", "estrella", "trompeta", "trueno", "trompo"]
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
        icon: "Visual/Material/Animaciones/Generales/advertencia.jpg",
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
        puntaje = 6.6
        Progreso(contador, puntaje)
        vida.innerHTML = '<img src="Visual/Material/Iconos/corazon2.png" width="100">'
    }

    if(error == 1){
        puntaje = 3.3
        Progreso(contador, puntaje)
        vida.innerHTML = '<img src="Visual/Material/Iconos/corazon1.png" width="100">'
    }

    if(error == 0){
        puntaje = 0
        Progreso(contador, puntaje)
        vida.innerHTML = ""
        swal({
            title: "¡Oh no!",
            text: "No te quedan más vidas. ¿Deseas salir o reintentar?",
            icon: "Visual/Material/Animaciones/Generales/triste.jpg",
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
        icon: "Visual/Material/Animaciones/Generales/PolloBien.gif"
    })

    .then((continuacion) => {
        if (continuacion) {
            document.getElementById("btnIniciar").innerHTML = "Continuar"
            contador++
            document.getElementById("barra").value = contador
            document.getElementById("barra").innerHTML = contador

            if(contador == 12){
                swal({
                    title: "Felicidades",
                    text: "¿Quieres salir del juego o volver a intentarlo?",
                    icon: "Visual/Material/Animaciones/Generales/PolloBien (4).gif",
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
        icon: "Visual/Material/Animaciones/Generales/teclas.jpg"
    })
}