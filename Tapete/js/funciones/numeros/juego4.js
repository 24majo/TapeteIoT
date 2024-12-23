// Vidas
var imagen = document.getElementById('vida');
imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
var error = 3
// Barra de progreso
contador = 0
document.getElementById("barra").value = contador
document.getElementById("barra").innerHTML = contador
// Circulos de opciones
var opciones = document.getElementsByClassName("opcion")
var op = []
var resultado = 0
var arreglo = []
var semaforo = document.getElementById('semaforo')
contador2 = 0
puntaje = 10
const audioCorrecto = document.getElementById('audioCorrecto');
const audioIncorrecto = document.getElementById('audioIncorrecto');

Ayuda() // Tutorial al abrir la pestaña por primera vez

function Progreso(progreso,puntaje){
    $.ajax({
        url: 'conexiones/actualizar_progreso_a.php',  
        type: 'POST',
        data: {
            progreso: progreso, 
            puntaje: puntaje,
            num_juego: 4,
        },
        success: function(response) {
            console.log('Progreso actualizado');
        },
        error: function(xhr, status, error) {
            console.error('Error al actualizar el progreso: ' + error);
        }
    });
}

window.onload = function() {
    valor = localStorage.getItem('valorBoton');
    if(valor == 'facil'){
        contador2 = 0
        semaforo.src = "Visual/Material/Recursos/SemaforoFacil.png"
    }

    if(valor == 'medio'){
        contador2 = 3.3
        semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
    }

    if(valor == 'dificil'){
        contador2 = 6.6
        semaforo.src = "Visual/Material/Recursos/SemaforoDificil.png"
    }
    console.log("carga: " + contador2)
}

function Empezar(){
    document.getElementById('aparecer').style.display='block';

    switch(valor){
        case 'facil':
            num1 = Math.floor(Math.random() * (50-1)+1)
            num2 = Math.floor(Math.random() * (num1-1)+1)
            Random(num1, num2)  
            break

        case 'medio':
            num1 = Math.floor(Math.random() * (100-50)+50)
            num2 = Math.floor(Math.random() * (num1-50)+50)
            Random(num1, num2)  
            break
        
        case 'dificil':
            num1 = Math.floor(Math.random() * (100-1)+1)
            num2 = Math.floor(Math.random() * (num1-1)+1)
            Random(num1, num2) 
            break
    }
}

function Random(num1, num2){
    resultado = num1 - num2
    if(num1<=9){
        document.getElementById("linea_l").innerHTML = "-"
        document.getElementById("linea_s").innerHTML = "0"+num1
    }else{
        document.getElementById("linea_l").innerHTML = "-"
        document.getElementById("linea_s").innerHTML = num1
    }if(num2<=9){
        document.getElementById("linea_i").innerHTML = "0"+num2
        document.getElementById("linea_l").innerHTML = "-"
    }else{
        document.getElementById("linea_l").innerHTML = "-"
        document.getElementById("linea_i").innerHTML =  num2
    }if(num1<=9 && num2<=9){
        document.getElementById("linea_s").innerHTML = "0"+num1
        document.getElementById("linea_l").innerHTML = "-"
        document.getElementById("linea_i").innerHTML = "0"+num2
    }if(num1>9 && num2<=9){
        document.getElementById("linea_s").innerHTML = num1
        document.getElementById("linea_i").innerHTML = "0"+num2
    }if(num2>9 && num1<=9){
        document.getElementById("linea_s").innerHTML = "0"+num1
        document.getElementById("linea_l").innerHTML = "-"
        document.getElementById("linea_i").innerHTML = num2
    }

    op = Opcion(arreglo = [])

    for(let i = 0; i < opciones.length; i++){
        opciones[i].innerHTML = op[i]
    }
}

function Opcion(arreglo){
    if(arreglo.length == 4){
        var res = arreglo.indexOf(resultado)
        if(res == -1){
            var r = Math.floor(Math.random() * arreglo.length) 
            arreglo.splice(r, 1, resultado)
        }
    }

    else{
        var r = Math.floor(Math.random() * ((100-1)+1))
        arreglo.push(r)
                
        result = arreglo.filter((item,index)=>{
            return arreglo.indexOf(item) === index;
        })
        
        Opcion(result)
    }
    return result
}

function RCorrecto(num){
    if(num == resultado){
        audioCorrecto.play(); // Iniciar audio correcto :D
        contador2 += 0.3
        console.log(contador2)
        Progreso(contador2, puntaje)
        contador+=1
        PolloBueno()
        document.getElementById("btnIniciar").innerHTML = "Continuar"
        document.getElementById("barra").value = contador
        document.getElementById("barra").innerHTML = contador

        if(contador == 10){
            if(valor == "dificil"){
                contador2 = 10
                Progreso(contador2, puntaje)
                swal({
                    title: "¡Ganador!",
                    text: "Completaste todos los niveles. ¿Deseas salir o reiniciar?",
                    icon: "Visual/Material/Animaciones/Generales/PolloBien (3).gif",
                    buttons:  ["Continuar", "Salir"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        location.href = "JuegosNumeros.html"
                    } 
                    else{
                        document.getElementById("btnIniciar").innerHTML = "Empezar"
                        Reiniciar()
                    }
                })
            }

            else{
                swal({
                    title: "¡Felicidades!",
                    text: "Completaste el nivel " + valor + ". ¿Deseas avanzar al siguiente nivel?",
                    icon: "Visual/Material/Animaciones/Generales/PolloBien (4).gif",
                    buttons: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        if(valor == 'facil'){
                            contador2 = 3.3
                            Progreso(contador2, puntaje)
                            valor = 'medio'
                            semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
                            //valor = document.querySelector('#medio').checked = true
                            Reiniciar()
                        }

                        else{
                            if(valor == 'medio'){
                                contador2 = 6.6
                                Progreso(contador2, puntaje)
                                valor = 'dificil'
                                semaforo.src = "Visual/Material/Recursos/SemaforoDificil.png"
                                //valor = document.querySelector('#dificil').checked = true
                                Reiniciar()
                            }
                        }
                    } 
                })
            }
        }
    }
    else{
        audioIncorrecto.play(); // Iniciar audio incorrecto :c
        error--
        if(error == 2){
            imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon2.png" width="100">'
            puntaje -= 0.3
            Progreso(contador2, puntaje)
            Polloincorrectoo()
        }

        if(error == 1){
            imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon1.png" width="100">'
            puntaje -= 0.3
            Progreso(contador2, puntaje)
            Polloincorrectoo()
        }

        if(error == 0){
            imagen.innerHTML = ""
            puntaje -= 0.3
            Progreso(contador2, puntaje)
            Polloincorrectoo()
            swal({
                title: "Oh no!",
                text: "No te quedan más vidas. ¿Deseas salir o reintentar?",
                icon: "Visual/Material/Animaciones/Generales/error.jpg",
                buttons:  ["Reintentar", "Salir"] 
            })
            .then((reintento) => {
                if (reintento) {
                    location.href = "JuegosNumeros.html"
                } 
                else{

                    if(valor == "facil"){
                        document.getElementById("btnIniciar").innerHTML = "Empezar"
                        Reiniciar()
                    }

                    else{
                        swal({
                            title: "¿Deseas reintentar el nivel o elegir otra dificultad?",
                            icon: "Visual/Material/Animaciones/Generales/Chick.gif",
                            buttons:  ["Mantener", "Cambiar"] 
                        })
                        .then((cambiar) => {
                            if(cambiar){
                                if(valor == 'dificil'){
                                    valor = "medio"
                                    contador2 = 3.3
                                    Progreso(contador2, puntaje)
                                    semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
                                }

                                if(valor == 'medio'){
                                    valor = "facil"
                                    contador2 = 0
                                    Progreso(contador2, puntaje)
                                    semaforo.src = "Visual/Material/Recursos/SemaforoFacil.png"
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
}

function Reiniciar(){
    error = 3
    contador = 0
    imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
    document.getElementById("barra").value = contador
    document.getElementById("barra").innerHTML = contador
    Empezar()
}

function Reinicio(){
    swal({
        title: "Reiniciar juego",
        text: "Si reinicias ahora, el progreso se perderá. ¿Deseas continuar?",
        icon: "Visual/Material/Animaciones/Generales/advertencia(1).jpg",
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

window.addEventListener("keydown",(e)=>{
    let tecla = e.key
    switch(tecla){
        case 'ArrowUp':
            RCorrecto(op[0])
            break;

        case 'ArrowDown':
            RCorrecto(op[1])
            break;

        case 'ArrowLeft':
            RCorrecto(op[2])
            break;

        case 'ArrowRight':
            RCorrecto(op[3])
            break;

        default:
            break;
    }
})

window.addEventListener("keyup",(e)=>{
    let tecla = e.key
    switch(tecla){
        case 'ArrowUp':
        case 'ArrowDown':
        case 'ArrowLeft':
        case 'ArrowRight':
            Empezar()
            break;

        default:
            break;
    }
})

function Ayuda(){
    swal({
        title: "Tutorial",
        text: "Realiza la resta de dos números. Elige la opción correcta por medio de las teclas ↑ ↓ → ← o los botones del tablero.",
        icon: "Visual/Material/Animaciones/Generales/teclas.jpg"
    })
}

function PolloBueno(){
    const espera = document.getElementById("espera");
    const acierto = document.getElementById("acierto");

    //Ocultar la animación de espera para pasar a la de acierto
    espera.classList.add("desaparecer");

    //Muestra la aninmación de acierto una vez
    acierto.classList.remove("desaparecer");
    acierto.classList.add("acierto");

    //Se usa el evento animationend para indicar que la animación finalizó 
    //y de nuevo muestre la animación de espera
    acierto.addEventListener("animationend", function() {
        //Ocultar la animación de acierto
    acierto.classList.add("desaparecer");    
    acierto.classList.remove("acierto");
        //Mostrar la animación de espera
    espera.classList.remove("desaparecer"); 
    //Ayuda a que la animación se ejecute una vez
    }, { once: true });
}

function Polloincorrectoo(){
    const espera = document.getElementById("espera");
    const incorrecto = document.getElementById("incorrecto");

    espera.classList.add("desaparecer");

    incorrecto.classList.remove("desaparecer");
    incorrecto.classList.add("incorrecto");

    incorrecto.addEventListener("animationend", function() {
        incorrecto.classList.add("desaparecer"); 
        incorrecto.classList.remove("incorrecto");

        espera.classList.remove("desaparecer"); 
    }, { once: true });
}