document.addEventListener('DOMContentLoaded', () => {

    
const baseUrl = document.querySelector('meta[name="base-url"]')?.content || "";

const leadIdHolder = document.getElementById('leadIdHolder');
const leadIdFromAttribute = leadIdHolder ? leadIdHolder.dataset.leadId : null;

const urlParams = new URLSearchParams(window.location.search);
const leadIdFromURL = urlParams.get("id");

const btnGuardar = document.getElementById('guardar');


const leadId = leadIdFromAttribute || leadIdFromURL;



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

        if (result.success && result.idempresa) {
            alert('Empresa agregada corectamente', result.idempresa);
        } else {
            alert('No se ha podido agregar la empresa');
        }

      


    }
    catch(error) {
        console.error(error);
    }

}

async function guardarContrato () {
        guardarEmpresa();
}


btnGuardar.addEventListener('click',guardarContrato);



async function getIDPersonaAndIDAsesor() {

    try {
        const peticion = await fetch(`${baseUrl}app/controllers/ContratoController.php?id=${leadId}`);
        const response  = await peticion.json();

        return {idpersona:response.idpersona, idasesor:response.idasesor};

    }
    catch(error) {
        console.error('Error al obtener los datos', error);
    }

}







});





