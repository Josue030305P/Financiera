document.addEventListener('DOMContentLoaded', async () => {
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content || "";
    const tablaCronogramaBody = document.querySelector('#tabla-cronograma tbody');
    const inversionistaDisplay = document.getElementById('inversionista-display');
    const dniDisplay = document.getElementById('dni-display');
    const exportPdfButton = document.getElementById('pdf-export-button');

    const getIdContratoFromUrl = () => {
        const params = new URLSearchParams(window.location.search);
        return params.get('idcontrato');
    };

    const idContrato = getIdContratoFromUrl();

    if (!idContrato) {
        console.error("ID de contrato no encontrado en la URL.");
        tablaCronogramaBody.innerHTML = '<tr><td colspan="7">No se pudo cargar el cronograma de pagos. ID de contrato no especificado.</td></tr>';
        return;
    }

    try {
        const response = await fetch(`${baseUrl}/app/controllers/CronogramaPago.Controller.php?idcontrato=${idContrato}`);
        if (!response.ok) {
            throw new Error(`Error en la petición: ${response.statusText}`);
        }
        const result = await response.json();

        if (result.status === "success" && result.data.length > 0) {
            const cronogramaData = result.data;

            inversionistaDisplay.textContent = `${cronogramaData[0].nombre_inversionista} ${cronogramaData[0].apellido_inversionista}`;
            dniDisplay.textContent = `${cronogramaData[0].dni}`;
            
            tablaCronogramaBody.innerHTML = ''; 
            cronogramaData.forEach(item => {
                const row = tablaCronogramaBody.insertRow();
                row.insertCell().textContent = item.numcuota;
                row.insertCell().textContent = item.fechavencimiento;
                row.insertCell().textContent = `S/ ${parseFloat(item.totalneto).toFixed(2)}`;
                row.insertCell().textContent = `S/ ${parseFloat(item.amortizacion).toFixed(2)}`;
                row.insertCell().textContent = `S/ ${parseFloat(item.restante).toFixed(2)}`;
                
                const estadoCell = row.insertCell();
                const estadoText = document.createElement('span');
                estadoText.textContent = item.estado_pago;
                estadoText.classList.add('estado-pago', item.estado_pago.toLowerCase().replace(/\s/g, '-'));
                estadoCell.appendChild(estadoText);
            });

        } else {
            tablaCronogramaBody.innerHTML = '<tr><td colspan="7">No se encontraron datos para este cronograma de pagos.</td></tr>';
        }
    } catch (error) {
        console.error("Error al obtener el cronograma de pagos:", error);
        tablaCronogramaBody.innerHTML = '<tr><td colspan="7">Ocurrió un error al cargar los datos.</td></tr>';
    }

    exportPdfButton.addEventListener('click', () => {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        const table = document.getElementById('tabla-cronograma');
        
        const header = Array.from(table.querySelector('thead tr').children)
                            .map(th => th.textContent.trim());

        const body = Array.from(table.querySelectorAll('tbody tr')).map(row => {
            return Array.from(row.children).map(cell => cell.textContent.trim());
        });

        const inversionistaName = inversionistaDisplay.textContent;
        const dniNumber = dniDisplay.textContent;

        doc.setFontSize(16);
        doc.text("Cronograma de Pagos", 14, 20);
        doc.setFontSize(12);
        doc.text(`Inversionista: ${inversionistaName}`, 14, 30);
        doc.text(`DNI: ${dniNumber}`, 14, 37);

        doc.autoTable({
            head: [header],
            body: body,
            startY: 45,
            theme: 'striped',
            styles: { fontSize: 10, cellPadding: 2, overflow: 'linebreak' },
            headStyles: { fillColor: [41, 128, 185], textColor: 255, fontStyle: 'bold' },
            columnStyles: {
                0: { cellWidth: 15 },
                1: { cellWidth: 30 },
                2: { cellWidth: 25 },
                3: { cellWidth: 25 },
                4: { cellWidth: 25 },
                5: { cellWidth: 25 }
            }
        });

        doc.save(`cronogramapagos_${inversionistaName.replace(/\s/g, '_')}.pdf`);
    });
});