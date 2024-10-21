// Vidas
var error = 3
var vida = document.getElementById('vida');
vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'

// Barra de progreso
contador = 0
document.getElementById("barra").value = contador
document.getElementById("barra").innerHTML = contador

// Elementos generales
var semaforo = document.getElementById('semaforo')
var imagen = document.getElementById('figura') 
var palabras_f = ["uva", "vela", "vaso", "viento", "volcán", "globo", "lombríz", "libro", "árbol", "cebolla"]
var palabras_m = ["víbora", "vivir", "burbuja", "bebé", "beber", "babosa", "envolver", "biblioteca", "bebida", "sobrevivir"]
//const palabras_m = ["víbora"]
var palabras = []
var opciones = document.getElementsByClassName("opcion")
var respuesta, respuesta_m = []
var arreglo = []
var num_ejercicio = 0, num_opcion = 0
var palabras_d =[
    {
        frase: "Las vacas no pueden volar.",
        valores: ["vacas", "volar"],
        ruta: "Visual/Material/Letras/Juego4/VacasVolar.jpg"
    },
    {
        frase: "Las abejas saben bailar.",
        valores: ["abejas", "bailar"],
        ruta: "Visual/Material/Letras/Juego4/AbejasBailar.jpg"
    },
    {
        frase:"Las liebres pueden brincar.",
        valores: ["liebres", "brincar"],
        ruta: "Visual/Material/Letras/Juego4/LiebresBrincar.jpg"
    },
    {
        frase:"El tiburón es carnívoro.",
        valores: ["tiburón", "carnívoro"],
        ruta: "Visual/Material/Letras/Juego4/TiburónCarnívoro.jpg"
    },
    {
        frase:"La lombríz tiene fiebre.",
        valores: ["lombríz", "fiebre"],
        ruta: "Visual/Material/Letras/Juego4/LombrizFiebre.jpg"
    },
    {
        frase:"El búho gira su cabeza.",
        valores: ["búho", "cabeza"],
        ruta: "Visual/Material/Letras/Juego4/BuhoCabeza.jpg"
    },
    {
        frase:"La ballena quiere viajar.",
        valores: ["ballena", "viajar"],
        ruta: "Visual/Material/Letras/Juego4/BallenaViajar.jpg"
    },
    {
        frase:"El venado se está bañando.",
        valores: ["venado", "bañando"],
        ruta: "Visual/Material/Letras/Juego4/VenadoBañando.jpg"
    },
    {
        frase:"El cuervo no puede barrer.",
        valores: ["cuervo", "barrer"],
        ruta: "Visual/Material/Letras/Juego4/CuervoBarrer.jpg"
    },
    {
        frase:"El borrego quiere brillar.",
        valores: ["borrego", "brillar"],
        ruta: "Visual/Material/Letras/Juego4/BorregoBrillar.jpg"
    }
]

Ayuda()

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
    document.getElementById("linea").innerHTML = "" 
    for(let i = 0; i < opciones.length; i++){
        opciones[i].innerHTML = ""
    }
    
    if(valor == 'facil')
        palabras_f = ["uva", "vela", "vaso", "viento", "Volcán", "globo", "lombríz", "libro", "árbol", "cebolla"]
    
    if(valor == 'medio')
        palabras_m = ["víbora", "vivir", "burbuja", "bebé", "beber", "babosa", "envolver", "biblioteca", "bebida", "sobrevivir"]

    palabras = []
    error = 3
    vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
    contador = 0
    imagen.src = ""
    document.getElementById("btnIniciar").innerHTML = "Empezar"
    document.getElementById("barra").value = contador
    document.getElementById("barra").innerHTML = contador
    num_ejercicio = 0
    num_opcion = 0
    respuesta_m = []
    Empezar()
}

function Empezar(){
    switch(valor){
        case 'facil':
            arreglo = ["b", "v"]
            palabras = palabras_f
            respuesta = palabras[Math.floor(Math.random() * palabras.length)]
            var repetida = palabras.indexOf(respuesta)
            palabras.splice(repetida, 1)
            //alert(palabras)
            document.getElementById("linea").innerHTML = respuesta
            imagen.src = "Visual/Material/Letras/Juego4/" + respuesta + ".jpg"
            
            if(respuesta.includes('b') == true || respuesta.includes('v') == true){
                document.getElementById("linea").innerHTML = respuesta.replaceAll(/b|v/g, "_")
            }

            for(let i = 0; i < arreglo.length; i++){
                opciones[i].innerHTML = arreglo[i]
            }
            
            document.getElementById('aparecer').style.display='block';
            break

        case 'medio':
            arreglo = ["b", "v"]
            palabras = palabras_m

            if(!respuesta_m.includes("_")){
                respuesta = palabras[Math.floor(Math.random() * palabras.length)]
                var repetida = palabras.indexOf(respuesta)
                palabras.splice(repetida, 1)

                if(respuesta.includes('b') == true || respuesta.includes('v') == true){
                    respuesta_m = respuesta.replaceAll(/b|v/g, "_")
                    imagen.src = "Visual/Material/Letras/Juego4/" + respuesta + ".jpg"
                    document.getElementById("linea").innerHTML = respuesta_m
                }
            }

            for(let i = 0; i < arreglo.length; i++){
                opciones[i].innerHTML = arreglo[i]
            }
            
            document.getElementById('aparecer').style.display='block';
            break
        
        case 'dificil':
            arr_res = palabras_d[num_ejercicio].valores
            respuesta = arr_res[num_opcion]

            if(num_opcion == 0){
                arr_res.forEach(valor => {
                    palabras_d[num_ejercicio].frase = palabras_d[num_ejercicio].frase.replaceAll(valor, "_______");
                    imagen.src = palabras_d[num_ejercicio].ruta
                });
            }

            document.getElementById("linea").innerHTML = palabras_d[num_ejercicio].frase

            if(respuesta.includes("b")){
                var palabra = respuesta.replace("b", "v");
                
                if(arreglo.length == 2){
                    arreglo[0] = palabra
                    arreglo[1] = respuesta
                }
                else{
                    arreglo.push(palabra)
                    arreglo.push(respuesta)
                }
            }

            else if(respuesta.includes("v")){
                var palabra = respuesta.replace("v", "b");
                if(arreglo.length == 2){
                    arreglo[0] = respuesta
                    arreglo[1] = palabra
                }
                else{
                    arreglo.push(respuesta)
                    arreglo.push(palabra)
                }
            }

            //alert(arreglo)

            for (let i = 0; i < opciones.length; i++){
                    opciones[i].innerHTML = arreglo[i] // Se muestran las opciones en los círculos
            }

            document.getElementById('aparecer').style.display='block';
            // if(palabras_d[num_ejercicio].frase.includes(arr_res[0]) && palabras_d[num_ejercicio].frase.includes(arr_res[1])){
            //     document.getElementById("linea").innerHTML = palabras_d[num_ejercicio].frase.replaceAll(/arr_res[0]|arr_res[1]/g, "_")
            // }
            break
    }
}

function ComprobarM(letra){
    if(respuesta.includes(letra)) {
        for(var i = 0; i < respuesta.length; i++){
            //alert("i: " + i)
            if(respuesta_m[i] == "_"){
                if(respuesta[i] == letra){
                    respuesta_m = respuesta_m.replace("_", letra)
                    break
                }

                else{
                    Fallo()
                    break
                }
                break
            }
        }
        document.getElementById("linea").innerHTML = respuesta_m

        if(!respuesta_m.includes("_")){
            Felicidades()
        }
    }

    else{
        Fallo()
    }
}

function Comprobar(letra){
    if(respuesta.includes(letra)) {
        for(var i = 0; i < respuesta.length; i++) {
            if(respuesta[i]==letra){
                respuesta[i] == letra
                break
            }
        }

        switch(valor){
            case 'facil':
                document.getElementById("linea").innerHTML = respuesta
                Felicidades()
                break

            case 'dificil':
                palabras_d[num_ejercicio].frase = palabras_d[num_ejercicio].frase.replace("_______", respuesta)
                document.getElementById("linea").innerHTML = palabras_d[num_ejercicio].frase
                num_opcion++

                if(num_opcion > 1 && num_ejercicio < 10){
                    num_ejercicio++
                    num_opcion = 0
                    Felicidades()
                }
                break
        }
    }
    
    else{
        Fallo()
    }
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
            icon: "Visual/Material/Animaciones/Generales/triste.jpg",
            buttons:  ["Reintentar", "Salir"] 
        })
        .then((reintento) => {
            if (reintento) {
                location.href = "JuegosLetras.html"
            } 
            else{
                if(valor == 'facil'){
                    palabras_f = ["uva", "vela", "vaso", "viento", "volcán", "globo", "lombríz", "libro", "árbol", "cebolla"]
                    palabras = palabras_f
                    //alert("Original: " + palabras_f)
                    document.getElementById("btnIniciar").innerHTML = "Empezar"
                    Reiniciar()
                }

                else{
                    swal({
                        title: "¿Deseas reintentar el nivel o elegir otra dificultad?",
                        icon: "Visual/Material/Animaciones/Generales/advertencia(1).jpg",
                        buttons:  ["Mantener", "Cambiar"] 
                    })
                    .then((cambiar) => {
                        if(cambiar){
                            if(valor == 'dificil'){
                                valor = "medio"
                                semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
                                palabras_m = ["víbora", "vivir", "burbuja", "bebé", "beber", "babosa", "envolver", "biblioteca", "bebida", "sobrevivir"]
                                palabras = palabras_m
                            }

                            else if(valor == 'medio'){
                                valor = "facil"
                                semaforo.src = "Visual/Material/Recursos/SemaforoFacil.png"
                                palabras_f = ["uva", "vela", "vaso", "viento", "volcán", "globo", "lombríz", "libro", "árbol", "cebolla"]
                                palabras = palabras_f
                            }
                            
                            document.getElementById("btnIniciar").innerHTML = "Empezar"
                            Reiniciar()
                        }
                        else{
                            document.getElementById("btnIniciar").innerHTML = "Empezar"
                            Reiniciar()
                        }
                    })
                }
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

            if(contador == 10){
                if(valor == "dificil"){
                    swal({
                        title: "Felicidades",
                        text: "Has completado todos los niveles. ¿Quieres reiniciar todo o salir?",
                        icon: "Visual/Material/Animaciones/Generales/PolloBien (4).gif",
                        buttons:  ["Reintentar todo", "Salir"] 
                    })
                    .then((reintento) => {
                        if (reintento) {
                            location.href = "JuegosLetras.html"
                        } 
                        else{
                            valor = "facil"
                            semaforo.src = "Visual/Material/Recursos/SemaforoFacil.png"
                            palabras_f = ["uva", "vela", "vaso", "viento", "volcán", "globo", "lombríz", "libro", "árbol", "cebolla"]
                            palabras = palabras_f
                            document.getElementById("btnIniciar").innerHTML = "Empezar"
                            Reiniciar()
                        }
                    })
                }

                else{
                    swal({
                        title: "Felicidades",
                        text: "¿Quieres avanzar al siguiente nivel o salir del juego?",
                        icon: "Visual/Material/Animaciones/Generales/PolloBien (3).gif",
                        buttons:  ["Siguiente nivel", "Salir"] 
                    })
                    .then((reintento) => {
                        if (reintento) {
                            location.href = "JuegosLetras.html"
                        } 
                        else{
                            if(valor == 'facil'){
                                valor = 'medio'
                                semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
                                Reiniciar()
                            }

                            else{
                                if(valor == 'medio'){
                                    valor = 'dificil'
                                    semaforo.src = "Visual/Material/Recursos/SemaforoDificil.png"
                                    Reiniciar()
                                }
                            }
                        }
                    })
                }
                // swal({
                //     title: "Felicidades",
                //     text: "¿Quieres salir del juego o volver a intentarlo?",
                //     icon: "Visual/Material/Animaciones/Generales/pollo.gif",
                //     buttons:  ["Volver a jugar", "Salir"] 
                // })
                // .then((reintento) => {
                //     if (reintento) {
                //         location.href = "JuegosLetras.html"
                //     } 
                //     else{
                //         if (valor == "facil")
                //             palabras_f = ["uva", "vela", "vaso", "viento", "volcán", "globo", "lombríz", "libro", "árbol", "cebolla"]
                        
                //         if (valor == "medio")
                //             palabras_m = ["víbora", "vivir", "burbuja", "bebé", "beber", "babosa", "envolver", "biblioteca", "bebida", "sobrevivir"]

                //         document.getElementById("btnIniciar").innerHTML = "Empezar"
                //         Reiniciar()
                //     }
                // })
            }
            else{
                Empezar()
            }
        } 
    })
}

window.addEventListener("keydown",(e)=>{
    let tecla = e.key
    switch(tecla){
    case 'ArrowLeft':
        //alert(arreglo[0])
        if(valor == 'medio'){
            ComprobarM(arreglo[0])
        }
        else{
            Comprobar(arreglo[0])
        }
        break;
    case 'ArrowRight':
        //alert(arreglo[1])
        if(valor == 'medio'){
            ComprobarM(arreglo[1])
        }
        else{
            Comprobar(arreglo[1])
        }
        break;
    default:
        break;
    }
})

window.addEventListener("keyup",(e)=>{
    let tecla = e.key

    switch(tecla){
        case 'ArrowRight':
            if(valor == 'dificil')
                Empezar()
            break;
        case 'ArrowLeft':
            if(valor == 'dificil')
                Empezar()
            break;
        default:
            break;
    }
})

function Ayuda(){
    swal({
        title: "Tutorial",
        text: "Completa la palabra con la letra correcta.\n Elige la opción correcta por medio de las teclas ↑ ↓ → ← o los botones del tablero.",
        icon: "Visual/Material/Animaciones/Generales/teclas.jpg"
    })
}

window.onload = function() {
    valor = localStorage.getItem('valorBoton');
    if(valor == 'facil')
        semaforo.src = "Visual/Material/Recursos/SemaforoFacil.png"

    if(valor == 'medio')
        semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"

    if(valor == 'dificil')
        semaforo.src = "Visual/Material/Recursos/SemaforoDificil.png"
}