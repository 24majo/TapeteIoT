//ANIMACIÓN bien
document.getElementById("iniciarBien").addEventListener("click", function() {
    const espera = document.getElementById("espera");
    const bien = document.getElementById("acierto");
  
    //Ocultar la animación de espera para pasar a la de bien
    espera.classList.add("desaparecer");
  
    //Muestra la aninmación de bien una vez
    bien.classList.remove("desaparecer");
    bien.classList.add("acierto");
  
    //Se usa el evento animationend para indicar que la animación finalizó 
    //y de nuevo muestre la animación de espera
    bien.addEventListener("animationend", function() {
        //Ocultar la animación de bien
      bien.classList.add("desaparecer");    
      bien.classList.remove("acierto");
        //Mostrar la animación de espera
      espera.classList.remove("desaparecer"); 
      //Ayuda a que la animación se ejecute una vez
    }, { once: true });
  });

  document.getElementById("iniciarMal").addEventListener("click", function() {
    const espera = document.getElementById("espera");
    const bien = document.getElementById("corregir");
  
    //Ocultar la animación de espera para pasar a la de bien
    espera.classList.add("desaparecer");
  
    //Muestra la aninmación de bien una vez
    bien.classList.remove("desaparecer");
    bien.classList.add("corregir");
  
    //Se usa el evento animationend para indicar que la animación finalizó 
    //y de nuevo muestre la animación de espera
    bien.addEventListener("animationend", function() {
        //Ocultar la animación de bien
      bien.classList.add("desaparecer");    
      bien.classList.remove("corregir");
        //Mostrar la animación de espera
      espera.classList.remove("desaparecer"); 
      //Ayuda a que la animación se ejecute una vez
    }, { once: true });
  });
