<main class="main users chart-page" id="skip-target">
  <div class="container">
    <h2 class="main-title">Lista de <?= htmlspecialchars($tipo) ?></h2>

    <div class="row">
      <div class="table-header">
        <a href="<?= $links[$tipo] ?? '#' ?>">
          <button class="create-lead">+ Nuevo <?= htmlspecialchars($tipo) ?></button>
        </a>

        <div class="search-container">
          <input type="text" placeholder="Buscar <?= htmlspecialchars($tipo) ?> 🔍">
          <span><img src="<?= BASE_URL ?>app/img/svg/Bulk/Plus.svg">Ver más</span>
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
              <?php foreach ($columnas as $columna): ?>
                <th><?= htmlspecialchars($columna) ?></th>
              <?php endforeach; ?>
            </tr>
          </thead>

          <tbody>
            <?php if (!empty($datos[$tipo])): ?>
              <tr>
                <?php foreach ($columnas as $columna): ?>
                  <td>
                    <?php if ($columna === 'Prioridad'): ?>
                      <?php
                      $prioridad = strtolower($datos[$tipo][$columna] ?? '');
                      $colorClase = match ($prioridad) {
                        'alta' => 'prioridad-alta',
                        'media' => 'prioridad-media',
                        'baja' => 'prioridad-baja',
                        default => '',
                      };
                      ?>
                      <span class="<?= $colorClase ?>"><?= htmlspecialchars($datos[$tipo][$columna] ?? '') ?></span>
                    <?php elseif ($columna === 'Acciones' && is_array($datos[$tipo]['Acciones'] ?? null)): ?>
                      <a href="<?= $datos[$tipo]['Acciones']['editar'][1] ?>">
                        <img src="<?= $datos[$tipo]['Acciones']['editar'][0] ?>" alt="Editar" class="edit-lead">
                      </a>
                      <a href="">
                        <img src="<?= $datos[$tipo]['Acciones']['eliminar'] ?>" alt="Eliminar" class="delete-lead">
                      </a>
                    <?php else: ?>
                      <?= htmlspecialchars($datos[$tipo][$columna] ?? '—') ?>
                    <?php endif; ?>
                  </td>
                <?php endforeach; ?>
              </tr>
            <?php else: ?>
              <tr>
                <td colspan="<?= count($columnas) ?>" class="text-center">No hay datos disponibles</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
