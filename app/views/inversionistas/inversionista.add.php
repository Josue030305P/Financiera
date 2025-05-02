<?php session_start();
require_once '../../includes/header.php';
require_once "../../includes/config.php";

$leadIdParaJS = $_POST['leadId'] ?? null;
?>

<head>
  <meta charset="UTF-8">
  <meta name="base-url" content="<?= BASE_URL ?>">
  <title>Contrato</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>app/css/contrato.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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

            <div class="row mb-3" id="campos_conyuge">
              <div class="col-md-4 form-group">
                <label for="buscarDNI">Buscar DNI (cónyuge)</label>
                <div class="input-group">
                  <input type="search" class="form-control" id="buscarDNI" maxlength="8" data-id-conyuge="" />
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
      </div>


      <script src="<?= BASE_URL ?>app/plugins/chart.min.js"></script>
  <script src="<?= BASE_URL ?>app/plugins/feather.min.js"></script>
  <script src="<?= BASE_URL ?>app/js/script.js"></script>
  <script src="<?= BASE_URL ?>app/js/contrato.js"></script>
  <script src="<?= BASE_URL ?>app/js/generarContrato.js"></script> 
  <!-- PRUEBA DE ENVIO DE DATOS A REPORTES PDF -->
   <!-- <script src="<?= BASE_URL ?>app/js/contrato.prueba.js"></script>  -->
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