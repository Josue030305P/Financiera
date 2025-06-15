// (() => {
//     console.log("leadsFiltros.js - Script iniciado.");
//     const dataTableInstance = window.dataTable; 

//     if (dataTableInstance) {
//         console.log("leadsFiltros.js - dataTableInstance encontrado.", dataTableInstance); // Muestra la instancia completa

//         // Función para poblar el select de asesores
//         dataTableInstance.popularFiltroAsesor = function() {
//             console.log("popularFiltroAsesor ejecutado.");
//             const filtroAsesorSelect = document.getElementById("filtro-asesor-lead");
            
//             // **IMPORTANTE:** Log para verificar si el select se encuentra
//             if (!filtroAsesorSelect) {
//                 console.error("ERROR: Elemento SELECT con ID 'filtro-asesor-lead' NO ENCONTRADO en el DOM. Asegúrate de que el HTML esté correcto.");
//                 return;
//             } else {
//                 console.log("Elemento SELECT 'filtro-asesor-lead' encontrado:", filtroAsesorSelect);
//             }

//             // Limpiar opciones existentes (excepto "Todos")
//             filtroAsesorSelect.innerHTML = '<option value="">Todos</option>';

//             // Recoger nombres de asesores únicos de los datos originales
//             const asesoresUnicos = new Set();
//             console.log("popularFiltroAsesor - dataOriginal:", this.dataOriginal);
//             console.log("popularFiltroAsesor - dataOriginal length:", this.dataOriginal.length); // <--- NUEVO LOG
//             if (this.dataOriginal && Array.isArray(this.dataOriginal)) {
//                 this.dataOriginal.forEach(lead => {
//                     try { // <--- NUEVO BLOQUE TRY-CATCH
//                         const asesorNombre = this.obtenerValorCampo(lead, 'Asesor');
//                         console.log("Procesando Lead (ID:", lead.idlead, "): -> Asesor obtenido:", asesorNombre); // Log por cada lead
//                         if (asesorNombre && asesorNombre !== "NO ASIGNADO" && asesorNombre.trim() !== "") {
//                             asesoresUnicos.add(asesorNombre);
//                         }
//                     } catch (e) {
//                         console.error("Error al obtener asesor para el lead:", lead, "Error:", e); // <--- NUEVO LOG DE ERROR
//                     }
//                 });
//             } else {
//                 console.warn("this.dataOriginal no es un array o está vacío en popularFiltroAsesor. No se cargarán asesores.");
//             }
            
//             console.log("Asesores únicos recopilados:", asesoresUnicos); // Muestra el Set de asesores

//             // Ordenar alfabéticamente y añadir al select
//             Array.from(asesoresUnicos).sort().forEach(asesor => {
//                 const option = document.createElement("option");
//                 option.value = asesor;
//                 option.textContent = asesor;
//                 filtroAsesorSelect.appendChild(option);
//             });
//             console.log("Filtro de asesores populado (si hay datos).");
//         };

//         // Sobrescribir el método cargarDatos para popular el filtro de asesor después de cargar
//         const originalCargarDatos = dataTableInstance.cargarDatos;
//         dataTableInstance.cargarDatos = async function() {
//             console.log("leadsFiltros - Sobreescribiendo cargarDatos. Llamando al original...");
//             await originalCargarDatos.apply(this); // Llama al método original para cargar datos
//             console.log("leadsFiltros - originalCargarDatos completado.");
//             if (this.tipo === "leads") {
//                 console.log("leadsFiltros - Es tipo 'leads'. Llamando a popularFiltroAsesor...");
//                 this.popularFiltroAsesor();
//             } else {
//                 console.log("leadsFiltros - No es tipo 'leads'. No se llama a popularFiltroAsesor.");
//             }
//         };

//         // Asignar el método de filtrado directamente a la instancia de dataTable
//         dataTableInstance.filtrarLeads = function () {
//             let datosFiltrados = [...this.dataOriginal];
//             const filtroPrioridad = document.getElementById("filtro-estado-lead")?.value;
//             const filtroAsesor = document.getElementById("filtro-asesor-lead")?.value;

//             if (filtroPrioridad) {
//                 datosFiltrados = datosFiltrados.filter(lead => {
//                     const prioridadDelLead = this.obtenerValorCampo(lead, 'Prioridad');
//                     return prioridadDelLead && prioridadDelLead.toLowerCase() === filtroPrioridad.toLowerCase();
//                 });
//             }

//             if (filtroAsesor) {
//                 datosFiltrados = datosFiltrados.filter(lead => {
//                     const asesorDelLead = this.obtenerValorCampo(lead, 'Asesor');
//                     return asesorDelLead && asesorDelLead.toLowerCase() === filtroAsesor.toLowerCase();
//                 });
//             }

//             this.renderizarTabla(datosFiltrados);
//         };

//         // Asignar el método para resetear filtros
//         dataTableInstance.resetearFiltrosLeads = function () {
//             const filtroPrioridadSelect = document.getElementById("filtro-estado-lead");
//             if (filtroPrioridadSelect) {
//                 filtroPrioridadSelect.value = ""; 
//             }
//             const filtroAsesorSelect = document.getElementById("filtro-asesor-lead");
//             if (filtroAsesorSelect) {
//                 filtroAsesorSelect.value = ""; 
//             }
//             this.renderizarTabla(this.dataOriginal); 
//         };

//         // Inicializar los listeners de eventos para los botones de filtro
//         dataTableInstance.initLeadFilterEventListeners = function() {
//             const aplicarFiltrosLeadBtn = document.getElementById("aplicar-filtros-lead");
//             if (aplicarFiltrosLeadBtn) {
//                 aplicarFiltrosLeadBtn.addEventListener("click", this.filtrarLeads.bind(this));
//             }

//             const resetearFiltrosLeadBtn = document.getElementById("resetear-filtros-lead");
//             if (resetearFiltrosLeadBtn) {
//                 resetearFiltrosLeadBtn.addEventListener("click", this.resetearFiltrosLeads.bind(this));
//             }
//         };

//         // Llamar a la inicialización de los listeners del filtro de Leads
//         if (dataTableInstance.tipo === "leads") {
//             dataTableInstance.initLeadFilterEventListeners();
//         }
        
//     } else {
//         console.warn("DataTable instance not found. Make sure DataTable class is loaded and initialized before this script.");
//     }
// })();