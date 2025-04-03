<main class="main users chart-page" id="skip-target">
    <div class="container">
        <h2 class="main-title">Lista de <?= htmlspecialchars($tipo) ?></h2>

        <div class="row">

            <div class="table-header">
                <a href="<?= $links[$tipo] ?? '#' ?>">
                    <button class="create-lead">+ Nuevo <?= ($tipo) ?></button>
                </a>
                

                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Buscar <?= htmlspecialchars($tipo) ?> 🔍">

                </div>

                <div class="header-buttons">
                    <button class="import-btn delete-btn">Exportar</button>
                    <button class="import-btn">Importar</button>
                    <button class="bg-primary">Ver más</button>
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
</main>