document.addEventListener("DOMContentLoaded", () => {
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
        allData = data;
        renderizarTablaAgrupada(data);
    }

    function renderizarTablaAgrupada(data) {
        tablaCronogramaBody.innerHTML = "";
        const contratosAgrupados = agruparPorContrato(data);

        function crearCeldaTexto(fila, contenido) {
            const celda = fila.insertCell();
            celda.textContent = contenido;
            return celda;
        }

        function crearBotonPagarCuota(
            baseUrl,
            idcronogramaPago,
            idcontrato,
            estadoPago,
            numcuota,
            totalneto,
            restante
        ) {
            if (estadoPago && estadoPago.toLowerCase() === "pagado") {
                return null;
            }

            const btnPagarCuota = document.createElement("button");
            btnPagarCuota.className = "btn-pagar-cuota btn btn-sm btn-success";

            const icon = document.createElement('i');
            icon.className = 'fas fa-dollar-sign';
            btnPagarCuota.appendChild(icon);

            const textSpan = document.createElement('span');
            btnPagarCuota.appendChild(textSpan);

            btnPagarCuota.dataset.idcontrato = idcontrato;

            btnPagarCuota.addEventListener('click', () => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `${baseUrl}app/views/detallepagos/detallepago.add`;
                form.style.display = 'none';

                const inputIdCronograma = document.createElement('input');
                inputIdCronograma.type = 'hidden';
                inputIdCronograma.name = 'idcronograma';
                inputIdCronograma.value = idcronogramaPago;
                form.appendChild(inputIdCronograma);

                const inputIdContrato = document.createElement('input');
                inputIdContrato.type = 'hidden';
                inputIdContrato.name = 'idcontrato';
                inputIdContrato.value = idcontrato;
                form.appendChild(inputIdContrato);

                const inputNumCuota = document.createElement('input');
                inputNumCuota.type = 'hidden';
                inputNumCuota.name = 'numcuota';
                inputNumCuota.value = numcuota;
                form.appendChild(inputNumCuota);

                const inputTotalNeto = document.createElement('input');
                inputTotalNeto.type = 'hidden';
                inputTotalNeto.name = 'totalneto';
                inputTotalNeto.value = totalneto;
                form.appendChild(inputTotalNeto);

                const inputRestante = document.createElement('input');
                inputRestante.type = 'hidden';
                inputRestante.name = 'restante';
                inputRestante.value = restante;
                form.appendChild(inputRestante);

                document.body.appendChild(form);
                form.submit();
            });

            return btnPagarCuota;
        }

        for (const contratoId in contratosAgrupados) {
            const pagosContrato = contratosAgrupados[contratoId];

            if (pagosContrato.length > 0) {
                const primeraFila = pagosContrato[0];

                const grupoRow = tablaCronogramaBody.insertRow();
                grupoRow.classList.add("grupo-contrato");
                grupoRow.dataset.contratoId = contratoId;

                crearCeldaTexto(grupoRow, primeraFila.idcontrato);
                crearCeldaTexto(grupoRow, pagosContrato.length + " pagos");
                crearCeldaTexto(grupoRow, calcularTotalBruto(pagosContrato).toFixed(2));
                crearCeldaTexto(
                    grupoRow,
                    `${primeraFila.nombre_inversionista} ${primeraFila.apellido_inversionista}`
                );
                crearCeldaTexto(grupoRow, primeraFila.dni);
                crearCeldaTexto(grupoRow, primeraFila.numcuota);
                crearCeldaTexto(grupoRow, primeraFila.fechavencimiento);
                crearCeldaTexto(grupoRow, primeraFila.totalneto);
                crearCeldaTexto(grupoRow, primeraFila.amortizacion);
                crearCeldaTexto(grupoRow, primeraFila.restante);

                const estadoCellGrupo = crearCeldaTexto(
                    grupoRow,
                    primeraFila.estado_pago
                );
                estadoCellGrupo.classList.add(
                    `estado-${primeraFila.estado_pago.toLowerCase()}`
                );

                const accionesCellGrupo = grupoRow.insertCell();
                accionesCellGrupo.classList.add("acciones-cell");
                const botonesContainerGrupo = document.createElement("div");
                botonesContainerGrupo.className = "botones-accion";
                botonesContainerGrupo.style.display = "flex";
                botonesContainerGrupo.style.gap = "4px"; // Reducido el gap para más espacio
                botonesContainerGrupo.style.justifyContent = "center";

                const btnExpandir = document.createElement("button");
                btnExpandir.className = "btn-expandir btn btn-sm btn-secondary";
                const iconExpand = document.createElement('i');
                iconExpand.className = 'fas fa-plus';
                btnExpandir.appendChild(iconExpand);

                const btnExcel = document.createElement("button");
                btnExcel.className = "btn-exportar-excel btn btn-sm btn-info";
                btnExcel.dataset.contratoId = contratoId;
                const iconExcel = document.createElement('i');
                iconExcel.className = 'fas fa-file-excel';
                btnExcel.appendChild(iconExcel);
                // No se necesita textSpanExcel si solo se mostrará el icono

                // Nuevo botón para ver cronograma completo del contrato
                const btnVerCronograma = document.createElement("button");
                btnVerCronograma.className = "btn-ver-cronograma btn btn-sm btn-primary";
                btnVerCronograma.dataset.contratoId = contratoId;
                const iconVerCronograma = document.createElement('i');
                iconVerCronograma.className = 'fas fa-calendar-alt'; // Icono de calendario o lista
                btnVerCronograma.appendChild(iconVerCronograma);
                btnVerCronograma.title = "Ver Cronograma Completo"; // Tooltip
                btnVerCronograma.addEventListener('click', () => {
                    // Redirige a la página de cronograma con el ID del contrato
                    window.location.href = `${baseUrl}app/views/cronograma/index.php?idcontrato=${contratoId}`;
                });


                // Nuevo botón para ver el historial de pagos
                const btnHistorialPagos = document.createElement("button");
                btnHistorialPagos.className = "btn-historial-pagos btn btn-sm btn-dark"; // Usamos btn-dark para diferenciar
                btnHistorialPagos.dataset.contratoId = contratoId;
                const iconHistorialPagos = document.createElement('i');
                iconHistorialPagos.className = 'fas fa-history'; // Icono de historial o detalles
                btnHistorialPagos.appendChild(iconHistorialPagos);
                btnHistorialPagos.title = "Ver Historial de Pagos"; // Tooltip
                btnHistorialPagos.addEventListener('click', () => {
                    // Redirige a la página de historial de pagos con el ID del contrato
                    window.location.href = `${baseUrl}app/views/historialpagos/index.php?idcontrato=${contratoId}`;
                });


                const btnPagarGrupo = crearBotonPagarCuota(
                    baseUrl,
                    primeraFila.idcronogramapago,
                    primeraFila.idcontrato,
                    primeraFila.estado_pago,
                    primeraFila.numcuota,
                    primeraFila.totalneto,
                    primeraFila.restante
                );

                botonesContainerGrupo.appendChild(btnExpandir);
                botonesContainerGrupo.appendChild(btnExcel);
                botonesContainerGrupo.appendChild(btnVerCronograma); // Añadir el nuevo botón
                botonesContainerGrupo.appendChild(btnHistorialPagos); // Añadir el nuevo botón
                if (btnPagarGrupo) {
                    botonesContainerGrupo.appendChild(btnPagarGrupo);
                }
                accionesCellGrupo.appendChild(botonesContainerGrupo);

                for (let i = 1; i < pagosContrato.length; i++) {
                    const pago = pagosContrato[i];

                    const detalleRow = tablaCronogramaBody.insertRow();
                    detalleRow.classList.add("detalle-pago");
                    detalleRow.dataset.contratoId = contratoId;
                    detalleRow.style.display = "none";

                    crearCeldaTexto(detalleRow, pago.idcontrato);
                    crearCeldaTexto(detalleRow, "");
                    crearCeldaTexto(detalleRow, "");
                    crearCeldaTexto(
                        detalleRow,
                        `${pago.nombre_inversionista} ${pago.apellido_inversionista}`
                    );
                    crearCeldaTexto(detalleRow, pago.dni);
                    crearCeldaTexto(detalleRow, pago.numcuota);
                    crearCeldaTexto(detalleRow, pago.fechavencimiento);
                    crearCeldaTexto(detalleRow, pago.totalneto);
                    crearCeldaTexto(detalleRow, pago.amortizacion);
                    crearCeldaTexto(detalleRow, pago.restante);

                    const estadoDetalleCell = crearCeldaTexto(
                        detalleRow,
                        pago.estado_pago
                    );
                    estadoDetalleCell.classList.add(
                        `estado-${pago.estado_pago.toLowerCase()}`
                    );

                    const accionesDetalleCell = detalleRow.insertCell();
                    const btnPagarDetalle = crearBotonPagarCuota(
                        baseUrl,
                        pago.idcronogramapago,
                        pago.idcontrato,
                        pago.estado_pago,
                        pago.numcuota,
                        pago.totalneto,
                        pago.restante
                    );

                    if (btnPagarDetalle) {
                        accionesDetalleCell.appendChild(btnPagarDetalle);
                    }
                }
            }
        }

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
                const icon = this.querySelector('i');
                if (icon) {
                    icon.className = icon.className === 'fas fa-plus' ? 'fas fa-minus' : 'fas fa-plus';
                }
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
        let dataToExport = [...allData];

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
            const workbook = XLSX.utils.book_new();
            const worksheet = XLSX.utils.aoa_to_sheet(excelData);

            worksheet["!cols"] = [
                { wch: 15 },
                { wch: 30 },
                { wch: 15 },
                { wch: 10 },
                { wch: 15 },
                { wch: 15 },
                { wch: 15 },
                { wch: 15 },
                { wch: 15 },
            ];

            XLSX.utils.book_append_sheet(workbook, worksheet, "Cronograma");

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
                    mensajeSinResults.textContent =
                        "Error al cargar los datos. Por favor, intente de nuevo.";
                    mensajeSinResults.style.display = "block";
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
                if (!mensajeSinResults) {
                    mensajeSinResults = document.createElement("p");
                    mensajeSinResults.id = "mensaje-sin-resultados";
                    mensajeSinResults.style.textAlign = "center";
                    mensajeSinResults.style.marginTop = "20px";
                    mensajeSinResults.textContent =
                        "Error al cargar los datos. Por favor, intente de nuevo.";
                    tablaCronogramaBody.parentNode.insertBefore(
                        mensajeSinResults,
                        tablaCronogramaBody.nextSibling
                    );
                } else {
                    mensajeSinResults.textContent =
                        "Error al cargar los datos. Por favor, intente de nuevo.";
                    mensajeSinResults.style.display = "block";
                }
            });
    });

    fetch(`${baseUrl}app/controllers/CronogramaPago.Controller.php`)

        .then((response) => response.json())
        .then((data) => {
            actualizarTabla(data.data);
        })
        .catch((error) => {
            console.error("Error al cargar los datos iniciales:", error);
        });
});






// document.addEventListener("DOMContentLoaded", () => {
//   const baseUrl =
//     document.querySelector('meta[name="base-url"]')?.content || "";
//   const tablaCronogramaBody = document.querySelector("#tabla-cronograma tbody");
//   const btnFiltrar = document.getElementById("btn-filtrar");
//   const btnLimpiarFiltro = document.getElementById("btn-limpiar-filtro");
//   const filtroEstado = document.getElementById("filtro-estado");
//   const filtroIdContrato = document.getElementById("filtro-id-contrato");
//   const filtroDni = document.getElementById("filtro-dni");

//   let allData = [];
//   function actualizarTabla(data) {
//     allData = data; // Almacena los datos
//     renderizarTablaAgrupada(data);
//   }

//   function renderizarTablaAgrupada(data) {
//     tablaCronogramaBody.innerHTML = "";
//     const contratosAgrupados = agruparPorContrato(data);

//     // Función auxiliar para crear y añadir texto a una celda
//     function crearCeldaTexto(fila, contenido) {
//       const celda = fila.insertCell();
//       celda.textContent = contenido;
//       return celda;
//     }
//     function crearBotonPagarCuota(
//       baseUrl,
//       idcronogramaPago,
//       idcontrato,
//       estadoPago,
//       numcuota,
//       totalneto,
//       restante
//     ) {
//       if (estadoPago && estadoPago.toLowerCase() === "pagado") {
//         return null; // No retorna nada si ya está pagado
//       }

//       const btnPagarCuota = document.createElement("button");
//       btnPagarCuota.className = "btn-pagar-cuota";
//       btnPagarCuota.textContent = `Pagar cuota ${numcuota}`; // Mostrar qué cuota es
//       btnPagarCuota.dataset.idcontrato = idcontrato;

//       const btnEnlace = document.createElement("a");
//       btnEnlace.href = `${baseUrl}app/views/detallepagos/detallepago.add?idcronograma=${idcronogramaPago}&idcontrato=${idcontrato}&numcuota=${numcuota}&totalneto=${encodeURIComponent(
//         totalneto
//       )}&restante=${encodeURIComponent(restante)}`;
//       btnEnlace.appendChild(btnPagarCuota);
//       return btnEnlace;
//     }

//     for (const contratoId in contratosAgrupados) {
//       const pagosContrato = contratosAgrupados[contratoId];

//       if (pagosContrato.length > 0) {
//         const primeraFila = pagosContrato[0];

//         // Fila de grupo (encabezado)
//         const grupoRow = tablaCronogramaBody.insertRow();
//         grupoRow.classList.add("grupo-contrato");
//         grupoRow.dataset.contratoId = contratoId;

//         crearCeldaTexto(grupoRow, primeraFila.idcontrato);
//         crearCeldaTexto(grupoRow, pagosContrato.length + " pagos");
//         crearCeldaTexto(grupoRow, calcularTotalBruto(pagosContrato).toFixed(2));
//         crearCeldaTexto(
//           grupoRow,
//           `${primeraFila.nombre_inversionista} ${primeraFila.apellido_inversionista}`
//         );
//         crearCeldaTexto(grupoRow, primeraFila.dni);
//         crearCeldaTexto(grupoRow, primeraFila.numcuota);
//         crearCeldaTexto(grupoRow, primeraFila.fechavencimiento);
//         crearCeldaTexto(grupoRow, primeraFila.totalneto);
//         crearCeldaTexto(grupoRow, primeraFila.amortizacion);
//         crearCeldaTexto(grupoRow, primeraFila.restante);

//         const estadoCellGrupo = crearCeldaTexto(
//           grupoRow,
//           primeraFila.estado_pago
//         );
//         estadoCellGrupo.classList.add(
//           `estado-${primeraFila.estado_pago.toLowerCase()}`
//         );

//         // Celda de acciones para la fila de grupo
//         const accionesCellGrupo = grupoRow.insertCell();
//         accionesCellGrupo.classList.add("acciones-cell");
//         const botonesContainerGrupo = document.createElement("div");
//         botonesContainerGrupo.className = "botones-accion";
//         botonesContainerGrupo.style.display = "flex";
//         botonesContainerGrupo.style.gap = "8px";
//         botonesContainerGrupo.style.justifyContent = "flex-end";

//         const btnExpandir = document.createElement("button");
//         btnExpandir.className = "btn-expandir";
//         btnExpandir.textContent = "+";

//         const btnExcel = document.createElement("button");
//         btnExcel.className = "btn-exportar-excel";
//         btnExcel.dataset.contratoId = contratoId;
//         btnExcel.textContent = "Excel";

//         // Pasamos el estado de pago a la función crearBotonPagarCuota

//         const btnEnlaceGrupo = crearBotonPagarCuota(
//           baseUrl,
//           primeraFila.idcronogramapago,
//           primeraFila.idcontrato,
//           primeraFila.estado_pago,
//           primeraFila.numcuota,
//           primeraFila.totalneto,
//           primeraFila.restante
//         );

//         // const btnEnlaceGrupo = crearBotonPagarCuota(
//         //   baseUrl,
//         //   primeraFila.idcronogramapago,
//         //   primeraFila.idcontrato,
//         //   primeraFila.estado_pago // <--- AQUÍ se pasa el estado
//         // );

//         botonesContainerGrupo.appendChild(btnExpandir);
//         botonesContainerGrupo.appendChild(btnExcel);
//         // Solo añadimos el botón si no es nulo (es decir, si el pago no está 'Pagado')
//         if (btnEnlaceGrupo) {
//           botonesContainerGrupo.appendChild(btnEnlaceGrupo);
//         }
//         accionesCellGrupo.appendChild(botonesContainerGrupo);

//         // Filas de detalle (ocultas inicialmente)
//         for (let i = 1; i < pagosContrato.length; i++) {
//           const pago = pagosContrato[i];

//           const detalleRow = tablaCronogramaBody.insertRow();
//           detalleRow.classList.add("detalle-pago");
//           detalleRow.dataset.contratoId = contratoId;
//           detalleRow.style.display = "none";

//           crearCeldaTexto(detalleRow, pago.idcontrato);
//           crearCeldaTexto(detalleRow, ""); // Celda vacía para alineación
//           crearCeldaTexto(detalleRow, ""); // Celda vacía para alineación
//           crearCeldaTexto(
//             detalleRow,
//             `${pago.nombre_inversionista} ${pago.apellido_inversionista}`
//           );
//           crearCeldaTexto(detalleRow, pago.dni);
//           crearCeldaTexto(detalleRow, pago.numcuota);
//           crearCeldaTexto(detalleRow, pago.fechavencimiento);
//           crearCeldaTexto(detalleRow, pago.totalneto);
//           crearCeldaTexto(detalleRow, pago.amortizacion);
//           crearCeldaTexto(detalleRow, pago.restante);

//           const estadoDetalleCell = crearCeldaTexto(
//             detalleRow,
//             pago.estado_pago
//           );
//           estadoDetalleCell.classList.add(
//             `estado-${pago.estado_pago.toLowerCase()}`
//           );

//           const accionesDetalleCell = detalleRow.insertCell();
//           // Pasamos el estado de pago a la función crearBotonPagarCuota
//           const btnEnlaceDetalle = crearBotonPagarCuota(
//   baseUrl,
//   pago.idcronogramapago,
//   pago.idcontrato,
//   pago.estado_pago,
//   pago.numcuota,
//   pago.totalneto,
//   pago.restante
// );

//           // Solo añadimos el botón si no es nulo
//           if (btnEnlaceDetalle) {
//             accionesDetalleCell.appendChild(btnEnlaceDetalle);
//           }
//         }
//       }
//     }

//     // Listeners para expandir/contraer y exportar a Excel (estos no cambian)
//     document.querySelectorAll(".btn-expandir").forEach((button) => {
//       button.addEventListener("click", function () {
//         const contratoId = this.closest(".grupo-contrato").dataset.contratoId;
//         const detalleRows = document.querySelectorAll(
//           `.detalle-pago[data-contrato-id="${contratoId}"]`
//         );
//         detalleRows.forEach((row) => {
//           row.style.display =
//             row.style.display === "none" ? "table-row" : "none";
//         });
//         this.textContent = this.textContent === "+" ? "-" : "+";
//       });
//     });

//     document.querySelectorAll(".btn-exportar-excel").forEach((button) => {
//       button.addEventListener("click", function () {
//         const contratoId = this.dataset.contratoId;
//         exportarExcel(contratoId);
//       });
//     });
//   }

//   function agruparPorContrato(data) {
//     const contratosAgrupados = {};
//     data.forEach((pago) => {
//       if (!contratosAgrupados[pago.idcontrato]) {
//         contratosAgrupados[pago.idcontrato] = [];
//       }
//       contratosAgrupados[pago.idcontrato].push(pago);
//     });
//     return contratosAgrupados;
//   }

//   function calcularTotalBruto(pagos) {
//     let total = 0;
//     pagos.forEach((pago) => {
//       total += parseFloat(pago.totalneto);
//     });
//     return total;
//   }

//   function exportarExcel(contratoId = null) {
//     let dataToExport = [...allData]; // Usa una copia de los datos

//     // Verificar si hay datos para exportar
//     if (dataToExport.length === 0) {
//       Swal.fire({
//         icon: "warning",
//         title: "No hay datos para exportar",
//         text: "No se encontraron registros en el cronograma.",
//         confirmButtonText: "Entendido",
//       });
//       return;
//     }

//     if (contratoId) {
//       dataToExport = dataToExport.filter(
//         (pago) => pago.idcontrato == contratoId
//       );

//       if (dataToExport.length === 0) {
//         Swal.fire({
//           icon: "warning",
//           title: "No hay datos para exportar",
//           text: `No se encontraron pagos para el contrato ${contratoId}.`,
//           confirmButtonText: "Entendido",
//         });
//         return;
//       }
//     }

//     const excelData = [
//       // Encabezados
//       [
//         "ID Contrato",
//         "Inversionista",
//         "DNI",
//         "Cuota #",
//         "Fecha Vencimiento",
//         "Total Neto",
//         "Amortización",
//         "Restante",
//         "Estado",
//       ],
//     ];

//     // Agregar los datos de cada pago
//     dataToExport.forEach((pago) => {
//       excelData.push([
//         pago.idcontrato,
//         `${pago.nombre_inversionista} ${pago.apellido_inversionista}`,
//         pago.dni,
//         pago.numcuota,
//         pago.fechavencimiento,
//         pago.totalneto,
//         pago.amortizacion,
//         pago.restante,
//         pago.estado_pago,
//       ]);
//     });

//     try {
//       // Crear el Excel
//       const workbook = XLSX.utils.book_new();
//       const worksheet = XLSX.utils.aoa_to_sheet(excelData);

//       // Ajustar el ancho de las columnas
//       worksheet["!cols"] = [
//         { wch: 15 }, // ID Contrato
//         { wch: 30 }, // Inversionista
//         { wch: 15 }, // DNI
//         { wch: 10 }, // Cuota #
//         { wch: 15 }, // Fecha Vencimiento
//         { wch: 15 }, // Total Neto
//         { wch: 15 }, // Amortización
//         { wch: 15 }, // Restante
//         { wch: 15 }, // Estado
//       ];

//       XLSX.utils.book_append_sheet(workbook, worksheet, "Cronograma");

//       // Generar el archivo Excel
//       const filename = contratoId
//         ? `Cronograma_Contrato_${contratoId}.xlsx`
//         : "Cronograma_Completo.xlsx";

//       XLSX.writeFile(workbook, filename);
//     } catch (error) {
//       console.error("Error al generar el Excel:", error);
//       Swal.fire({
//         icon: "error",
//         title: "Error al exportar",
//         text: "Ocurrió un error al generar el archivo Excel.",
//         confirmButtonText: "Entendido",
//       });
//     }
//   }

//   btnFiltrar.addEventListener("click", function () {
//     const estado = filtroEstado.value;
//     const idContrato = filtroIdContrato.value;
//     const dni = filtroDni.value;

//     const params = new URLSearchParams();
//     if (estado) params.append("estado", estado);
//     if (idContrato) params.append("idcontrato", idContrato);
//     if (dni) params.append("dni", dni);

//     const url = `${baseUrl}app/controllers/CronogramaPago.Controller.php?${params.toString()}`;
//     const tablaCronogramaBody = document.querySelector(
//       "#tabla-cronograma tbody"
//     );
//     let mensajeSinResultados = document.getElementById(
//       "mensaje-sin-resultados"
//     );

//     fetch(url)
//       .then((response) => {
//         if (!response.ok) {
//           throw new Error("Error en la respuesta de la red");
//         }
//         return response.json();
//       })
//       .then((data) => {
//         if (data && data.data && data.data.length > 0) {
//           actualizarTabla(data.data);
//           tablaCronogramaBody.style.display = "";
//           // Eliminar el mensaje si existe
//           if (mensajeSinResultados) {
//             mensajeSinResultados.remove();
//           }
//         } else {
//           tablaCronogramaBody.innerHTML = "";
//           tablaCronogramaBody.style.display = "none";
//           if (!mensajeSinResultados) {
//             mensajeSinResultados = document.createElement("p");
//             mensajeSinResultados.id = "mensaje-sin-resultados";
//             mensajeSinResultados.style.textAlign = "center";
//             mensajeSinResultados.style.marginTop = "20px";
//             mensajeSinResultados.style.marginBottom = "20px";
//             mensajeSinResultados.textContent =
//               "No se encontraron resultados para los filtros aplicados.";
//             tablaCronogramaBody.parentNode.insertBefore(
//               mensajeSinResultados,
//               tablaCronogramaBody.nextSibling
//             );
//           } else {
//             mensajeSinResultados.textContent =
//               "No se encontraron resultados para los filtros aplicados.";
//             mensajeSinResultados.style.display = "block";
//           }
//         }
//       })
//       .catch((error) => {
//         console.error("Error al filtrar los datos:", error);
//         tablaCronogramaBody.innerHTML = "";
//         tablaCronogramaBody.style.display = "none";
//         let mensajeSinResultados = document.getElementById(
//           "mensaje-sin-resultados"
//         );
//         if (!mensajeSinResultados) {
//           mensajeSinResultados = document.createElement("p");
//           mensajeSinResultados.id = "mensaje-sin-resultados";
//           mensajeSinResultados.style.textAlign = "center";
//           mensajeSinResultados.style.marginTop = "20px";
//           mensajeSinResultados.textContent =
//             "Error al cargar los datos. Por favor, intente de nuevo.";
//           tablaCronogramaBody.parentNode.insertBefore(
//             mensajeSinResultados,
//             tablaCronogramaBody.nextSibling
//           );
//         } else {
//           mensajeSinResultados.textContent =
//             "Error al cargar los datos. Por favor, intente de nuevo.";
//           mensajeSinResultados.style.display = "block";
//         }
//       });
//   });

//   btnLimpiarFiltro.addEventListener("click", function () {
//     filtroEstado.value = "";
//     filtroIdContrato.value = "";
//     filtroDni.value = "";

//     const tablaCronogramaBody = document.querySelector(
//       "#tabla-cronograma tbody"
//     );
//     const mensajeSinResultados = document.getElementById(
//       "mensaje-sin-resultados"
//     );

//     // Recargar todos los datos
//     fetch(`${baseUrl}app/controllers/CronogramaPago.Controller.php`)
//       .then((response) => {
//         if (!response.ok) {
//           throw new Error("Error en la respuesta de la red");
//         }
//         return response.json();
//       })
//       .then((data) => {
//         actualizarTabla(data.data);
//         tablaCronogramaBody.style.display = "";

//         if (mensajeSinResultados) {
//           mensajeSinResultados.remove();
//         }
//       })
//       .catch((error) => {
//         console.error("Error al cargar los datos:", error);
//         tablaCronogramaBody.innerHTML = "";
//         tablaCronogramaBody.style.display = "none";
//         let mensajeSinResultados = document.getElementById(
//           "mensaje-sin-resultados"
//         );
//         if (!mensajeSinResultados) {
//           mensajeSinResultados = document.createElement("p");
//           mensajeSinResultados.id = "mensaje-sin-resultados";
//           mensajeSinResultados.style.textAlign = "center";
//           mensajeSinResultados.style.marginTop = "20px";
//           mensajeSinResultados.textContent =
//             "Error al cargar los datos. Por favor, intente de nuevo.";
//           tablaCronogramaBody.parentNode.insertBefore(
//             mensajeSinResultados,
//             tablaCronogramaBody.nextSibling
//           );
//         } else {
//           mensajeSinResultados.textContent =
//             "Error al cargar los datos. Por favor, intente de nuevo.";
//           mensajeSinResultados.style.display = "block";
//         }
//       });
//   });

//   // Cargar los datos iniciales al cargar la página
//   fetch(`${baseUrl}app/controllers/CronogramaPago.Controller.php`)
//     .then((response) => response.json())
//     .then((data) => {
//       actualizarTabla(data.data);
//     })
//     .catch((error) => {
//       console.error("Error al cargar los datos iniciales:", error);
//     });
// });
