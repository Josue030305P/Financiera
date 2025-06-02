<?php session_start(); ?>
<?php require_once '../../includes/header.php'; ?>
<?php require_once "../../includes/config.php"; ?>


<meta name="base-url" content="<?= BASE_URL ?>">
 <link rel="stylesheet" href="<?= BASE_URL ?>/app/css/form.update.css"> 

<body>
    <div class="page-flex">
        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>
        <div class="main-wrapper">
            <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>

            <div id="lead-form" class="form-container form">
                <h2 class="form-title">Actualizar Lead</h2>
                <div class="form-header">
                    <a href="<?= BASE_URL ?>app/"><span class="regresar-btn"> ⬅️ Lista de leads</span></a>
                </div>

                <div class="form-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" id="apellidos" placeholder="Ingrese sus apellidos" class="apellidos"
                                required disabled>
                        </div>

                        <div class="form-group">
                            <label for="nombres">Nombres</label>
                            <input type="text" id="nombres" placeholder="Ingrese sus nombres" class="nombres" required disabled>
                        </div>

                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="tel" id="telefono" placeholder="Ingrese su teléfono" class="telefono"
                                maxlength="9" required disabled>
                        </div>

                        <div class="form-group">
                            <label for="telsecundario">Telefono secundario (Opcional)</label>
                            <input type="tel" id="telsecundario" placeholder="Ingrese número de telefono"
                                class="telsecundario" maxlength="9">
                        </div>


                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input type="email" id="correo" name="email" placeholder="Ingrese su correo" class="correo" required disabled>
                        </div>

                        <div class="form-group">
                            <label for="pais">País</label>
                            <select name="pais" id="pais" class="select-box" required disabled>
                                <option value="">Seleccione un país</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="departamento">Departamento</label>
                            <select name="departamento" id="departamento" class="select-box" required>
                                <option value="">Seleccione un departamento</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="provincia">Provincia</label>
                            <select name="provincia" id="provincia" class="select-box" required>
                                <option value="">Seleccione un provincia</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="distrito">Distrito</label>
                            <select name="distrito" id="distrito" class="select-box" required>
                                <option value="">Seleccione un distrito</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tipodocumento">Tipo de documento</label>
                            <select name="tipodocumento" id="tipodocumento" class="select-box" required>
                                <option value="DNI">DNI</option>
                                <option value="PSP">PSP</option>
                                <option value="CEX">CEX</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="numdocumento">N° documento</label>
                            <input type="text" id="numdocumento" name="numdocumento" placeholder="Ingrese el n° de documento"
                                class="numdocumento" required="true" maxlength="12">
                        </div>

                        <div class="form-group">
                            <label for="fechanacimiento">Fecha nacimiento</label>
                            <input type="datetime" id="fechanacimiento" name="fechanacimiento" placeholder="Ingrese la fecha de nacimiento"
                                class="fechanacimiento" required="true">
                        </div>


                        <div class="form-group">
                            <label for="domicilio">Domicilio</label>
                            <input type="text" id="domicilio" name="domicilio" placeholder="Ingrese el domicilio" class="domicilio">
                        </div>



                        <div class="form-group">
                            <label for="referencia">Referencia</label>
                            <input type="text" id="referencia" name="referencia" placeholder="Ingrese una referencia"
                                class="numdocumento">
                        </div>


                        <div class="form-group">
                            <label for="prioridad">Prioridad</label>
                            <select name="prioridad" id="prioridad" class="select-box" required>
                                <option value="">Seleccione prioridad</option>
                                <option value="Alto">Alto</option>
                                <option value="Medio">Medio</option>
                                <option value="Bajo">Bajo</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="asesor">Asesor</label>
                            <select name="asesor" id="asesor" class="select-box" required>
                                <option value="">Seleccione un asesor</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="canal">Canal</label>
                            <select name="canal" id="canal" class="select-box" required>
                                <option value="">Seleccione un canal</option>
                                <option value="1">Facebook</option>
                                <option value="2">WhatsApp</option>
                                <option value="3">Instagram</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ocupacion">Ocupación</label>
                            <input type="text" id="ocupacion" name=ocupacion placeholder="Ingrese una ocupación" class="ocupacion">
                        </div>

                        <div class="form-group full-width">
                            <label for="comentarios">Comentarios</label>
                            <textarea name="comentarios" id="comentarios" class="textarea-box"></textarea>
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="button" class="add-btn">Actualizar lead</button>
                        <button type="button" class="reset-btn">Cancelar</button>
                        <form action="<?= BASE_URL ?>app/views/contratos/contrato.add.php" method="post" id="invertirForm">
                            <input type="hidden" name="leadId" id="leadIdInput" value="">
                            <button type="submit" class="invertir-btn d-none" visible="false">Invertir</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= BASE_URL ?>app/plugins/chart.min.js"></script>
    <script src="<?= BASE_URL ?>app/plugins/feather.min.js"></script>
    <script src="<?= BASE_URL ?>app/js/script.js"></script>
    <script src="<?= BASE_URL ?>app/js/ubigeo.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/css/pikaday.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/pikaday.min.js"></script>



    <script src="<?= BASE_URL ?>app/js/lead.form.js"></script>
    <script>
        // Función para validar edad mínima
        function validarEdadMinima(fechaNacimiento, edadMinima = 22) {
            const hoy = new Date();
            const fechaNac = new Date(fechaNacimiento);

            // Calcular la edad
            let edad = hoy.getFullYear() - fechaNac.getFullYear();
            const diferenciaMeses = hoy.getMonth() - fechaNac.getMonth();

            // Ajustar si aún no ha cumplido años este año
            if (diferenciaMeses < 0 || (diferenciaMeses === 0 && hoy.getDate() < fechaNac.getDate())) {
                edad--;
            }

            return {
                esValida: edad >= edadMinima,
                edad: edad,
                edadMinima: edadMinima
            };
        }

        // Función para mostrar mensaje de error
        function mostrarErrorEdad(edad, edadMinima) {
            Swal.fire({
                title: 'Edad no válida',
                text: `La edad mínima requerida es ${edadMinima} años. Edad actual: ${edad} años.`,
                icon: 'error',
                confirmButtonText: 'Entendido'
            });
        }


        document.addEventListener('DOMContentLoaded', () => {
            let picker = new Pikaday({
                field: document.getElementById('fechanacimiento'),
                format: 'DD-MM-YYYY',
                yearRange: [1900, 3000],
                minDate: new Date(1900, 0, 1),
                maxDate: new Date(),
                i18n: {
                    previousMonth: 'Mes anterior',
                    nextMonth: 'Mes siguiente',
                    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb']
                },
                onSelect: function() {
                    let fechaSeleccionada = this.getDate();
                    let fechaFormateada = fechaSeleccionada.toLocaleDateString('es-ES');
                    fechaFormateada = fechaFormateada.replace(/\//g, '-');


                    const validacion = validarEdadMinima(fechaSeleccionada, 22);

                    if (!validacion.esValida) {

                        document.getElementById('fechanacimiento').value = '';
                        mostrarErrorEdad(validacion.edad, validacion.edadMinima);
                        return;
                    }

                    document.getElementById('fechanacimiento').value = fechaFormateada;
                }
            });


            const btnActualizar = document.querySelector('.add-btn');
            if (btnActualizar) {
                btnActualizar.addEventListener('click', (e) => {
                    const fechaNacimiento = document.getElementById('fechanacimiento').value;

                    if (fechaNacimiento) {

                        const partes = fechaNacimiento.split('-');
                        const fecha = new Date(partes[2], partes[1] - 1, partes[0]);

                        const validacion = validarEdadMinima(fecha, 22);

                        if (!validacion.esValida) {
                            e.preventDefault();
                            mostrarErrorEdad(validacion.edad, validacion.edadMinima);
                            return false;
                        }
                    }


                });
            }


            const urlParams = new URLSearchParams(window.location.search);
            const leadId = urlParams.get('id');
            const invertirForm = document.getElementById('invertirForm');
            const leadIdInput = document.getElementById('leadIdInput');
            const btnContrato = document.querySelector('.invertir-btn');

            if (leadId) {
                new LeadForm(leadId, true);
                leadIdInput.value = leadId;

                btnContrato.addEventListener('click', function(e) {
                    e.preventDefault();
                    invertirForm.submit();
                });
            } else {
                alert('ID de lead no proporcionado');
                window.location.href = BASE_URL + 'app/';
            }
        });
    </script>
</body>



</html>