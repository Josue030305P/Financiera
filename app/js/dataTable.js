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

      window.dataTable = this;

      this.init();
  }

  init() {
      this.cargarDatos();
      this.initEventListeners();
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
      tbody.innerHTML = "";

      if (data && Array.isArray(data)) {
          data.forEach((item) => {
              const row = document.createElement("tr");
              row.className = "users-table-row";

              this.columnas.forEach((columna) => {
                  const td = document.createElement("td");
                  td.className = "td-item";

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
          console.error("Error: Los datos para renderizar la tabla no son un array o son undefined.", data);
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
          acciones+= `
              <a href="${this.baseUrl}app/views/inversionistas/inversionista.add?lead_id=${id}">
                  <button class="btn-addInversionista">
                      <img src="${this.baseUrl}app/img/svg/Bulk/3-User-white.svg" alt="Inversionista" class="icon-inversionista">
                  </button>
              </a>
          `;
      }

      if (this.tipo === 'contratos') {
         acciones = `
       
        <a href="#" onclick="window.dataTable.confirmarEliminacion(${id}); return false;">
            <img src="${this.baseUrl}app/img/svg/Bulk/Delete.svg" alt="Eliminar" class="delete-lead">
        </a>

          <a href="${this.baseUrl}app/views/cronograma-pagos/">
            <img src="${this.baseUrl}app/img/svg/Bulk/Paper-gray.svg" alt="Eliminar" class="ver-cronograma">
        </a>

    `;
      }

      return acciones;
  }

  async confirmarEliminacion(id) {
      const result = await Swal.fire({
          title: "¿Eliminar?",
          text: "¿Estás seguro de que deseas eliminar este registro?",
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
              {
                  method: "DELETE",
              }
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
      const searchInput = document.getElementById("searchInput");
      if (searchInput) {
          searchInput.addEventListener("input", (e) => {
              const searchTerm = e.target.value.toLowerCase();
              const rows = document.querySelectorAll(`#${this.tableId} tbody tr`);

              rows.forEach((row) => {
                  const text = row.textContent.toLowerCase();
                  row.style.display = text.includes(searchTerm) ? "" : "none";
              });
          });
      }
  }
}