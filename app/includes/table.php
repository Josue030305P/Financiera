<link rel="stylesheet" href="<?= BASE_URL ?>app/css/tabla-reutilizable.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanilla-datatables@latest/dist/vanilla-dataTables.min.css">   
    <style>
        .introjs-tooltip {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border: none;
            padding: 15px 20px;
            font-family: 'Inter', sans-serif;
            text-align: center;
        }

        .custom-tooltip {
            background-color: #1a202c !important;
            color: #fff !important;
            font-size: 15px;
            border-radius: 8px;
            padding: 15px;
            max-width: 300px;
            line-height: 1.6;
            position: relative;
        }

        .custom-highlight {
            box-shadow: 0 0 0 5px rgba(59, 130, 246, 0.7), 0 0 0 10000px rgba(0, 0, 0, 0.4);
            border-radius: 12px;
            transition: all 0.3s ease-in-out;
        }

        .introjs-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 15px;
            margin: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 600;
        }

        .introjs-button:hover {
            background-color: #45a049;
        }

        .introjs-prevbutton {
            background-color: #4a5568;
        }

        .introjs-prevbutton:hover {
            background-color: #2d3748;
        }

        .introjs-skipbutton {
            background-color: transparent;
            color: #a0aec0;

            position: absolute;
            top: 10px;
            right: 15px;
            padding: 5px 10px;
            font-size: 13px;
            border-radius: 5px;
            z-index: 1000;
        }

        .introjs-skipbutton:hover {
            color: #e2e8f0;
            border-color: #e2e8f0;
        }

        .introjs-donebutton {
            background-color: #007bff;
            color: white;
        }

        .introjs-donebutton:hover {
            background-color: #0056b3;
        }

        .introjs-bullets {
            text-align: center;
            padding: 10px 0;
        }

        .introjs-bullets ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: inline-block;
        }

        .introjs-bullets li {
            display: inline-block;
            margin: 0 5px;
        }

        .introjs-bullets a {
            display: block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #cbd5e0;
            transition: background-color 0.3s ease;
        }

        .introjs-bullets a.active {
            background-color: #4CAF50;
            border: 2px solid #38a169;
        }

        .introjs-arrow {
            border: none !important;
        }

        .introjs-arrow.top {
            border-bottom-color: #1a202c !important;
        }

        .introjs-arrow.bottom {
            border-top-color: #1a202c !important;
        }

        .introjs-arrow.left {
            border-right-color: #1a202c !important;
        }

        .introjs-arrow.right {
            border-left-color: #1a202c !important;
        }

        .introjs-overlay {
            opacity: 0.6 !important;
        }

        .introjs-tooltip-header {
            position: relative;
            padding-top: 20px;
        }
    </style>
<main class="main users chart-page" id="skip-target">
    <div class="container">
        <h2 class="main-title"  data-intro="Este es el título donde se indica qué tipo de datos estás visualizando." data-step="1">Lista de <?= htmlspecialchars($tipo) ?></h2>

        <div class="card table-container" data-intro="Aquí se encuentra toda la estructura de tu tabla y filtros." data-step="2">
            <div class="table-header" data-intro="Botones principales de acción como agregar, importar o exportar." data-step="3">
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
                        <?php if ($tipo === 'Leads'): ?>
                            <button class="icon-button import-excel" title="Importar desde Excel">
                                <i class="fas fa-file-import"></i>
                                <span>Importar Excel</span>
                            </button>
                            <input type="file" id="excelFileInput" accept=".xlsx, .xls" style="display: none;">
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($tipo === 'Leads'): ?>
                    <div class="filters-container" data-intro="Puedes aplicar filtros para encontrar registros más específicos." data-step="4">
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

            <div class="table-wrapper" data-intro="Aquí se muestra la tabla con los datos filtrados." data-step="5">
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


    <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
<link href="https://unpkg.com/intro.js/minified/introjs.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/vanilla-datatables@latest/dist/vanilla-dataTables.min.js"></script>


<script>
function iniciarTourTabla() {
    introJs().setOptions({
        nextLabel: 'Siguiente',
        prevLabel: 'Anterior',
        doneLabel: 'Finalizar',
        skipLabel: 'Saltar',
        tooltipClass: 'custom-tooltip',
        highlightClass: 'custom-highlight'
    }).onchange(function(element) {
        mostrarSoloElementoTabla(element);
    }).start();
}

function mostrarSoloElementoTabla(elemento) {
    const elementos = [
        'titulo-tabla',
        'contenedor-tabla',
        'encabezado-controles',
        'contenedor-filtros',
        'contenedor-tabla-datos'
    ];

    elementos.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = 'none';
    });

    const actual = elemento.id;
    if (actual && document.getElementById(actual)) {
        document.getElementById(actual).style.display = 'block';
        document.getElementById(actual).scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// Mostrar el tour SOLO una vez por navegador
setTimeout(() => {
    if (!localStorage.getItem('tour_tabla_realizado')) {
        iniciarTourTabla();
        localStorage.setItem('tour_tabla_realizado', 'true');
    }
}, 1000);
</script>


  <script src="<?= BASE_URL ?>app/js/inactividad.js"></script>

</main>