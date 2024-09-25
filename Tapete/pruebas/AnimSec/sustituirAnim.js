//ANIMACIÓN SALTO
document.getElementById("iniciarSalto").addEventListener("click", function() {
    const espera = document.getElementById("espera");
    const salto = document.getElementById("salto");
  
    //Ocultar la animación de espera para pasar a la de salto
    espera.classList.add("desaparecer");
  
    //Muestra la aninmación de salto una vez
    salto.classList.remove("desaparecer");
    salto.classList.add("salto");
  
    //Se usa el evento animationend para indicar que la animación finalizó 
    //y de nuevo muestre la animación de espera
    salto.addEventListener("animationend", function() {
        //Ocultar la animación de salto
      salto.classList.add("desaparecer");    
      salto.classList.remove("salto");
        //Mostrar la animación de espera
      espera.classList.remove("desaparecer"); 
      //Ayuda a que la animación se ejecute una vez
    }, { once: true });
  });

  //ANIMACIÓN CAÍDA
  document.getElementById("iniciarCaida").addEventListener("click", function() {
    const espera = document.getElementById("espera");
    const salto = document.getElementById("caer");
  
    espera.classList.add("desaparecer");
  
    salto.classList.remove("desaparecer");
    salto.classList.add("caer");
  
    salto.addEventListener("animationend", function() {
      salto.classList.add("desaparecer"); 
      salto.classList.remove("caer");
  
      espera.classList.remove("desaparecer"); 
    }, { once: true });
  });