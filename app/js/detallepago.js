document.addEventListener("DOMContentLoaded", () => {
  const baseUrl = document.querySelector('meta[name="base-url"]')?.content || "";
  const form = document.getElementById("formPagoCuota");
  const numCuentaSelect = document.getElementById("numcuenta");
  
  const urlParams = new URLSearchParams(window.location.search);
  const idcontrato = urlParams.get("idcontrato");
  const idcronogramapago = urlParams.get("idcronograma");

  const showToast = async (icon, title, position = "top-end") => {
    Swal.fire({
      icon: icon,
      title: title,
      toast: true,
      position: position,
      showConfirmButton: false,
      timer: 1500,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
      },
    });
  };

  async function obtenerNumCuentas() {
    try {
      const response = await fetch(
        `${baseUrl}app/controllers/NumCuentasController.php?idcontrato=${idcontrato}`
      );

      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`);
      }

      const data = await response.json();
      console.log("Datos recibidos:", data);

      if (data.status === "success") {
        numCuentaSelect.innerHTML = '<option value="">Selecciona una cuenta</option>';
        data.data.forEach((cuenta) => {
          const option = document.createElement("option");
          option.value = cuenta.idnumcuentas;
          option.textContent = cuenta.numcuenta || `Cuenta ${cuenta.idnumcuenta}`;
          numCuentaSelect.appendChild(option);
        });

      } else {
        numCuentaSelect.innerHTML = '<option value="">No hay cuentas disponibles</option>';
        showToast("warning", "No hay cuentas registradas para este contrato");
      }
    } catch (error) {
      console.error("Error:", error);
      numCuentaSelect.innerHTML = '<option value="">Error al cargar cuentas</option>';
      showToast("error", "Error al cargar las cuentas bancarias");
    }
  }
  
  obtenerNumCuentas();

  async function agregarDetallePago() {
    
    const idnumcuenta =numCuentaSelect.value;
    const numtransaccion = document.getElementById("numtransaccion").value;
    const fechahora = document.getElementById("fechahora").value;
    const monto = document.getElementById("monto").value;
    const observaciones = document.getElementById("observaciones").value;
    console.log('IDNUMCUENTA: ', idnumcuenta, idcronogramapago);
    
    if (!idnumcuenta) {
      showToast("error", "Debes seleccionar una cuenta bancaria");
      return;
    }

    const datosEnviar = {
      idcronogramapago: idcronogramapago,
      idnumcuenta: idnumcuenta,
      numtransaccion: numtransaccion,
      fechahora: fechahora,
      monto: monto,
      observaciones: observaciones ?? null, 
    };

    try {
      const response = await fetch(
        `${baseUrl}app/controllers/DetallePagoController.php`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(datosEnviar),
        }
      );

      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`);
      }
      
      const result = await response.json();
      console.log("Respuesta del servidor:", result);

      if (result.status) {
        showToast("success", "Pago registrado correctamente");
        setTimeout(() => {
          window.location = `${baseUrl}app/views/cronograma-pagos/`;
        }, 1500);
      } else {
        throw new Error(result.message || "Error al registrar el pago");
      }
    } catch (error) {
      console.error("Error:", error);
      showToast("error", error.message || "Error al registrar el pago");
    }
  }



  form.addEventListener('submit',  async (e) => {
    e.preventDefault();
    agregarDetallePago();
  });
});