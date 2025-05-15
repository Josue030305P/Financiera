<?php session_start();
require_once '../../includes/header.php';
require_once "../../includes/config.php";

$leadIdParaJS = $_POST['leadId'] ?? null;
$idConyuge = $_POST['idconyuge'] ?? null;
?>

<head>
  <meta charset="UTF-8">
  <meta name="base-url" content="<?= BASE_URL ?>">
  <title>Contrato</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>app/css/contrato.css">


  <style>
    .mostrar {
      display: block !important;
    }
    .ocultar {
      display: none !important;
    }
    </style>
</head>

<body>

  <div class="page-flex">
    <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>
    <div class="main-wrapper">
      <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>
      <div id="leadIdHolder" style="display: none;" data-lead-id="<?= htmlspecialchars($leadIdParaJS) ?>"></div>
      <input type="hidden" name="idconyuge"  id= "idconyuge" value= "<?php echo $idConyuge !== null ? htmlspecialchars($idConyuge) : ''; ?>">
      <div class="container" style="margin-top: 40px;">

        <!-- Inversionista -->
        <div class="card mb-5 text-bg-secondary">
          <div class="card-header bg-primary text-white fw-bold">Inversionista</div>

          <div class="card-body">

            <div class="form-group">
              <label for="tipo_inversionista">Tipo de Inversionista</label>
              <select name="tipo_inversionista" id="tipo_inversionista" class="select-box" required>
                <option value="persona">Persona</option>
                <option value="empresa">Empresa</option>
              </select>
            </div>

            <hr class="m">
            </hr>

            <div class="row mb-3">
              <div class="col-md-4 form-group inversionista-info mostrar">
                <label for="nombre">Inversionista</label>
                <input type="text" class="form-control" id="nombre" disabled value="">
              </div>

              <div class="col-md-2 form-group inversionista-info mostrar">
                <label for="tipodocumento">Tipo de documento</label>
                <input type="text" class="form-control" id="tipodocumento" value="" disabled>
              </div>

              <div class="col-md-3 form-group inversionista-info mostrar">
                <label for="numdocumento">N° documento</label>
                <input type="text" class="form-control" id="numdocumento" value="" disabled maxlength="8">
              </div>

              <div class="col-md-3 form-group inversionista-info mostrar">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" disabled maxlength="9">
              </div>
            </div>

            <div class="row mb-3" id="campos_conyuge" >
              <div class="col-md-4 form-group">
                <label for="buscarDNI">Buscar DNI (cónyuge)</label>
                <div class="input-group">
                  <input type="search" class="form-control" id="buscarDNI" maxlength="8" data-id-conyuge=""/>
                </div>
              </div>

              <div class="col-md-5 form-group">
                <label for="conyuge">Cónyuge</label>
                <input type="text" class="form-control" id="conyuge" readonly>
              </div>

              <div class="col-md-3 form-group">
                <label for="telconyuge">Teléfono (Cónyuge)</label>
                <input type="text" class="form-control" id="telconyuge" maxlength="9">
              </div>
            </div>


            <div id="campos_empresa" style="display: none;" class="row mb-3">
              <div class="form-group col-md-3">
                <label for="nombrecomercial">Nombre Comercial</label>
                <input type="text" id="nombrecomercial" name="nombrecomercial"
                  placeholder="Ingrese el nombre comercial">
              </div>
              <div class="form-group col-md-3">
                <label for="razonsocial">Razón Social</label>
                <input type="text" id="razonsocial" name="razonsocial" placeholder="Ingrese la razón social" required>
              </div>
              <div class="form-group col-md-3">
                <label for="ruc">RUC</label>
                <input type="text" id="ruc" name="ruc" placeholder="Ingrese el RUC" maxlength="11" required>
              </div>
              <div class="form-group col-md-3">
                <label for="direccion_empresa">Dirección Empresa</label>
                <input type="text" id="direccion_empresa" name="direccion_empresa"
                  placeholder="Ingrese la dirección de la empresa" required>
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
                <label for="meses">Número de Meses</label>
                <input type="number" class="form-control" id="meses" value="0" min="1" required>
              </div>
              <div class="col-md-3 form-group">
                <label for="fechafin">Fecha fin</label>
                <input type="date" class="form-control" id="fechafin" value="" required>
              </div>

              <div class="col-md-3 form-group">
                <label for="moneda">Moneda</label>
                <select class="form-select" id="moneda" aria-label="Moneda" required>
                  <option selected value="PEN">PEN</option>
                  <option value="USD">USD</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-3 form-group">
                <label for="interes">Interés</label>
                <input type="text" class="form-control" id="interes" required>
              </div>
              <div class="col-md-3 form-group">
                <label for="capital">Capital</label>
                <input type="text" class="form-control" id="capital" value="" required>
              </div>
              <div class="col-md-3 form-group">
                <label for="tipo">Tipo</label>
                <input type="text" class="form-control" id="tipo" value="Fijo" required>
              </div>
              <div class="col-md-3 form-group">
                <label for="diapago">Día pago</label>
                <input type="text" class="form-control" id="diapago" value="" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-4 form-group">
                <label for="periodo">Período</label>
                <input type="text" class="form-control" id="periodo" value="Mensual" required>
              </div>
              <div class="col-md-4 form-group">
                <label for="impuestorenta">Impuesto renta</label>
                <input type="number" class="form-control" id="impuestorenta" value="5" min="0" max="100">
              </div>
              <div class="col-md-4 form-group">
                <label for="tolerancia">Tolerancia días</label>
                <input type="text" class="form-control" id="tolerancia" value="3" required>
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
                <input type="text" class="form-control" id="fechacontrato" readonly>
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
  <script src="<?= BASE_URL ?>app/js/contrato.js"></script>
  <script src="<?= BASE_URL ?>app/js/generarContrato.js"></script> 
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    const tipoInversionista = document.getElementById('tipo_inversionista');
    const camposEmpresa = document.getElementById('campos_empresa');
    const inversionistaInfoElements = document.querySelectorAll(".inversionista-info");
    const camposConyuge = document.getElementById('campos_conyuge');
    const claseMostrar = 'mostrar';
    const claseOcultar = 'ocultar';

    tipoInversionista.addEventListener('change', () => {
      camposEmpresa.style.display = tipoInversionista.value === 'empresa' ? 'flex' : 'none';
      camposConyuge.style.display = tipoInversionista.value === 'persona' ? 'flex' : 'none';

      inversionistaInfoElements.forEach(element => {
        element.classList.toggle(claseMostrar, tipoInversionista.value === 'persona');
        element.classList.toggle(claseOcultar, tipoInversionista.value === 'empresa');
      });
    });

    document.addEventListener('DOMContentLoaded', () => {
      camposEmpresa.style.display = 'none';
      camposConyuge.style.display = 'flex';
    });
  </script>
</body>