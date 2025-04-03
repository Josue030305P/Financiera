<?php require_once '../../includes/header.php'; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/app/css/form-add/form.add.css">
<meta name="base-url" content="<?= BASE_URL ?>">

<body>

    <div class="page-flex">

        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>

        <div class="main-wrapper">

            <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>


            <div class="form-container form">
                <h2 class="form-title">Agregar Nuevo Inversionista</h2>
                <div class="form-header">

                    <a href="<?= BASE_URL ?>app/views/inversionistas/"><span class="regresar-btn"> ⬅️ Inversionistas</span></a>

                </div>


                <div class="form-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" id="apellidos" placeholder="Ingrese sus apellidos" class="apellidos" disabled>
                        </div>

                        <div class="form-group">
                            <label for="nombres">Nombres</label>
                            <input type="text" id="nombres" placeholder="Ingrese sus nombres" class="nombres" disabled>
                        </div>

                        <div class="form-group">
                            <label for="tipodocumento">Tipo de documento</label>
                            <select id="tipodocumento" class="select-box" disabled>
                                <option value="DNI">DNI</option>
                                <option value="RUC">RUC</option>
                                <option value="CE">CE</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="numdocumento">Número de Documento</label>
                            <input type="text" id="numdocumento" placeholder="Ingrese su documento"
                                class="numdocumento" maxlength="12">
                        </div>


                        <div class="form-group">
                            <label for="fechanacimiento">Fecha de Nacimiento</label>
                            <input type="date" id="fechanacimiento" class="fechanacimiento">
                        </div>

                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="tel" id="telefono" placeholder="Ingrese su teléfono" class="telefono" maxlength="9" disabled>
                        </div>

                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <input type="email" id="correo" placeholder="Ingrese su correo" class="correo" disabled>
                        </div>

                        <div class="form-group">
                            <label for="pais">País</label>
                            <select id="pais" class="select-box" >
                                <option value="">Seleccione un país</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="distrito">Provincia</label>
                            <select id="distrito" class="select-box">
                                <option value="">Seleccione un distrito</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="distrito">Distrito</label>
                            <select id="distrito" class="select-box">
                                <option value="">Seleccione un distrito</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="domicilio">Domicilio</label>
                            <input type="text" id="domicilio" placeholder="Ingrese el domicilio" class="domicilio">
                        </div>
                        <div class="form-group">
                            <label for="referencia">Referencia</label>
                            <input type="text" id="referencia" placeholder="Ingrese una referencia" class="referencia ">
                        </div>


                        <div class="form-group ">
                            <label for="nombreempresa">Empresa (Opcional)</label>
                            <input type="text" id="nombreempresa" placeholder="Ingrese nombre de la empresa"
                                class="nombreempresa">
                        </div>

                        <div class="form-group ">
                            <label for="ruc">RUC (Opcional)</label>
                            <input type="text" id="ruc" placeholder="Ingrese RUC de la empresa" class="ruc">
                        </div>

                     
                        

                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select id="estado" class="select-box">
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="asesor">Asesor</label>
                            <select id="asesor" class="select-box">
                                <option value="">Seleccione un asesor</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-footer">
                        <button class="add-btn">Agregar Inversionista</button>
                        <button class="reset-btn">Cancelar</button>
                    </div>
                </div>

            </div>


        </div>


    </div>


    <!-- Chart library -->
    <script src="<?= BASE_URL ?>app/plugins/chart.min.js"></script>

    <!-- Icons library -->
    <script src="<?= BASE_URL ?>app/plugins/feather.min.js"></script>

    <!-- Custom scripts -->
    <script src="<?= BASE_URL ?>app/js/script.js"></script>
    
    <!-- Inversionista form script -->
    <script src="<?= BASE_URL ?>app/js/inversionista.form.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            new InversionistaForm();
        });
    </script>

</body>