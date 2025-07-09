<?php session_start(); ?>
<?php require_once '../../includes/header.php'; ?>
<?php require_once __DIR__ . "/../../includes/config.php"; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/app/css/usuario.add.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
<meta name="base-url" content="<?= BASE_URL ?>">



<body>
    <div class="page-flex">
        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>

        <div class="main-wrapper">


            <div class="dashboard-header">
                <h1>Gestión de Usuarios</h1>
            </div>

            <div class="form-cards-container">
                <!-- CARD PARA AGREGAR PERSONA_USUARIO -->
                <div class="card add-persona-card">
                    <div class="card-header header-persona">
                        <h3><i class="fas fa-user-plus icon-title"></i> Agregar Persona/Usuario</h3>
                    </div>
                    <div class="card-body">
                        <form id="form-persona">
                            <div class="input-group">
                                <label for="pais"><i class="fas fa-globe"></i> País</label>
                                <select id="pais" name="pais" required>
                                    <option value="">Perú</option>


                                </select>
                            </div>
                            <div class="input-group">
                                <label for="apellidos"><i class="fas fa-signature"></i> Apellidos</label>
                                <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" required>
                            </div>
                            <div class="input-group">
                                <label for="nombres"><i class="fas fa-file-signature"></i> Nombres</label>
                                <input type="text" id="nombres" name="nombres" placeholder="Nombres" required>
                            </div>
                            <div class="input-group">
                                <label for="fechanacimiento"><i class="fas fa-calendar-alt"></i> Fecha de
                                    Nacimiento</label>
                                <input type="date" id="fechanacimiento" name="fechanacimiento" required>
                            </div>
                            <div class="input-group">
                                <label for="tipodocumento"><i class="fas fa-id-card"></i> Tipo de Documento</label>
                                <select id="tipodocumento" name="tipodocumento" required>
                                    <option value="DNI" selected>DNI</option>
                                    <option value="PSP">PSP</option>
                                    <option value="CEX">CEX</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label for="numdocumento"><i class="fas fa-fingerprint"></i> Número de Documento</label>
                                <input type="text" id="numdocumento" name="numdocumento"
                                    placeholder="Número de Documento" maxlength="8" required>
                            </div>
                            <div class="input-group">
                                <label for="correo"><i class="fas fa-envelope"></i> Email</label>
                                <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" required>
                            </div>
                            <div class="input-group">
                                <label for="telprincipal"><i class="fas fa-phone"></i> Teléfono Principal</label>
                                <input type="text" id="telprincipal" name="telprincipal" placeholder="9XXXXXXXX"
                                    maxlength="9" required>
                            </div>
                            <div class="input-group full-width">
                                <label for="domicilio"><i class="fas fa-home"></i> Domicilio</label>
                                <input type="text" id="domicilio" name="domicilio" placeholder="Dirección completa"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary full-width" id="crear-persona">Crear
                                Persona</button>
                        </form>
                    </div>
                </div>

                <!-- CARD PARA AGREGAR COLABORADOR_USUARIO -->
                <div class="card add-colaborador-card card-hidden">
                    <div class="card-header header-colaborador">
                        <h3><i class="fas fa-user-tie icon-title"></i> Agregar Colaborador/Usuario</h3>
                    </div>
                    <div class="card-body">
                        <form id="form-colaborador">
                            <div class="input-group">
                                <label for="colaborador"><i class="fas fa-user"></i> Seleccionar Persona</label>
                                <select id="colaborador" name="colaborador" required>
                                    <option value="">Seleccione una persona</option>

                                </select>
                            </div>
                            <div class="input-group">
                                <label for="rol"><i class="fas fa-user-tag"></i> Rol</label>
                                <select id="rol" name="rol" required>
                                    <option value="">Seleccione un rol</option>


                                </select>
                            </div>
                            <div class="input-group">
                                <label for="fechainicio"><i class="fas fa-calendar-check"></i> Fecha de Inicio</label>
                                <input type="date" id="fechainicio" name="fechainicio" required>
                            </div>
                            <div class="input-group">
                                <label for="fechafin"><i class="fas fa-calendar-times"></i> Fecha de Fin </label>
                                <input type="date" id="fechafin" name="fechafin">
                            </div>
                            <div class="input-group full-width">
                                <label for="observaciones"><i class="fas fa-comment-dots"></i> Observaciones</label>
                                <textarea id="observaciones" name="observaciones"
                                    placeholder="Comentarios adicionales"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success full-width" id="agregar-colaborador">Agregar
                                Colaborador</button>
                        </form>
                    </div>
                </div>

                <!-- CARD PARA AGREGAR UN USUARIO -->
                <div class="card add-usuario-login-card card-hidden">
                    <div class="card-header header-usuario-login">
                        <h3><i class="fas fa-key icon-title"></i> Crear Credenciales de Usuario</h3>
                    </div>
                    <div class="card-body">
                        <form id="form-usuario-login">
                            <div class="input-group full-width">
                                <label for="usuario"><i class="fas fa-user-circle"></i> Seleccionar Colaborador</label>
                                <select id="usuario" name="usuario" required>
                                    <option value="">Seleccione un colaborador</option>

                                </select>
                            </div>
                            <div class="input-group">
                                <label for="usuario"><i class="fas fa-user"></i> Nombre de Usuario</label>
                                <input type="text" id="usuario" name="usuario" placeholder="Ej: j.perez" required>
                            </div>
                            <div class="input-group">
                                <label for="password"><i class="fas fa-lock"></i> Contraseña</label>
                                <input type="password" id="password" name="password" placeholder="********" required>
                            </div>
                            <div class="input-group full-width file-input-group">
                                <label for="fotoperfil"><i class="fas fa-camera"></i> Foto de Perfil</label>
                                <input type="file" id="fotoperfil" name="fotoperfil" accept="image/*">
                                <label for="fotoperfil" class="custom-file-upload">
                                    <i class="fas fa-upload"></i> Subir Foto
                                </label>
                                <span id="file-name-display" class="file-name-display">Ningún archivo
                                    seleccionado</span>
                            </div>
                            <button type="submit" class="btn btn-dark full-width" id="crear-usuario">Crear
                                Usuario</button>
                        </form>
                    </div>
                </div>
            </div>



        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="<?= BASE_URL ?>app/js/usuario.add.js"></script>


</body>