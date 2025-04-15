<?php session_start();
require_once '../../includes/header.php';
require_once "../../includes/config.php";
?>

<head>
  <meta charset="UTF-8">
  <meta name="base-url" content="<?= BASE_URL ?>">
  <title>Document</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>app/css/contrato.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

  <div class="page-flex">
    <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>
    <div class="main-wrapper">
      <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>

      <div class="container mt-5">
        <!-- Inversionista -->
        <div class="card mb-5 text-bg-secondary">
          <div class="card-header bg-primary text-white fw-bold">Inversionista</div>

          <div class="card-body">
            <div class="row mb-3">
              <div class="col-md-4 form-group">
                <label for="nombre">Inversionista</label>
                <input type="text" class="form-control" id="nombre" disabled value="">
              </div>

              <div class="col-md-2 form-group">
                <label for="tipodocumento">Tipo de documento</label>
                <input type="text" class="form-control" id="tipodocumento" value="" disabled>
              </div>

              <div class="col-md-3 form-group">
                <label for="numdocumento">N° documento</label>
                <input type="text" class="form-control" id="numdocumento" value="" disabled maxlength="8">
              </div>

              <div class="col-md-3 form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" disabled>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-4 form-group">
                <label for="buscarDNI">Buscar DNI (cónyuge)</label>
                <div class="input-group">
                  <input type="search" class="form-control" id="buscarDNI"  maxlength="8"/>
                </div>
              </div>
 
              <div class="col-md-5 form-group">
                <label for="conyuge">Cónyuge</label>
                <input type="text" class="form-control" id="conyuge">
              </div>

              <div class="col-md-3 form-group">
                <label for="telconyuge">Teléfono (Cónyuge)</label>
                <input type="text" class="form-control" id="telconyuge">
              </div>
            </div>
          </div>
        </div>

        <!-- Datos de inversión -->
        <div class="card mb-5 text-bg-secondary">
          <div class="card-header bg-primary text-white fw-bold">Datos de inversión</div>
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-md-3 form-group">
                <label for="fechainicio">Fecha inicio</label>
                <input type="date" class="form-control" id="fechainicio" disabled>
              </div>
              <div class="col-md-3 form-group">
                <label for="fechafin">Fecha fin</label>
                <input type="date" class="form-control" id="fechafin" value="">
              </div>
              <div class="col-md-3 form-group">
                <label for="meses">Meses</label>
                <input type="text" class="form-control" id="meses" value="">
              </div>
              <div class="col-md-3 form-group">
                <label for="moneda">Moneda</label>
                <select class="form-select" id="moneda" aria-label="Moneda">
                  <option selected value="PEN">PEN</option>
                  <option value="USD">USD</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-3 form-group">
                <label for="interes">Interés</label>
                <input type="text" class="form-control" id="interes">
              </div>
              <div class="col-md-3 form-group">
                <label for="capital">Capital</label>
                <input type="text" class="form-control" id="capital" value="">
              </div>
              <div class="col-md-3 form-group">
                <label for="tipo">Tipo</label>
                <input type="text" class="form-control" id="tipo" value="Fijo">
              </div>
              <div class="col-md-3 form-group">
                <label for="diapago">Día pago</label>
                <input type="text" class="form-control" id="diapago" value="">
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-4 form-group">
                <label for="periodo">Período</label>
                <input type="text" class="form-control" id="periodo" value="">
              </div>
              <div class="col-md-4 form-group">
                <label for="impuestorenta">Impuesto renta</label>
                <input type="number" class="form-control" id="impuestorenta" value="5">
              </div>
              <div class="col-md-4 form-group">
                <label for="tolerancia">Tolerancia días</label>
                <input type="text" class="form-control" id="tolerancia" value="3">
              </div>
            </div>

            <div class="row mb-3 mt-2 d-flex justify-content-center">
              <div class="col-md-10 form-group">
                <label for="observacion">Observaciones</label>
                <textarea class="form-control" id="observacion" style="height: 100px;"></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- Asesor -->
        <div class="card mb-2 text-bg-secondary">
          <div class="card-header bg-primary text-white fw-bold">Asesor</div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4 form-group">
                <label for="nombreAsesor">Asesor</label>
                <input type="text" class="form-control" id="nombreAsesor" disabled>
              </div>
              <div class="col-md-4 form-group">
                <label for="fecharegistro">Fecha registro</label>
                <input type="text" class="form-control" id="fecharegistro" value="" disabled>
              </div>
              <div class="col-md-4 form-group">
                <label for="fechacontrato">Fecha contrato</label>
                <input type="text" class="form-control" id="fechacontrato" value="" disabled>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <button type="button" class="btn btn-outline-primary" id="guardar">Guardar</button>
        </div>
      </div>
    </div>
  </div>


  <script src="<?= BASE_URL ?>app/plugins/chart.min.js"></script>
  <script src="<?= BASE_URL ?>app/plugins/feather.min.js"></script>
  <script src="<?= BASE_URL ?>app/js/script.js"></script>
  <script src="<?= BASE_URL ?>app/js/buscarConyuge.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>


    const urlParams = new URLSearchParams(window.location.search);
    const leadId = urlParams.get('id');

    fetch(`<?= BASE_URL ?>app/controllers/ContratoController.php?id=${leadId}`)
      .then(response => response.json())
      .then(data => {
        console.log(data)
        document.getElementById('nombre').value = data.nombrecompleto;
        document.getElementById('tipodocumento').value = data.tipodocumento;
        document.getElementById('numdocumento').value = data.numdocumento;
        document.getElementById('telefono').value = data.telefono;
      })
      .catch(error => console.error(error))




    const fechainicio = document.getElementById('fechainicio');
    const hoy = new Date();
    const yyyy = hoy.getFullYear();
    const mm = String(hoy.getMonth() + 1).padStart(2, '0');
    const dd = String(hoy.getDate()).padStart(2, '0');
    const fechaFormateada = `${yyyy}-${mm}-${dd}`;

    fechainicio.value = fechaFormateada;
  </script>




</body>