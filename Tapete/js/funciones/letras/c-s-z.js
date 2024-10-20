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
var palabras_f = ["carta", "príncipe", "sirena", "zapato", "zanahoria", "manzana", "zorro", "sol", "oso", "mariposa"]
var palabras_m = ["cereza", "cabeza", "pizza", "cisne", "cascada", "escalera", "cazador", "avestruz", "cocodrilo", "pescador"]
var opciones = document.getElementsByClassName("opcion")
var respuesta, respuesta_m = []
var arreglo = []
var num_ejercicio = 0, num_opcion = 0, palabras
var palabras_d =[
    {
        frase: "El príncipe perdió su zapato.",
        valores: ["príncipe", "zapato"]
    },
    {
        frase: "El oso está buscando al cazador.",
        valores: ["oso", "cazador"]
    },
    {
        frase:"Mi cabeza brilla como el sol.",
        valores: ["cabeza", "sol"]
    },
    {
        frase:"La sirena se comió la manzana envenenada.",
        valores: ["sirena", "manzana"]
    },
    {
        frase:"La pizza tiene mucho queso.",
        valores: ["pizza", "queso"]
    },
    {
        frase:"El café tiene un zapato.",
        valores: ["café", "zapato"]
    },
    {
        frase:"Los niños saltan a la cuerda.",
        valores: ["saltan", "cuerda"]
    },
    {
        frase:"El perro se come la cerca.",
        valores: ["come", "cerca"]
    },
    {
        frase:"El gato brinca en el sillón.",
        valores: ["brinca", "sillón"]
    },
    {
        frase:"La sopa está en la cazuela.",
        valores: ["sopa", "cazuela"]
    }
]

Ayuda()

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
    document.getElementById("linea").innerHTML = "" 
    for(let i = 0; i < opciones.length; i++){
        opciones[i].innerHTML = ""
    }
    if(valor == 'facil')
        palabras_f = ["carta", "príncipe", "sirena", "zapato", "zanahoria", "manzana", "zorro", "sol", "oso", "mariposa"]

    if(valor == 'medio')
        palabras_m = ["cereza", "cabeza", "pizza", "cisne", "cascada", "escalera", "cazador", "avestruz", "cocodrilo", "pescador"]

    error = 3
    vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
    contador = 0
    imagen = ""
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
            arreglo = ["c", "s", "z"]
            palabras = palabras_f
            respuesta = palabras[Math.floor(Math.random() * palabras.length)]
            var repetida = palabras.indexOf(respuesta)
            palabras.splice(repetida, 1)
            document.getElementById("linea").innerHTML = respuesta
            imagen = document.getElementById('figura') 
            imagen.src = "Visual/Material/Letras/Juego4/" + respuesta + ".png"
            
            if(respuesta.includes('c') == true || respuesta.includes('s') == true || respuesta.includes('z') == true){
                document.getElementById("linea").innerHTML = respuesta.replaceAll(/c|s|z/g, "_")
            }

            for(let i = 0; i < arreglo.length; i++){
                opciones[i].innerHTML = arreglo[i]
            }
            
            document.getElementById('aparecer').style.display='block';
            break

        case 'medio':
            arreglo = ["c", "s", "z"]
            palabras = palabras_m
            if(!respuesta_m.includes("_")){
                respuesta = palabras[Math.floor(Math.random() * palabras.length)]
                var repetida = palabras.indexOf(respuesta)
                palabras.splice(repetida, 1)

                if(respuesta.includes('c') == true || respuesta.includes('s') == true || respuesta.includes('z') == true){
                    respuesta_m = respuesta.replaceAll(/c|s|z/g, "_")
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
                });
            }

            document.getElementById("linea").innerHTML = palabras_d[num_ejercicio].frase

            if(respuesta.includes("c")){
                var palabra1 = respuesta.replace("c", "s")
                var palabra2 = respuesta.replace("c", "z")
                
                if(arreglo.length == 3){
                    arreglo[0] = respuesta
                    arreglo[1] = palabra1
                    arreglo[2] = palabra2
                }
                else{
                    arreglo.push(respuesta)
                    arreglo.push(palabra1)
                    arreglo.push(palabra2)
                }
            }

            else if(respuesta.includes("s")){
                var palabra1 = respuesta.replace("s", "c")
                var palabra2 = respuesta.replace("s", "z")
                if(arreglo.length == 3){
                    arreglo[0] = palabra1
                    arreglo[1] = respuesta
                    arreglo[2] = palabra2
                }
                else{
                    arreglo.push(palabra1)
                    arreglo.push(respuesta)
                    arreglo.push(palabra2)
                }
            }

            else if(respuesta.includes("z")){
                var palabra1 = respuesta.replace("z", "c")
                var palabra2 = respuesta.replace("z", "s")
                if(arreglo.length == 3){
                    arreglo[0] = palabra1
                    arreglo[1] = palabra2
                    arreglo[2] = respuesta
                }
                else{
                    arreglo.push(palabra1)
                    arreglo.push(palabra2)
                    arreglo.push(respuesta)
                }
            }

            for (let i = 0; i < opciones.length; i++){
                    opciones[i].innerHTML = arreglo[i] 
            }

            document.getElementById('aparecer').style.display='block';
            break
    }
}

function ComprobarM(letra){
    //alert(respuesta)
    if(respuesta.includes(letra)) {
        for(var i = 0; i < respuesta.length; i++){
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
            icon: "error",
            buttons:  ["Reintentar", "Salir"] 
        })
        .then((reintento) => {
            if (reintento) {
                location.href = "JuegosLetras.html"
            } 
            else{
                if(valor == 'facil'){
                    palabras_f = ["carta", "príncipe", "sirena", "zapato", "zanahoria", "manzana", "zorro", "sol", "oso", "mariposa"]
                    palabras = palabras_f
                    //alert("Original: " + palabras_f)
                    document.getElementById("btnIniciar").innerHTML = "Empezar"
                    Reiniciar()
                }

                // if (valor == 'medio'){
                //     palabras_m = ["cereza", "cabeza", "pizza", "cisne", "cascada", "escalera", "cazador", "avestruz", "cocodrilo", "pescador"]
                //     palabras = palabras_m
                //     //alert("Original: " + palabras)
                //     document.getElementById("btnIniciar").innerHTML = "Empezar"
                //     Reiniciar()
                // }

                else{
                    swal({
                        title: "¿Deseas reintentar el nivel o elegir otra dificultad?",
                        icon: "info",
                        buttons:  ["Mantener", "Cambiar"] 
                    })
                    .then((cambiar) => {
                        if(cambiar){
                            if(valor == 'dificil'){
                                valor = "medio"
                                semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
                                palabras_m = ["cereza", "cabeza", "pizza", "cisne", "cascada", "escalera", "cazador", "avestruz", "cocodrilo", "pescador"]
                                palabras = palabras_m
                            }

                            else if(valor == 'medio'){
                                valor = "facil"
                                semaforo.src = "Visual/Material/Recursos/SemaforoFacil.png"
                                palabras_f = ["carta", "príncipe", "sirena", "zapato", "zanahoria", "manzana", "zorro", "sol", "oso", "mariposa"]
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
        icon: "Visual/Material/Animaciones/Generales/echeleganas.png"
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
                        icon: "Visual/Material/Animaciones/Generales/pollo.gif",
                        buttons:  ["Reintentar todo", "Salir"] 
                    })
                    .then((reintento) => {
                        if (reintento) {
                            location.href = "JuegosLetras.html"
                        } 
                        else{
                            valor = 'facil'
                            semaforo.src = "Visual/Material/Recursos/SemaforoFacil.png"
                            palabras_f = ["uva", "vela", "vaso", "viento", "volcán", "globo", "lombríz", "libro", "balón", "barco"]
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
                        icon: "Visual/Material/Animaciones/Generales/pollo.gif",
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
        if(valor == 'medio'){
            ComprobarM(arreglo[0])
        }
        else{
            Comprobar(arreglo[0])
        }
        break;

    case 'ArrowDown':
        if(valor == 'medio'){
            ComprobarM(arreglo[1])
        }
        else{
            Comprobar(arreglo[1])
        }
        break

    case 'ArrowRight':
        if(valor == 'medio'){
            ComprobarM(arreglo[2])
        }
        else{
            Comprobar(arreglo[2])
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
        case 'ArrowDown':
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
        icon: "Visual/Material/Animaciones/Generales/teclado.gif"
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