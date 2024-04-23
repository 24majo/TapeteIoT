var correcta = 0
var arreglo_f = []
var opciones = document.getElementsByClassName("opcion") // Crea un "arreglo" con la cantidad de elementos con la misma clase


window.addEventListener("keydown",(e)=>{
    let tecla = e.key

    switch(tecla){
        case 'ArrowUp':
            if(arreglo_f[0]== correcta){
                document.getElementById("arr").style.backgroundColor = '#f958a5'
            }
            break;

        case 'ArrowDown':
            if(arreglo_f[1]== correcta){
                document.getElementById("ab").style.backgroundColor = '#f958a5'
            }
            break;

        case 'ArrowLeft':
            if(arreglo_f[2]== correcta){
                document.getElementById("izq").style.backgroundColor = '#f958a5'
            }
            break;

        case 'ArrowRight':
            if(arreglo_f[3]== correcta){
                document.getElementById("der").style.backgroundColor = '#f958a5'
            }
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

function Random(){
    var arreglo = OpRandom()
    console.log("Arreglo: ", arreglo)

    for(var i = 0; i < arreglo.length; i++){
        opciones[i].style.backgroundColor = '#ff99ff' // Devolver color del circulo al original
        opciones[i].innerHTML = arreglo[i]
    } 
}

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

/* function TRandom(){ // Función para darle valores booleanos a la tabla
    var n = 1 // Variable de apoyo para que solo dé 9 numeros
    var contar = 0 // Sirve para saber la cantidad de true que existen en la tabla
    //var imagen = document.getElementById(n)

    while(n<10){
        var r = Math.random() < 0.5 // Generar valores booleanos aleatorios 
        document.getElementById(n).innerHTML = r // Asignar el valor booleano random al ID de la tabla correspondiente
        
        if(r){
            contar++ // Si el valor de la tabla es verdadero, se contabiliza
            //imagen.src = "Visual/Material/Numeros/Juego1/1.jpg"
        } 
        n+=1
    }
    correcta = contar
    return contar
}*/