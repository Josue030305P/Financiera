document.addEventListener("DOMContentLoaded", function () {
  const baseUrl =
    document.querySelector('meta[name="base-url"]')?.content || "";
  const tablaCronogramaBody = document.querySelector("#tabla-cronograma tbody");
  const btnFiltrar = document.getElementById("btn-filtrar");
  const btnLimpiarFiltro = document.getElementById("btn-limpiar-filtro");
  const filtroEstado = document.getElementById("filtro-estado");
  const filtroFechaInicio = document.getElementById("filtro-fecha-inicio");
  const filtroFechaFin = document.getElementById("filtro-fecha-fin");
  const filtroIdContrato = document.getElementById("filtro-id-contrato");
  const filtroDni = document.getElementById("filtro-dni");

  let allData = []; // Variable para almacenar todos los datos recibidos

  function actualizarTabla(data) {
    allData = data; // Almacena los datos
    renderizarTablaAgrupada(data);
  }

  function renderizarTablaAgrupada(data) {
    tablaCronogramaBody.innerHTML = "";
    const contratosAgrupados = agruparPorContrato(data);

    for (const contratoId in contratosAgrupados) {
      const pagosContrato = contratosAgrupados[contratoId];

      if (pagosContrato.length > 0) {
        const primeraFila = pagosContrato[0];

        // Fila principal (primera fila del contrato)
        const grupoRow = tablaCronogramaBody.insertRow();
        grupoRow.classList.add("grupo-contrato");
        grupoRow.dataset.contratoId = contratoId;
        grupoRow.insertCell().textContent = primeraFila.idcontrato;
        grupoRow.insertCell().textContent = pagosContrato.length + " pagos";
        grupoRow.insertCell().textContent =
          calcularTotalBruto(pagosContrato).toFixed(2);
        grupoRow.insertCell().textContent =
          primeraFila.nombre_inversionista +
          " " +
          primeraFila.apellido_inversionista;
        grupoRow.insertCell().textContent = primeraFila.dni;
        grupoRow.insertCell().textContent = primeraFila.numcuota;
        grupoRow.insertCell().textContent = primeraFila.fechavencimiento;
        grupoRow.insertCell().textContent = primeraFila.totalneto;
        grupoRow.insertCell().textContent = primeraFila.amortizacion;
        grupoRow.insertCell().textContent = primeraFila.restante;
        const estadoCell = grupoRow.insertCell();
        estadoCell.textContent = primeraFila.estado_pago;
        estadoCell.classList.add(
          `estado-${primeraFila.estado_pago.toLowerCase()}`
        );
        grupoRow.insertCell().textContent = primeraFila.fecha_inicio_contrato; // Nueva columna: Fecha Inicio Contrato
        grupoRow.insertCell().textContent = primeraFila.fecha_fin_contrato; // Nueva columna: Fecha Fin Contrato
        const expandirCell = grupoRow.insertCell();
        expandirCell.innerHTML = '<button class="btn-expandir">+</button>';
        expandirCell.classList.add("expandir-control");

        // Filas de pago individuales (ocultas inicialmente)
        for (let i = 1; i < pagosContrato.length; i++) {
          const pago = pagosContrato[i];
          const detalleRow = tablaCronogramaBody.insertRow();
          detalleRow.classList.add("detalle-pago");
          detalleRow.dataset.contratoId = contratoId;
          detalleRow.style.display = "none";

          detalleRow.insertCell().textContent = pago.idcontrato;
          detalleRow.insertCell().textContent = "";
          detalleRow.insertCell().textContent = "";
          detalleRow.insertCell().textContent =
            pago.nombre_inversionista + " " + pago.apellido_inversionista;
          detalleRow.insertCell().textContent = pago.dni;
          detalleRow.insertCell().textContent = pago.numcuota;
          detalleRow.insertCell().textContent = pago.fechavencimiento;
          detalleRow.insertCell().textContent = pago.totalneto;
          detalleRow.insertCell().textContent = pago.amortizacion;
          detalleRow.insertCell().textContent = pago.restante;
          const estadoDetalleCell = detalleRow.insertCell();
          estadoDetalleCell.textContent = pago.estado_pago;
          estadoDetalleCell.classList.add(
            `estado-${pago.estado_pago.toLowerCase()}`
          );
          detalleRow.insertCell(); // Celda vacía para Detalles..
          detalleRow.insertCell().textContent = pago.fecha_inicio_contrato; // Nueva columna: Fecha Inicio Contrato
          detalleRow.insertCell().textContent = pago.fecha_fin_contrato; // Nueva columna: Fecha Fin Contrato
        }
      }
    }

    // Event listener para expandir/contraer
    document.querySelectorAll(".btn-expandir").forEach((button) => {
      button.addEventListener("click", function () {
        const contratoId = this.closest(".grupo-contrato").dataset.contratoId;
        const detalleRows = document.querySelectorAll(
          `.detalle-pago[data-contrato-id="${contratoId}"]`
        );
        detalleRows.forEach((row) => {
          row.style.display =
            row.style.display === "none" ? "table-row" : "none";
        });
        this.textContent = this.textContent === "+" ? "-" : "+";
      });
    });
  }

  function agruparPorContrato(data) {
    const contratosAgrupados = {};
    data.forEach((pago) => {
      if (!contratosAgrupados[pago.idcontrato]) {
        contratosAgrupados[pago.idcontrato] = [];
      }
      contratosAgrupados[pago.idcontrato].push(pago);
    });
    return contratosAgrupados;
  }

  function calcularTotalBruto(pagos) {
    let total = 0;
    pagos.forEach((pago) => {
      total += parseFloat(pago.totalbruto);
    });
    return total;
  }

 btnFiltrar.addEventListener('click', function() {
    const estado = filtroEstado.value;
    const fechaInicio = filtroFechaInicio.value;
    const fechaFin = filtroFechaFin.value;
    const idContrato = filtroIdContrato.value;
    const dni = filtroDni.value;

    const params = new URLSearchParams();
    if (estado) params.append('estado', estado);
    if (fechaInicio) params.append('fechainicio', fechaInicio); // Usa el ID correcto del input
    if (fechaFin) params.append('fechafin', fechaFin);     // Usa el ID correcto del input
    if (idContrato) params.append('idcontrato_filtro', idContrato);
    if (dni) params.append('dni', dni);

    const url = `${baseUrl}app/controllers/CronogramaPago.Controller.php?${params.toString()}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            actualizarTabla(data.data);
        })
        .catch(error => {
            console.error('Error al filtrar los datos:', error);
        });
});

  btnLimpiarFiltro.addEventListener("click", function () {
    filtroEstado.value = "";
    filtroFechaInicio.value = "";
    filtroFechaFin.value = "";
    filtroIdContrato.value = "";
    filtroDni.value = "";

    // Recargar todos los datos
    fetch(`${baseUrl}app/controllers/CronogramaPago.Controller.php`)
      .then((response) => response.json())
      .then((data) => {
        actualizarTabla(data.data);
      })
      .catch((error) => {
        console.error("Error al cargar los datos:", error);
      });
  });

  // Cargar los datos iniciales al cargar la página
  fetch(`${baseUrl}app/controllers/CronogramaPago.Controller.php`)
    .then((response) => response.json())
    .then((data) => {
      actualizarTabla(data.data);
    })
    .catch((error) => {
      console.error("Error al cargar los datos iniciales:", error);
    });
});
