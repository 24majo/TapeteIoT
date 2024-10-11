const menu = document.getElementById("menu");
const barralateral = document.querySelector(".mini-barra")
const spans = document.querySelectorAll("span")

menu.addEventListener("click", ()=>{
    barralateral.classList.toggle("barra-lateral"); // Aplica y reduce el tamaño de la barra 
    spans.forEach((span)=>{
        span.classList.toggle("")
    })
});