

document.addEventListener("DOMContentLoaded", () => {
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content || "";
    const formAddDetalleGarantia = document.getElementById("formAddDetalleGarantia");
    const selectTipoGarantia = document.getElementById("idgarantia");
    const porcentajeInput = document.getElementById("porcentaje");
    const observacionesInput = document.getElementById("observaciones");

    const urlParams = new URLSearchParams(window.location.search);
    const idContratoParam = urlParams.get("idcontrato");

    

    const showToast = async (icon, title, position = "top-end") => {
        Swal.fire({
            icon: icon,
            title: title,
            toast: true,
            position: position,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
        });
    };

    if (!idContratoParam) {
        showToast("error", "ID de contrato no especificado en la URL. No se puede agregar la garantía.");
        formAddDetalleGarantia.querySelector(".btn-submit").disabled = true;
        selectTipoGarantia.disabled = true;
        porcentajeInput.disabled = true;
        observacionesInput.disabled = true;
        return;
    }

    async function cargarTiposGarantia() {
        try {
            const response = await fetch(`${baseUrl}app/controllers/GarantiaController.php`); 

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const data = await response.json();

            selectTipoGarantia.innerHTML = '<option value="">Seleccione un tipo de garantía</option>';

            if (data.status && data.data && data.data.length > 0) {
                data.data.forEach((tipo) => {
                    const option = document.createElement("option");
                    option.value = tipo.idgarantia;
                    option.textContent = tipo.tipogarantia;
                    selectTipoGarantia.appendChild(option);
                });
            } else {
                selectTipoGarantia.innerHTML = '<option value="">No hay tipos de garantía disponibles</option>';
                showToast("warning", data.message || "No se pudieron cargar los tipos de garantía.");
                selectTipoGarantia.disabled = true;
            }
        } catch (error) {
            console.error("Error al cargar tipos de garantía:", error);
            selectTipoGarantia.innerHTML = '<option value="">Error al cargar tipos</option>';
            showToast("error", "Error al cargar los tipos de garantía.");
            selectTipoGarantia.disabled = true;
        }
    }

    cargarTiposGarantia();

    async function registrarGarantia() {
        if (!selectTipoGarantia.value) {
            showToast("warning", "Por favor, seleccione un tipo de garantía.");
            return;
        }
        const porcentajeValue = parseFloat(porcentajeInput.value);
        if (isNaN(porcentajeValue) || porcentajeValue < 0 || porcentajeValue > 100) {
            showToast("warning", "Por favor, ingrese un porcentaje válido entre 0 y 100.");
            return;
        }

         
        const datosEnviar = {
            idgarantia: selectTipoGarantia.value,
            idcontrato: idContratoParam, 
            porcentaje: porcentajeValue,
            observaciones: observacionesInput.value || null
        };

        try {
            const response = await fetch(`${baseUrl}app/controllers/DetalleGarantiaController.php`, { 
                method: "POST",
                headers: {
                    
                    "Content-Type": "application/json", 
                },
                body: JSON.stringify(datosEnviar), 
            });

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            
            const result = await response.json();
      

            if (result.status) {
                showToast("success", "Garantía registrada correctamente");
                formAddDetalleGarantia.reset();
                setTimeout(() => {
                    window.location.href = `${baseUrl}app/views/contratos/`; 
                }, 1500);
            } else {
                throw new Error(result.message || "Error al registrar la garantía.");
            }
        } catch (error) {
            console.error("Error al registrar garantía:", error);
            showToast("error", error.message || "Error al registrar la garantía.");
        }
    }

    formAddDetalleGarantia.addEventListener("submit", async (e) => {
        e.preventDefault();
        registrarGarantia();
    });
});