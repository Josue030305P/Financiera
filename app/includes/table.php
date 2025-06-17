<link rel="stylesheet" href="<?= BASE_URL ?>app/css/tabla-reutilizable.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
<main class="main users chart-page" id="skip-target">
    <div class="container">
        <h2 class="main-title">Lista de <?= htmlspecialchars($tipo) ?></h2>

        <div class="card table-container">
            <div class="table-header">
                <div class="header-controls">
                    <?php if ($tipo !== 'Contratos' && $tipo !== 'Contactos' && $tipo !== 'Inversionistas'): ?>
                        <a href="<?= $links[$tipo] ?? '#' ?>">
                            <button class="create-lead button-primary">+ Nuevo <?= htmlspecialchars($tipo) ?></button>
                        </a>
                    <?php endif; ?>

                    <div class="header-buttons">
                        <button class="icon-button export-excel" title="Exportar a Excel">
                            <i class="fas fa-file-excel"></i>
                            <span>Exportar Excel</span>
                        </button>
                        <button class="icon-button import-excel" title="Importar desde Excel">
                            <i class="fas fa-file-import"></i>
                            <span>Importar Excel</span>
                        </button>
                        <input type="file" id="excelFileInput" accept=".xlsx, .xls" style="display: none;">
                    </div>
                </div>

                <?php if ($tipo === 'Leads'): ?>
                    <div class="filters-container">
                        <div class="filter-group">
                            <label for="filtro-estado-lead">Filtrar por Prioridad:</label>
                            <select id="filtro-estado-lead" class="filter-select">
                                <option value="">Todos</option>
                                <option value="Alto">Alto</option>
                                <option value="Medio">Medio</option>
                                <option value="Bajo">Bajo</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="filtro-asesor-lead">Filtrar por Asesor:</label>
                            <select id="filtro-asesor-lead" class="filter-select">
                                <option value="">Todos</option>
                               
                            </select>
                        </div>


                        <div class="filter-actions">
                            <button id="aplicar-filtros-lead" class="button-secondary">Aplicar Filtros</button>
                            <button id="resetear-filtros-lead" class="button-ghost">Resetear</button>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($tipo === 'Contratos'): ?>
                    <div class="filters-container">
                        <div class="filter-group">
                            <label for="filtro-asesor-contrato">Filtrar por Asesor:</label>
                            <select id="filtro-asesor-contrato" class="filter-select">
                                <option value="">Todos</option>
                            
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="filtro-dni-inversionista">DNI Inversionista:</label>
                            <input type="text" id="filtro-dni-inversionista" placeholder="Ingrese DNI" class="filter-input">
                        </div>
                        <div class="filter-group">
                            <label for="filtro-vencimiento">Próximos a Vencer:</label>
                            <select id="filtro-vencimiento" class="filter-select">
                                <option value="">Todos</option>
                                <option value="proximos_30_dias">Próximos 30 días</option>
                                <option value="proximos_60_dias">Próximos 60 días</option>
                                <option value="proximos_90_dias">Próximos 90 días</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="filtro-estado">Estado:</label>
                            <select id="filtro-estado" class="filter-select">
                                <option value="">Todos</option>
                                <option value="Vigente">Vigente</option>
                                <option value="Completado">Completado</option>

                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="filtro-anio">Contratos por Año:</label>
                            <?php
                            $currentYear = date('Y');
                            $startYear = 2023;
                            ?>
                            <select id="filtro-anio" class="filter-select">
                                <option value="">Todos</option>
                                <?php for ($i = $currentYear; $i >= $startYear; $i--): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="filter-actions">
                            <button id="aplicar-filtros" class="button-secondary">Aplicar Filtros</button>
                            <button id="resetear-filtros" class="button-ghost">Resetear</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="table-wrapper">
                <table class="posts-table" id="dataTable">
                    <thead>
                        <tr class="users-table-info">
                            <?php foreach ($columnas as $columna): ?>
                                <th>
                                    <?= htmlspecialchars($columna) ?>
                                    <span class="sort-icon"></span>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="<?= BASE_URL ?>app/js/export-excel.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', e => {
            exportExcel("<?= $tipo ?>");
        })
    </script>
    <script src="<?= BASE_URL ?>app/js/import-excel.js"></script>
</main>