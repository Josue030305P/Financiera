document.addEventListener('DOMContentLoaded', () => {

    
const baseUrl = document.querySelector('meta[name="base-url"]')?.content || "";

const leadIdHolder = document.getElementById('leadIdHolder');
const leadIdFromAttribute = leadIdHolder ? leadIdHolder.dataset.leadId : null;



const urlParams = new URLSearchParams(window.location.search);
const leadIdFromURL = urlParams.get("id");

const btnGuardar = document.getElementById('guardar');
let empresaId = null;


const leadId = leadIdFromAttribute || leadIdFromURL;


// Ya agrega una empresa y capturo el idempresa:
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




async function guardarContrato(){
    //obtenerDatosInversionista();
    // agregarInversionista({
    //     idpersona:9,
    //     idempresa:17,
    //     idasesor:2
    // });
}







btnGuardar.addEventListener('click',guardarContrato);

});





