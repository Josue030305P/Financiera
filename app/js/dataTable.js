class DataTable {
  constructor(options) {
    this.tableId = options.tableId;
    this.apiUrl = options.apiUrl;
    this.tipo = options.tipo;
    this.columnas = options.columnas;
    this.mapeo = options.mapeo;
    this.baseUrl = options.baseUrl;
    this.idField = options.idField || "id";
    this.customRenderers = options.customRenderers || {};
    this.dataOriginal = [];
    this.modalCronograma = document.getElementById("modal-cronograma");
    this.modalCronogramaBody = document.getElementById("modal-cronograma-body");
    this.modalContratoIdSpan = document.getElementById("modal-contrato-id");

    window.dataTable = this;

    this.init();
  }

  init() {
    this.cargarDatos();
    this.initEventListeners();
    this.initFilterEventListeners();
    this.initHeader();
    this.initModalEventListeners();
  }

  initHeader() {
    const tableHeader = document.querySelector(".table-header");
    if (tableHeader && this.tipo === "contratos") {
      const nuevoButton = tableHeader.querySelector(".create-lead");
      if (nuevoButton) {
        nuevoButton.href =
          this.links && this.links[this.tipo] ? this.links[this.tipo] : "#";
        nuevoButton.textContent = `+ Nuevo ${this.tipo}`;
      }
    }
  }

  initModalEventListeners() {
    if (this.modalCronograma) {
      const closeModalButton =
        this.modalCronograma.querySelector(".close-button");
      if (closeModalButton) {
        closeModalButton.addEventListener("click", () => {
          this.modalCronograma.style.display = "none";
        });
      }

      window.addEventListener("click", (event) => {
        if (event.target == this.modalCronograma) {
          this.modalCronograma.style.display = "none";
        }
      });
    }
  }

  async cargarDatos() {
    try {
      const response = await fetch(`${this.baseUrl}app/${this.apiUrl}`);
      const data = await response.json();
      this.dataOriginal = [...data];
      console.log("Datos originales cargados en dataTable:", this.dataOriginal);
      this.renderizarTabla(data);
    } catch (error) {
      console.error("Error al cargar datos:", error);
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Error al cargar los datos",
        confirmButtonColor: "#3085d6",
      });
    }
  }

  renderizarTabla(data) {
    console.log("Renderizando tabla con:", data);
    const tbody = document.querySelector(`#${this.tableId} tbody`);
    const thead = document.querySelector(`#${this.tableId} thead tr`);
    tbody.innerHTML = "";

    if (thead) {
      thead.className = "users-table-info";
      thead.querySelectorAll("th").forEach((th) => {
        th.style.fontWeight = "500";
        th.style.padding = "10px";
      });
    }

    if (data && Array.isArray(data)) {
      data.forEach((item) => {
        const row = document.createElement("tr");
        row.className = "users-table-row";
        row.dataset.id = item[this.idField];

        this.columnas.forEach((columna) => {
          const td = document.createElement("td");
          td.className = "td-item";
          td.style.padding = "10px";

          if (this.customRenderers[columna]) {
            td.innerHTML = this.customRenderers[columna](item);
          } else {
            switch (columna) {
              case "Prioridad":
                const prioridad = item[this.mapeo[columna]];
                const clase =
                  {
                    Alto: "badge-active",
                    Medio: "badge-pending",
                    Bajo: "badge-trashed",
                  }[prioridad] || "";
                td.innerHTML = `<span class="${clase}">${prioridad}</span>`;
                break;
              case "Estado":
                const estado = item[this.mapeo[columna]];
                const claseEstado =
                  {
                    Activo: "badge-active",
                    Pendiente: "badge-pending",
                    Inactivo: "badge-trashed",
                  }[estado] || "";
                td.innerHTML = `<span class="${claseEstado}">${estado}</span>`;
                break;
              case "Acciones":
                td.innerHTML = this.renderizarAcciones(item[this.idField]);
                break;
              default:
                td.textContent = this.obtenerValorCampo(item, columna);
            }
          }
          row.appendChild(td);
        });

        tbody.appendChild(row);
      });
    } else {
      console.error(
        "Error: Los datos para renderizar la tabla no son un array o son undefined.",
        data
      );
    }
  }

  obtenerValorCampo(item, columna) {
    const campo = this.mapeo[columna];
    if (Array.isArray(campo)) {
      return campo.map((c) => item[c]).join(" ");
    } else if (campo) {
      return item[campo] || "—";
    }
    return "—";
  }

  renderizarAcciones(id) {
    let acciones = `
            <a href="${this.baseUrl}app/views/${this.tipo}/${this.tipo}.update.php?id=${id}">
                <img src="${this.baseUrl}app/img/svg/Bulk/Edit-white.svg" alt="Editar" class="edit-lead">
            </a>
            <a href="#" onclick="window.dataTable.confirmarEliminacion(${id}); return false;">
                <img src="${this.baseUrl}app/img/svg/Bulk/Delete.svg" alt="Eliminar" class="delete-lead">
            </a>
        `;

    if (this.tipo === "leads") {
      acciones += `
                <a href="${this.baseUrl}app/views/inversionistas/inversionista.add?lead_id=${id}">
                    <button class="btn-addInversionista">
                        <img src="${this.baseUrl}app/img/svg/Bulk/3-User-white.svg" alt="Inversionista" class="icon-inversionista">
                    </button>
                </a>
            `;
    }

    if (this.tipo === "contratos") {
      acciones = `
                <a href="#" onclick="window.dataTable.confirmarEliminacion(${id}); return false;">
                    <img src="${this.baseUrl}app/img/svg/Bulk/Delete.svg" alt="Eliminar" class="delete-lead">
                </a>
             <a href="#" class="ver-cronograma-modal" style="cursor: pointer; display: inline-block;" data-contrato-id="${id}">
            <img src="${this.baseUrl}app/img/svg/Bulk/Paper-gray.svg" alt="Ver Cronograma" >
        </a>
                <a href="${this.baseUrl}app/views/contratos/generar-pdf.php?idcontrato=${id}" target="_blank">
                    <img src="${this.baseUrl}app/img/svg/Bulk/Download.svg" alt="Generar PDF" class="generar-contrato">
                </a>
            `;
    }
    return acciones;
  }

  async confirmarEliminacion(id) {
    const result = await Swal.fire({
      title: "¿Eliminar?",
      text: `¿Estás seguro de que deseas eliminar este registro? ${id}`,
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminar",
      cancelButtonText: "Cancelar",
    });

    if (result.isConfirmed) {
      await this.eliminarRegistro(id);
    }
  }

  async eliminarRegistro(id) {
    try {
      const response = await fetch(
        `${this.baseUrl}app/${this.apiUrl}?id=${id}`,
        { method: "DELETE" }
      );
      const result = await response.json();

      if (result.status === "success") {
        await Swal.fire({
          icon: "success",
          title: "Éxito",
          text: "Registro eliminado correctamente",
          confirmButtonColor: "#3085d6",
        });
        this.cargarDatos();
      } else {
        await Swal.fire({
          icon: "error",
          title: "Error",
          text: "Error al eliminar: " + result.message,
          confirmButtonColor: "#3085d6",
        });
      }
    } catch (error) {
      console.error("Error al eliminar:", error);
      await Swal.fire({
        icon: "error",
        title: "Error",
        text: "Error al eliminar el registro",
        confirmButtonColor: "#3085d6",
      });
    }
  }

  initEventListeners() {
    const tableBody = document.querySelector(`#${this.tableId} tbody`);
    if (tableBody) {
      tableBody.addEventListener("click", (event) => {
        const target = event.target.closest(".ver-cronograma-modal");
        if (target) {
          const contratoId = target.dataset.contratoId;
          if (contratoId) {
            this.abrirModalCronograma(contratoId);
          }
        }
      });
    }
  }

  abrirModalCronograma(idContrato) {
    if (
      this.modalCronograma &&
      this.modalCronogramaBody &&
      this.modalContratoIdSpan
    ) {
      this.modalContratoIdSpan.textContent = idContrato;
      this.modalCronogramaBody.innerHTML = "<p>Cargando cronograma...</p>";
      this.modalCronograma.style.display = "block";

      fetch(
        `${this.baseUrl}app/controllers/CronogramaPago.Controller.php?idcontrato=${idContrato}`
      )
        .then((response) => {
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json();
        })
        .then((data) => {
          this.renderizarCronogramaEnModal(data.data);
        })
        .catch((error) => {
          console.error("Error al cargar el cronograma:", error);
          this.modalCronogramaBody.innerHTML =
            "<p>Error al cargar el cronograma.</p>";
        });
    }
  }

  renderizarCronogramaEnModal(cronograma) {
    let tablaHTML = "<table>";
    tablaHTML +=
      "<thead><tr><th>Cuota #</th><th>Fecha de Pago</th><th>Total Bruto (S/)</th><th>Total Neto (S/)</th></tr></thead>";
    tablaHTML += "<tbody>";

    if (cronograma && cronograma.length > 0) {
      cronograma.forEach((pago) => {
        tablaHTML += `
                    <tr>
                        <td>${pago.numcuota}</td>
                        <td>${pago.fechavencimiento}</td>
                        <td>${pago.totalbruto}</td>
                        <td>${pago.totalneto}</td>
                    </tr>
                `;
      });
    } else {
      tablaHTML +=
        '<tr><td colspan="4">No se encontraron pagos para este contrato.</td></tr>';
    }

    tablaHTML += "</tbody></table>";
    this.modalCronogramaBody.innerHTML = tablaHTML;
  }

  initFilterEventListeners() {
    const aplicarFiltrosBtn = document.getElementById("aplicar-filtros");
    if (aplicarFiltrosBtn) {
      aplicarFiltrosBtn.addEventListener(
        "click",
        this.filtrarContratos.bind(this)
      );
    }

    const resetearFiltrosBtn = document.getElementById("resetear-filtros");
    if (resetearFiltrosBtn) {
      resetearFiltrosBtn.addEventListener(
        "click",
        this.resetearFiltros.bind(this)
      );
    }
  }

  filtrarContratos() {
    let datosFiltrados = [...this.dataOriginal];

    const filtroVencimiento =
      document.getElementById("filtro-vencimiento")?.value;
    const filtroEstado = document.getElementById("filtro-estado")?.value;
    const filtroAsesor = document
      .getElementById("filtro-asesor")
      ?.value.toLowerCase();
    const filtroMoneda = document.getElementById("filtro-moneda")?.value;

    if (filtroVencimiento === "proximos_30_dias") {
      const hoy = new Date();
      const dentroDe30Dias = new Date();
      dentroDe30Dias.setDate(hoy.getDate() + 30);
      datosFiltrados = datosFiltrados.filter((contrato) => {
        const fechaFin = new Date(contrato["Fin"]);
        return fechaFin >= hoy && fechaFin <= dentroDe30Dias;
      });
    }

    if (filtroEstado) {
      datosFiltrados = datosFiltrados.filter(
        (contrato) => contrato["Estado"] === filtroEstado
      );
    }

    if (filtroAsesor) {
      datosFiltrados = datosFiltrados.filter((contrato) =>
        contrato["Asesor"].toLowerCase().includes(filtroAsesor)
      );
    }

    if (filtroMoneda) {
      datosFiltrados = datosFiltrados.filter(
        (contrato) => contrato["Moneda"] === filtroMoneda
      );
    }

    this.renderizarTabla(datosFiltrados);
  }

  resetearFiltros() {
    Swal.fire({
      toast: true,
      position: "top-end",
      title: "Filtros",
      text: "¿Desea quitar los filtros?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí",
      cancelButtonText: "No",
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
    }).then((result) => {
      if (result.isConfirmed) {
        const filtroVencimiento = document.getElementById("filtro-vencimiento");
        const filtroEstado = document.getElementById("filtro-estado");
        const filtroAsesor = document.getElementById("filtro-asesor");
        const filtroMoneda = document.getElementById("filtro-moneda");

        if (filtroVencimiento) filtroVencimiento.value = "";
        if (filtroEstado) filtroEstado.value = "";
        if (filtroAsesor) filtroAsesor.value = "";
        if (filtroMoneda) filtroMoneda.value = "";

        this.renderizarTabla(this.dataOriginal);
      }
    });
  }
}
