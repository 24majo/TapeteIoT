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
//Opciones de dificultad
//var radios = document.getElementsByName("dificultad")
// Elementos generales
var pecera = document.getElementById("pecera")
var respuesta = ""
var ejercicio = 0
var semaforo = document.getElementById('semaforo')

Ayuda()

window.onload = function() {
    valor = localStorage.getItem('valorBoton');
    //alert(valor)
    if(valor == 'facil')
        semaforo.src = "Visual/Material/Recursos/SemaforoFacil.png"

    if(valor == 'medio')
        semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"

    if(valor == 'dificil')
        semaforo.src = "Visual/Material/Recursos/SemaforoDificil.png"
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
            // for(let y = 0; y < 3; y++){
            //     radios[y].disabled = false
            // }
            // for (var i = 0; i < radios.length; i++) {
            //     var niveles = radios[i];
            //     niveles.checked = false;
            // }
            document.getElementById("btnIniciar").innerHTML = "Empezar"
            Reiniciar()
        } 
    });
}

function Empezar(){
    // if(!document.querySelector('input[name="dificultad"]:checked')){
    //     swal({
    //         title: "Advertencia",
    //         text: "Elige una dificultad para iniciar el juego",
    //         icon: "Visual/Material/Iconos/jake.gif", 
    //     })
    // }

    // else{
    //     for(let y = 0; y < 3; y++){
    //         radios[y].disabled = true
    //     }
    //     valor = document.querySelector('input[name="dificultad"]:checked').value
    document.getElementById('aparecer').style.display='block';
    
    switch(valor){
        case 'facil':
            num = Math.floor(Math.random() * (50-1)+1)
            // decena = num - (num % 10) + 10
            // alert("Decena: " + decena)
            pecera.innerHTML = '<img src="Visual/Material/Numeros/Juego5/'+ num +'.jpg" width="400">'
            //alert("num: " + num)
            Completar(num)  
            break

        case 'medio':
            num = Math.floor(Math.random() * (99-51)+51)
            // decena = num - (num % 10) + 10
            // alert("Decena: " + decena)
            pecera.innerHTML = '<img src="Visual/Material/Numeros/Juego5/'+ num +'.jpg" width="400">'
            Completar(num)  
            break
        
        case 'dificil':
            num = Math.floor(Math.random() * (99-1)+1)
            // decena = num - (num % 10) + 10
            // alert("Decena: " + decena)
            pecera.innerHTML = '<img src="Visual/Material/Numeros/Juego5/'+ num +'.jpg" width="400">'
            Completar(num) 
            break
    }
    //}
}

function Completar(num){
    decena = num - (num % 10) + 10
    //alert("Decena: "+decena)
    respuesta = decena - num
    //alert("Respuesta: " + respuesta)
    
    op = Opcion(arreglo = [])

    for(let i = 0; i < opciones.length; i++){
        opciones[i].innerHTML = op[i]
    }

}

function Opcion(arreglo){
    if(arreglo.length == 4){
        //alert("respuesta en opciones: " + respuesta)
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
    //alert("Numero de respuesta: " + num)
    if(num == respuesta){
        contador += 1
        document.getElementById("btnIniciar").innerHTML = "Continuar"
        document.getElementById("barra").value = contador
        document.getElementById("barra").innerHTML = contador

        if(contador == 10){
            if(valor == "dificil"){
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
                        // for(let y = 0; y < 3; y++){
                        //     radios[y].disabled = false
                        // }
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
                            valor = 'medio'
                            semaforo.src = "Visual/Material/Recursos/SemaforoMedio.png"
                            //alert(valor)
                            //valor = document.querySelector('#medio').checked = true
                            Reiniciar()
                        }

                        else{
                            if(valor == 'medio'){
                                valor = 'dificil'
                                semaforo.src = "Visual/Material/Recursos/SemaforoDificil.png"
                                //alert(valor)
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
        error--
        if(error == 2){
            imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon2.png" width="100">'
        }

        if(error == 1){
            imagen.innerHTML = '<img src="Visual/Material/Iconos/corazon1.png" width="100">'
        }

        if(error == 0){
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
        text: "Identifica la cantidad de peces que se encuentran en la pecera. Deberás sumarlos para identificar cuanto falta para la siguiente decena. \nElige la opción correcta por medio de las teclas ↑ ↓ → ← o los botones del tablero.",
        icon: "Visual/Material/Animaciones/Generales/teclas.jpg"
    })
}