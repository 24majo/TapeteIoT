var correcta = 0
var arreglo_f = []
var opciones = document.getElementsByClassName("opcion")
contador = 0

function apretar(numero){
    if(arreglo_f[numero]== correcta){
        //opciones[numero].style.backgroundColor = '#f958a5'
        contador++
        document.getElementById("cont").innerHTML = "Aciertos: " + contador
    }
}

function Reiniciar(){
    contador = 0
    document.getElementById("cont").innerHTML = "Aciertos: " + contador
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
    let repetir

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
    var resultado = Math.floor(Math.random() * 9)+1
    var ex = false
    
    while (arreglo.length < 4){
        var existe = false
        var n = Math.floor(Math.random() * 9)+1 // Valores random del 1 al 9
        
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
    imagen.src = "Visual/Material/Numeros/Juego1/" + resultado + ".jpg"
    arreglo_f = arreglo
    correcta = resultado
    console.log("Respuesta: ", correcta)
    return arreglo
}
