// Vidas
var imagen = document.getElementById('vida');
imagen.innerHTML = '<img src="Visual/Material/Numeros/Juego1/3.jpg" width="100">'
var error = 3
// Barra de progreso
contador = 0
document.getElementById("barra").value = contador
document.getElementById("barra").innerHTML = contador
// Circulos de opciones
var opciones = document.getElementsByClassName("opcion")
//Opciones de dificultad
var radios = document.getElementsByName("dificultad")
// Elementos generales
var resultado = 0
var arreglo = []


function Empezar(){
    if(!document.querySelector('input[name="dificultad"]:checked')){
        alert("Selecciona algo ptm")
    }
    else{
        valor = document.querySelector('input[name="dificultad"]:checked').value
        document.getElementById('aparecer').style.display='block';
        //alert(valor)
        switch(valor){
            case 'facil':
                Random(0,0)

                break

            case 'medio':

                break
            
            case 'dificil':

                break
        }
    }
}

function Random(num1, num2){
    num1 = Math.floor(Math.random() * (100-10)+10)
    num2 = Math.floor(Math.random() * (100-10)+10)
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
            let r = Math.floor(Math.random() * arreglo.length) 
            arreglo.splice(r, 1, resultado)
        }
    }
    else{
        let r = Math.floor(Math.random() * (100-10)+10)
        arreglo.push(r)
    
        result = arreglo.filter((item,index)=>{ // Se evita que las vocales aleatorias se repitan
            return arreglo.indexOf(item) === index;
        })
        Opcion(result)
    }
    return result
}


function Reinicio(){
    for (var i = 0; i < radios.length; i++) {
        var niveles = radios[i];
        niveles.checked = false;
    }
    error = 3
    contador = 0
    document.getElementById("barra").value = contador
    document.getElementById("barra").innerHTML = contador
}

window.addEventListener("keydown",(e)=>{
    let tecla = e.key
    switch(tecla){
        case 'ArrowUp':
            Random(0)
            break;

        case 'ArrowDown':
            Random(1)
            break;

        case 'ArrowLeft':
            Random(2)
            break;

        case 'ArrowRight':
            Random(3)
            break;

        default:
            break;
    }
})