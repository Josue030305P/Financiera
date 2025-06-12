document.addEventListener('DOMContentLoaded', async () => {
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content || "";
    const tablaHistorialBody = document.querySelector('#tabla-historial-pagos tbody');
    const inversionistaNombreSpan = document.getElementById('inversionista-nombre');
    const inversionistaDniSpan = document.getElementById('inversionista-dni');
    const contratoIdSpan = document.getElementById('contrato-id');
    const mensajeSinHistorial = document.getElementById('mensaje-sin-historial');
    const exportPdfButton = document.getElementById('export-pdf-historial');

    const comprobanteModal = document.getElementById('comprobanteModal');
    const modalComprobanteImage = document.getElementById('modalComprobanteImage');
    const closeButton = document.querySelector('.close-button');
    const modalContent = comprobanteModal.querySelector('.modal-content');

    const urlParams = new URLSearchParams(window.location.search);
    const idContrato = urlParams.get('idcontrato');

    if (!idContrato) {
        tablaHistorialBody.innerHTML = '<tr><td colspan="10">ID de contrato no especificado en la URL.</td></tr>';
        mensajeSinHistorial.style.display = 'block';
        return;
    }

    let historialData = [];

    try {
        const response = await fetch(`${baseUrl}app/controllers/DetallePagoController?idcontrato=${idContrato}`);
        if (!response.ok) throw new Error(`Error al cargar los datos: ${response.statusText}`);

        const result = await response.json();

        if (result.status) {
            historialData = result.data;

            if (historialData.length > 0) {
                inversionistaNombreSpan.textContent = historialData[0].inversionsita;
                inversionistaDniSpan.textContent = historialData[0].dni;
                contratoIdSpan.textContent = historialData[0].idcontrato;
            } else {
                inversionistaNombreSpan.textContent = 'N/A';
                inversionistaDniSpan.textContent = 'N/A';
                contratoIdSpan.textContent = 'N/A';
            }

            tablaHistorialBody.innerHTML = '';
            historialData.forEach(pago => {
                const row = tablaHistorialBody.insertRow();
                row.insertCell().textContent = pago.ncuota;
                row.insertCell().textContent = `S/ ${parseFloat(pago.montopagado).toFixed(2)}`;
                row.insertCell().textContent = `S/ ${parseFloat(pago.totalcuota).toFixed(2)}`;
                row.insertCell().textContent = pago.fechapago;
                row.insertCell().textContent = pago.cuentadepositada;
                row.insertCell().textContent = pago.entidad;
                row.insertCell().textContent = pago.ntransaccion;
                row.insertCell().textContent = pago.observaciones || 'N/A';

                const estadoCell = row.insertCell();
                const estadoSpan = document.createElement('span');
                estadoSpan.textContent = pago.estado_cuota;
                estadoSpan.classList.add('estado-cuota', pago.estado_cuota.toLowerCase().replace(/\s/g, '-'));
                estadoCell.appendChild(estadoSpan);

                const comprobanteCell = row.insertCell();
                if (pago.comprobante) {
                    const viewButton = document.createElement('button');
                    viewButton.textContent = 'Ver Comprobante';
                    viewButton.classList.add('btn', 'btn-info', 'btn-sm');
                    Object.assign(viewButton.style, {
                        fontSize: '0.75rem',
                        padding: '0.25rem 0.5rem',
                        whiteSpace: 'nowrap',
                        display: 'inline-flex',
                        alignItems: 'center',
                        gap: '5px'
                    });

                    const icon = document.createElement('i');
                    icon.classList.add('fas', 'fa-eye');
                    viewButton.prepend(icon);

                    viewButton.addEventListener('click', (event) => {
                        event.stopPropagation();
                        modalComprobanteImage.src = `${baseUrl}public/${pago.comprobante}`;
                        comprobanteModal.style.display = 'flex';
                    });
                    comprobanteCell.appendChild(viewButton);
                } else {
                    comprobanteCell.textContent = 'N/A';
                }
            });
            mensajeSinHistorial.style.display = 'none';
        } else {
            tablaHistorialBody.innerHTML = '<tr><td colspan="10">No se encontraron pagos para este contrato.</td></tr>';
            mensajeSinHistorial.style.display = 'block';
        }
    } catch (error) {
        console.error("Error al cargar el historial de pagos:", error);
        tablaHistorialBody.innerHTML = '<tr><td colspan="10">Ocurrió un error al cargar los datos del historial.</td></tr>';
        mensajeSinHistorial.textContent = 'Error al cargar los datos. Por favor, intente de nuevo más tarde.';
        mensajeSinHistorial.style.display = 'block';
    }

    closeButton.addEventListener('click', () => {
        comprobanteModal.style.display = 'none';
        modalComprobanteImage.src = '';
    });

    document.addEventListener('click', (event) => {
        if (comprobanteModal.style.display === 'flex' && modalContent && !modalContent.contains(event.target) && event.target !== closeButton) {
            comprobanteModal.style.display = 'none';
            modalComprobanteImage.src = '';
        }
    });

    exportPdfButton.addEventListener('click', async () => {
        if (historialData.length === 0) {
            alert('No hay datos para exportar a PDF.');
            return;
        }

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('landscape');

        const header = ['Cuota #', 'Monto Pagado', 'Total Cuota', 'Fecha Pago', 'Cuenta Depositada', 'Entidad', 'N° Transacción', 'Observaciones', 'Estado Cuota', 'Comprobante'];
        const body = [];
        const imagePromises = [];

        historialData.forEach(pago => {
            if (pago.comprobante) {
                const imgUrl = `${baseUrl}public/${pago.comprobante}`;
                imagePromises.push(new Promise((resolve) => {
                    const img = new Image();
                    img.crossOrigin = 'Anonymous';
                    img.onload = () => {
                        try {
                            const canvas = document.createElement('canvas');
                            canvas.width = img.width;
                            canvas.height = img.height;
                            canvas.getContext('2d').drawImage(img, 0, 0);

                            let imageType = 'image/jpeg';
                            if (pago.comprobante.toLowerCase().endsWith('.png')) imageType = 'image/png';
                            else if (pago.comprobante.toLowerCase().endsWith('.gif')) imageType = 'image/gif';
                            
                            resolve({ path: pago.comprobante, dataUrl: canvas.toDataURL(imageType), originalWidth: img.width, originalHeight: img.height });
                        } catch (e) {
                            console.error(`Error procesando imagen para PDF: ${imgUrl}`, e);
                            resolve({ path: pago.comprobante, dataUrl: 'N/A' });
                        }
                    };
                    img.onerror = () => {
                        console.warn(`Error al cargar imagen para PDF: ${imgUrl}`);
                        resolve({ path: pago.comprobante, dataUrl: 'N/A' });
                    };
                    img.src = imgUrl;
                }));
            }
        });

        const loadedImages = await Promise.all(imagePromises);
        // Store the image data in a map for easy retrieval by path
        const imageMap = new Map(loadedImages.map(img => [img.path, { dataUrl: img.dataUrl, originalWidth: img.originalWidth, originalHeight: img.originalHeight }]));

        historialData.forEach(pago => {
            // Retrieve the full comprobanteInfo object
            const comprobanteInfo = pago.comprobante ? imageMap.get(pago.comprobante) : null;
            const row = [
                pago.ncuota,
                `S/ ${parseFloat(pago.montopagado).toFixed(2)}`,
                `S/ ${parseFloat(pago.totalcuota).toFixed(2)}`,
                pago.fechapago,
                pago.cuentadepositada,
                pago.entidad,
                pago.ntransaccion,
                pago.observaciones || 'N/A',
                pago.estado_cuota,
                // Pass the full object to didDrawCell by assigning it to data.cell.raw
                // We'll put a placeholder string in the cell's text content, but the raw data will be the object
                comprobanteInfo || 'N/A' 
            ];
            body.push(row);
        });

        const pageWidth = doc.internal.pageSize.getWidth();
        let yPos = 20;

        doc.setFontSize(18);
        doc.text("Historial de Pagos del Contrato", pageWidth / 2, yPos, { align: 'center' });
        yPos += 10;

        doc.setFontSize(12);
        doc.text(`Inversionista: ${inversionistaNombreSpan.textContent}`, pageWidth / 2, yPos, { align: 'center' });
        yPos += 7;
        doc.text(`DNI: ${inversionistaDniSpan.textContent}`, pageWidth / 2, yPos, { align: 'center' });
        yPos += 7;
        doc.text(`ID Contrato: ${contratoIdSpan.textContent}`, pageWidth / 2, yPos, { align: 'center' });
        yPos += 15;

        doc.autoTable({
            head: [header],
            body: body,
            startY: yPos,
            theme: 'striped',
            styles: { fontSize: 8, cellPadding: 2, overflow: 'linebreak', valign: 'middle', halign: 'left' },
            headStyles: { fillColor: [52, 152, 219], textColor: 255, fontStyle: 'bold', halign: 'center' },
            columnStyles: {
                0: { cellWidth: 15, halign: 'center' },
                1: { cellWidth: 25, halign: 'right' },
                2: { cellWidth: 25, halign: 'right' },
                3: { cellWidth: 25, halign: 'center' },
                4: { cellWidth: 25 },
                5: { cellWidth: 25 },
                6: { cellWidth: 30 },
                7: { cellWidth: 30 },
                8: { cellWidth: 20, halign: 'center' },
                9: { cellWidth: 30, halign: 'center' },
            },
            didParseCell: function (data) {
                const estadoColIndex = header.indexOf('Estado Cuota');
                if (data.column.index === estadoColIndex && data.cell.section === 'body') {
                    const estado = data.cell.raw;
                    if (estado.toLowerCase() === 'pagado') {
                        data.cell.styles.fillColor = [212, 237, 218];
                        data.cell.styles.textColor = [21, 87, 36];
                    } else if (estado.toLowerCase() === 'pendiente') {
                        data.cell.styles.fillColor = [255, 243, 205];
                        data.cell.styles.textColor = [133, 100, 4];
                    } else if (estado.toLowerCase() === 'vencido') {
                        data.cell.styles.fillColor = [248, 215, 218];
                        data.cell.styles.textColor = [114, 28, 36];
                    }
                    data.cell.styles.fontStyle = 'bold';
                    data.cell.styles.fontSize = 7;
                }
                const comprobanteColIndex = header.indexOf('Comprobante');
                if (data.column.index === comprobanteColIndex && data.cell.section === 'body') {
                    const comprobanteInfo = data.cell.raw; // This is the object you passed in `body`
                    if (comprobanteInfo && comprobanteInfo.dataUrl && comprobanteInfo.dataUrl !== 'N/A') {
                        // Set the text content to an empty string or 'Ver Comprobante' to avoid [object Object]
                        data.cell.text = ['']; 
                    } else {
                        data.cell.text = ['N/A'];
                    }
                }
            },
            didDrawCell: function (data) {
                const comprobanteColIndex = header.indexOf('Comprobante');
                if (data.column.index === comprobanteColIndex && data.cell.section === 'body') {
                    const comprobanteInfo = data.cell.raw; // Access the full object here

                    if (comprobanteInfo && comprobanteInfo.dataUrl && comprobanteInfo.dataUrl !== 'N/A') {
                        const { dataUrl, originalWidth, originalHeight } = comprobanteInfo;
                        const cellWidth = data.cell.width;
                        const cellHeight = data.cell.height;

                        let imageFormat = 'JPEG';
                        if (dataUrl.startsWith('data:image/png')) imageFormat = 'PNG';
                        else if (dataUrl.startsWith('data:image/gif')) imageFormat = 'GIF';

                        let imgWidth = originalWidth || 30; 
                        let imgHeight = originalHeight || 30;

                        const imgAspectRatio = imgWidth / imgHeight;
                        const maxImgWidth = cellWidth - 2;
                        const maxImgHeight = cellHeight - 2;

                        let drawWidth = maxImgWidth;
                        let drawHeight = maxImgWidth / imgAspectRatio;

                        if (drawHeight > maxImgHeight) {
                            drawHeight = maxImgHeight;
                            drawWidth = maxImgHeight * imgAspectRatio;
                        }
                        
                        if (drawWidth > 0 && drawHeight > 0) {
                            doc.addImage(dataUrl, imageFormat,
                                data.cell.x + (cellWidth - drawWidth) / 2,
                                data.cell.y + (cellHeight - drawHeight) / 2,
                                drawWidth, drawHeight);
                        } else {
                            doc.text('Error Imagen', data.cell.x + cellWidth / 2, data.cell.y + cellHeight / 2, { align: 'center', baseline: 'middle' });
                        }
                    } else {
                        doc.text('N/A', data.cell.x + data.cell.width / 2, data.cell.y + data.cell.height / 2, { align: 'center', baseline: 'middle' });
                    }
                }
            },
            rowPageBreak: 'avoid',
            tableWidth: 'auto',
            margin: { top: yPos + 5, bottom: 10, left: 10, right: 10 }
        });

        doc.save(`historial_pagos_contrato_${idContrato}.pdf`);
    });
});