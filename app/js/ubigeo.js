document.addEventListener("DOMContentLoaded", () => {
  const baseUrl = document
    .querySelector('meta[name="base-url"]')
    .getAttribute("content");

  const paisSelect = document.getElementById("pais");
  const departamentoSelect = document.getElementById("departamento");
  const provinciaSelect = document.getElementById("provincia");
  const distritoSelect = document.getElementById("distrito");

  // Disparar change inicial solo si no hay valor preseleccionado
  if (!paisSelect.value) {
    paisSelect.dispatchEvent(new Event("change"));
  }

  paisSelect.addEventListener("change", (e) => {
    const paisId = e.target.value;
    console.log(paisId);

    if (paisId) {
      fetchDepartamentos(paisId);
    } else {
      departamentoSelect.innerHTML =
        "<option value=''>Seleccione un departamento</option>";
      provinciaSelect.innerHTML =
        "<option value=''>Seleccione una provincia</option>";
      distritoSelect.innerHTML =
        "<option value=''>Seleccione un distrito</option>";
    }
  });

  departamentoSelect.addEventListener("change", (e) => {
    const departamentoId = e.target.value;
    if (departamentoId) {
      fetchProvincias(departamentoId);
    } else {
      provinciaSelect.innerHTML =
        "<option value=''>Seleccione una provincia</option>";
      distritoSelect.innerHTML =
        "<option value=''>Seleccione un distrito</option>";
    }
  });

  provinciaSelect.addEventListener("change", (e) => {
    const provinciaId = e.target.value;
    if (provinciaId) {
      fetchDistritos(provinciaId);
    } else {
      distritoSelect.innerHTML =
        "<option value=''>Seleccione un distrito</option>";
    }
  });

  function fetchDepartamentos(paisId) {
    // Limpiar departamentos antes de cargar nuevos
    departamentoSelect.innerHTML = "<option value=''>Seleccione un departamento</option>";
    provinciaSelect.innerHTML = "<option value=''>Seleccione una provincia</option>";
    distritoSelect.innerHTML = "<option value=''>Seleccione un distrito</option>";
    
    fetch(`${baseUrl}app/controllers/UbigeoController?pais=${paisId}`)
      .then((response) => response.json())
      .then((data) => {
        data.forEach((departamento) => {
          console.log(departamento);
          departamentoSelect.innerHTML += `<option value="${departamento.iddepartamento}">${departamento.departamento}</option>`;
        });
        
        // Si hay un departamento preseleccionado, disparar su evento change
        if (departamentoSelect.value) {
          departamentoSelect.dispatchEvent(new Event("change"));
        }
      })
      .catch((error) => console.error("Error al cargar departamentos:", error));
  }

  function fetchProvincias(departamentoId) {
    fetch(
      `${baseUrl}app/controllers/UbigeoController?departamento=${departamentoId}`
    )
      .then((response) => response.json())
      .then((data) => {
        provinciaSelect.innerHTML =
          "<option value=''>Seleccione una provincia</option>";
        data.forEach((provincia) => {
          provinciaSelect.innerHTML += `<option value="${provincia.idprovincia}">${provincia.provincia}</option>`;
        });
        
        // Si hay una provincia preseleccionada, disparar su evento change
        if (provinciaSelect.value) {
          provinciaSelect.dispatchEvent(new Event("change"));
        }
      })
      .catch((error) => console.error("Error al cargar provincias:", error));
  }

  function fetchDistritos(provinciaId) {
    fetch(`${baseUrl}app/controllers/UbigeoController?provincia=${provinciaId}`)
      .then((response) => response.json())
      .then((data) => {
        distritoSelect.innerHTML =
          "<option value=''>Seleccione un distrito</option>";
        data.forEach((distrito) => {
          distritoSelect.innerHTML += `<option value="${distrito.iddistrito}">${distrito.distrito}</option>`;
        });
      })
      .catch((error) => console.error("Error al cargar distritos:", error));
  }

  // Función pública para cargar ubigeo completo (llamar desde cargarDatosLead)
  window.cargarUbigeoCompleto = function(paisId, departamentoId, provinciaId, distritoId) {
    if (paisId) {
      paisSelect.value = paisId;
      
      fetchDepartamentos(paisId).then(() => {
        if (departamentoId) {
          setTimeout(() => {
            departamentoSelect.value = departamentoId;
            
            fetchProvincias(departamentoId).then(() => {
              if (provinciaId) {
                setTimeout(() => {
                  provinciaSelect.value = provinciaId;
                  
                  if (distritoId) {
                    fetchDistritos(provinciaId).then(() => {
                      setTimeout(() => {
                        distritoSelect.value = distritoId;
                      }, 100);
                    });
                  }
                }, 100);
              }
            });
          }, 100);
        }
      });
    }
  };
});