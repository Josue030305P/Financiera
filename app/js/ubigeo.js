document.addEventListener("DOMContentLoaded", () => {
  const baseUrl = document
    .querySelector('meta[name="base-url"]')
    .getAttribute("content");

  const paisSelect = document.getElementById("pais");
  const departamentoSelect = document.getElementById("departamento");
  const provinciaSelect = document.getElementById("provincia");
  const distritoSelect = document.getElementById("distrito");


  paisSelect.dispatchEvent(new Event("change"));
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
    fetch(`${baseUrl}app/controllers/UbigeoController?pais=${paisId}`)
      .then((response) => response.json())
      .then((data) => {
        
        data.forEach((departamento) => {
          console.log(departamento);
          departamentoSelect.innerHTML += `<option value="${departamento.iddepartamento}">${departamento.departamento}</option>`;
        });
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
});