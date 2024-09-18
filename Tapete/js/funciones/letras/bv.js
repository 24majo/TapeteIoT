// Vidas
var error = 3
var vida = document.getElementById('vida');
vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'

// Barra de progreso
contador = 0
document.getElementById("barra").value = contador
document.getElementById("barra").innerHTML = contador

// Elementos generales
const palabras = ["libro"]
//const palabras = ["uva", "vela", "vaso", "viento", "volcán", "globo", "lombríz", "libro", "víbora"]
var opciones = document.getElementsByClassName("opcion")
var respuesta
var arreglo = ["b", "v"]

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
            for(let y = 0; y < 3; y++){
                radios[y].disabled = false
            }
            for (var i = 0; i < radios.length; i++) {
                var niveles = radios[i];
                niveles.checked = false;
            }
            document.getElementById("btnIniciar").innerHTML = "Empezar"
            Reiniciar()
        } 
    });
}

function Reiniciar(){
    error = 3
    vida.innerHTML = '<img src="Visual/Material/Iconos/corazon3.png" width="100">'
    contador = 0
    imagen = ""
    document.getElementById("linea").innerHTML = ""
    document.getElementById("barra").value = contador
    document.getElementById("barra").innerHTML = contador
    Empezar()
}

function Empezar(){
    if(!document.querySelector('input[name="dificultad"]:checked')){
        swal({
            title: "Advertencia",
            text: "Elige una dificultad para iniciar el juego",
            icon: "Visual/Material/Iconos/pollo.jpg", 
        })
    }

    else{
        for(let y = 0; y < 3; y++){
            radios[y].disabled = true
        }

        for(let i = 0; i < opciones.length; i++){
            opciones[i].innerHTML = arreglo[i]
        }

        valor = document.querySelector('input[name="dificultad"]:checked').value
        //document.getElementById('aparecer').style.display='block';

        switch(valor){
            case 'facil':
                respuesta = palabras[Math.floor(Math.random() * palabras.length)]
                document.getElementById("linea").innerHTML = respuesta
                imagen = document.getElementById('figura') 
                imagen.src = "Visual/Material/Letras/Juego4/" + respuesta + ".png"
                if(respuesta.includes('b') == true || respuesta.includes('v') == true){
                    document.getElementById("linea").innerHTML = respuesta.replaceAll(/b|v/g, "_")
                }
                break

            case 'medio':

                break
            
            case 'dificil':

                break
        }
        //document.getElementById('aparecer').style.display='block';
    }
}

window.addEventListener("keydown",(e)=>{
    let tecla = e.key
    switch(tecla){
    case 'ArrowLeft':
        
        break;
    case 'ArrowRight':
        
        break;
    default:
        break;
    }
})

window.addEventListener("keyup",(e)=>{
    let tecla = e.key

    switch(tecla){
        case 'ArrowLeft':
            
            break;
        case 'ArrowRight':
            
            break;
        default:
            break;
    }
})

function Ayuda(){
    swal("Tutorial", 
        "Completa la palabra con la letra correcta.");
}