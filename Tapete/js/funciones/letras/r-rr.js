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
var palabras_f = ["pera", "perro", "ratón", "carro", "tierra", "tortuga", "árbol", "torre", "zorro", "guitarra"]
var palabras_m = ["carretera", "barrera", "corredor", "arrastrar", "ferretería", "territorio", "aterrizar", "corrector", "correo", "ferrocarril"]
var palabras = []
var opciones = document.getElementsByClassName("opcion")
var imagen = document.getElementById('figura')  
var respuesta, respuesta_m = []
var arreglo = []
var num_ejercicio = 0, num_opcion = 0
var palabras_d =[
    {
        frase: "El ratón toca la guitarra.",
        valores: ["ratón", "guitarra"]
    },
    {
        frase: "Los perros no comen brócoli.",
        valores: ["perros", "brócoli"]
    },
    {
        frase:"La tortuga ganó la carrera.",
        valores: ["tortuga", "carrera"]
    },
    {
        frase:"El zorro no puede bucear.",
        valores: ["zorro", "bucear"]
    },
    {
        frase:"Hay un árbol en la carretera.",
        valores: ["árbol", "carretera"]
    },
    {
        frase:"La rata se llevó mi tarea.",
        valores: ["rata", "tarea"]
    },
    {
        frase:"Tu perfume huele a fresa.",
        valores: ["perfume", "fresa"]
    },
    {
        frase:"Arrastraron algo en la tierra.",
        valores: ["Arrastraron", "tierra"]
    },
    {
        frase:"Hicieron cangrejo a la parrilla.",
        valores: ["cangrejo", "parrilla"]
    },
    {
        frase:"No hay barrera que impida imaginar.",
        valores: ["barrera", "imaginar"]
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
        palabras_f = ["pera", "perro", "ratón", "carro", "tierra", "tortuga", "árbol", "torre", "zorro", "guitarra"]

    if (valor == "medio")
        palabras_m = ["carretera", "barrera", "corredor", "arrastrar", "ferretería", "territorio", "aterrizar", "corrector", "rincón", "ferrocarril"]
    
    palabras = []
    error = 3
    vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
    contador = 0
    imagen.src = ""
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
            arreglo = ["r", "rr"]
            palabras = palabras_f
            respuesta = palabras[Math.floor(Math.random() * palabras.length)]
            var repetida = palabras.indexOf(respuesta)
            palabras.splice(repetida, 1)
            document.getElementById("linea").innerHTML = respuesta
            imagen.src = "Visual/Material/Letras/Juego5/" + respuesta + ".jpg"
            
            if(respuesta.includes('r') == true){
                document.getElementById("linea").innerHTML = respuesta.replaceAll(/r/g, "_")
            }

            for(let i = 0; i < arreglo.length; i++){
                opciones[i].innerHTML = arreglo[i]
            }
            
            document.getElementById('aparecer').style.display='block';
            break

        case 'medio':
            arreglo = ["r", "rr"]
            palabras = palabras_m

            if(!respuesta_m.includes("_")){
                respuesta = palabras[Math.floor(Math.random() * palabras.length)]
                var repetida = palabras.indexOf(respuesta)
                palabras.splice(repetida, 1)

                if(respuesta.includes('r') == true){
                    respuesta_m = respuesta.replaceAll(/r/g, "_")
                    document.getElementById("linea").innerHTML = respuesta_m
                }
            }

            for(let i = 0; i < arreglo.length; i++){
                opciones[i].innerHTML = arreglo[i]
            }
            imagen.src = "Visual/Material/Letras/Juego5/" + respuesta + ".jpg"
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
            var rr = /rr/.test(respuesta);

            if(rr){
                var palabra = respuesta.replace("rr", "r");
                
                if(arreglo.length == 2){
                    arreglo[0] = palabra
                    arreglo[1] = respuesta
                }
                else{
                    arreglo.push(palabra)
                    arreglo.push(respuesta)
                }
            }

            else{
                var palabra = respuesta.replace("r", "rr");
                if(arreglo.length == 2){
                    arreglo[0] = respuesta
                    arreglo[1] = palabra
                }
                else{
                    arreglo.push(respuesta)
                    arreglo.push(palabra)
                }
            }

            for (let i = 0; i < opciones.length; i++){
                    opciones[i].innerHTML = arreglo[i] // Se muestran las opciones en los círculos
            }

            document.getElementById('aparecer').style.display='block';
            break
    }
}

function ComprobarD(palabra){
    if(respuesta == palabra){
        palabras_d[num_ejercicio].frase = palabras_d[num_ejercicio].frase.replace("_______", respuesta)
        document.getElementById("linea").innerHTML = palabras_d[num_ejercicio].frase
        num_opcion++

        if(num_opcion > 1 && num_ejercicio < 10){
            num_ejercicio++
            num_opcion = 0
            Felicidades()
        }
    }
    else{
        Fallo()
    }
}

function ComprobarM(letra){
    var rr = /rr/.test(respuesta);
    var r = /r/.test(respuesta);

    if (rr && r) {
        for(var i = 0; i < respuesta.length; i++) {
            if(respuesta_m[i]=="_" && respuesta_m[i+1] == "_"){
                if(letra == "rr"){
                    respuesta_m = respuesta_m.replace("_", "r")
                    respuesta_m = respuesta_m.replace("_", "r")
                    break
                }
                else{
                    Fallo()
                }
                break
            }

            else if(respuesta_m[i] == "_" && respuesta_m[i+1] != "_"){
                if(letra == "r"){
                    respuesta_m = respuesta_m.replace("_", letra)
                    break
                }
                else{
                    Fallo()
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
        for(var i = 0; i < respuesta.length; i++) {
            if(respuesta_m[i]=="_" && respuesta_m[i+1] == "_"){
                if(letra == "rr"){
                    respuesta_m = respuesta_m.replace("_", "r")
                    respuesta_m = respuesta_m.replace("_", "r")
                    break
                }
                else{
                    Fallo()
                }
                break
            }

            else if(respuesta_m[i] == "_" && respuesta_m[i+1] != "_"){
                if(letra == "r"){
                    respuesta_m = respuesta_m.replace("_", letra)
                    break
                }
                else{
                    Fallo()
                }
                break
            }
        }

        document.getElementById("linea").innerHTML = respuesta_m

        if(!respuesta_m.includes("_")){
            Felicidades()
        }
    }
}

function ComprobarF(letra){
    var rr = /rr/.test(respuesta);
    
    if (rr) {
        if(letra == "rr"){
            for(var i = 0; i < respuesta.length; i++) {
                if(respuesta[i]=="r"){
                    respuesta[i] == "r"
                    break
                }
            }
            document.getElementById("linea").innerHTML = respuesta
            Felicidades()
        }
        else{
            Fallo()
        }
    } 
    else{
        if(letra == "r"){
            for(var i = 0; i < respuesta.length; i++) {
                if(respuesta[i] == letra){
                    respuesta[i] == letra
                    break
                }
            }
            document.getElementById("linea").innerHTML = respuesta
            Felicidades()
        }
        else{
            Fallo()
        }
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
                    palabras_f = ["pera", "perro", "ratón", "carro", "tierra", "tortuga", "árbol", "torre", "zorro", "guitarra"]
                    palabras = palabras_f
                    document.getElementById("btnIniciar").innerHTML = "Empezar"
                    Reiniciar()
                }

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
                                palabras_m = ["carretera", "barrera", "corredor", "arrastrar", "ferretería", "territorio", "aterrizar", "corrector", "rincón", "ferrocarril"]
                                palabras = palabras_m
                                //alert(palabras)
                            }

                            if(valor == 'medio'){
                                valor = "facil"
                                semaforo.src = "Visual/Material/Recursos/SemaforoFacil.png"
                                palabras_f = ["pera", "perro", "ratón", "carro", "tierra", "tortuga", "árbol", "torre", "zorro", "guitarra"]
                                palabras = palabras_f
                                //alert(palabras)
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
                        buttons:  ["Volver a jugar", "Salir"] 
                    })
                    .then((reintento) => {
                        if (reintento) {
                            location.href = "JuegosLetras.html"
                        } 
                        else{
                            valor = "facil"
                            semaforo.src = "Visual/Material/Recursos/SemaforoFacil.png"
                            var palabras_f = ["pera", "perro", "ratón", "carro", "tierra", "tortuga", "árbol", "torre", "zorro", "guitarra"]
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
        if(valor == "dificil"){
            ComprobarD(arreglo[0])
        }
        else if(valor == 'medio'){
            ComprobarM(arreglo[0])
        }
        else{
            ComprobarF(arreglo[0])
        }
        break;
    case 'ArrowRight':
        if(valor == "dificil"){
            ComprobarD(arreglo[1])
        }
        if(valor == 'medio'){
            ComprobarM(arreglo[1])
        }
        else if(valor == 'facil'){
            ComprobarF(arreglo[1])
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