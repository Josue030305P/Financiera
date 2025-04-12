class ContratoForm extends HTMLElement {
    constructor() {
      super();
      const shadow = this.attachShadow({ mode: 'open' });
  
      const wrapper = document.createElement('div');
  
      wrapper.innerHTML = `
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
        <style>
          body {
            font-family: 'Inter', sans-serif;
          }
          .card-header {
            color: #fff;
            font-weight: bold;
            background: linear-gradient(to right, #26D0CE, #1A2980);
          }
        </style>
        <div class="container mt-5">
          ${this.innerHTML}
        </div>
      `;
  
      shadow.appendChild(wrapper);
    }
  
    connectedCallback() {
      // Espera al próximo ciclo para asegurar que los elementos estén renderizados
      requestAnimationFrame(() => {
        const fechainicio = this.shadowRoot.querySelector('#fechainicio');
        if (fechainicio) {
          const hoy = new Date();
          const yyyy = hoy.getFullYear();
          const mm = String(hoy.getMonth() + 1).padStart(2, '0');
          const dd = String(hoy.getDate()).padStart(2, '0');
          const fechaFormateada = `${yyyy}-${mm}-${dd}`;
          fechainicio.value = fechaFormateada;
        }
      });
    }
  }
  
  customElements.define('contrato-form', ContratoForm);
  