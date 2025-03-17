<?php require_once '../../includes/header.php'; ?>
<?php require_once __DIR__ . "/../../includes/config.php"; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/app/css/form.lead.css">

<body>

    <div class="page-flex">

        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>

        <div class="main-wrapper">

            <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>


            <div id="lead-form" class="form-container">
                <div class="form-header">
                    <h2 class="form-title">Agregar Nuevo Lead</h2>
                    <a href=""><button class="regresar-btn">Lista de leads</button></a>
                </div>

                <div class="form-body">
                    <div class="form-group">
                        <input type="search" placeholder="Buscar una persona 🔍" class="search-input">
                        <select name="select-person" id="person" class="select-box">
                            <option value="person1">María</option>
                            <option value="person2">Sofía</option>
                            <option value="person3">Cesar</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="search" placeholder="Buscar un asesor 🔍" class="search-input">
                        <select name="select-asesor" id="asesor" class="select-box">
                            <option value="asesor1">Julia</option>
                            <option value="asesor2">Francisco</option>
                            <option value="asesor3">Estefanía</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="prioridad">Prioridad</label>
                        <select name="prioridad" id="prioridad" class="select-box">
                            <option value="Alta">Alta</option>
                            <option value="Media">Media</option>
                            <option value="Baja">Baja</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ocupacion">Ocupación</label>
                        <input type="text" id="ocupacion" placeholder="Ingrese una ocupación" class="ocupacion">
                    </div>

                    <div class="form-group">
                        <label for="comentarios">Comentarios</label>
                        <textarea name="comentarios" id="comentarios" class="textarea-box" placeholder="Ingrese algún comentario"></textarea>
                    </div>

                    <div class="form-footer">
                        <button class="add-btn">Agregar lead</button>
                        <button class="reset-btn">Cancelar</button>
                    </div>
                </div>
            </div>

        </div>


    </div>
    <?php require_once "../../includes/footer.php"  ?>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function filtrarOpciones(inputSelector, selectSelector) {
                const input = document.querySelector(inputSelector);
                const select = document.querySelector(selectSelector);
                const opciones = Array.from(select.options);

                input.addEventListener("input", function() {
                    const filtro = input.value.toLowerCase();
                    select.innerHTML = "";
                    select.size = select.options.length > 1 ? select.options.length : 2;


                    opciones.forEach(opcion => {
                        if (opcion.text.toLowerCase().includes(filtro) || filtro === "") {
                            select.appendChild(opcion.cloneNode(true));
                        }
                    });
                });
            }

            filtrarOpciones(".search-input:nth-of-type(1)", "#person");
            filtrarOpciones(".search-input:nth-of-type(2)", "#asesor");
        });
    </script>



    <!-- Chart library -->
    <script src="<?= BASE_URL ?>app/plugins/chart.min.js"></script>

    <!-- Icons library -->
    <script src="<?= BASE_URL ?>app/plugins/feather.min.js"></script>

    <!-- Custom scripts -->
    <script src="<?= BASE_URL ?>app/js/script.js"></script>


</body>



</html>