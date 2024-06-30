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
                
                break

            case 'medio':

                break
            
            case 'dificil':

                break
        }
    }
}

function Reinicio(){
    for (var i = 0; i < radios.length; i++) {
        var niveles = radios[i];
        niveles.checked = false;
    }
}