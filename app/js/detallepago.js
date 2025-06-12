document.addEventListener("DOMContentLoaded", () => {
    const baseUrl =
        document.querySelector('meta[name="base-url"]')?.content || "";
    const form = document.getElementById("formPagoCuota");
    const numCuentaSelect = document.getElementById("numcuenta");
    const comprobanteInput = document.getElementById("comprobantepago");
    const montoInput = document.getElementById("monto");
    const restanteInput = document.getElementById("restante");
    const comprobanteFileNameSpan = document.getElementById("comprobanteFileName"); 
    const customFileButton = document.querySelector(".custom-file-button"); 

    const idcontrato = document.getElementById("hidden-id-contrato")?.value || "";
    const idcronogramapago = document.getElementById("hidden-id-cronograma")?.value || "";

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
        if (!idcontrato) {
            numCuentaSelect.innerHTML = '<option value="">Error: ID de contrato no disponible</option>';
            showToast("error", "ID de contrato no disponible para cargar cuentas");
            return;
        }

        try {
            const response = await fetch(
                `${baseUrl}app/controllers/NumCuentasController.php?idcontrato=${idcontrato}`
            );

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const data = await response.json();

            if (data.status === "success" && data.data.length > 0) {
                numCuentaSelect.innerHTML = '<option value="">Selecciona una cuenta</option>';
                data.data.forEach((cuenta) => {
                    const option = document.createElement("option");
                    option.value = `${cuenta.idnumcuentas}`;
                    option.textContent = `${cuenta.numcuenta} - ${cuenta.entidad}`;
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

    async function agregarDetallePago() {
        const idnumcuenta = numCuentaSelect.value;
        const numtransaccion = document.getElementById("numtransaccion").value;
        const fechahora = document.getElementById("fechahora").value;
        const monto = parseFloat(montoInput.value); 
        const restante = parseFloat(restanteInput.value); 
        const observaciones = document.getElementById("observaciones").value;

        if (!idnumcuenta) {
            showToast("error", "Debes seleccionar una cuenta bancaria");
            return;
        }

        if (!idcronogramapago) {
            showToast("error", "Error: ID de cronograma de pago no disponible.");
            return;
        }

        if (isNaN(monto) || monto <= 0) {
            showToast("error", "El monto a pagar debe ser mayor que 0.");
            return;
        }

        if (monto > restante) {
            showToast("error", `El monto a pagar (${monto.toFixed(2)}) no puede ser mayor que el monto restante (${restante.toFixed(2)}).`);
            return;
        }
        
        if (comprobanteInput.hasAttribute('required') && comprobanteInput.files.length === 0) {
            showToast("error", "Por favor, selecciona un comprobante de pago.");
            return;
        }


        const formData = new FormData();
        formData.append('idcronogramapago', idcronogramapago);
        formData.append('idnumcuenta', idnumcuenta);
        formData.append('numtransaccion', numtransaccion);
        formData.append('fechahora', fechahora);
        formData.append('monto', monto);
        formData.append('observaciones', observaciones);

        if (comprobanteInput.files.length > 0) {
            formData.append('comprobante', comprobanteInput.files[0]);
        } else {
            formData.append('comprobante', null); 
        }

        try {
            const response = await fetch(
                `${baseUrl}app/controllers/DetallePagoController.php`,
                {
                    method: "POST",
                    body: formData, 
                }
            );

            const result = await response.json();

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

    obtenerNumCuentas();


    customFileButton.addEventListener('click', () => {
        comprobanteInput.click();
    });

    
    comprobanteInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            comprobanteFileNameSpan.textContent = this.files[0].name;
        } else {
            comprobanteFileNameSpan.textContent = 'Ningún archivo seleccionado';
        }
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        await agregarDetallePago();
    });
});

// document.addEventListener("DOMContentLoaded", () => {
//   const baseUrl = document.querySelector('meta[name="base-url"]')?.content || "";
//   const form = document.getElementById("formPagoCuota");
//   const numCuentaSelect = document.getElementById("numcuenta");
  
//   const urlParams = new URLSearchParams(window.location.search);
//   const idcontrato = urlParams.get("idcontrato");
//   const idcronogramapago = urlParams.get("idcronograma");

//   const showToast = async (icon, title, position = "top-end") => {
//     Swal.fire({
//       icon: icon,
//       title: title,
//       toast: true,
//       position: position,
//       showConfirmButton: false,
//       timer: 1500,
//       timerProgressBar: true,
//       didOpen: (toast) => {
//         toast.addEventListener("mouseenter", Swal.stopTimer);
//         toast.addEventListener("mouseleave", Swal.resumeTimer);
//       },
//     });
//   };

//   async function obtenerNumCuentas() {
//     try {
//       const response = await fetch(
//         `${baseUrl}app/controllers/NumCuentasController.php?idcontrato=${idcontrato}`
//       );

//       if (!response.ok) {
//         throw new Error(`Error HTTP: ${response.status}`);
//       }

//       const data = await response.json();
//       console.log("Datos recibidos:", data);

//       if (data.status === "success") {
//         numCuentaSelect.innerHTML = '<option value="">Selecciona una cuenta</option>';
//         data.data.forEach((cuenta) => {
//           const option = document.createElement("option");
//           option.value = `${cuenta.idnumcuentas}`;
//           option.textContent = `${cuenta.numcuenta} - ${cuenta.entidad}`;
//           numCuentaSelect.appendChild(option);
//         });

//       } else {
//         numCuentaSelect.innerHTML = '<option value="">No hay cuentas disponibles</option>';
//         showToast("warning", "No hay cuentas registradas para este contrato");
//       }
//     } catch (error) {
//       console.error("Error:", error);
//       numCuentaSelect.innerHTML = '<option value="">Error al cargar cuentas</option>';
//       showToast("error", "Error al cargar las cuentas bancarias");
//     }
//   }
  
//   obtenerNumCuentas();

//   async function agregarDetallePago() {
    
//     const idnumcuenta =numCuentaSelect.value;
//     const numtransaccion = document.getElementById("numtransaccion").value;
//     const fechahora = document.getElementById("fechahora").value;
//     const monto = document.getElementById("monto").value;
//     const observaciones = document.getElementById("observaciones").value;
//     console.log('IDNUMCUENTA: ', idnumcuenta, idcronogramapago);
    
//     if (!idnumcuenta) {
//       showToast("error", "Debes seleccionar una cuenta bancaria");
//       return;
//     }

//     const datosEnviar = {
//       idcronogramapago: idcronogramapago,
//       idnumcuenta: idnumcuenta,
//       numtransaccion: numtransaccion,
//       fechahora: fechahora,
//       monto: monto,
//       observaciones: observaciones ?? null, 
//     };

//     try {
//       const response = await fetch(
//         `${baseUrl}app/controllers/DetallePagoController.php`,
//         {
//           method: "POST",
//           headers: {
//             "Content-Type": "application/json",
//           },
//           body: JSON.stringify(datosEnviar),
//         }
//       );

//       if (!response.ok) {
//         throw new Error(`Error HTTP: ${response.status}`);
//       }
      
//       const result = await response.json();
//       console.log("Respuesta del servidor:", result);

//       if (result.status) {
//         showToast("success", "Pago registrado correctamente");
//         setTimeout(() => {
//           window.location = `${baseUrl}app/views/cronograma-pagos/`;
//         }, 1500);
//       } else {
//         throw new Error(result.message || "Error al registrar el pago");
//       }
//     } catch (error) {
//       console.error("Error:", error);
//       showToast("error", error.message || "Error al registrar el pago");
//     }
//   }



//   form.addEventListener('submit',  async (e) => {
//     e.preventDefault();
//     agregarDetallePago();
//   });
// });