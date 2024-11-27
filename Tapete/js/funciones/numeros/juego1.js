var correcta = 0
var arreglo_f = []
var opciones = document.getElementsByClassName("opcion")
contador = 0
var imagen = document.getElementById('vida');
imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
var error = 3
var puntaje = 10
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
            num_juego: 1,
        },
        success: function(response) {
            console.log('Progreso actualizado', response);
        },
        error: function(xhr, status, error) {
            console.error('Error al actualizar el progreso: ' + error);
        }
    });
}

function apretar(numero){
    if(arreglo_f[numero]== correcta){
        audioCorrecto.play(); // Iniciar audio correcto :D
        //opciones[numero].style.backgroundColor = '#f958a5'
        contador++
        document.getElementById("barra").value = contador
        document.getElementById("barra").innerHTML = contador

        Progreso(contador, puntaje)

        if(contador == 10){
           
            Progreso(contador, puntaje)
            swal({
                title: "¡Ganador!",
                text: "Has superado la prueba. ¿Deseas salir o reiniciar el juego?",
                icon: "Visual/Material/Animaciones/Generales/PolloBien (2).gif",
                buttons:  ["Continuar", "Salir"],
            })
            .then((willDelete) => {
                if (willDelete) {
                    location.href = "JuegosNumeros.html"
                } 
                else{
                    Reiniciar()
                }
            })
            //alert("Ganaste")
        }
        //document.getElementById("cont").innerHTML = "Aciertos: " + contador
    }

    else{
        audioIncorrecto.play(); // Iniciar audio incorrecto :c
        error--
        if(error == 2){
            imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon2.png" width="100">'
            puntaje = 6.6
        }

        if(error == 1){
            imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon1.png" width="100">'
            puntaje = 3.3
        }

        if(error == 0){
            imagen.innerHTML = ""
            puntaje = 0

            swal({
                title: "Perdiste:(",
                text: "Has perdido todas tus vidas. ¿Deseas salir o reiniciar?",
                icon: "Visual/Material/Animaciones/Generales/error.jpg",
                buttons:  ["Reintentar", "Salir"],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    location.href = "JuegosNumeros.html"
                } 
                else{
                    //document.getElementById("btnIniciar").innerHTML = "Empezar"
                    Reiniciar()
                }
            })
        }
        // error -= 1
        // document.getElementById("error").innerHTML = "Errores: " + error 

        // if(error == 0){
        //     alert("Chin")
        //     Random()
        // }
    }
}

function Reinicio(){
    swal({
        title: "Reiniciar juego",
        text: "Si reinicias ahora, el progreso se perderá. ¿Deseas continuar?",
        icon: "Visual/Material/Animaciones/Generales/advertencia.jpg", // En este apartado se puede poner la ruta de las imágenes
        buttons: true, // Como si fuera arreglo, se pueden agregar más botones con texto 
        dangerMode: true, // Botón rojo
    })

    .then((Reinicia) => {
        if (Reinicia) {
            Reiniciar()
        } 
    });
}

function Reiniciar(){
    contador = 0
    error = 3
    //document.getElementById("cont").innerHTML = "Aciertos: " + 
    document.getElementById("barra").value = contador
    document.getElementById("barra").innerHTML = contador
    imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
    //document.getElementById("error").innerHTML = "Errores: 3"
    Random()
}

function Random(){
    var arreglo = OpRandom()
    console.log("Arreglo: ", arreglo)

    for(var i = 0; i < arreglo.length; i++){
        //opciones[i].style.backgroundColor = '#ff99ff' 
        opciones[i].innerHTML = arreglo[i]
    } 

    document.getElementById('aparecer').style.display='block';
}

window.addEventListener("keydown",(e)=>{
    let tecla = e.key
    switch(tecla){
        case 'ArrowUp':
            apretar(0)
            break;

        case 'ArrowDown':
            apretar(1)
            break;

        case 'ArrowLeft':
            apretar(2)
            break;

        case 'ArrowRight':
            apretar(3)
            break;

        default:
            break;
    }
})

window.addEventListener("keyup",(e)=>{
    let tecla = e.key

    switch(tecla){
        case 'ArrowUp':
            repetir = Random()
            break;

        case 'ArrowDown':
            repetir = Random()
            break;

        case 'ArrowLeft':
            repetir = Random()
            break;

        case 'ArrowRight':
            repetir = Random()
            break;

        default:
            break;
    }
    
})

function OpRandom(){ // Asignar 4 números aleatorios a los círculos
    var arreglo = [] // Arreglo de apoyo 
    var aux = 0
    var resultado = Math.floor(Math.random() * (99-1)+1)
    var ex = false
    
    while (arreglo.length < 4){
        var existe = false
        var n = Math.floor(Math.random() * (99-1)+1)// Valores random del 1 al 9
        
        for(var i = 0; i <arreglo.length; i++){
            if(arreglo[i] == n){ // Si el numero random se encuentra en el arreglo
                existe = true
                break
            }
        }
        
        if(!existe){
            arreglo.push(n) // Se agrega el numero random al arreglo para evitar repetirse
            aux++
        }
    }
    
    for(var i = 0; i <arreglo.length; i++){
        if(arreglo[i] == resultado){
            ex = true
            break
        }
    }
    
    if(!ex){
        var num = Math.floor(Math.random() * 4)
        arreglo[num] = resultado
    }
    
    var imagen = document.getElementById("img")
    imagen.src = "Visual/Material/Numeros/Juego5/" + resultado + ".jpg"
    arreglo_f = arreglo
    correcta = resultado
    return arreglo
}

function Ayuda(){
    swal({
        title: "Tutorial",
        text: "Cuenta la cantidad de peces que están en la pecera. Elige la opción correcta por medio de las teclas ↑ ↓ → ← o los botones del tablero.",
        icon: "Visual/Material/Animaciones/Generales/teclas.jpg"
    })
    // swal("Tutorial", 
    //     "Realiza la resta de dos números y elige la opción correcta con los botones o las flechas del teclado.");
}