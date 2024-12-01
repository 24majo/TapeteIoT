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
var pecera = document.getElementById("pecera")
var respuesta = ""
var ejercicio = 0
var semaforo = document.getElementById('semaforo')
contador2 = 0
puntaje = 10
const audioCorrecto = document.getElementById('audioCorrecto');
const audioIncorrecto = document.getElementById('audioIncorrecto');

Ayuda()

function Progreso(progreso,puntaje){
    $.ajax({
        url: 'conexiones/actualizar_progreso_a.php',  
        type: 'POST',
        data: {
            progreso: progreso, 
            puntaje: puntaje,
            num_juego: 5,
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

function Empezar(){
    document.getElementById('aparecer').style.display='block';
    
    switch(valor){
        case 'facil':
            num = Math.floor(Math.random() * (50-1)+1)
            pecera.innerHTML = '<img src="Visual/Material/Numeros/Juego5/'+ num +'.jpg" width="400">'
            Completar(num)  
            break

        case 'medio':
            num = Math.floor(Math.random() * (99-51)+51)
            pecera.innerHTML = '<img src="Visual/Material/Numeros/Juego5/'+ num +'.jpg" width="400">'
            Completar(num)  
            break
        
        case 'dificil':
            num = Math.floor(Math.random() * (99-1)+1)
            pecera.innerHTML = '<img src="Visual/Material/Numeros/Juego5/'+ num +'.jpg" width="400">'
            Completar(num) 
            break
    }
}

function Completar(num){
    decena = num - (num % 10) + 10
    respuesta = decena - num
    
    op = Opcion(arreglo = [])

    for(let i = 0; i < opciones.length; i++){
        opciones[i].innerHTML = op[i]
    }

}

function Opcion(arreglo){
    if(arreglo.length == 4){
        var res = arreglo.indexOf(respuesta)
        if(res == -1){
            var r = Math.floor(Math.random() * arreglo.length) 
            arreglo.splice(r, 1, respuesta)
        }
    }

    else{
        var r = Math.floor(Math.random() * ((10-1)+1))
        arreglo.push(r)
                
        result = arreglo.filter((item,index)=>{
            return arreglo.indexOf(item) === index;
        })
        
        Opcion(result)
    }
    return result
}

function Validar(num){
    if(num == respuesta){
        audioCorrecto.play(); // Iniciar audio correcto :D
        contador2 += 0.3
        console.log(contador2)
        Progreso(contador2, puntaje)
        contador += 1
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
                    icon: "Visual/Material/Animaciones/Generales/PolloBien (2).gif",
                    buttons: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        if(valor == 'facil'){
                            contador2 = 3.3
                            Progreso(contador2, puntaje)
                            valor = 'medio'
                            semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
                            Reiniciar()
                        }

                        else{
                            if(valor == 'medio'){
                                contador2 = 6.6
                                Progreso(contador2, puntaje)
                                valor = 'dificil'
                                semaforo.src = "Visual/Material/Recursos/SemaforoDificil.png"
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
            puntaje -= 0.3
            Progreso(contador2, puntaje)
            imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon2.png" width="100">'
        }

        if(error == 1){
            puntaje -= 0.3
            Progreso(contador2, puntaje)
            imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon1.png" width="100">'
        }

        if(error == 0){
            puntaje -= 0.3
            Progreso(contador2, puntaje)
            imagen.innerHTML = ""
            swal({
                title: "¡Oh no!",
                text: "No te quedan más vidas. ¿Deseas salir o reintentar?",
                icon: "Visual/Material/Animaciones/Generales/triste.jpg",
                buttons:  ["Reintentar", "Salir"] 
            })
            .then((reintento) => {
                if (reintento) {
                    location.href = "JuegosNumeros.html"
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
                                contador2 = 3.3
                                Progreso(contador2, puntaje)
                                valor = "medio"
                                semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
                            }

                            if(valor == 'medio'){
                                contador2 = 0
                                Progreso(contador2, puntaje)
                                valor = "facil"
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
            })
        }
    }
}

window.addEventListener("keydown",(e)=>{
    let tecla = e.key
    switch(tecla){
        case 'ArrowUp':
            Validar(op[0])
            break;

        case 'ArrowLeft':
            Validar(op[1])
            break;

        case 'ArrowDown':
            Validar(op[2])
            break;

        case 'ArrowRight':
            Validar(op[3])
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
        text: "Identifica la cantidad de peces que se encuentran en la pecera. Deberás sumarlos para identificar cuanto falta para la siguiente decena. \nElige la opción correcta por medio de las teclas ↑ ↓ → ← o los botones del tablero.",
        icon: "Visual/Material/Animaciones/Generales/teclas.jpg"
    })
}