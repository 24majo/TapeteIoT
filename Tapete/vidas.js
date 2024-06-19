var barra = 0
var imagen = document.getElementById('vida');
imagen.innerHTML = '<img src="Visual/Material/Numeros/Juego1/3.jpg" width="100">'
var cant_imagen = 3
var porc = 0

function prueba(){
    // Barra de progreso
    barra += 10
    document.getElementById("barra").value = barra
    document.getElementById("barra").innerHTML = barra

    // Vidas
    cant_imagen--
    if(cant_imagen == 2){
        imagen.innerHTML = '<img src="Visual/Material/Numeros/Juego1/2.jpg" width="100">'
    }

    if(cant_imagen == 1){
        imagen.innerHTML = '<img src="Visual/Material/Numeros/Juego1/1.jpg" width="100">'
    }

    if(cant_imagen == 0){
        imagen.innerHTML = ""
        //alert("Perdiste, intenta de nuevo")
    }

    // Porcentaje
    porc += 10
    document.getElementById("porcentaje").innerHTML = porc + " %"
}