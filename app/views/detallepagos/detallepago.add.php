<?php session_start(); ?>
<?php require_once '../../includes/header.php'; ?>
<?php require_once __DIR__ . "/../../includes/config.php"; ?>

<link rel="stylesheet" href="<?= BASE_URL ?>/app/css/detallepago.add.css">
<meta name="base-url" content="<?= BASE_URL ?>">

<body>
  <div class="page-flex">
    <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>

    <div class="main-wrapper">
      <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>

      <div class="container-form-pago">
        <div class="card-pago">
          <h1 class="form-title">Registrar Pago de Cuota</h1>
          <form id="formPagoCuota" class="form-grid"> 
            

            <div class="form-group">
              <label for="numcuenta">N° de cuenta</label>
              <select name="idnumcuenta" id="numcuenta" class="form-control" required>
                <option value="">Selecciona una cuenta</option>
              </select>
            </div>

            <div class="form-group">
              <label for="numtransaccion">N° de transacción</label>
              <input type="text" id="numtransaccion" name="numtransaccion" class="form-control"
                placeholder="Ingrese el número de transacción" required>
            </div>

            <div class="form-group">
              <label for="fechahora">Fecha y Hora del Pago</label>
              <input type="datetime-local" id="fechahora" name="fechahora" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="monto">Monto</label>
              <input type="number" id="monto" name="monto" class="form-control" step="0.01" placeholder="Ej: 880.65"
                required>
            </div>

            <div class="form-group form-group-full-width"> <label for="observaciones">Observaciones</label>
              <textarea id="observaciones" name="observaciones" class="form-control textarea-large"
                placeholder="Ingrese algún comentario adicional sobre el pago (opcional)"></textarea>
            </div>

            <div class="form-actions form-group-full-width">
              <button type="submit" class="btn btn-primary">Registrar Pago</button>
              <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancelar</button>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <script src="<?= BASE_URL ?>app/plugins/chart.min.js"></script>
  <script src="<?= BASE_URL ?>app/plugins/feather.min.js"></script>
  <script src="<?= BASE_URL ?>app/js/script.js"></script>
  <script src="<?= BASE_URL ?>app/js/detallepago.js"></script>

</body>

</html>