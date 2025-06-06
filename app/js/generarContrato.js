document.addEventListener("DOMContentLoaded", () => {
  const baseUrl =
    document.querySelector('meta[name="base-url"]')?.content || "";

  const leadIdHolder = document.getElementById("leadIdHolder");
  const leadIdFromAttribute = leadIdHolder ? leadIdHolder.dataset.leadId : null;
  const leadId = leadIdFromAttribute || leadIdFromURL;

  const idConyuge = document.getElementById("idconyuge").value;
  const idConyugeValidado =
    document.getElementById("idconyuge").value === "" ? null : idConyuge;

  const btnGuardar = document.getElementById("guardar");
  let empresaId = null;
  const tipoInversionista = document.getElementById("tipo_inversionista");

  // Campos del card inversión:
  const fechaInicio = document.getElementById("fechainicio");
  const numMeses = document.getElementById("meses");
  const fechaFin = document.getElementById("fechafin");
  const moneda = document.getElementById("moneda");
  const interes = document.getElementById("interes");
  const capital = document.getElementById("capital");
  const tipo = document.getElementById("tipo");
  const diaPago = document.getElementById("diapago");
  const periodo = document.getElementById("periodo");
  const impuestoRenta = document.getElementById("impuestorenta");
  const tolerancia = document.getElementById("tolerancia");
  const observacion = document.getElementById("observacion");

  // Ya agrega una empresa y capturo el idempresa - FUNCIONA DESDE  LA VIEW CONTRATO
  async function guardarEmpresa() {
    try {
      const formData = {
        nombrecomercial: document
          .getElementById("nombrecomercial")
          .value.trim(),
        direccion: document.getElementById("direccion_empresa").value.trim(),
        ruc: document.getElementById("ruc").value.trim(),
        razonsocial: document.getElementById("razonsocial").value.trim(),
      };

      const response = await fetch(
        `${baseUrl}app/controllers/EmpresaController.php`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(formData),
        }
      );
      const result = await response.json();

      if (result.status && result.data.idempresa) {
        alert("Empresa agregada corectamente", result.data.idempresa);
        empresaId = result.data.idempresa;
        return empresaId;
        // console.log('id empresa: ', empresaId);
      } else {
        alert("No se ha podido agregar la empresa");
        return null;
      }
    } catch (error) {
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

      if (result.status === "success" && result.data) {
        return {
          idpersona: result.data.idpersona,
          idasesor: result.data.idasesor,
        };
      } else {
        console.error(
          "Error al obtener datos del lead:",
          result.message || "Error desconocido"
        );
        return { idpersona: null, idasesor: null };
      }
    } catch (error) {
      console.error("Error al obtener datos del lead:", error);
      return { idpersona: null, idasesor: null };
    }
  }

  // SI AGREGA EL INVERSIONISTA

  async function agregarInversionista(inversionistaData) {
    try {
      const response = await fetch(
        `${baseUrl}app/controllers/InversionistaController.php`,
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(inversionistaData),
        }
      );
      const result = await response.json();
      const resultFinally =
        result.status && result.idinversionista
          ? { idinversionista: result.idinversionista }
          : null;

      return resultFinally;
    } catch (error) {
      console.error("Error al agregar inversionista:", error);
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Ocurrió un error al comunicarse con el servidor.",
      });
      return null;
    }
  }

  // FUNCIÓN PARA AGREGAR EL CRONOGRAMA DE PAGOS

  function generarCronograma(capital, interes, duracionMeses, fechaInicio) {
    const cuotas = [];
    const interesDecimal = interes / 100;
    const cuotaBase = capital * interesDecimal;
    const totalBruto = cuotaBase - cuotaBase * 0.05; // Aplicando el 5% de retencion

    let fecha = new Date(fechaInicio);

    fecha.setMonth(fecha.getMonth() + 1); // Incrementamos el mes para la primera cuota

    for (let i = 1; i <= duracionMeses; i++) {
      let fechaPago = new Date(fecha);
      const diaInicioContrato = new Date(fechaInicio).getDate() + 1; // Obtenemos el día en cada iteración
      fechaPago.setDate(diaInicioContrato); // Establecemos el día del mes al día de inicio del contrato

      // Manejo de fin de mes: si el día de inicio es mayor que los días del mes actual
      if (fechaPago.getMonth() !== fecha.getMonth() && diaInicioContrato > 28) {
        fechaPago.setDate(0); // Retrocede al último día del mes anterior
      }

      // Formatear fecha a dd/mm/yyyy
      const fechaStr = fechaPago.toLocaleDateString("es-ES");
      console.log("FECHA STR:", fechaStr);
      cuotas.push({
        Cuota: i,
        Fecha: fechaStr,
        Total_Bruto: Number(cuotaBase.toFixed(2)),
        Total_Neto: totalBruto,
      });

      fecha.setMonth(fecha.getMonth() + 1);
    }
    return cuotas;
  }

  async function obtenerVersionActivaContrato() {
    try {
      const response = await fetch(
        `${baseUrl}app/controllers/VersionController.php?`
      );
      const result = await response.json();
      const idversionActiva = result[0].idversion;
      return idversionActiva;
      // console.log('IDVERSION:', result.data[0].idversion); // Obtengo el idversion
    } catch (error) {
      console.error("Error al obtener idversion activa:", error);
      return null;
    }
  }

   obtenerVersionActivaContrato();
  

  async function guardarContrato() {
    let empresaID = null;
    const tipoInversionistaValue = tipoInversionista.value;

    if (tipoInversionistaValue === "empresa") {
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

      const inversionistaResult = await agregarInversionista(
        nuevoInversionista
      );

      try {
        // DE ESTA FORMA AGREGA UN CONTRATO - FALTA CAPTURAR EL IDCONYUGE SI ES QUE SE CREA
        const versionActiva = await obtenerVersionActivaContrato();
        // console.log('IDVERSION DESDE CONTRATO: ', await obtenerVersionActivaContrato());
        const formData = {
          idversion: versionActiva,
          idasesor: inversionistaData.idasesor,
          idinversionista: inversionistaResult.idinversionista,
          idconyuge: idConyugeValidado,
          fechainicio: fechaInicio.value,
          fechafin: fechaFin.value,
          impuestorenta: impuestoRenta.value,
          toleranciadias: tolerancia.value,
          duracionmeses: numMeses.value,
          moneda: moneda.value,
          diapago: diaPago.value,
          interes: interes.value,
          capital: capital.value,
          tiporetorno: tipo.value,
          periodopago: periodo.value,
          observacion: observacion.value,
        };

       // console.log("DATOS DEL CONTRATO:", formData);

        const response = await fetch(
          `${baseUrl}app/controllers/ContratoController.php`,
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify(formData),
          }
        );
        const result = await response.json();

        if (result.success) {
          await Swal.fire({
            toast: true,
            position: "top-end",
            icon: "success",
            title: "Éxito",
            text: "Contrato Generado",
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
          });

          const idcontrato = result.idcontrato;

          const cronograma = generarCronograma(
            formData.capital,
            Number(formData.interes),
            formData.duracionmeses,
            formData.fechainicio
          );
         // console.table(cronograma);
          await fetch(
            `${baseUrl}app/controllers/CronogramaPago.Controller.php`,
            {
              method: "POST",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify({
                idcontrato: idcontrato,
                cuotas: cronograma,
              }),
            }
          );

         window.location.href = `${baseUrl}app/views/cronograma-pagos/`;
        }
      } catch (error) {
        console.error(error);
      }
    }
  }

  btnGuardar.addEventListener("click", guardarContrato);
});
