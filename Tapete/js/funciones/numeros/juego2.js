var opciones = document.getElementsByClassName("opcion")
var secuencia = []
var adivinar = []
var numeros = [1,2,3,4,5,6,7,8,9]
var respuesta
var result
var op = []
// Barra de progreso
contador = 0
document.getElementById("barra").value = contador
document.getElementById("barra").innerHTML = contador
var error = 3
var puntaje = 10
var imagen = document.getElementById('vida');
imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'

Ayuda()

function Ayuda(){
    swal({
        title: "Tutorial",
        text: "Elige el número siguiente al anterior de acuerdo con la secuencia presentada por medio de las teclas ↑ ↓ → ← o los botones del tablero.",
        icon: "Visual/Material/Animaciones/Generales/teclas.jpg"
    })
}

function Progreso(progreso,puntaje){
    $.ajax({
        url: 'conexiones/actualizar_progreso_a.php',  
        type: 'POST',
        data: {
            progreso: progreso, 
            puntaje: puntaje,
            num_juego: 2,
        },
        success: function(response) {
            console.log('Progreso actualizado', response);
        },
        error: function(xhr, status, error) {
            console.error('Error al actualizar el progreso: ' + error);
        }
    });
}

function Reiniciar(){
    numeros = [1,2,3,4,5,6,7,8,9]
    contador = 0
    error = 3
    document.getElementById("barra").value = contador
    document.getElementById("barra").innerHTML = contador
    imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
    document.getElementById("btnIniciar").innerHTML = "Empezar"
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
    .then((Reinicios) => {
        if(Reinicios){
            document.getElementById("btnIniciar").innerHTML = "Empezar"
            Reiniciar()
        }
    })
}

function Empezar(){
    document.getElementById('aparecer').style.display='block';
    var num1 = numeros[Math.floor(Math.random() * numeros.length)]
    // alert("Numero: "+num1)
    var repetida = numeros.indexOf(num1)
    if(repetida != -1){
        numeros.splice(repetida, 1)
    }
    else{
        Empezar()
    }
    // alert("Nuevo: " + numeros)
    
    for(let i = 0; i < 10; i++){
        secuencia[i] = num1 * (i+1)
        adivinar[i] = num1 * (i+1)
    }

    for(let i = 0; i < 4; i++){
        var num2 = Math.floor(Math.random() * 9+1)
        adivinar.splice(num2, 1, "_")
    }
    document.getElementById("linea").innerHTML = adivinar
    Acciones()
    
}

function Acciones(){
    for(let i = 0; i < secuencia.length; i++){
        if(adivinar[i] == "_"){
            respuesta = secuencia[i]
            break
        }
    }
    //console.log("Respuesta: ", respuesta)
    op = Opcion(arreglo = [])

    for(let i = 0; i < opciones.length; i++){
        opciones[i].innerHTML = op[i]
    }
}

function Opcion(arreglo){
    if(arreglo.length == 4){
        var res = arreglo.indexOf(respuesta)
        if(res == -1){
            let r = Math.floor(Math.random() * arreglo.length) 
            arreglo.splice(r, 1, respuesta)
        }
    }
    else{
        let r = Math.floor(Math.random() * secuencia.length) 
        arreglo.push(secuencia[r])
    
        result = arreglo.filter((item,index)=>{ // Se evita que las vocales aleatorias se repitan
            return arreglo.indexOf(item) === index;
        })
        Opcion(result)
    }
    return result
}

function Opciones(num){
    if(num == respuesta){
        for(let i = 0; i < secuencia.length; i++){
            if(adivinar[i] == "_"){
                adivinar.splice(i, 1, respuesta)
                break
            }
        }

        document.getElementById("linea").innerHTML = adivinar
        var e = adivinar.includes('_')

        if(!e){
            contador++
            document.getElementById("barra").value = contador
            document.getElementById("barra").innerHTML = contador
            Progreso(contador, puntaje)

            swal({
                title: "¡Bien hecho!",
                text: "Continuemos al siguiente ejercicio",
                icon: "Visual/Material/Animaciones/Generales/PolloBien.gif",
                button: "Continuar",
            })
            .then((Continuar) => {
                if(Continuar){
                    document.getElementById("btnIniciar").innerHTML = "Continuar"
                    Empezar()
                }
            })

            if(contador==9){
                Progreso(contador, puntaje)
                swal({
                    title: "¡Felicidades! :D",
                    text: "Has completado todas las secuencias. \n ¿Deseas reintentar el juego o salir?",
                    icon: "Visual/Material/Animaciones/Generales/PolloBien (3).gif",
                    buttons: ["Reintentar", "Salir"],
                })
                .then((Continuar) => {
                    if(Continuar){
                        location.href = "JuegosNumeros.html"
                    }
                    else{
                        Reiniciar() 
                    }
                })
            }
        }
        SaltoPollo()
    }
    else{
        error--
        if(error == 2){
            puntaje = 6.6
            imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon2.png" width="100">'
            CaidaPollo()
        }

        if(error == 1){
            puntaje = 3.3
            imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon1.png" width="100">'
            CaidaPollo()
        }

        if(error == 0){
            puntaje = 0
            imagen.innerHTML = ""
            CaidaPollo()

            swal({
                title: "¡Oh no!",
                text: "No te quedan más vidas. ¿Deseas salir o reintentar?",
                icon: "Visual/Material/Animaciones/Generales/error.jpg",
                buttons: ["Reintentar", "Salir"]
            })
            .then((reintento) => {
                if(reintento){
                    location.href = "JuegosNumeros.html"
                }
                else{
                    document.getElementById("btnIniciar").innerHTML = "Empezar"
                    Reiniciar()
                }
            })
        }
    }
}

window.addEventListener("keydown",(e)=>{
    let tecla = e.key

    switch(tecla){
    case 'ArrowUp':
        Opciones(op[0])
        break;
    case 'ArrowDown':
        Opciones(op[1])
        break;
    case 'ArrowLeft':
        Opciones(op[2])
        break;
    case 'ArrowRight':
        Opciones(op[3])
        break;
    default:
        break;
    }
})

window.addEventListener("keyup",(e)=>{
    let tecla = e.key

    switch(tecla){
        case 'ArrowUp':
            Acciones()
            break;

        case 'ArrowDown':
            Acciones()
            break;

        case 'ArrowLeft':
            Acciones()
            break;

        case 'ArrowRight':
            Acciones()
            break;

        default:
            break;
    }
})

function SaltoPollo(){
    const espera = document.getElementById("espera");
    const salto = document.getElementById("salto");
    
    //Ocultar la animación de espera para pasar a la de salto
    espera.classList.add("desaparecer");
    
    //Muestra la aninmación de salto una vez
    salto.classList.remove("desaparecer");
    salto.classList.add("salto");
    
    //Se usa el evento animationend para indicar que la animación finalizó 
    //y de nuevo muestre la animación de espera
    salto.addEventListener("animationend", function() {
        //Ocultar la animación de salto
        salto.classList.add("desaparecer");    
        salto.classList.remove("salto");
        //Mostrar la animación de espera
        espera.classList.remove("desaparecer"); 
        //Ayuda a que la animación se ejecute una vez
    }, { once: true });
}

function CaidaPollo(){
    const espera = document.getElementById("espera");
    const salto = document.getElementById("caer");
    
    espera.classList.add("desaparecer");
    
    salto.classList.remove("desaparecer");
    salto.classList.add("caer");
    
    salto.addEventListener("animationend", function() {
        salto.classList.add("desaparecer"); 
        salto.classList.remove("caer");
    
        espera.classList.remove("desaparecer"); 
    }, { once: true });
}