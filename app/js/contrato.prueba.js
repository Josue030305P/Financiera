document.getElementById('guardar').addEventListener('click', function() {
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content || '';
    const normalizedBaseUrl = baseUrl.endsWith('/') ? baseUrl : baseUrl + '/';
    
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `${normalizedBaseUrl}pdf/reporte.php`;
    form.style.display = 'none';
    form.enctype = 'application/json'; 
    
    // Recoger todos los datos del formulario
    const formData = {
        inversionista: {
            nombre: document.getElementById('nombre').value,
            documento: document.getElementById('numdocumento').value,
            telefono: document.getElementById('telefono').value,
            conyuge: document.getElementById('conyuge').value,
            telConyuge: document.getElementById('telconyuge').value
        },
        inversion: {
            fechaInicio: document.getElementById('fechainicio').value,
            meses: document.getElementById('meses').value,
            fechaFin: document.getElementById('fechafin').value,
            moneda: document.getElementById('moneda').value,
            interes: document.getElementById('interes').value,
            capital: document.getElementById('capital').value,
            tipo: document.getElementById('tipo').value,
            diaPago: document.getElementById('diapago').value,
            periodo: document.getElementById('periodo').value,
            impuesto: document.getElementById('impuestorenta').value,
            tolerancia: document.getElementById('tolerancia').value,
            observaciones: document.getElementById('observacion').value
        },
        asesor: {
            nombre: document.getElementById('nombreAsesor').value,
            fechaRegistro: document.getElementById('fecharegistro').value,
            fechaContrato: document.getElementById('fechacontrato').value
        }
    };

    
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'jsonData';
    input.value = JSON.stringify(formData);
    form.appendChild(input);


    console.log("Datos a enviar:", formData);
    console.log("JSON a enviar:", input.value);
    console.log("URL destino:", form.action);


    document.body.appendChild(form);
    form.submit();
});