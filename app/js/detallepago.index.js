document.addEventListener("DOMContentLoaded", () => {
  const BASE_URL = document
    .querySelector("meta[name='base-url']")
    .getAttribute("content");
  const paymentDetailsTableBody = document.getElementById(
    "paymentDetailsTableBody"
  );
  const mensajeSinResultados = document.getElementById(
    "mensaje-sin-resultados"
  );

  const fetchAndRenderPaymentDetails = async () => {
    try {
      const url = `${BASE_URL}app/controllers/DetallePagoController.php`;
      const response = await fetch(url);
      const result = await response.json();

      if (result.status && result.data.length > 0) {
        renderizarTablaAgrupadaPorCuenta(result.data);
      } else {
        mensajeSinResultados.textContent =
          result.message || "No hay detalles de pagos para mostrar.";
        mensajeSinResultados.style.display = "block";
        paymentDetailsTableBody.innerHTML = "";
      }
    } catch (error) {
      console.error("Error al obtener los detalles de pagos:", error);
      Swal.fire(
        "Error",
        "Ocurrió un error al comunicarse con el servidor.",
        "error"
      );
      mensajeSinResultados.textContent =
        "Error al cargar los datos. Por favor, intente de nuevo.";
      mensajeSinResultados.style.display = "block";
      paymentDetailsTableBody.innerHTML = "";
    }
  };

  const agruparPorCuenta = (data) => {
    const grouped = {};

    data.sort((a, b) => {
      if (a.idnumcuenta !== b.idnumcuenta) {
        return a.idnumcuenta - b.idnumcuenta;
      }
      // Ordenar por fecha de pago ascendente para que el más antiguo sea el "primero" visible
      const dateA = new Date(
        a.fechapago.split(" ")[0].split("-").reverse().join("-") +
          "T" +
          a.fechapago.split(" ")[1]
      );
      const dateB = new Date(
        b.fechapago.split(" ")[0].split("-").reverse().join("-") +
          "T" +
          b.fechapago.split(" ")[1]
      );
      return dateA - dateB;
    });

    data.forEach((item) => {
      const cuentaId = item.idnumcuenta; // El ID de la cuenta es la clave de agrupación
      if (!grouped[cuentaId]) {
        grouped[cuentaId] = [];
      }
      grouped[cuentaId].push(item);
    });
    return grouped;
  };

  // Función principal para renderizar la tabla con la lógica de agrupación por CUENTA
  function renderizarTablaAgrupadaPorCuenta(data) {
    paymentDetailsTableBody.innerHTML = "";
    const detallePagosAgrupados = agruparPorCuenta(data);

    function crearCeldaTexto(
      fila,
      contenidoVisible,
      contenidoCompleto = null,
      classList = []
    ) {
      const celda = fila.insertCell();
      celda.textContent = contenidoVisible;

      if (
        contenidoCompleto !== null &&
        contenidoCompleto !== contenidoVisible
      ) {
        celda.setAttribute("title", contenidoCompleto);
      } else if (contenidoVisible) {
        // Solo si hay contenido visible, para evitar title vacío
        celda.setAttribute("title", contenidoVisible);
      }

      if (classList.length > 0) {
        celda.classList.add(...classList);
      }
      return celda;
    }

    function crearBotonAccionDetalle(baseUrl, detallePago, tipoAccion) {
      const button = document.createElement("button");
      button.className = `btn-${tipoAccion}-detalle`;
      button.dataset.iddetalle = detallePago.iddetalle;

      let link = null;

      if (tipoAccion === "editar") {
        button.textContent = "Editar";
        link = document.createElement("a");
        link.href = `${baseUrl}app/views/detallepagos/detallepago.edit?iddetalle=${detallePago.iddetalle}`;
        link.appendChild(button);
      } else if (tipoAccion === "eliminar") {
        button.textContent = "Eliminar";

        button.onclick = () => {
          Swal.fire({
            title: "¿Estás seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminarlo!",
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                "Eliminado!",
                "El detalle de pago ha sido eliminado.",
                "success"
              );
              // Recargar la tabla después de eliminar
              fetchAndRenderPaymentDetails();
            }
          });
        };
      }

      return link || button;
    }

    // Iterar sobre cada grupo de detallepagos (cada cuenta bancaria)
    for (const cuentaId in detallePagosAgrupados) {
      const pagosDeCuenta = detallePagosAgrupados[cuentaId];

      if (pagosDeCuenta.length > 0) {
        // El primer detallepago de la lista será la fila principal
        const primerDetallePago = pagosDeCuenta[0];

        // Fila principal (visible) - representa el primer detallepago de la cuenta
        const mainRow = paymentDetailsTableBody.insertRow();
        mainRow.classList.add("grupo-detalle-pago"); // Clase para la fila principal del grupo
        mainRow.dataset.cuentaId = cuentaId; // Identificador para expandir/colapsar

        crearCeldaTexto(mainRow, primerDetallePago.inversionsita);
        crearCeldaTexto(mainRow, primerDetallePago.dni);
        crearCeldaTexto(mainRow, primerDetallePago.cuentadepositada);
        crearCeldaTexto(mainRow, primerDetallePago.entidad);
        crearCeldaTexto(mainRow, primerDetallePago.ntransaccion);
        crearCeldaTexto(
          mainRow,
          `S/ ${parseFloat(primerDetallePago.montopagado).toFixed(2)}`
        );
        crearCeldaTexto(mainRow, primerDetallePago.observaciones);
        crearCeldaTexto(mainRow, primerDetallePago.ncuota);
        crearCeldaTexto(
          mainRow,
          `S/ ${parseFloat(primerDetallePago.totalcuota).toFixed(2)}`
        );
        const estadoCellMain = crearCeldaTexto(
          mainRow,
          primerDetallePago.estado_cuota
        );
        estadoCellMain.classList.add(
          `estado-${primerDetallePago.estado_cuota.toLowerCase()}`
        );
        crearCeldaTexto(mainRow, primerDetallePago.usuario);
        crearCeldaTexto(mainRow, primerDetallePago.fechapago);
        crearCeldaTexto(mainRow, primerDetallePago.fechavencimiento_cuota);

        // Celda de acciones para la fila principal
        const accionesCell = mainRow.insertCell();
        accionesCell.classList.add("acciones-cell");
        const botonesContainer = document.createElement("div");
        botonesContainer.className = "botones-accion";
        botonesContainer.style.display = "flex";
        botonesContainer.style.gap = "8px";
        botonesContainer.style.justifyContent = "flex-end";

        // Botón de expandir/colapsar
        const btnExpandir = document.createElement("button");
        btnExpandir.className = "btn-expandir-detalle"; // Clase específica para detalles
        if (pagosDeCuenta.length > 1) {
          btnExpandir.textContent = "+";
        } else {
          btnExpandir.style.visibility = "hidden"; // Ocultar si no hay más detalles
        }

        const btnEditarPrimerDetalle = crearBotonAccionDetalle(
          BASE_URL,
          primerDetallePago,
          "editar"
        );
        const btnEliminarPrimerDetalle = crearBotonAccionDetalle(
          BASE_URL,
          primerDetallePago,
          "eliminar"
        );

        botonesContainer.appendChild(btnExpandir);
        if (btnEditarPrimerDetalle)
          botonesContainer.appendChild(btnEditarPrimerDetalle);
        if (btnEliminarPrimerDetalle)
          botonesContainer.appendChild(btnEliminarPrimerDetalle);
        accionesCell.appendChild(botonesContainer);

        for (let i = 1; i < pagosDeCuenta.length; i++) {
          const detallePagoAdicional = pagosDeCuenta[i];

          const detailRow = paymentDetailsTableBody.insertRow();
          detailRow.classList.add("detalle-pago-extra");
          detailRow.dataset.cuentaId = cuentaId;
          detailRow.style.display = "none";

          crearCeldaTexto(detailRow, detallePagoAdicional.inversionsita); // Inversionista (vacío)
          crearCeldaTexto(detailRow,detallePagoAdicional.dni); // DNI (vacío)
          crearCeldaTexto(detailRow, detallePagoAdicional.cuentadepositada); // Cuenta Depositada (vacío)
          crearCeldaTexto(detailRow, detallePagoAdicional.entidad); // Entidad (vacío)
          crearCeldaTexto(detailRow, detallePagoAdicional.ntransaccion);
          crearCeldaTexto(
            detailRow,
            `S/ ${parseFloat(detallePagoAdicional.montopagado).toFixed(2)}`
          ); // Monto del pago individual
          crearCeldaTexto(detailRow, detallePagoAdicional.observaciones);
          crearCeldaTexto(detailRow, detallePagoAdicional.ncuota);
          crearCeldaTexto(
            detailRow,
            `S/ ${parseFloat(detallePagoAdicional.totalcuota).toFixed(2)}`
          ); // Total Cuota sí se muestra
          const estadoDetalleCell = crearCeldaTexto(
            detailRow,
            detallePagoAdicional.estado_cuota
          );
          estadoDetalleCell.classList.add(
            `estado-${detallePagoAdicional.estado_cuota.toLowerCase()}`
          );
          crearCeldaTexto(detailRow, detallePagoAdicional.usuario);
          crearCeldaTexto(detailRow, detallePagoAdicional.fechapago);
          crearCeldaTexto(
            detailRow,
            detallePagoAdicional.fechavencimiento_cuota
          ); // Fecha Vencimiento Cuota sí se muestra

          // Celda de acciones para la fila de detalle adicional
          const accionesDetalleCell = detailRow.insertCell();
          accionesDetalleCell.classList.add("acciones-cell");
          const botonesContainerDetalle = document.createElement("div");
          botonesContainerDetalle.className = "botones-accion";
          botonesContainerDetalle.style.display = "flex";
          botonesContainerDetalle.style.gap = "8px";
          botonesContainerDetalle.style.justifyContent = "flex-end";

          const btnEditarDetalle = crearBotonAccionDetalle(
            BASE_URL,
            detallePagoAdicional,
            "editar"
          );
          const btnEliminarDetalle = crearBotonAccionDetalle(
            BASE_URL,
            detallePagoAdicional,
            "eliminar"
          );

          if (btnEditarDetalle)
            botonesContainerDetalle.appendChild(btnEditarDetalle);
          if (btnEliminarDetalle)
            botonesContainerDetalle.appendChild(btnEliminarDetalle);
          accionesDetalleCell.appendChild(botonesContainerDetalle);
        }
      }
    }

    // Listeners para los botones de expandir/colapsar
    document.querySelectorAll(".btn-expandir-detalle").forEach((button) => {
      button.addEventListener("click", function () {
        const cuentaId = this.closest(".grupo-detalle-pago").dataset.cuentaId;
        const detalleRows = document.querySelectorAll(
          `.detalle-pago-extra[data-cuenta-id="${cuentaId}"]`
        );
        detalleRows.forEach((row) => {
          row.style.display =
            row.style.display === "none" ? "table-row" : "none";
        });
        this.textContent = this.textContent === "+" ? "-" : "+";
      });
    });
  }

  fetchAndRenderPaymentDetails();
});
