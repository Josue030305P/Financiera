
<?php include_once "./includes/header.php" ?>

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
            <button class="create-lead">+ Nuevo lead</button>
            <div class="search-container">
                <input type="text" placeholder="Buscar lead 🔍">
               
            </div>
            <button class="import-btn">Exportar</button>
            <button class="delete-btn icon delete"></button>
        </div>

<!-- FORMULARIO PARA AGREGAR UN NUEVO LEAD Y PARA EDITAR -->
<div id="lead-form" class="form-container">
  <div class="form-header h2">
      <h2>Agregar Nuevo Lead</h2>
      <span class="close-btn">✖</span>
  </div>
  
  <div class="form-body">
      <label>Nombre</label>
      <input type="text" placeholder="Ingrese nombre">
      
      <label>Email</label>
      <input type="email" placeholder="Ingrese email">
      
      <label>Teléfono</label>
      <input type="text" placeholder="Ingrese teléfono">
      
      <label>Empresa</label>
      <input type="text" placeholder="Ingrese empresa">
      
      <label>Designación</label>
      <input type="text" placeholder="Ingrese designación">
      
      <label>Estado del Lead</label>
      <select>
          <option>Seleccionar estado</option>
          <option>Nuevo</option>
          <option>En proceso</option>
          <option>Convertido</option>
      </select>
      
      <label>Información Personal</label>
      <textarea placeholder="Ingrese información personal"></textarea>
      
      <div class="form-footer">
          <button class="add-btn">+ Agregar Contacto</button>
          <button class="close-btn">Cerrar</button>
      </div>
  </div>
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
                        <th>Domicilio</th>
                        <th>Referencia</th>
                        <th>Tipo de Documento</th>
                        <th>Número de Documento</th>
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
                        <td>Av. Siempre Viva 742</td>
                        <td>Frente al parque</td>
                        <td>DNI</td>
                        <td>12345678</td>
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
                      <td>Av. Siempre Viva 742</td>
                      <td>Frente al parque</td>
                      <td>DNI</td>
                      <td>12345678</td>
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
                    <td>Av. Siempre Viva 742</td>
                    <td>Frente al parque</td>
                    <td>DNI</td>
                    <td>12345678</td>
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





<script>
  document.addEventListener("DOMContentLoaded", function () {
    const leadForm = document.getElementById("lead-form");

    if (!leadForm) {
        console.error("No se encontró el formulario con ID 'lead-form'");
        return;
    }

    const formTitle = leadForm.querySelector(".form-header h2");
    const addButton = leadForm.querySelector(".add-btn");

    function openForm(editing = false, leadData = {}) {
        leadForm.style.display = "block";

        formTitle.textContent = editing ? "Editar Lead" : "Agregar Nuevo Lead";
        addButton.textContent = editing ? "Guardar Cambios" : "+ Agregar Contacto";

        // Llenar los campos con los datos si es edición, o vaciar si es nuevo
        document.querySelector("input[placeholder='Ingrese nombre']").value = leadData.name || "";
        document.querySelector("input[placeholder='Ingrese email']").value = leadData.email || "";
        document.querySelector("input[placeholder='Ingrese teléfono']").value = leadData.phone || "";
        document.querySelector("input[placeholder='Ingrese empresa']").value = leadData.company || "";
        document.querySelector("input[placeholder='Ingrese designación']").value = leadData.designation || "";
        document.querySelector("textarea[placeholder='Ingrese información personal']").value = leadData.info || "";
    }

    function closeForm() {
        leadForm.style.display = "none";
    }

    
    document.querySelector(".create-lead").addEventListener("click", () => openForm(false));

    
    document.querySelector(".users-table table").addEventListener("click", function (event) {
        if (event.target.classList.contains("edit-lead")) {
            const row = event.target.closest("tr");

            if (!row) {
                console.error("No se encontró la fila de la tabla.");
                return;
            }

            const tds = row.querySelectorAll("td");

            const leadData = {
                name: tds[4]?.textContent.trim() || "",
                phone: tds[5]?.textContent.trim() || "",
                email: tds[6]?.textContent.trim() || "",
                company: tds[7]?.textContent.trim() || "",
                designation: tds[8]?.textContent.trim() || "",
                info: "" 
            };

            openForm(true, leadData);
        }
    });

    
    document.querySelector(".close-btn").addEventListener("click", closeForm);
});


  </script>
  
</body>

</html>