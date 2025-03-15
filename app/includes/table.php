<?php require_once __DIR__ . "/config.php"; ?>

<?php
$tipo = isset($tipo) ? $tipo : '';

$encabezados = [
  'Inversionistas' => [
    'DNI',
    'Apellidos y nombres',
    'Fecha de inicio',
    'Mes',
    'Fecha de termino',
    'Capital',
    '%',
    'Monto',
    'N° cuenta',
    'CCI',
    'Entidad',
    'Fecha',
    'Observacion',
    'Garantía',
    'Asesor',
    'Acciones'
  ]
];


$columnas = isset($encabezados[$tipo]) ? $encabezados[$tipo] : [];



?>
<main class="main users chart-page" id="skip-target">
  <div class="container">
    <h2 class="main-title">Lista de <?= $tipo ?></h2>

    <div class="row">
      <div class="table-header">
        <button class="create-lead">+ Nuevo <?= $tipo ?></button>
        <div class="search-container">
          <input type="text" placeholder="Buscar <?= $tipo ?> 🔍">

        </div>
        <button class="import-btn">Exportar</button>
        <button class="delete-btn icon delete"></button>
      </div>

      <!-- FORMULARIO PARA AGREGAR UN NUEVO LEAD Y PARA EDITAR -->
      <div id="lead-form" class="form-container">
        <div class="form-header h2">
          <h2>Agregar Nuevo <?= $tipo ?></h2>
          <span class="close-btn">✖</span>
        </div>

        <div class="form-body">
          <label></label>
          <input type="text" placeholder="Ingrese nombre">

          <label>Email</label>
          <input type="email" placeholder="Ingrese email">

          <label>Teléfono</label>
          <input type="text" placeholder="Ingrese teléfono">

          <label>Empresa</label>
          <input type="text" placeholder="Ingrese empresa">

          <label>Designación</label>
          <input type="text" placeholder="Ingrese designación">

          <label>Estado del Lead</label>
          <select>
            <option>Seleccionar estado</option>
            <option>Nuevo</option>
            <option>En proceso</option>
            <option>Convertido</option>
          </select>

          <label>Información Personal</label>
          <textarea placeholder="Ingrese información personal"></textarea>

          <div class="form-footer">
            <button class="add-btn">+ Agregar</button>
            <button class="close-btn">Cerrar</button>
          </div>
        </div>
      </div>


      <div class="users-table table-wrapper">
        <table class="posts-table">
          <thead>
            <tr class="users-table-info">
              <?php if (!empty($columnas)): ?>
                <?php foreach ($columnas as $columna): ?>
                  <th><?= htmlspecialchars($columna) ?></th>
                <?php endforeach; ?>
              <?php else: ?>
                <th>No hay encabezados disponibles</th>
              <?php endif; ?>
            </tr>
          </thead>

          <tbody>
            <?php

            $datos = [
              [
                'DNI' => '12345678',
                'Apellidos y nombres' => 'González Pérez, Juan',
                'Fecha de inicio' => '15/03/2025',
                'Mes' => 'Marzo',
                'Fecha de termino' => '15/09/2025',
                'Capital' => 'S/ 10,000',
                '%' => '5%',
                'Monto' => 'S/ 500',
                'N° cuenta' => '123-456789-0-12',
                'CCI' => '002-123456789012345678-90',
                'Entidad' => 'Banco XYZ',
                'Fecha' => '15/03/2025',
                'Observacion' => 'Ninguna',
                'Garantía' => 'Sí',
                'Asesor' => 'María López',
                'iconos' => [
                  'editar' => BASE_URL . 'app/img/svg/Bulk/Edit-white.svg',
                  'eliminar' => BASE_URL . 'app/img/svg/Bulk/Delete.svg'
                ]

              ],

            ];

            if (!empty($datos)):
              foreach ($datos as $fila):
            ?>
                <tr>
                  <?php foreach ($columnas as $columna): ?>
                    <td><?= htmlspecialchars($fila[$columna] ?? '') ?></td>
                  <?php endforeach; ?>
                  <td class="row-actions">
                    <img src="<?= $fila['iconos']['editar'] ?>" alt="Editar lead" class="edit-lead">
                    <img src="<?= $fila['iconos']['eliminar'] ?>" alt="Eliminar lead" class="delete-lead">
                  </td>

                </tr>
              <?php
              endforeach;
            else:
              ?>
              <tr>
                <td colspan="<?= count($columnas) + 1 ?>" style="text-align: center;">No hay registros disponibles</td>
              </tr>
            <?php endif; ?>
          </tbody>

        </table>
      </div>
    </div>
  </div>
</main>