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
var valorBoton
    //var radios = document.getElementsByName("dificultad")
// Elementos generales
var resultado = 0
var arreglo = []

Ayuda() // Tutorial al abrir la pestaña por primera vez

window.onload = function() {
    valor = localStorage.getItem('valorBoton');
    //alert(valor)
    //document.getElementById('mostrarValor').textContent = valor ? valor : 'No se recibió ningún valor';
}

function Empezar(){
    // if(!document.querySelector('input[name="dificultad"]:checked')){
    //     swal({
    //         title: "Advertencia",
    //         text: "Elige una dificultad para iniciar el juego",
    //         icon: "warning", 
    //     })
    // }
    //else{
        // for(let y = 0; y < 3; y++){
        //     radios[y].disabled = true
        // }
        // valor = document.querySelector('input[name="dificultad"]:checked').value
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
            //alert("Num1: " + num1 + " num2: " + num2)
            Random(num1, num2)  
            break
        
        case 'dificil':
            num1 = Math.floor(Math.random() * (100-1)+1)
            num2 = Math.floor(Math.random() * (100-1)+1)
            Random(num1, num2) 
            break
    }
    //}
}

function Random(num1, num2){
    //num1 = Math.round(num1 / 10) * 10
    //num2 = Math.round(num2 / 10) * 10
    resultado = num1 + num2
    document.getElementById("linea_s").innerHTML = num1
    document.getElementById("linea_i").innerHTML = "+" + num2

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

function RCorrecto(num){ 
    if(num == resultado){
        contador+=1
        //alert("Vas bien", contador)
        document.getElementById("btnIniciar").innerHTML = "Continuar"
        document.getElementById("barra").value = contador
        document.getElementById("barra").innerHTML = contador

        if(contador == 10){
            if(valor == "dificil"){
                swal({
                    title: "¡Ganador!",
                    text: "Completaste todos los niveles. ¿Deseas salir o reiniciar?",
                    icon: "success",
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
                    icon: "Visual/Material/Animaciones/Generales/pollo.gif",
                    buttons: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        if(valor == 'facil'){
                            valor = "medio"
                            Reiniciar()
                        }

                        else{
                            if(valor == 'medio'){
                                valor = "dificil"
                                Reiniciar()
                            }
                        }
                    } 
                })
            }

            // var pregunta = window.confirm('¿Deseas continuar a la siguiente difilcutad?');
            // if (pregunta === true) {
            //     if(valor == 'facil'){
            //         valor = document.querySelector('#medio').checked = true
            //         Reiniciar()
            //     }
            //     else{
            //         if(valor == 'medio'){
            //             valor = document.querySelector('#dificil').checked = true
            //             Reiniciar()
            //         }
            //         else{
            //             alert("Ya ahora si ganaste todo, vete")
            //         }
            //     }
            // }
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
                title: "Oh no!",
                text: "No te quedan más vidas. ¿Deseas salir o reintentar?",
                icon: "warning",
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
                            icon: "info",
                            buttons:  ["Mantener", "Cambiar"] 
                        })
                        .then((cambiar) => {
                            if(cambiar){
                                // for(let y = 0; y < 3; y++){
                                //     radios[y].disabled = false
                                // }
                                // for (var i = 0; i < radios.length; i++) {
                                //     var niveles = radios[i];
                                //     niveles.checked = false;
                                // }

                                if(valor == 'dificil'){
                                    valor = "medio"
                                }

                                if(valor == 'medio'){
                                    valor = "facil"
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
        icon: "warning",
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
    
    // var pregunta = window.confirm('Al reiniciar, se perderá el progreso actual');
    // if (pregunta === true) {
    //     window.alert('Conste we');

        
    // } 
    // else { 
    //     window.alert('Se te hace así');
    // }
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
        icon: "Visual/Material/Animaciones/Generales/teclado.gif"
    })
    // $.dialog({
    //     title: 'Tutorial',
    //     content: 'Realiza la suma de dos números y elige la opción correcta con los botones o las flechas del teclado.',
    // });
}