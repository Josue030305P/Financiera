<main class="main users chart-page" id="skip-target">
    <div class="container">
        <h2 class="main-title">Lista de <?= htmlspecialchars($tipo) ?></h2>

        <div class="row">

            <div class="table-header">
                <a href="<?= $links[$tipo] ?? '#' ?>">
                    <button class="create-lead">+ Nuevo <?= ($tipo) ?></button>
                </a>


                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Bucar de forma multiple 🔍">
                    <!-- Buscar  htmlspecialchars($tipo) !-->
                </div>

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
                                <th><?= htmlspecialchars($columna) ?></th>
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
            exportExcel("<?= $tipo	?>");
        })
    </script>
    <script src="<?= BASE_URL ?>app/js/import-excel.js"></script>



</main>