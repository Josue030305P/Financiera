document.addEventListener("DOMContentLoaded", () => {
const baseUrl =
    document.querySelector('meta[name="base-url"]')?.content || "";

    const form = document.getElementById('formPagoCuota');
    const numCuenta = document.getElementById('numcuenta');
    const numTransaccion =  document.getElementById('numtransaccion');
    const fechaHora = document.getElementById('fechahora');
    const monto = document.getElementById('monto');
    const observaciones = document.getElementById('observaciones');
    const urlParams = new URLSearchParams(window.location.search);
    const idcontrato = urlParams.get("idcontrato");


    async function obtenerNumCuentas () {
      
      try {
        const response = await `${baseUrl}app/controllers/DetallePagoController?idcontrato=${idcontrato}`;
        const data = await data.json();
        
        await data.forEach(element => {
          console.log(element.numuenta);
          
        });

      }
      catch(error) {
        console.log(error);
      }
    }
  






});
