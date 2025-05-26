document.addEventListener("DOMContentLoaded", function () {
  const baseUrl =
    document.querySelector('meta[name="base-url"]')?.content || "";
  const tablaCronogramaBody = document.querySelector("#tabla-cronograma tbody");
  const btnFiltrar = document.getElementById("btn-filtrar");
  const btnLimpiarFiltro = document.getElementById("btn-limpiar-filtro");
  const filtroEstado = document.getElementById("filtro-estado");
  const filtroIdContrato = document.getElementById("filtro-id-contrato");
  const filtroDni = document.getElementById("filtro-dni");

  let allData = [];
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

        // Celda única para ambos botones
        const accionesCell = grupoRow.insertCell();
        accionesCell.classList.add("acciones-cell");

        // Crear contenedor para los botones
        const botonesContainer = document.createElement("div");
        botonesContainer.className = "botones-accion";
        botonesContainer.style.display = "flex";
        botonesContainer.style.gap = "8px";
        botonesContainer.style.justifyContent = "flex-end";

        // Botón de expandir
        const btnExpandir = document.createElement("button");
        btnExpandir.className = "btn-expandir";
        btnExpandir.textContent = "+";

        // Botón de Excel
        const btnExcel = document.createElement("button");
        btnExcel.className = "btn-exportar-excel";
        btnExcel.dataset.contratoId = contratoId;
        btnExcel.textContent = "Excel";

        // Botón para ir a pagar cuota
        const btnPagarCuota = document.createElement("button");
        btnPagarCuota.className = "btn-pagar-cuota";
        btnPagarCuota.textContent = "Pagar cuota";
        btnPagarCuota.dataset.idcontrato = primeraFila.idcontrato;
        //console.log("BOTON DE PAGAR CON ID COPTRATO: ",btnPagarCuota );
        
        // Crear etiqueta 'a' que me llevara a la vista de pago

        const btnEnlace = document.createElement("a");
        btnEnlace.href = `${baseUrl}app/views/detallepagos/detallepago.add?idcronograma=${primeraFila.idcronogramapago}&idcontrato=${primeraFila.idcontrato}`;

        btnEnlace.appendChild(btnPagarCuota);

        // Agregar botones al contenedor
        botonesContainer.appendChild(btnExpandir);
        botonesContainer.appendChild(btnExcel);
        botonesContainer.appendChild(btnEnlace);

        // Agregar contenedor a la celda
        accionesCell.appendChild(botonesContainer);



        // LA TABLA DE CRONOGRAMAS

        for (let i = 1; i < pagosContrato.length; i++) {
          // Botón para ir a pagar cuota
         
          const pago = pagosContrato[i];
          const btnPagarCuota = document.createElement("button");
          btnPagarCuota.className = "btn-pagar-cuota";
          btnPagarCuota.textContent = "Pagar cuota";

          // Crear etiqueta 'a' que me llevara a la vista de pago

          const btnEnlace = document.createElement("a");
          btnEnlace.href = `${baseUrl}app/views/detallepagos/detallepago.add?idcronograma=${pago.idcronogramapago}&idcontrato=${pago.idcontrato}`;

          btnEnlace.appendChild(btnPagarCuota);
          btnPagarCuota.dataset.idcontrato = primeraFila.idcontrato;
          console.log("BOTON DE PAGAR CON ID COPTRATO: ",btnPagarCuota );
          //console.log("ID CRONOGRAMA DE PAGOS: ", pago.idcronogramapago); // ID DEL CRMOGRAMA DE PAGO

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
          detalleRow.insertCell().appendChild(btnEnlace);
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

    document.querySelectorAll(".btn-exportar-excel").forEach((button) => {
      button.addEventListener("click", function () {
        const contratoId = this.dataset.contratoId;
        exportarExcel(contratoId);
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
      total += parseFloat(pago.totalneto);
    });
    return total;
  }

  function exportarExcel(contratoId = null) {
    let dataToExport = [...allData]; // Usa una copia de los datos

    // Verificar si hay datos para exportar
    if (dataToExport.length === 0) {
      Swal.fire({
        icon: "warning",
        title: "No hay datos para exportar",
        text: "No se encontraron registros en el cronograma.",
        confirmButtonText: "Entendido",
      });
      return;
    }

    if (contratoId) {
      dataToExport = dataToExport.filter(
        (pago) => pago.idcontrato == contratoId
      );

      if (dataToExport.length === 0) {
        Swal.fire({
          icon: "warning",
          title: "No hay datos para exportar",
          text: `No se encontraron pagos para el contrato ${contratoId}.`,
          confirmButtonText: "Entendido",
        });
        return;
      }
    }

    const excelData = [
      // Encabezados
      [
        "ID Contrato",
        "Inversionista",
        "DNI",
        "Cuota #",
        "Fecha Vencimiento",
        "Total Neto",
        "Amortización",
        "Restante",
        "Estado",
      ],
    ];

    // Agregar los datos de cada pago
    dataToExport.forEach((pago) => {
      excelData.push([
        pago.idcontrato,
        `${pago.nombre_inversionista} ${pago.apellido_inversionista}`,
        pago.dni,
        pago.numcuota,
        pago.fechavencimiento,
        pago.totalneto,
        pago.amortizacion,
        pago.restante,
        pago.estado_pago,
      ]);
    });

    try {
      // Crear el libro de Excel
      const workbook = XLSX.utils.book_new();
      const worksheet = XLSX.utils.aoa_to_sheet(excelData);

      // Ajustar el ancho de las columnas
      worksheet["!cols"] = [
        { wch: 15 }, // ID Contrato
        { wch: 30 }, // Inversionista
        { wch: 15 }, // DNI
        { wch: 10 }, // Cuota #
        { wch: 15 }, // Fecha Vencimiento
        { wch: 15 }, // Total Neto
        { wch: 15 }, // Amortización
        { wch: 15 }, // Restante
        { wch: 15 }, // Estado
      ];

      XLSX.utils.book_append_sheet(workbook, worksheet, "Cronograma");

      // Generar el archivo Excel
      const filename = contratoId
        ? `Cronograma_Contrato_${contratoId}.xlsx`
        : "Cronograma_Completo.xlsx";

      XLSX.writeFile(workbook, filename);
    } catch (error) {
      console.error("Error al generar el Excel:", error);
      Swal.fire({
        icon: "error",
        title: "Error al exportar",
        text: "Ocurrió un error al generar el archivo Excel.",
        confirmButtonText: "Entendido",
      });
    }
  }

  btnFiltrar.addEventListener("click", function () {
    const estado = filtroEstado.value;
    const idContrato = filtroIdContrato.value;
    const dni = filtroDni.value;

    const params = new URLSearchParams();
    if (estado) params.append("estado", estado);
    if (idContrato) params.append("idcontrato", idContrato);
    if (dni) params.append("dni", dni);

    const url = `${baseUrl}app/controllers/CronogramaPago.Controller.php?${params.toString()}`;
    const tablaCronogramaBody = document.querySelector(
      "#tabla-cronograma tbody"
    );
    let mensajeSinResultados = document.getElementById(
      "mensaje-sin-resultados"
    );

    fetch(url)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error en la respuesta de la red");
        }
        return response.json();
      })
      .then((data) => {
        if (data && data.data && data.data.length > 0) {
          actualizarTabla(data.data);
          tablaCronogramaBody.style.display = "";
          // Eliminar el mensaje si existe
          if (mensajeSinResultados) {
            mensajeSinResultados.remove();
          }
        } else {
          tablaCronogramaBody.innerHTML = "";
          tablaCronogramaBody.style.display = "none";
          if (!mensajeSinResultados) {
            mensajeSinResultados = document.createElement("p");
            mensajeSinResultados.id = "mensaje-sin-resultados";
            mensajeSinResultados.style.textAlign = "center";
            mensajeSinResultados.style.marginTop = "20px";
            mensajeSinResultados.style.marginBottom = "20px";
            mensajeSinResultados.textContent =
              "No se encontraron resultados para los filtros aplicados.";
            tablaCronogramaBody.parentNode.insertBefore(
              mensajeSinResultados,
              tablaCronogramaBody.nextSibling
            );
          } else {
            mensajeSinResultados.textContent =
              "No se encontraron resultados para los filtros aplicados.";
            mensajeSinResultados.style.display = "block";
          }
        }
      })
      .catch((error) => {
        console.error("Error al filtrar los datos:", error);
        tablaCronogramaBody.innerHTML = "";
        tablaCronogramaBody.style.display = "none";
        let mensajeSinResultados = document.getElementById(
          "mensaje-sin-resultados"
        );
        if (!mensajeSinResultados) {
          mensajeSinResultados = document.createElement("p");
          mensajeSinResultados.id = "mensaje-sin-resultados";
          mensajeSinResultados.style.textAlign = "center";
          mensajeSinResultados.style.marginTop = "20px";
          mensajeSinResultados.textContent =
            "Error al cargar los datos. Por favor, intente de nuevo.";
          tablaCronogramaBody.parentNode.insertBefore(
            mensajeSinResultados,
            tablaCronogramaBody.nextSibling
          );
        } else {
          mensajeSinResultados.textContent =
            "Error al cargar los datos. Por favor, intente de nuevo.";
          mensajeSinResultados.style.display = "block";
        }
      });
  });

  btnLimpiarFiltro.addEventListener("click", function () {
    filtroEstado.value = "";
    filtroIdContrato.value = "";
    filtroDni.value = "";

    const tablaCronogramaBody = document.querySelector(
      "#tabla-cronograma tbody"
    );
    const mensajeSinResultados = document.getElementById(
      "mensaje-sin-resultados"
    );

    // Recargar todos los datos
    fetch(`${baseUrl}app/controllers/CronogramaPago.Controller.php`)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error en la respuesta de la red");
        }
        return response.json();
      })
      .then((data) => {
        actualizarTabla(data.data);
        tablaCronogramaBody.style.display = "";

        if (mensajeSinResultados) {
          mensajeSinResultados.remove();
        }
      })
      .catch((error) => {
        console.error("Error al cargar los datos:", error);
        tablaCronogramaBody.innerHTML = "";
        tablaCronogramaBody.style.display = "none";
        let mensajeSinResultados = document.getElementById(
          "mensaje-sin-resultados"
        );
        if (!mensajeSinResultados) {
          mensajeSinResultados = document.createElement("p");
          mensajeSinResultados.id = "mensaje-sin-resultados";
          mensajeSinResultados.style.textAlign = "center";
          mensajeSinResultados.style.marginTop = "20px";
          mensajeSinResultados.textContent =
            "Error al cargar los datos. Por favor, intente de nuevo.";
          tablaCronogramaBody.parentNode.insertBefore(
            mensajeSinResultados,
            tablaCronogramaBody.nextSibling
          );
        } else {
          mensajeSinResultados.textContent =
            "Error al cargar los datos. Por favor, intente de nuevo.";
          mensajeSinResultados.style.display = "block";
        }
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
