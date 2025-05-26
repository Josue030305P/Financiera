document.addEventListener("DOMContentLoaded",  () =>  {
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

    // Función auxiliar para crear y añadir texto a una celda
    function crearCeldaTexto(fila, contenido) {
        const celda = fila.insertCell();
        celda.textContent = contenido;
        return celda;
    }


    function crearBotonPagarCuota(baseUrl, idcronogramaPago, idcontrato, estadoPago) {
        if (estadoPago && estadoPago.toLowerCase() === "pagado") {
            return null; // No retorna nada si ya está pagado
        }

        const btnPagarCuota = document.createElement("button");
        btnPagarCuota.className = "btn-pagar-cuota";
        btnPagarCuota.textContent = "Pagar cuota";
        btnPagarCuota.dataset.idcontrato = idcontrato;

        const btnEnlace = document.createElement("a");
        btnEnlace.href = `${baseUrl}app/views/detallepagos/detallepago.add?idcronograma=${idcronogramaPago}&idcontrato=${idcontrato}`;
        btnEnlace.appendChild(btnPagarCuota);
        return btnEnlace;
    }

    for (const contratoId in contratosAgrupados) {
        const pagosContrato = contratosAgrupados[contratoId];

        if (pagosContrato.length > 0) {
            const primeraFila = pagosContrato[0];

            // Fila de grupo (encabezado)
            const grupoRow = tablaCronogramaBody.insertRow();
            grupoRow.classList.add("grupo-contrato");
            grupoRow.dataset.contratoId = contratoId;

            crearCeldaTexto(grupoRow, primeraFila.idcontrato);
            crearCeldaTexto(grupoRow, pagosContrato.length + " pagos");
            crearCeldaTexto(grupoRow, calcularTotalBruto(pagosContrato).toFixed(2));
            crearCeldaTexto(grupoRow, `${primeraFila.nombre_inversionista} ${primeraFila.apellido_inversionista}`);
            crearCeldaTexto(grupoRow, primeraFila.dni);
            crearCeldaTexto(grupoRow, primeraFila.numcuota);
            crearCeldaTexto(grupoRow, primeraFila.fechavencimiento);
            crearCeldaTexto(grupoRow, primeraFila.totalneto);
            crearCeldaTexto(grupoRow, primeraFila.amortizacion);
            crearCeldaTexto(grupoRow, primeraFila.restante);

            const estadoCellGrupo = crearCeldaTexto(grupoRow, primeraFila.estado_pago);
            estadoCellGrupo.classList.add(`estado-${primeraFila.estado_pago.toLowerCase()}`);

            // Celda de acciones para la fila de grupo
            const accionesCellGrupo = grupoRow.insertCell();
            accionesCellGrupo.classList.add("acciones-cell");
            const botonesContainerGrupo = document.createElement("div");
            botonesContainerGrupo.className = "botones-accion";
            botonesContainerGrupo.style.display = "flex";
            botonesContainerGrupo.style.gap = "8px";
            botonesContainerGrupo.style.justifyContent = "flex-end";

            const btnExpandir = document.createElement("button");
            btnExpandir.className = "btn-expandir";
            btnExpandir.textContent = "+";

            const btnExcel = document.createElement("button");
            btnExcel.className = "btn-exportar-excel";
            btnExcel.dataset.contratoId = contratoId;
            btnExcel.textContent = "Excel";

            // Pasamos el estado de pago a la función crearBotonPagarCuota
            const btnEnlaceGrupo = crearBotonPagarCuota(
                baseUrl,
                primeraFila.idcronogramapago,
                primeraFila.idcontrato,
                primeraFila.estado_pago // <--- AQUÍ se pasa el estado
            );

            botonesContainerGrupo.appendChild(btnExpandir);
            botonesContainerGrupo.appendChild(btnExcel);
            // Solo añadimos el botón si no es nulo (es decir, si el pago no está 'Pagado')
            if (btnEnlaceGrupo) {
                botonesContainerGrupo.appendChild(btnEnlaceGrupo);
            }
            accionesCellGrupo.appendChild(botonesContainerGrupo);

            // Filas de detalle (ocultas inicialmente)
            for (let i = 1; i < pagosContrato.length; i++) {
                const pago = pagosContrato[i];

                const detalleRow = tablaCronogramaBody.insertRow();
                detalleRow.classList.add("detalle-pago");
                detalleRow.dataset.contratoId = contratoId;
                detalleRow.style.display = "none";

                crearCeldaTexto(detalleRow, pago.idcontrato);
                crearCeldaTexto(detalleRow, ""); // Celda vacía para alineación
                crearCeldaTexto(detalleRow, ""); // Celda vacía para alineación
                crearCeldaTexto(detalleRow, `${pago.nombre_inversionista} ${pago.apellido_inversionista}`);
                crearCeldaTexto(detalleRow, pago.dni);
                crearCeldaTexto(detalleRow, pago.numcuota);
                crearCeldaTexto(detalleRow, pago.fechavencimiento);
                crearCeldaTexto(detalleRow, pago.totalneto);
                crearCeldaTexto(detalleRow, pago.amortizacion);
                crearCeldaTexto(detalleRow, pago.restante);

                const estadoDetalleCell = crearCeldaTexto(detalleRow, pago.estado_pago);
                estadoDetalleCell.classList.add(`estado-${pago.estado_pago.toLowerCase()}`);

                const accionesDetalleCell = detalleRow.insertCell();
                // Pasamos el estado de pago a la función crearBotonPagarCuota
                const btnEnlaceDetalle = crearBotonPagarCuota(
                    baseUrl,
                    pago.idcronogramapago,
                    pago.idcontrato,
                    pago.estado_pago // <--- AQUÍ también se pasa el estado
                );
                // Solo añadimos el botón si no es nulo
                if (btnEnlaceDetalle) {
                    accionesDetalleCell.appendChild(btnEnlaceDetalle);
                }
            }
        }
    }

    // Listeners para expandir/contraer y exportar a Excel (estos no cambian)
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
      // Crear el Excel
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
