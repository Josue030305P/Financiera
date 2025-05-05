class ConyugeForm {
  constructor() {
    this.urlParams = new URLSearchParams(window.location.search);
    this.leadId = this.urlParams.get("id");
    this.baseUrl =
      document.querySelector('meta[name="base-url"]')?.content || "";
    this.form = document.getElementById("lead-form");
    this.init();

  }

  async init() {
    await this.cargarPaises();
    this.initEventListeners();
  }

  async cargarPaises() {
    try {
      const response = await fetch(
        `${this.baseUrl}app/controllers/PaisController.php`
      );
      const paises = await response.json();

      const selectPais = document.getElementById("pais");
      selectPais.innerHTML = '<option value="">Seleccione un país</option>';

      paises.forEach((pais) => {
        selectPais.innerHTML += `
                    <option value="${pais.idpais}">${pais.pais}</option>
                `;
      });
    } catch (error) {
      console.error("Error al cargar países:", error);
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Error al cargar los países",
        confirmButtonColor: "#3085d6",
      });
    }
  }

  async initEventListeners() {
    const addBtn = this.form.querySelector(".add-btn");
    const resetBtn = this.form.querySelector(".reset-btn");

    addBtn.addEventListener("click", (e) => {
      e.preventDefault();
      this.guardarConyuge();
    });

    resetBtn.addEventListener("click", async (e) => {
      e.preventDefault();
      const result = await Swal.fire({
        title: "¿Cancelar?",
        text: "¿Estás seguro de que deseas cancelar?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, cancelar",
        cancelButtonText: "No",
      });

    
      
      if (result.isConfirmed) {
           // Crear un formulario dinámicamente
           const form = document.createElement("form");
           form.method = "POST";
           form.action = `${this.baseUrl}app/views/contratos/contrato.add`;

           const leadIdInput = document.createElement("input");
           leadIdInput.type = "hidden";
           leadIdInput.name = "leadId";
           leadIdInput.value = this.leadId;

           
        form.appendChild(leadIdInput);

        document.body.appendChild(form);

        form.submit();
      }
    });
  }

  async guardarConyuge() {
    try {
        const formData = {
          idpais: document.getElementById("pais").value,
          apellidos: document.getElementById("apellidos").value.trim(),
          nombres: document.getElementById("nombres").value.trim(),
          email: document.getElementById("correo").value.trim().toLowerCase(),
          telprincipal: document.getElementById("telefono").value.trim(),
          tipodocumento: document.getElementById("tipodocumento").value,
          numdocumento: document.getElementById("numdocumento").value.trim(),
          domicilio: document.getElementById("domicilio").value.trim(),
  
        };

        const response = await fetch(
            `${this.baseUrl}app/controllers/PersonaController.php`,
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(formData),
            }
        );

        const result = await response.json();

        if (result.success && result.idconyuge) {
            await Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Éxito",
                text: "Cónyuge guardado correctamente",
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
            });

            // Crear un formulario dinámicamente
            const form = document.createElement("form");
            form.method = "POST";
            form.action = `${this.baseUrl}app/views/contratos/contrato.add`;

            const leadIdInput = document.createElement("input");
            leadIdInput.type = "hidden";
            leadIdInput.name = "leadId";
            leadIdInput.value = this.leadId;
            form.appendChild(leadIdInput);

          
            const idConyugeInput = document.createElement("input");
            idConyugeInput.type = "hidden";
            idConyugeInput.name = "idconyuge";
            idConyugeInput.value = result.idconyuge;
            form.appendChild(idConyugeInput);
          

            document.body.appendChild(form);
            form.submit();
        } else {
            await Swal.fire({
                icon: "error",
                title: "Error",
                text: result.message || "Error al guardar el cónyuge",
                confirmButtonColor: "#3085d6",
            });
        }

    } catch (error) {
        console.error("Error:", error);
        await Swal.fire({
            icon: "error",
            title: "Error",
            text: "Error al guardar el cónyuge: " + error.message,
            confirmButtonColor: "#3085d6",
        });
    }
}

}

document.addEventListener("DOMContentLoaded", () => {
  new ConyugeForm();
});
