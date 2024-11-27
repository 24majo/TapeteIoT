const audio = document.getElementById('audio');
const btnIniciar = document.getElementById('btnIniciar');
const silenciar = document.getElementById('silenciar');
const volumen = document.getElementById('volumen');

// Iniciar audio
btnIniciar.addEventListener('click', () => {
 audio.play()
   .then(() => {
   
   })
   .catch(error => {
     console.error('Error al reproducir el audio:', error);
     alert('No se pudo reproducir el audio.');
   });
});

// Silencia o activa el sonido
silenciar.addEventListener('click', () => {
 if (audio.muted) {
   audio.muted = false;
   silenciar.src = "Visual/Material/Recursos/ConVolumen.png"; 
 } else {
   audio.muted = true;
   silenciar.src = "Visual/Material/Recursos/SinVolumen.png"; 
   }
});

//Dismiuir el volumen
volumen.addEventListener('input', (event) => {
 audio.volume = event.target.value;
});