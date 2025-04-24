document.addEventListener('DOMContentLoaded', () => {

    
const baseUrl = document.querySelector('meta[name="base-url"]')?.content || "";

const leadIdHolder = document.getElementById('leadIdHolder');
const leadIdFromAttribute = leadIdHolder ? leadIdHolder.dataset.leadId : null;

const urlParams = new URLSearchParams(window.location.search);
const leadIdFromURL = urlParams.get("id");



const leadId = leadIdFromAttribute || leadIdFromURL;

async function getIDPersonaAndIDAsesor() {

    try {
        const peticion = await fetch(`${baseUrl}app/controllers/ContratoController.php?id=${leadId}`);
        const response  = await peticion.json();

        const idPersona = response.idpersona;
        const idAsesor = response.idasesor;

       return idPersona, idAsesor
    }
    catch(error) {
        console.error('Error al obtener los datos', error);
    }


}
console.log(getIDPersonaAndIDAsesor());

});





