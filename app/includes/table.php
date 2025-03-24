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
  ],

  'Leads' => [
    'Fecha de cita',
    'Hora',
    'Prioridad',
    'Apellidos y nombres',
    'Teléfono',
    'Correo',
    'Asesor',
    'Acciones'

  ],

  'Contactos' => [
    'Apellidos y nombres',
    'Asesor',
    'Correo',
    'Teléfono',
    'Ocupación',
    'Fecha',
    'Hora',
    'Comentarios',
    'Estado',
    'Acciones'
  ]


];

$links = [
  "Inversionistas" => "nuevo-inversionista",
  "Leads" =>  BASE_URL . "/app/views/leads/leads.add",
  "Contactos" => BASE_URL . "/app/views/contactibilidad/contactos.add"
];


$columnas = isset($encabezados[$tipo]) ? $encabezados[$tipo] : [];

?>
<main class="main users chart-page" id="skip-target">
  <div class="container">
    <h2 class="main-title">Lista de <?= $tipo ?></h2>

    <div class="row">
      <div class="table-header">
        <a href="<?= isset($links[$tipo]) ? $links[$tipo] : '#' ?>">
          <button class="create-lead">+ Nuevo <?= $tipo ?></button>
        </a>

        <div class="search-container">
          <input type="text" placeholder="Buscar <?= $tipo ?> 🔍">
        </div>
        <div class="header-buttons">
          <button class="import-btn">Exportar</button>
          <button class="delete-btn icon delete"></button>
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
              'Inversionistas' => [
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
                'Acciones' => [
                  'editar' => [BASE_URL . 'app/img/svg/Bulk/Edit-white.svg', BASE_URL . 'app/views/leads/inversionistas.update.php'],
                  'eliminar' => BASE_URL . 'app/img/svg/Bulk/Delete.svg'
                ]

              ],


              'Leads' => [
                'Fecha de cita' => '21/03/2025',
                'Hora' => '15:30pm',
                'Apellidos y nombres' => 'Pilpe Yataco, Josué Isai',
                'Prioridad' => 'Baja',
                'Teléfono' => '919482381',
                'Correo' => 'josue96@gmail.com',
                'Asesor' => 'Julia',
                'Acciones' => [
                  'editar' => [BASE_URL . 'app/img/svg/Bulk/Edit-white.svg', BASE_URL . 'app/views/leads/leads.update.php'],
                  'eliminar' => BASE_URL . 'app/img/svg/Bulk/Delete.svg'
                ]

              ],

              'Contactos' => [
                'Apellidos y nombres' => 'Pilpe Yataco, Josué Isai',
                'Asesor' => 'Julia',
                'Correo' => 'josue96@gmail.com',
                'Teléfono' => '919482381',
                'Ocupación' => 'Contador',
                'Fecha' => '21/03/2025',
                'Hora' => '15:30pm',
                'Comentarios' => 'Muy interesado en el contrato a firmar',
                'Estado' => 'Cerrado',
                'Acciones' => [
                  'editar' => [BASE_URL . 'app/img/svg/Bulk/Edit-white.svg', BASE_URL . 'app/views/leads/contactos.update.php'],
                  'eliminar' => BASE_URL . 'app/img/svg/Bulk/Delete.svg'
                ]
              ]

            ];

            if (!empty($datos[$tipo])):
            ?>
              <tr>
                <?php foreach ($columnas as $columna): ?>
                  <td>
                    <?php if ($columna === 'Prioridad'): ?>
                      <?php
                      $prioridad = strtolower($datos[$tipo][$columna] ?? '');
                      $colorClase = '';
                      switch ($prioridad) {
                        case 'alta':
                          $colorClase = 'prioridad-alta';
                          break;
                        case 'media':
                          $colorClase = 'prioridad-media';
                          break;
                        case 'baja':
                          $colorClase = 'prioridad-baja';
                          break;
                      }
                      ?>
                      <span class="<?= $colorClase ?>"><?= htmlspecialchars($datos[$tipo][$columna] ?? '') ?></span>
                    <?php elseif ($columna === 'Acciones' && is_array($datos[$tipo]['Acciones'] ?? null)): ?>
                      <a href="<?= $datos[$tipo]['Acciones']['editar'][1] ?>"><img src="<?= $datos[$tipo]['Acciones']['editar'][0] ?>" alt="Editar" class="edit-lead"></a>
                      <a href=""><img src="<?= $datos[$tipo]['Acciones']['eliminar'] ?>" alt="Eliminar" class="delete-lead"></a>
                    <?php else: ?>
                      <?= htmlspecialchars($datos[$tipo][$columna] ?? '') ?>
                    <?php endif; ?>
                  </td>

                <?php endforeach; ?>
              </tr>
            <?php
            else: ?>
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