<main class="main users chart-page" id="skip-target">
    <div class="container">
        <h2 class="main-title">Lista de <?= htmlspecialchars($tipo) ?></h2>

        <div class="row">

            <div class="table-header">
                <a href="<?= $links[$tipo] ?? '#' ?>">
                    <button class="create-lead">+ Nuevo <?= ($tipo) ?></button>
                </a>

                <?php if ($tipo === 'Contratos'): ?>
                    <div class="filters-container">
                        <label for="filtro-vencimiento">Vencimiento:</label>
                        <select id="filtro-vencimiento">
                            <option value="">Todos</option>
                            <option value="proximos_30_dias">Próximos 30 días</option>
                        </select>

                        <label for="filtro-estado">Estado:</label>
                        <select id="filtro-estado">
                            <option value="">Todos</option>
                            <option value="Vigente">Vigente</option>
                            <option value="Completado">Completado</option>
                        </select>

                        <label for="filtro-asesor">Asesor:</label>
                        <input type="text" id="filtro-asesor" placeholder="Nombre del Asesor">

                        <label for="filtro-moneda">Moneda:</label>
                        <select id="filtro-moneda">
                            <option value="">Todas</option>
                            <option value="PEN">PEN</option>
                            <option value="USD">USD</option>
                        </select>

                        <button id="aplicar-filtros">Aplicar Filtros</button>
                        <button id="resetear-filtros">Resetear</button>
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