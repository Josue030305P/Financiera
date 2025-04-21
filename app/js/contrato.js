const baseUrl = document.querySelector('meta[name="base-url"]')?.content || "";

const leadIdHolder = document.getElementById('leadIdHolder');
const leadIdFromAttribute = leadIdHolder ? leadIdHolder.dataset.leadId : null;

const urlParams = new URLSearchParams(window.location.search);
const leadIdFromURL = urlParams.get("id");

const leadId = leadIdFromAttribute || leadIdFromURL;

console.log("Lead ID en contrato.js:", leadId);

const nombreAsesor = document.querySelector("#nombreAsesor");
const fechaInicio = document.getElementById("fechainicio");
const fechaFin = document.getElementById("fechafin");
const mesesInput = document.getElementById("meses");
const diaPago = document.getElementById("diapago");
const fechaRegistro = document.querySelector("#fecharegistro");
const fechaContrato = document.querySelector("#fechacontrato");




function formatearFecha(fecha) {
  const yyyy = fecha.getFullYear();
  const mm = String(fecha.getMonth() + 1).padStart(2, "0");
  const dd = String(fecha.getDate()).padStart(2, "0");
  return `${yyyy}-${mm}-${dd}`;
}

(async () => {
    const hoy = new Date();
    const fechaFormateada = formatearFecha(hoy);
    const dd = String(hoy.getDate()).padStart(2, "0"); 
  
    fechaContrato.value = fechaFormateada;
    fechaInicio.value = fechaFormateada;
    diaPago.value = dd;
  
    try {
      const peticion = await fetch(
        `${baseUrl}app/controllers/AsesorController.php?id=${leadId}`
      );
      const response = await peticion.json();
      console.log(response);
  
      response.forEach((data) => {
        nombreAsesor.value = data.nombreasesor;
        fechaRegistro.value = data.fecharegistrolead;
      });
    } catch (error) {
      console.error("Error al obtener asesor:", error);
    }
  })();
  

(async () => {
  try {
    const peticion = await fetch(
      `${baseUrl}app/controllers/ContratoController.php?id=${leadId}`
    );
    console.log(peticion);
    const response = await peticion.json();
    console.log(response);


    document.getElementById("nombre").value = response.nombrecompleto;
    document.getElementById("tipodocumento").value = response.tipodocumento;
    document.getElementById("numdocumento").value = response.numdocumento;
    document.getElementById("telefono").value = response.telefono;
  } catch (error) {
    console.error("Error al obtener datos del lead:", error);
  }
})();

function buscarConyuge() {
  const dni = document.getElementById("buscarDNI").value.trim();

  if (!dni || dni.length !== 8) {
    Swal.fire({
      toast: true,
      position: "top-end",
      icon: "error",
      title: "Ingrese un DNI válido de 8 dígitos",
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true,
    });
    return;
  }

  Swal.fire({
    title: "Buscando...",
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    },
  });

  fetch(`${baseUrl}app/controllers/ContratoController.php?dni=${dni}`)
    .then((response) => response.json())
    .then((data) => {
      document.getElementById("conyuge").value = `${data.nombres || ""} ${
        data.apellidos || ""
      }`.trim();
      document.getElementById("telconyuge").value = data.telprincipal || "";

      Swal.fire({
        toast: true,
        position: "top-end",
        icon: "success",
        title: "Datos encontrados",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
      });
    })
  
    .catch((error) => {
      Swal.fire({
        toast: true,
        position: "top-end",
        title: "No se encontraron resultados",
        text: "¿Desea agregar al cónyuge?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Sí, agregar",
        cancelButtonText: "No",
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `${baseUrl}app/views/leads/conyuge.lead?id=${leadId}`;
        }
      });
      console.error("Error al buscar conyuge:", error);
    });
}

document.getElementById("buscarDNI").addEventListener("keypress", function (e) {
  if (e.key === "Enter") {
    e.preventDefault();
    buscarConyuge();
    document.getElementById("conyuge").value = ''; // Cada busqueda vuelva a reiniicar el Input
  }
});

document.getElementById("buscarDNI").addEventListener("input", function () {
  this.value = this.value.replace(/[^0-9]/g, ""); // Solo números
  if (this.value.length > 8) {
    this.value = this.value.slice(0, 8);
  }
});

function calcularFechaFin() {
  if (!mesesInput.value || mesesInput.value.trim() === "") {
    fechaFin.value = "";
    return;
  }

  if (fechaInicio.value && mesesInput.value) {
    const fecha = new Date(fechaInicio.value);
    const meses = parseInt(mesesInput.value);

    if (!isNaN(meses)) {
      fecha.setMonth(fecha.getMonth() + meses);

      fecha.setDate(fecha.getDate() + 1); 
      fechaFin.value = formatearFecha(fecha);
    }
  }
}

mesesInput.addEventListener("input", calcularFechaFin);
mesesInput.addEventListener("change", calcularFechaFin);
fechaInicio.addEventListener("change", calcularFechaFin);
