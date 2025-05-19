
<style>
.modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(27, 27, 27, 0.4); 
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto; 
    padding: 20px;
    border: 1px solid #888;
    width: 80%; 
}

.close-button {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close-button:hover,
.close-button:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

#modal-cronograma-body table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

#modal-cronograma-body th, #modal-cronograma-body td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

#modal-cronograma-body th {
    background-color: #f2f2f2;
}



.ver-cronograma-modal img {
    width: 24px; 
    height: 24px;
    vertical-align: middle;
}

</style>



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

        <div id="modal-cronograma" class="modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <h3>Cronograma de Pagos - Contrato <span id="modal-contrato-id"></span></h3>
                <div id="modal-cronograma-body">
                </div>
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