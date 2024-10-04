var encabezado1 = localStorage.getItem("opcion1")
document.getElementById("ayuda").onclick = Ayuda;

if(encabezado1 == "b"){
    document.getElementById("opcion1").textContent = "Bla"
    document.getElementById("opcion2").textContent = "Bra"
}
if(encabezado1 == "c"){
    document.getElementById("opcion1").textContent = "Cla"
    document.getElementById("opcion2").textContent = "Cra"
}
if(encabezado1 == 'f'){
    document.getElementById("opcion1").textContent = "Fla"
    document.getElementById("opcion2").textContent = "Fra"
}
if(encabezado1 == 'g'){
    document.getElementById("opcion1").textContent = "Gla"
    document.getElementById("opcion2").textContent = "Gra"
}
if(encabezado1 == 'p'){
    document.getElementById("opcion1").textContent = "Pla"
    document.getElementById("opcion2").textContent = "Pra"
}
if(encabezado1 == 't'){
    document.getElementById("opcion1").textContent = "Tla"
    document.getElementById("opcion2").textContent = "Tra"
}

function Ayuda(){
    swal({
        title: "Tutorial",
        text: "Determina en qué columna va la imagen. \n Elige la opción correcta por medio de las teclas ← → o los botones del tablero.",
        icon: "Visual/Material/Animaciones/Generales/teclado.gif"
    })
}