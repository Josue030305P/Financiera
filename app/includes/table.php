


<main class="main users chart-page" id="skip-target">
    <div class="container">
        <h2 class="main-title">Lista de <?= htmlspecialchars($tipo) ?></h2>

        <div class="row">

            <div class="table-header">
                <?php if ($tipo !== 'Contratos'  && $tipo !== 'Contactos' && $tipo !== 'Inversionistas' ): ?>
                    <a href="<?= $links[$tipo] ?? '#' ?>">
                        <button class="create-lead">+ Nuevo <?= htmlspecialchars($tipo) ?></button>
                    </a>
                <?php endif; ?>

                <?php if ($tipo === 'Leads'): ?>
                    <div class="filters-container">
                        <div class="filter-group">
                            <label for="filtro-estado-lead">Filtrar por Prioridad:</label>
                            <select id="filtro-estado-lead">
                                <option value="">Todos</option>
                                <option value="Alto">Alto</option>
                                <option value="Medio">Medio</option>
                                <option value="Bajo">Bajo</option>
                            </select>
                        </div>
                        <div class="filter-actions">
                            <button id="aplicar-filtros-lead">Aplicar Filtros</button>
                            <button id="resetear-filtros-lead">Resetear</button>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($tipo === 'Contratos'): ?>
                    <div class="filters-container">
                        <div class="filter-group">
                            <label for="filtro-dni-asesor">DNI Asesor:</label>
                            <input type="text" id="filtro-dni-asesor" placeholder="Ingrese DNI">
                        </div>

                        <div class="filter-group">
                            <label for="filtro-dni-inversionista">DNI Inversionista:</label>
                            <input type="text" id="filtro-dni-inversionista" placeholder="Ingrese DNI">
                        </div>

                        <div class="filter-group">
                            <label for="filtro-vencimiento">Próximos a Vencer:</label>
                            <select id="filtro-vencimiento">
                                <option value="">Todos</option>
                                <option value="proximos_30_dias">Próximos 30 días</option>
                                <option value="proximos_60_dias">Próximos 60 días</option>
                                <option value="proximos_90_dias">Próximos 90 días</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="filtro-estado">Estado:</label>
                            <select id="filtro-estado">
                                <option value="">Todos</option>
                                <option value="Vigente">Vigente</option>
                                <option value="Completado">Completado</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="filtro-anio">Contratos por Año:</label>
                            <?php
                            $currentYear = date('Y');
                            $startYear = 2020;
                            ?>
                            <select id="filtro-anio">
                                <option value="">Todos</option>
                                <?php for ($i = $currentYear; $i >= $startYear; $i--): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="filter-actions">
                            <button id="aplicar-filtros">Aplicar Filtros</button>
                            <button id="resetear-filtros">Resetear</button>
                        </div>
                    </div>
                <?php endif; ?>


                <div class="header-buttons">
                    <img src="<?= BASE_URL ?>/app/img/png/export-excel.png" alt="Exportar excel" class="export-excel" title="Exportar a Excel">
                    <img src="<?= BASE_URL ?>/app/img/png/import-excel.svg" alt="Importar excel" class="import-excel" title="Importar desde Excel">
                    <input type="file" id="excelFileInput" accept=".xlsx, .xls" style="display: none;">
                </div>

            </div>


            <div class="users-table table-wrapper">
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