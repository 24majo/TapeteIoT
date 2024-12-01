var imagen = document.getElementById('vida');
imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
var incorrecto = 3
// Barra de progreso
var contador2 = 0
contador = 0
document.getElementById("barra").value = contador
document.getElementById("barra").innerHTML = contador
// Circulos de opciones
var opciones = document.getElementsByClassName("opcion")
var op = []
//Opciones de dificultad
var valorBoton
// Elementos generales
var resultado = 0
var arreglo = []
var semaforo = document.getElementById('semaforo')
var puntaje = 10
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
            num_juego: 3,
        },
        success: function(response) {
            console.log('Progreso actualizado', response);
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
}

function Empezar(){
    document.getElementById('aparecer').style.display='block';
    
    switch(valor){
        case 'facil':
            num1 = Math.floor(Math.random() * (50-1)+1)
            num2 = Math.floor(Math.random() * (50-1)+1)
            Random(num1, num2)  
            break

        case 'medio':
            num1 = Math.floor(Math.random() * (100-50)+50)
            num2 = Math.floor(Math.random() * (100-50)+50)
            Random(num1, num2)  
            break
        
        case 'dificil':
            num1 = Math.floor(Math.random() * (100-1)+1)
            num2 = Math.floor(Math.random() * (100-1)+1)
            Random(num1, num2) 
            break
    }
}

function Random(num1, num2){
    resultado = num1 + num2
    if(num1<=9){
        document.getElementById("linea_s").innerHTML = "0"+num1
    }else{
        document.getElementById("linea_s").innerHTML = num1
    }if(num2<=9){
        document.getElementById("linea_i").innerHTML = "0"+num2
    }else{
        document.getElementById("linea_i").innerHTML = "+" + num2
    }if(num1<=9 && num2<=9){
        document.getElementById("linea_s").innerHTML = "0"+num1
        document.getElementById("linea_i").innerHTML = "+"+"0"+num2
    }if(num1>9 && num2<=9){
        document.getElementById("linea_s").innerHTML = num1
        document.getElementById("linea_i").innerHTML = "+"+"0"+num2
    }if(num2>9 && num1<=9){
        document.getElementById("linea_s").innerHTML = "0"+num1
        document.getElementById("linea_i").innerHTML = "+"+num2
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
        if(valor == 'facil'){
            var r = Math.floor(Math.random() * (100-10)+10)
        }
        else{
            if(valor == "medio") {
                var r = Math.floor(Math.random() * (199-100)+100)
            }
            else {
                var r = Math.floor(Math.random() * (199-10)+10)
            }
        }
        arreglo.push(r)
                
        result = arreglo.filter((item,index)=>{ 
            return arreglo.indexOf(item) === index;
        })
        
        Opcion(result)
    }
    return result
}

function Racierto(num){ 
    if(num == resultado){
        audioCorrecto.play(); // Iniciar audio correcto :D
        contador2 += 0.3
        console.log(contador2)
        Progreso(contador2, puntaje)
        PolloBueno()
        contador+=1
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
                        for(let y = 0; y < 3; y++){
                            radios[y].disabled = false
                        }
                        document.getElementById("btnIniciar").innerHTML = "Empezar"
                        Reiniciar()
                    }
                })
            }
            else{
                swal({
                    title: "¡Felicidades!",
                    text: "Completaste el nivel " + valor + ". ¿Deseas avanzar al siguiente nivel?",
                    icon: "Visual/Material/Animaciones/Generales/PolloBien.gif",
                    buttons: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        if(valor == 'facil'){
                            contador2 = 3.3
                            Progreso(contador2, puntaje)
                            valor = "medio"
                            semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
                            Reiniciar()
                        }

                        else{
                            if(valor == 'medio'){
                                contador2 = 6.6
                                Progreso(contador2, puntaje)
                                valor = "dificil"
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
        incorrecto--
        if(incorrecto == 2){
            imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon2.png" width="100">'
            puntaje -= 0.3
            Progreso(contador2, puntaje)
            Polloincorrectoo()
        }

        if(incorrecto == 1){
            imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon1.png" width="100">'
            puntaje -= 0.3
            Progreso(contador2, puntaje)
            Polloincorrectoo()
        }

        if(incorrecto == 0){
            puntaje -= 0.3
            Progreso(contador2, puntaje)
            Polloincorrectoo()
            imagen.innerHTML = ""
            swal({
                title: "Oh no!",
                text: "No te quedan más vidas. ¿Deseas salir o reintentar?",
                icon: "Visual/Material/Animaciones/Generales/triste.jpg",
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
                            title: "¿Deseas reintentar el nivel o bajar la dificultad?",
                            icon: "Visual/Material/Animaciones/Generales/Chick.gif",
                            buttons:  ["Mantener", "Cambiar"] 
                        })
                        .then((cambiar) => {
                            if(cambiar){

                                if(valor == 'dificil'){
                                    valor = "medio"
                                    semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
                                }

                                if(valor == 'medio'){
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
                }
            })
        }
    }
}

function Reiniciar(){
    incorrecto = 3
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

window.addEventListener("keydown",(e)=>{
    let tecla = e.key
    switch(tecla){
        case 'ArrowUp':
            Racierto(op[0])
            break;

        case 'ArrowDown':
            Racierto(op[1])
            break;

        case 'ArrowLeft':
            Racierto(op[2])
            break;

        case 'ArrowRight':
            Racierto(op[3])
            break;

        default:
            break;
    }
})

window.addEventListener("keyup",(e)=>{
    let tecla = e.key
    switch(tecla){
        case 'ArrowUp':
            Empezar()
            break;

        case 'ArrowDown':
            Empezar()
            break;

        case 'ArrowLeft':
            Empezar()
            break;

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
        text: "Realiza la suma de dos números. Elige la opción correcta por medio de las teclas ↑ ↓ → ← o los botones del tablero.",
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