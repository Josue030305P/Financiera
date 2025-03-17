
<?php include_once "./includes/header.php";
  require_once "./includes/config.php";
 ?>

<body>
  
<div class="page-flex">
  <!-- ! Sidebar -->
  <?php require_once "./includes/sidebar.php" ?>

<!-- Fin del sidebar -->
  <div class="main-wrapper">
    <!-- ! Main nav -->
    <?php  require_once "./includes/navbar.php" ?>

  <!-- ! Main -->
    <main class="main users chart-page" id="skip-target">
      <div class="container">
        <h2 class="main-title">Lista de Leads</h2>
        
        <div class="row">
          <div class="table-header">
            <a href="<?=BASE_URL?>/app/views/leads/leads.add.php"><button class="create-lead">+ Nuevo lead</button></a>
            <div class="search-container">
                <input type="text" placeholder="Buscar lead 🔍">
               
            </div>
            <button class="import-btn">Exportar</button>
            <button class="delete-btn icon delete"></button>
        </div>


        <div class="users-table table-wrapper">
            <table class="posts-table">
                <thead>
                    <tr class="users-table-info">
                        <th>Fecha de Cita</th>
                        <th>Hora</th>
                        <th>Prioridad</th>
                        <th>Ocupación</th>
                        <th>Apellidos y Nombres</th>
                        <th>Teléfono</th>
                        <th>Correo Electrónico</th>  
                        <th>Persona Encargada</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>15/03/2025</td>
                        <td>10:30 AM</td>
                        <td>Alta</td>
                        <td>Consulta de mantenimiento</td>
                        <td>González Pérez, Juan</td>
                        
                        <td>987654321</td>
                        <td>juan.gonzalez@example.com</td>
                        <td>María López</td>
                        <td class="row-actions">
                          <img src="./img/svg/Bulk/Edit-white.svg" alt="Editar lead" class="edit-lead">
                          <img src="./img/svg/Bulk//Delete.svg" alt="Eliminar lead" class="delete-lead">
                        </td>
                    </tr>

                    <tr>
                      <td>15/03/2025</td>
                      <td>10:30 AM</td>
                      <td>Alta</td>
                      <td>Consulta de mantenimiento</td>
                      <td>González Pérez, Juan</td>
                      <td>&nbsp;</td>
                      <td>987654321</td>
                      <td>juan.gonzalez@example.com</td> 
                      <td>María López</td>
                      <td class="row-actions">
                        <img src="./img/svg/Bulk/Edit-white.svg" alt="Editar lead" class="edit-lead">
                        <img src="./img/svg/Bulk//Delete.svg" alt="Eliminar lead" class="delete-lead">
                      </td> 
                    </tr>
          
                  <tr>
                    <td>15/03/2025</td>
                    <td>10:30 AM</td>
                    <td>Alta</td>
                    <td>Consulta de mantenimiento</td>
                    <td>González Pérez, Juan</td>
                    <td>987654321</td>
                    <td>juan.gonzalez@example.com</td>
                    <td>María López</td>
                    <td class="row-actions">
                      <img src="./img/svg/Bulk/Edit-white.svg" alt="Editar lead" class="edit-lead">
                      <img src="./img/svg/Bulk//Delete.svg" alt="Eliminar lead" class="delete-lead">
                  </td>
                  
                </tr>
                </tbody>
            </table>
        </div>
        </div>
      </div>
    </main>
    <!-- Fin de la vista leads -->

    <?php require_once "./includes/footer.php"  ?>


  </div>
</div>



  </script>
  
</body>

</html>