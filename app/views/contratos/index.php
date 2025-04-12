<?php session_start(); ?>
<?php require_once '../../includes/header.php'; ?>
<?php require_once "../../includes/config.php"; ?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>app/css/contrato.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    /* .card {
      border-radius: 10px;
      background: #fff;
      box-shadow: 0 6px 10px rgba(0, 0, 0, .08), 0 0 6px rgba(0, 0, 0, .05);
      transition: .3s box-shadow, .3s -webkit-transform;
      cursor: pointer;
    }

    .card:hover {
      transform: scale(1.03);
      box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
    }

    .form-control,
    .form-select,
    .form-floating>label {
      font-size: 0.8em;
    }


    textarea.form-control {
      height: 80px !important;
    } */
  </style>
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
          <div class="col-md-4 form-floating mb-3">
            <input type="text" class="form-control" id="nombre" disabled value="Pilpe Yataco Josué Isai">
            <label for="nombre">Inversionista</label>
          </div>

          <div class="col-md-2 form-floating mb-3">
            <input type="text" class="form-control" id="tipodocumento" value="" placeholder=" ">
            <label for="tipodocumento">Tipo de documento</label>
          </div>

          <div class="col-md-3 form-floating mb-3">
            <input type="text" class="form-control" id="numdocumento" value="" placeholder=" ">
            <label for="numdocumento">N° documento</label>
          </div>

          <div class="col-md-3 form-floating mb-3">
            <input type="text" class="form-control" id="telefono" placeholder=" ">
            <label for="telefono">Teléfono</label>
          </div>
        </div>

        <div class="row mb-3">

          <div class="col-md-4 mb-3">
            <div class="input-group">
              <div class="form-floating flex-grow-1">
                <input type="search" class="form-control" id="buscarDNI" placeholder=" " />
                <label for="buscarDNI">Buscar DNI (cónyuge)</label>
              </div>
              <button class="btn btn-primary" type="button" id="botonBuscar">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </div>

          <div class="col-md-5 form-floating mb-3">
            <input type="text" class="form-control" id="conyuge">
            <label for="conyuge">Conyugue</label>
          </div>

          <div class="col-md-3 form-floating mb-3">
            <input type="text" class="form-control" id="telconyuge">
            <label for="telconyuge">Teléfono (Conyuge)</label>
          </div>
        </div>
      </div>

    </div>

    <!-- Datos de inversión -->
    <div class="card mb-5 text-bg-secondary">
      <div class="card-header bg-primary text-white fw-bold">Datos de inversión</div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-3 form-floating mb-3">
            <input type="date" class="form-control" id="fechainicio" disabled placeholder=" ">
            <label for="fechainicio">Fecha inicio</label>
          </div>
          <div class="col-md-3 form-floating mb-3">
            <input type="date" class="form-control" id="fechafin" value="" placeholder=" ">
            <label for="fechafin">Fecha fin</label>
          </div>
          <div class="col-md-3 form-floating mb-3">
            <input type="text" class="form-control" id="meses" value="" placeholder=" ">
            <label for="meses">Meses</label>
          </div>
          <div class="col-md-3 form-floating mb-3">
            <select class="form-select" id="moneda" aria-label="Moneda">
              <option selected value="PEN">PEN</option>
              <option value="USD">USD</option>
            </select>
            <label for="moneda">Moneda</label>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-3 form-floating mb-3">
            <input type="text" class="form-control" id="interes" placeholder=" ">
            <label for="interes">Interés</label>
          </div>
          <div class="col-md-3 form-floating mb-3">
            <input type="text" class="form-control" id="capital" value="" placeholder=" ">
            <label for="capital">Capital</label>
          </div>
          <div class="col-md-3 form-floating mb-3">
            <input type="text" class="form-control" id="tipo" value="Fijo" placeholder=" ">
            <label for="tipo">Tipo</label>
          </div>
          <div class="col-md-3 form-floating mb-3">
            <input type="text" class="form-control" id="diapago" value="" placeholder=" ">
            <label for="diapago">Día pago</label>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4 form-floating mb-3">
            <input type="text" class="form-control" id="periodo" value="" placeholder=" ">
            <label for="periodo">Período</label>
          </div>
          <div class="col-md-4 form-floating mb-3">
            <input type="number" class="form-control" id="impuestorenta" value="5" placeholder=" ">
            <label for="impuestorenta">Impuesto renta</label>
          </div>
          <div class="col-md-4 form-floating mb-3">
            <input type="text" class="form-control" id="tolerancia" value="3" placeholder=" ">
            <label for="tolerancia">Tolerancia días</label>
          </div>
        </div>

        <div class="row mb-3 mt-2 d-flex justify-content-center">
          <div class="form-floating col-md-10 mt-3">
            <textarea class="form-control" placeholder=" " id="observacion" style="height: 100px;"></textarea>
            <label for="observacion">Observaciones</label>
          </div>
        </div>
      </div>
    </div>


    <!-- Asesor -->
    <div class="card mb-2 text-bg-secondary">
      <div class="card-header bg-primary text-white fw-bold">Asesor</div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4 form-floating mb-3">
            <input type="text" class="form-control" id="nombreAsesor" disabled>
            <label for="nombreAsesor">Asesor</label>
          </div>
          <div class="col-md-4 form-floating mb-3">
            <input type="text" class="form-control" id="fecharegistro" value="" disabled>
            <label for="fecharegistro">Fecha registro</label>
          </div>
          <div class="col-md-4 form-floating mb-3">
            <input type="text" class="form-control" id="fechacontrato" value="" disabled>
            <label for="fechacontrato">Fecha contrato</label>
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




  <script>
    const fechainicio = document.getElementById('fechainicio');
    const hoy = new Date();
    const yyyy = hoy.getFullYear();
    const mm = String(hoy.getMonth() + 1).padStart(2, '0');
    const dd = String(hoy.getDate()).padStart(2, '0');
    const fechaFormateada = `${yyyy}-${mm}-${dd}`;

    fechainicio.value = fechaFormateada;

  </script>

  <script>
    const fechainicio = document.getElementById('fechainicio');
    const hoy = new Date();
    const yyyy = hoy.getFullYear();
    const mm = String(hoy.getMonth() + 1).padStart(2, '0');
    const dd = String(hoy.getDate()).padStart(2, '0');
    const fechaFormateada = `${yyyy}-${mm}-${dd}`;

    fechainicio.value = fechaFormateada;
  </script>


</body>