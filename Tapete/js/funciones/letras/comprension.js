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
var radios = document.getElementsByName("dificultad")

// Elementos generales
var resp1 = "", resp2 = "", arr_datos1, arr_datos2
var num_parrafo = 0, aux = 0

// Variables de lectura
var preguntas_f = [
    { 
        nivel:1, 
        p:"¿Qué oficio tenía el padre?", 
        res1: ["molinero", "carpintero", "herrero", "panadero"],
    },
    { 
        nivel:2, 
        p:"¿A quién le dejó de herencia al gato?",
        res2: ["hijo menor", "hijo mayor", "unico hijo", "segundo hijo"]
    },
    { 
        nivel:3, 
        p:"¿Qué animal cazó el gato?",
        res1: ["conejos", "aves", "ratones", "liebres"]
    },
    { 
        nivel:4, 
        p:"¿De dónde era el Marqués?",
        res2: ["Carabás", "Alcarás", "Caravela", "Barabás", "Garabás"]
    },
    { 
        nivel:5, 
        p:"¿Por dónde paseaba el rey?",
        res1: ["río", "arroyo","laguna", "lago", "manantial"]
    },
    { 
        nivel:6, 
        p:"¿A dónde invitó el rey al Marqués?",
        res2: ["carruaje", "palacio", "castillo", "carroza"]
    },
    { 
        nivel:7, 
        p:"¿A quién engañó el gato?",
        res1: ["un ogro", "una bruja", "un hechicero", "un duende"]
    },
    { 
        nivel:8, 
        p:"¿De qué era propietario?",
        res2: ["tierras", "praderas", "sembradíos", "bosques"]
    },
    { 
        nivel:9, 
        p:"¿En qué lugar se hizo la fiesta?",
        res1: ["bosque", "palacio", "lago", "castillo"]
    },
    { 
        nivel:10, 
        p:"¿En dónde se quedó a vivir el gato?",
        res2: ["palacio", "hacienda", "castillo", "mansión"]
    }
]

function Empezar(){
    document.getElementById('aparecer').style.display='block';

    switch(valor){
        case 'facil':
            document.getElementById("titulo").innerHTML = "El gato con botas"
            Opciones()
            Parrafos(resp1, resp2, num_parrafo)
            CuadrosOp(op = [], aux-1)
            break

        case 'medio':
            document.getElementById("titulo").innerHTML = "Soldadito de plomo"
            break
        
        case 'dificil':
            document.getElementById("titulo").innerHTML = "El patito feo"
            break
    }
}

function Opciones(){
    switch(valor){
        case 'facil':
            if(resp1 == ""){
                arr_datos1 = preguntas_f[aux][Object.keys(preguntas_f[aux])[2]];
                resp1 = arr_datos1[Math.floor(Math.random() * arr_datos1.length)];
                aux++
                return Opciones(resp1, resp2)
            }

            if(resp2 == ""){
                arr_datos2 = preguntas_f[aux][Object.keys(preguntas_f[aux])[2]];
                resp2 = arr_datos2[Math.floor(Math.random() * arr_datos2.length)];
                return Opciones(resp1, resp2)
            }
            break

        case 'medio':
            break

        case 'dificil':
            break
    }
}

function Parrafos(res1, res2, num_parrafo){
    switch(valor){
        case 'facil':
            parrafo_f = [
                { n: 1, pa: "Un " + res1 + " dejó a su "+ res2 + " un gato como herencia. Aunque decepcionado, el joven pensó que el gato era inútil. Sin embargo, el gato habló y prometió hacer de su dueño un hombre rico si le conseguía unas botas y un saco."},
                { n: 2, pa: "Con sus nuevas botas, el astuto gato cazó "+ res1 + " que entregó al rey, diciendo que eran regalos de su amo, el Marqués de "+ res2 +". El rey, impresionado por las ofrendas, comenzó a interesarse por este noble 'marqués'."},
                { n: 3, pa: "Un día, el gato supo que el rey pasearía cerca del "+ res1 +". Ordenó a su amo que se bañara allí. Cuando el rey pasó, el gato gritó que el marqués había sido robado. El rey, compadecido, ofreció al joven ropa elegante y lo invitó a su "+ res2 +"."},
                { n: 4, pa: "Mientras viajaban, el gato corrió adelante y engañó a "+ res1 +", propietario de grandes "+ res2 +", para que se transformara en un ratón. Al hacerlo, el gato se lo comió, y sus tierras quedaron en posesión del supuesto marqués."},
                { n: 5, pa: "Gracias a las astutas maniobras del gato, el joven se casó con la princesa en una gran fiesta cerca del "+ res1 +", convirtiéndose en un noble verdadero. El gato vivió una vida de comodidades en el "+ res2 +", orgulloso de haber asegurado la fortuna de su amo."}
            ]
            document.getElementById("parrafo").innerHTML = parrafo_f[num_parrafo].pa
            break

        case 'medio':
            parrafo_m = [
                { n: 1, pa: "Había una vez un soldadito de plomo que tenía una sola pierna, pues fue el último de una serie y no alcanzó el plomo para darle dos. A pesar de esto, siempre mantenía la cabeza alta y el corazón valiente, luciendo elegante su uniforme color " + res1 +". Vivía en la habitación de un niño, junto con otros juguetes, pero lo que más amaba era una bailarina de "+ res2 +". Ella también se mantenía en un solo pie, lo que hacía que el soldadito sintiera que tenían algo en común."},
                { n: 2, pa: "Un día, el soldadito cayó accidentalmente por la ventana y aterrizó en la calle. Fue arrastrado por la corriente de agua de una tormenta hasta una alcantarilla, donde fue atrapado por "+ res1 +" niños que lo colocaron en un barco de papel. El barco navegó por las aguas turbulentas hasta que finalmente fue tragado por un pez enorme. Sin embargo, el soldadito, con su espíritu "+ res2 +", siguió firme, esperando su destino con valor."},
                { n: 3, pa: "El pez fue atrapado por un pescador y, sorprendentemente, vendido por el "+ res1 +", en el mismo mercado donde vivía el soldadito. El pescado llegó a la cocina de la casa del niño, y cuando lo abrieron, encontraron al soldadito de plomo en su interior. El niño volvió a colocar al soldadito en su lugar en la "+ res2 +", junto a la bailarina, lo que hizo que sintiera que su valentía había sido recompensada."},
                { n: 4, pa: "Un día, mientras el soldado contemplaba a la bailarina, una ráfaga de viento sopló en la habitación y llevó a la bailarina hacia la chimenea encendida al " + res1 + ". El soldadito, con su coraje inquebrantable, saltó tras ella, decidido a seguirla donde fuera. Ambos cayeron en las llamas, pero justo antes de ser consumidos, el soldadito pudo ver cómo la bailarina mantenía su " + res2 +"."},
                { n: 5, pa: "Al día siguiente, " + res1 +" entre las cenizas, se encontró un pequeño corazón de plomo, lo único que quedaba del soldadito, y "+ res2 +" de la bailarina. Aunque se habían desvanecido, su historia de amor y valentía quedó en la memoria de todos, recordando que, aunque pequeños y frágiles, el coraje y el amor pueden superar cualquier adversidad."},
            ]
            document.getElementById("parrafo").innerHTML = parrafo_m[num_parrafo].pa
            break

        case 'dificil':
            parrafo_d = [
                { n: 1, pa: "En un "+ res1 +" día de verano, una madre pata esperaba ansiosamente a que sus huevos se rompieran. Uno a uno, los patitos comenzaron a salir de sus cascarones, excepto el más grande, que tardó en abrirse. Finalmente, el huevo se rompió, y de él salió un patito diferente. Era "+ res2 +", con plumas grises en lugar de amarillas. Al verlo, la madre pata y sus otros hijos se sorprendieron. Los animales del corral no tardaron en señalar su apariencia, llamándolo 'feo' y burlándose de él sin cesar. El pobre patito comenzó a sentirse muy triste y rechazado por todos."},
                { n: 2, pa: "A medida que pasaban los días, las burlas y el desprecio crecían. El patito feo decidió que no podía soportarlo más, así que un día escapó del corral. Viajó solo a través de bosques y campos, encontrando refugio temporal aquí y allá, pero siempre sintiendo el peso de la soledad. Durante el invierno, luchó por sobrevivir al frío, escondiéndose en "+ res1 +". "+ res2 +" lo encontró un día y lo llevó a su casa para cuidarlo, pero el patito, asustado, se escapó de nuevo, prefiriendo estar solo que enfrentar el rechazo."},
                { n: 3, pa: "Cuando la primavera llegó, el patito feo estaba más grande y fuerte, pero aún se sentía diferente y solo. Un día, mientras se escondía en "+res1+", vio un grupo de majestuosos cisnes nadando en un lago cercano. Fascinado por su belleza, se acercó lentamente, deseando poder ser como ellos, aunque estaba seguro de que lo rechazarían. Para su sorpresa, los cisnes no lo ahuyentaron. En cambio, lo miraron con "+res2+". Confuso, el patito se acercó al agua para ver su reflejo, y lo que vio lo dejó sin aliento."},
                { n: 4, pa: "En el agua, no vio al patito feo que todos habían despreciado, sino un cisne blanco y "+res1+". Durante el invierno, había crecido y se había transformado en uno de los cisnes que tanto admiraba. Ahora entendía por qué siempre había sido diferente: no era un pato, sino un cisne. Su corazón se llenó de alegría al darse cuenta de que había encontrado su verdadera identidad. Los otros cisnes lo rodearon, dándole la bienvenida como uno de los suyos. Por primera vez, el patito feo se sintió "+res2+"."},
                { n: 5, pa: "El nuevo cisne nadó con su grupo, sintiendo "+res1+". A partir de ese día, vivió entre los cisnes, disfrutando de la belleza de su nuevo hogar y la compañía de sus iguales. El recuerdo de su difícil pasado se desvaneció, reemplazado por la satisfacción de haber encontrado su lugar en el mundo. Así, el patito feo, que nunca había sido feo en realidad, vivió una vida " + res2 +", sabiendo que la verdadera belleza viene de entender quien eres realmete."},
            ]
            document.getElementById("parrafo").innerHTML = parrafo_d[num_parrafo].pa
            break
    }
}

function CuadrosOp(result, aux){
    if(op.length == 4){
        alert(op)
    //     // if(!op.includes(res1)){
    //     //     let r = Math.floor(Math.random() * op.length)
    //     //     op.splice(r, 1, res1)
    //     // }

    //     // for (let i = 0; i < opciones.length; i++){
    //     //     opciones[i].innerHTML = op[i] // Se muestran las opciones en los círculos
    //     // }
    }

    else{
        let r = Math.floor(Math.random() * preguntas_f[aux][Object.keys(preguntas_f[aux])[2]].length)
        op.push(preguntas_f[aux][Object.keys(preguntas_f[aux])[2]][r])
        result = op.filter((item,index)=>{ // Filtro para determinar si una letra elegida ya está en el arreglo y evitar duplicidad
            return op.indexOf(item) === index;
        })
        return CuadrosOp(result,aux)
    }
//         let r = Math.floor(Math.random() * datos_r1.length)
//         op.push(datos_r1[r])
//         result = op.filter((item,index)=>{ // Filtro para determinar si una letra elegida ya está en el arreglo y evitar duplicidad
//             return op.indexOf(item) === index;
//         })
//         return CuadrosOp(result)
}
// var profesion = ["molinero", "carpintero", "herrero", "panadero"]
// var hijo = ["hijo menor", "hijo mayor", "unico hijo", "segundo hijo"]
// var animalCaza = ["conejos", "aves", "ratones", "liebres"]
// var nombreMarques = ["Carabás", "Alcarás", "Caravela", "Barabás", "Garabás"]
// var lugar = ["río", "arroyo","laguna", "lago", "manantial"]
// var invitacion = ["carruaje", "palacio", "castillo", "carroza"]
// var criaturaMagica = ["un ogro", "una bruja", "un hechizero", "un duende"]
// var lugar2 = ["tierras", "praderas", "sembradios", "bosques"]
// var lugarfiesta = ["bosque", "palacio", "lago", "castillo"]
// var casaGato = ["palacio", "hacienda", "castillo", "mansión"]

var res1, res2

window.onload = function() {
    valor = localStorage.getItem('valorBoton');
}

Ayuda() // Tutorial al abrir la pestaña por primera vez

// function Empezar(){
//     // if(!document.querySelector('input[name="dificultad"]:checked')){
//     //     swal({
//     //         title: "Advertencia",
//     //         text: "Elige una dificultad para iniciar el juego",
//     //         icon: "warning", 
//     //     })
//     // } 

//     // else{
//         // for(let y = 0; y < 3; y++){
//         //     radios[y].disabled = true
//         // }
//         // valor = document.querySelector('input[name="dificultad"]:checked').value
//     document.getElementById('aparecer').style.display='block';

//     switch(valor){
//         case 'facil':
//             document.getElementById("titulo").innerHTML = "El gato con botas"
//             res1 = profesion[Math.floor(Math.random() * profesion.length)]
//             res2 = hijo[Math.floor(Math.random() * hijo.length)]
//             document.getElementById("parrafo").innerHTML = "Un " + res1 + " dejó a su "+ res2 + " un gato como herencia. Aunque decepcionado, el joven pensó que el gato era inútil. Sin embargo, el gato habló y prometió hacer de su dueño un hombre rico si le conseguía unas botas y un saco."
//             Pregunta()

            
//             break

//         case 'medio':
//             document.getElementById("titulo").innerHTML = "Soldadito de plomo"
//             document.getElementById("parrafo").innerHTML = "2.1"
//             break
        
//         case 'dificil':
//             document.getElementById("titulo").innerHTML = "El patito feo"
//             document.getElementById("parrafo").innerHTML = "3.1"
//             break
//     }
//     // }
// }









// Variables de lectura
// var opciones_f = [
//     {n: 1, res1: ["molinero", "carpintero", "herrero", "panadero"]},
//     {n: 1, res2: ["hijo menor", "hijo mayor", "unico hijo", "segundo hijo"]},
//     {n: 2, res1: ["conejos", "aves", "ratones", "liebres"]},
//     {n: 2, res2: ["Carabás", "Alcarás", "Caravela", "Barabás", "Garabás"]},
//     {n: 3, res1: ["río", "arroyo","laguna", "lago", "manantial"]},
//     {n: 3, res2: ["carruaje", "palacio", "castillo", "carroza"]},
//     {n: 4, res1: ["un ogro", "una bruja", "un hechizero", "un duende"]},
//     {n: 4, res2: ["tierras", "praderas", "sembradios", "bosques"]},
//     {n: 5, res1: ["bosque", "palacio", "lago", "castillo"]},
//     {n: 5, res2: ["palacio", "hacienda", "castillo", "mansión"]}
// ]

// // Variables de preguntas de acuerdo con la dificultad 
// var preguntas_f = [
//     { nivel:1, p:"¿Qué oficio tenía el padre?"},
//     { nivel:1, p:"¿A quién le dejó de herencia al gato?"},
//     { nivel:2, p:"¿Qué animal cazó el gato?"},
//     { nivel:2, p:"¿De dónde era el Marqués?"},
//     { nivel:3, p:"¿Por dónde paseaba el rey?"},
//     { nivel:3, p:"¿A dónde invitó el rey al Marqués?"},
//     { nivel:4, p:"¿A quién engañó el gato?"},
//     { nivel:4, p:"¿De qué era propietario?"},
//     { nivel:5, p:"¿En qué lugar se hizo la fiesta?"},
//     { nivel:5, p:"¿En dónde se quedó a vivir el gato?"}
// ]

// var preguntas_m = [
//     {nivel: 1, p:"¿De qué color era el uniforme del soldadito?"},
//     {nivel: 1, p:"¿De qué material era la bailarina?"},
//     {nivel: 2, p:"¿Por quién fue atrapado el soldadito?"},
//     {nivel: 2, p:"¿Cómo era el espíritu del soldadito?"},
//     {nivel: 3, p:"¿Por quién fue vendido el pescado que tenía al soldadito?"},
//     {nivel: 3, p:"¿En dónde colocaron de nuevo al soldadito?"},
//     {nivel: 4, p:"¿En qué parte de la habitación se encontraba la chimenea?"},
//     {nivel: 4, p:"¿Quién encontró al soldadito y la bailarina?"},
//     {nivel: 5, p:"¿Qué fue lo que quedó de la bailarina?"},
//     {nivel: 5, p:""}
// ]

// var preguntas_d = [
//     {nivel: 1, p:""},
//     {nivel: 1, p:""},
//     {nivel: 2, p:""},
//     {nivel: 2, p:""},
//     {nivel: 3, p:""},
//     {nivel: 3, p:""},
//     {nivel: 4, p:""},
//     {nivel: 4, p:""},
//     {nivel: 5, p:""},
//     {nivel: 5, p:""}
// ]

// window.onload = function() {
//     valor = localStorage.getItem('valorBoton');
//     //alert(valor)
// }

// //Ayuda() // Tutorial al abrir la pestaña por primera vez

// function Empezar(){
//     document.getElementById('aparecer').style.display='block';

//     switch(valor){
//         case 'facil':
//             document.getElementById("titulo").innerHTML = "El gato con botas"
//             //res1 = profesion[Math.floor(Math.random() * profesion.length)]
//             //alert(res1)
//             //res2 = hijo[Math.floor(Math.random() * hijo.length)]
//             //alert(res2)
//             //document.getElementById("parrafo").innerHTML = parrafo_f[0].pa
//             Respuestas()
//             //alert(res1, res2)
//             Parrafos(res1, res2, num_parrafo)
//             Pregunta(num_parrafo)
//             break

//         case 'medio':
//             document.getElementById("titulo").innerHTML = "Soldadito de plomo"
//             Respuestas()
//             Parrafos(res1, res2, num_parrafo)
//             Pregunta(num_parrafo)
//             break
        
//         case 'dificil':
//             document.getElementById("titulo").innerHTML = "El patito feo"
//             Respuestas()
//             Parrafos(res1, res2, num_parrafo)
//             Pregunta(num_parrafo)
//             break
//     }
// }

// function Respuestas(){
//     switch(valor){
//         case 'facil':
//             for (let i = 0; i < opciones_f.length; i++) {
//                 if (opciones_f[i].n == num_parrafo+1) {
//                     var res1_v = opciones_f[i].res1;
//                     var resp1_v1 = res1_v[Math.floor(Math.random() * res1_v.length)];
//                     //alert("1: " + resp1_v1);
//                     var res2_v = opciones_f[i+1].res2;
//                     var resp2_v2 = res2_v[Math.floor(Math.random() * res2_v.length)];
//                     //alert("2: " + resp2_v2);
//                     break
//                 }
//             }
//             res1 = resp1_v1
//             res2 = resp2_v2
//             datos_r1 = res1_v
//             datos_r2 = res2_v
//             break

//         case 'medio':
//             break

//         case 'dificil':
//             break
//     }
//     // var profesion = ["molinero", "carpintero", "herrero", "panadero"]
//     // var hijo = ["hijo menor", "hijo mayor", "unico hijo", "segundo hijo"]
//     // var animalCaza = ["conejos", "aves", "ratones", "liebres"]
//     // var nombreMarques = ["Carabás", "Alcarás", "Caravela", "Barabás", "Garabás"]
//     // var lugar = ["río", "arroyo","laguna", "lago", "manantial"]
//     // var invitacion = ["carruaje", "palacio", "castillo", "carroza"]
//     // var criaturaMagica = ["un ogro", "una bruja", "un hechizero", "un duende"]
//     // var lugar2 = ["tierras", "praderas", "sembradios", "bosques"]
//     // var lugarfiesta = ["bosque", "palacio", "lago", "castillo"]
//     // var casaGato = ["palacio", "hacienda", "castillo", "mansión"]
// }

// function Parrafos(res1, res2, num_parrafo){
//     switch(valor){
//         case 'facil':
//             //alert("res1: "+ res1 + " res2: " + res2)
//             parrafo_f = [
//                 { n: 1, pa: "Un " + res1 + " dejó a su "+ res2 + " un gato como herencia. Aunque decepcionado, el joven pensó que el gato era inútil. Sin embargo, el gato habló y prometió hacer de su dueño un hombre rico si le conseguía unas botas y un saco."},
//                 { n: 2, pa: "Con sus nuevas botas, el astuto gato cazó "+ res1 + " que entregó al rey, diciendo que eran regalos de su amo, el Marqués de "+ res2 +". El rey, impresionado por las ofrendas, comenzó a interesarse por este noble 'marqués'."},
//                 { n: 3, pa: "Un día, el gato supo que el rey pasearía cerca del "+ res1 +". Ordenó a su amo que se bañara allí. Cuando el rey pasó, el gato gritó que el marqués había sido robado. El rey, compadecido, ofreció al joven ropa elegante y lo invitó a su "+ res2 +"."},
//                 { n: 4, pa: "Mientras viajaban, el gato corrió adelante y engañó a "+ res1 +", propietario de grandes "+ res2 +", para que se transformara en un ratón. Al hacerlo, el gato se lo comió, y sus tierras quedaron en posesión del supuesto marqués."},
//                 { n: 5, pa: "Gracias a las astutas maniobras del gato, el joven se casó con la princesa en una gran fiesta cerca del "+ res1 +", convirtiéndose en un noble verdadero. El gato vivió una vida de comodidades en el "+ res2 +", orgulloso de haber asegurado la fortuna de su amo."}
//             ]
//             document.getElementById("parrafo").innerHTML = parrafo_f[num_parrafo].pa
//             break

//         case 'medio':
//             parrafo_m = [
//                 { n: 1, pa: "Había una vez un soldadito de plomo que tenía una sola pierna, pues fue el último de una serie y no alcanzó el plomo para darle dos. A pesar de esto, siempre mantenía la cabeza alta y el corazón valiente, luciendo elegante su uniforme color " + res1 +". Vivía en la habitación de un niño, junto con otros juguetes, pero lo que más amaba era una bailarina de "+ res2 +". Ella también se mantenía en un solo pie, lo que hacía que el soldadito sintiera que tenían algo en común."},
//                 { n: 2, pa: "Un día, el soldadito cayó accidentalmente por la ventana y aterrizó en la calle. Fue arrastrado por la corriente de agua de una tormenta hasta una alcantarilla, donde fue atrapado por "+ res1 +" niños que lo colocaron en un barco de papel. El barco navegó por las aguas turbulentas hasta que finalmente fue tragado por un pez enorme. Sin embargo, el soldadito, con su espíritu "+ res2 +", siguió firme, esperando su destino con valor."},
//                 { n: 3, pa: "El pez fue atrapado por un pescador y, sorprendentemente, vendido por el "+ res1 +", en el mismo mercado donde vivía el soldadito. El pescado llegó a la cocina de la casa del niño, y cuando lo abrieron, encontraron al soldadito de plomo en su interior. El niño volvió a colocar al soldadito en su lugar en la "+ res2 +", junto a la bailarina, lo que hizo que sintiera que su valentía había sido recompensada."},
//                 { n: 4, pa: "Un día, mientras el soldado contemplaba a la bailarina, una ráfaga de viento sopló en la habitación y llevó a la bailarina hacia la chimenea encendida al " + res1 + ". El soldadito, con su coraje inquebrantable, saltó tras ella, decidido a seguirla donde fuera. Ambos cayeron en las llamas, pero justo antes de ser consumidos, el soldadito pudo ver cómo la bailarina mantenía su " + res2 +"."},
//                 { n: 5, pa: "Al día siguiente, " + res1 +" entre las cenizas, se encontró un pequeño corazón de plomo, lo único que quedaba del soldadito, y "+ res2 +" de la bailarina. Aunque se habían desvanecido, su historia de amor y valentía quedó en la memoria de todos, recordando que, aunque pequeños y frágiles, el coraje y el amor pueden superar cualquier adversidad."},
//             ]
//             document.getElementById("parrafo").innerHTML = parrafo_m[num_parrafo].pa
//             break

//         case 'dificil':
//             parrafo_d = [
//                 { n: 1, pa: "En un "+ res1 +" día de verano, una madre pata esperaba ansiosamente a que sus huevos se rompieran. Uno a uno, los patitos comenzaron a salir de sus cascarones, excepto el más grande, que tardó en abrirse. Finalmente, el huevo se rompió, y de él salió un patito diferente. Era "+ res2 +", con plumas grises en lugar de amarillas. Al verlo, la madre pata y sus otros hijos se sorprendieron. Los animales del corral no tardaron en señalar su apariencia, llamándolo 'feo' y burlándose de él sin cesar. El pobre patito comenzó a sentirse muy triste y rechazado por todos."},
//                 { n: 2, pa: "A medida que pasaban los días, las burlas y el desprecio crecían. El patito feo decidió que no podía soportarlo más, así que un día escapó del corral. Viajó solo a través de bosques y campos, encontrando refugio temporal aquí y allá, pero siempre sintiendo el peso de la soledad. Durante el invierno, luchó por sobrevivir al frío, escondiéndose en "+ res1 +". "+ res2 +" lo encontró un día y lo llevó a su casa para cuidarlo, pero el patito, asustado, se escapó de nuevo, prefiriendo estar solo que enfrentar el rechazo."},
//                 { n: 3, pa: "Cuando la primavera llegó, el patito feo estaba más grande y fuerte, pero aún se sentía diferente y solo. Un día, mientras se escondía en "+res1+", vio un grupo de majestuosos cisnes nadando en un lago cercano. Fascinado por su belleza, se acercó lentamente, deseando poder ser como ellos, aunque estaba seguro de que lo rechazarían. Para su sorpresa, los cisnes no lo ahuyentaron. En cambio, lo miraron con "+res2+". Confuso, el patito se acercó al agua para ver su reflejo, y lo que vio lo dejó sin aliento."},
//                 { n: 4, pa: "En el agua, no vio al patito feo que todos habían despreciado, sino un cisne blanco y "+res1+". Durante el invierno, había crecido y se había transformado en uno de los cisnes que tanto admiraba. Ahora entendía por qué siempre había sido diferente: no era un pato, sino un cisne. Su corazón se llenó de alegría al darse cuenta de que había encontrado su verdadera identidad. Los otros cisnes lo rodearon, dándole la bienvenida como uno de los suyos. Por primera vez, el patito feo se sintió "+res2+"."},
//                 { n: 5, pa: "El nuevo cisne nadó con su grupo, sintiendo "+res1+". A partir de ese día, vivió entre los cisnes, disfrutando de la belleza de su nuevo hogar y la compañía de sus iguales. El recuerdo de su difícil pasado se desvaneció, reemplazado por la satisfacción de haber encontrado su lugar en el mundo. Así, el patito feo, que nunca había sido feo en realidad, vivió una vida " + res2 +", sabiendo que la verdadera belleza viene de entender quien eres realmete."},
//             ]
//             document.getElementById("parrafo").innerHTML = parrafo_d[num_parrafo].pa
//             break
//     }
// }

// function Pregunta(num_parrafo){
//     document.getElementById("pregunta").innerHTML = preguntas_f[num_parrafo].p
//     CuadrosOp(op = [])
// }

// function CuadrosOp(op){
//     if(op.length == 4){
//         if(!op.includes(res1)){
//             let r = Math.floor(Math.random() * op.length)
//             op.splice(r, 1, res1)
//         }

//         for (let i = 0; i < opciones.length; i++){
//             opciones[i].innerHTML = op[i] // Se muestran las opciones en los círculos
//         }
//     }

//     else{
//         let r = Math.floor(Math.random() * datos_r1.length)
//         op.push(datos_r1[r])
//         result = op.filter((item,index)=>{ // Filtro para determinar si una letra elegida ya está en el arreglo y evitar duplicidad
//             return op.indexOf(item) === index;
//         })
//         return CuadrosOp(result)
//     }
// }

// function validar(palabra){
//     //alert(palabra)
//     alert(result)
//     var RespuestaFinal = ""

//     if (op.includes(res1)){
//         RespuestaFinal = res1
//     }
//     else{
//         RespuestaFinal = res2
//     }

//     if(palabra == RespuestaFinal){
//         alert("Acierto")
//         contador++
//         document.getElementById("barra").value = contador
//         document.getElementById("barra").innerHTML = contador
//     }
// }

window.addEventListener("keydown",(e)=>{
    let tecla = e.key
    switch(tecla){
    case 'ArrowUp':
        validar(result[0])
        break;
    case 'ArrowDown':
        validar(result[1])
        break;
    case 'ArrowLeft':
        validar(result[2])
        break;
    case 'ArrowRight':
        validar(result[3])
        break;
    default:
        break;
    }
})

window.addEventListener("keyup",(e)=>{
    let tecla = e.key

    switch(tecla){
        case 'ArrowUp':
            break;
        case 'ArrowDown':
            break;
        case 'ArrowLeft':
            break;
        case 'ArrowRight':
            break;
        default:
            break;
    }
})

function Ayuda(){
    swal({
        title: "Tutorial",
        text: "Lee la lectura detenidamente y contesta las preguntas. Elige la opción correcta por medio de las teclas ↑ ↓ → ← o los botones del tablero.",
        icon: "Visual/Material/Animaciones/Generales/teclado.gif"
    })
}

window.onload = function() {
    valor = localStorage.getItem('valorBoton');
}