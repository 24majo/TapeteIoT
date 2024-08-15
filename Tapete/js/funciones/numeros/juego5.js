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
var op = []
//Opciones de dificultad
var radios = document.getElementsByName("dificultad")
// Elementos generales
var resultado = 0
var arreglo = []
var ejercicio = 0

function Empezar(){
    if(!document.querySelector('input[name="dificultad"]:checked')){
        alert("Selecciona algo ptm")
    }

    else{
        for(let y = 0; y < 3; y++){
            radios[y].disabled = true
        }
        valor = document.querySelector('input[name="dificultad"]:checked').value
        document.getElementById('aparecer').style.display='block';
        
        switch(valor){
            case 'facil':
                num = Math.floor(Math.random() * (50-1)+1)
                Random(num1, num2)  
                break

            case 'medio':
                num = Math.floor(Math.random() * (100-51)+51)
                //alert("Num1: " + num1 + " num2: " + num2)
                Random(num1, num2)  
                break
            
            case 'dificil':
                num = Math.floor(Math.random() * (100-1)+1)
                Random(num1, num2) 
                break
        }
    }
}

