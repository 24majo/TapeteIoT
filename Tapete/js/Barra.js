const menu = document.getElementById("menu");
const barralateral = document.querySelector(".barra-lateral")
const spans = document.querySelectorAll("span")


menu.addEventListener("click", ()=>{
    barralateral.classList.toggle("mini-barra"); // Aplica y reduce el tamaño de la barra 
    spans.forEach((span)=>{
        span.classList.toggle("oculto")
    })
});