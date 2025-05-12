document.addEventListener('DOMContentLoaded', async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const idcontrato = urlParams.get('idcontrato');
    
    if (!idcontrato) {
        console.error('No se proporcionó ID de contrato');
        return;
    }

    try {
        const baseUrl = document.querySelector('meta[name="base-url"]')?.content || '';
        const response = await fetch(`${baseUrl}app/controllers/ContratoPDFController.php?idcontrato=${idcontrato}`);
        const data = await response.json();

        if (data.error) {
            console.error('Error:', data.error);
            return;
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `${baseUrl}pdf/reporte.php`;
        form.style.display = 'none';
        form.enctype = 'application/json';

        const formData = {
            inversionista: {
                nombre: data.nombre_inversionista,
                documento: data.dni_inversionista,
                direccion: data.direccion_inversionista,
                ubicacion: data.ubicacion_inversionista,
                banco: data.banco,
                numcuenta: data.numcuenta,
                cci: data.cci
            },
            conyuge: {
                nombre: data.nombre_conyuge,
                documento: data.dni_conyuge
            },
            contrato: {
                capital: data.capital,
                cronograma: data.cronograma_pagos
            }
        };

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'jsonData';
        input.value = JSON.stringify(formData);
        form.appendChild(input);

        document.body.appendChild(form);
        form.submit();

    } catch (error) {
        console.error('Error al obtener datos del contrato:', error);
    }
});