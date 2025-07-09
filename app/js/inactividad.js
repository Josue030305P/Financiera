
(  () => {
  let tiempoInactivo = 0;
  const limiteMinutos = 1; 
  const logoutUrl = document.querySelector('meta[name="base-url"]')?.content || "";

  function resetTimer() {
    tiempoInactivo = 0;
    localStorage.setItem('ultimaActividad', Date.now());
  }

  document.addEventListener('mousemove', resetTimer);
  document.addEventListener('keydown', resetTimer);
  document.addEventListener('click', resetTimer);

  setInterval(() => {
    tiempoInactivo++;
    const ultimaActividad = parseInt(localStorage.getItem('ultimaActividad')) || Date.now();
    const diferencia = (Date.now() - ultimaActividad) / 60000; // en minutos

    if (diferencia >= limiteMinutos) {
      alert("Sesión cerrada por inactividad.");
      localStorage.setItem('cerrarSesion', Date.now());
      window.location.href = logoutUrl;
    }
  }, 60000);

  window.addEventListener('storage', (event) => {
    if (event.key === 'cerrarSesion') {
      alert("Sesión cerrada por inactividad en otra pestaña.");
      window.location.href = logoutUrl;
    }
  });

  // Inicializar al cargar
  resetTimer();
})();
