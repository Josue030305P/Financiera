document.addEventListener('DOMContentLoaded', () => {

    
const baseUrl = document.querySelector('meta[name="base-url"]')?.content || "";

const leadIdHolder = document.getElementById('leadIdHolder');
const leadIdFromAttribute = leadIdHolder ? leadIdHolder.dataset.leadId : null;
const leadId = leadIdFromAttribute || leadIdFromURL;

const idConyuge = document.getElementById('idconyuge').value;

const btnGuardar = document.getElementById('guardar');
let empresaId = null;
const tipoInversionista = document.getElementById('tipo_inversionista');



// Campos del card inversión:
const fechaInicio =   document.getElementById('fechainicio');
const numMeses = document.getElementById('meses');
const fechaFin = document.getElementById('fechafin');
const moneda = document.getElementById('moneda');
const interes = document.getElementById('interes');
const capital = document.getElementById('capital');
const tipo = document.getElementById('tipo');
const diaPago = document.getElementById('diapago');
const periodo = document.getElementById('periodo');
const impuestoRenta = document.getElementById('impuestorenta');
const tolerancia = document.getElementById('tolerancia');
const observacion = document.getElementById('observacion');


// Ya agrega una empresa y capturo el idempresa - FUNCIONA DESDE  LA VIEW CONTRATO
async function guardarEmpresa() {

    try {


        
        const formData = {
            nombrecomercial: document.getElementById('nombrecomercial').value.trim(),
            direccion:document.getElementById('direccion_empresa').value.trim(),
            ruc:document.getElementById('ruc').value.trim(),
            razonsocial:document.getElementById('razonsocial').value.trim()
        };

        const response = await fetch(`${baseUrl}app/controllers/EmpresaController.php`, {
            method:'POST',
            headers:{
                 'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });
        const result = await response.json();

        if (result.status && result.data.idempresa) {
            alert('Empresa agregada corectamente', result.data.idempresa);
            empresaId = result.data.idempresa;
            return empresaId;
            // console.log('id empresa: ', empresaId);
        } else {
            alert('No se ha podido agregar la empresa');
            return null;
        }


    }
    catch(error) {
        console.error(error);
    }

}

// FUNCIONA CORRECTAMENTE
async function obtenerDatosInversionista() {
    try {
        const response = await fetch(
            `${baseUrl}app/controllers/InversionistaController.php?lead_id=${leadId}`
        );
        const result = await response.json();

        if (result.status === 'success' && result.data) {
            return { idpersona: result.data.idpersona, idasesor: result.data.idasesor };
        } else {
            console.error("Error al obtener datos del lead:", result.message || "Error desconocido");
            return { idpersona: null, idasesor: null };
        }
    } catch (error) {
        console.error("Error al obtener datos del lead:", error);
        return { idpersona: null, idasesor: null };
    }
}

// FUNCIONA DESDE LA VIEW CONTRATO

async function agregarInversionista(inversionistaData) {
    try {
        const response = await fetch(
            `${baseUrl}app/controllers/InversionistaController.php`,
            {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(inversionistaData)
            }
        );

        const result = await response.json();

        if (result.status === 'success' && result.idinversionista) {
            Swal.fire({
                icon: 'success',
                title: 'Inversionista agregado',
                text: `ID del inversionista: ${result.idinversionista}`,
            });

            return {idinversionista:result.idinversionista};
          
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error al agregar inversionista',
                text: result.message || 'Ocurrió un error.',
            });
        }
    } catch (error) {
        console.error("Error al agregar inversionista:", error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error al comunicarse con el servidor.',
        });
    }
}


// SI AGREGA EL INVERSIONISTA

async function agregarInversionista(inversionistaData) {
    try {
        const response = await fetch(`${baseUrl}app/controllers/InversionistaController.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(inversionistaData)
        });
        const result = await response.json();

        if (result.status  && result.idinversionista) {
            Swal.fire({ icon: 'success', title: 'Inversionista agregado', text: `ID del inversionista: ${result.idinversionista}` });
            return { idinversionista: result.idinversionista };
        } else {
            Swal.fire({ icon: 'error', title: 'Error al agregar inversionista', text: result.message || 'Ocurrió un error.' });
            return null;
        }
    } catch (error) {
        console.error("Error al agregar inversionista:", error);
        Swal.fire({ icon: 'error', title: 'Error', text: 'Ocurrió un error al comunicarse con el servidor.' });
        return null;
    }
}


async function guardarContrato() {
    let empresaID = null;
    const tipoInversionistaValue = tipoInversionista.value;

    if (tipoInversionistaValue === 'empresa') {
        empresaID = await guardarEmpresa();
        if (!empresaID) {
            return; 
        }
    }

    const inversionistaData = await obtenerDatosInversionista();

    if (inversionistaData.idpersona) {

        // Datos para agregar el inversionista

        const nuevoInversionista = {
            idpersona: inversionistaData.idpersona,
            idempresa: empresaID,
            idasesor: inversionistaData.idasesor,
        };

        const inversionistaResult = await agregarInversionista(nuevoInversionista);
    
        try {

        // DE ESTA FORMA AGREGA UN CONTRATO - FALTA CAPTURAR EL IDCONYUGE SI ES QUE SE CREA
        
        const formData = {
            idversion:1,
            idasesor:inversionistaData.idasesor,
            idinversionista:inversionistaResult.idinversionista,
            idconyuge:idConyuge,
            fechainicio : fechaInicio.value,
            fechafin: fechaFin.value,
            impuestorenta: impuestoRenta.value,
            toleranciadias: tolerancia.value,
            duracionmeses : numMeses.value,
            moneda: moneda.value,
            diapago : diaPago.value,
            interes:interes.value,
            capital:capital.value,
            tiporetorno:tipo.value,
            periodopago: periodo.value,
            observacion:observacion.value

            
        };

        const response = await fetch(`${baseUrl}app/controllers/ContratoController.php`, {
            method:'POST',
            headers:{
                 'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });
        const result = await response.json();

        if (result.success) {
            alert('SE HA CREADO EL CONTRATO');
        }


        } catch(error) {
                console.error(error);
        }

    }
}

btnGuardar.addEventListener('click', guardarContrato);

});









