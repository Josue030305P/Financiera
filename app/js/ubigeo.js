document.addEventListener("DOMContentLoaded", () => {
  
    const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');
    
    const departamentoSelect = document.getElementById("departamento");
    const provinciaSelect = document.getElementById("provincia");
    const distritoSelect = document.getElementById("distrito");

    fetchDepartamentos();

    departamentoSelect.addEventListener("change", (e) => {
        const departamentoId = e.target.value;
        if (departamentoId) {
            fetchProvincias(departamentoId);
        }
    });

    provinciaSelect.addEventListener("change", (e) => {
        const provinciaId = e.target.value;
        if (provinciaId) {
            fetchDistritos(provinciaId);
        }
    });

    function fetchDepartamentos() {
        fetch(`${baseUrl}app/controllers/UbigeoController`)  
            .then(response => response.json())
            .then(data => {
                console.log(data);
                departamentoSelect.innerHTML = "<option value=''>Seleccione un departamento</option>";
                data.forEach(departamento => {
                    departamentoSelect.innerHTML += `<option value="${departamento.iddepartamento}">${departamento.departamento}</option>`;
                });
            });
    }

    function fetchProvincias(departamentoId) {
        fetch(`${baseUrl}app/controllers/UbigeoController?departamento=${departamentoId}`)
            .then(response => response.json())
            .then(data => {
                provinciaSelect.innerHTML = "<option value=''>Seleccione una provincia</option>";
                data.forEach(provincia => {
                    provinciaSelect.innerHTML += `<option value="${provincia.idprovincia}">${provincia.provincia}</option>`;
                });
            });
    }

    function fetchDistritos(provinciaId) {
        fetch(`${baseUrl}app/controllers/UbigeoController?provincia=${provinciaId}`)
            .then(response => response.json())
            .then(data => {
                distritoSelect.innerHTML = "<option value=''>Seleccione un distrito</option>";
                data.forEach(distrito => {
                    distritoSelect.innerHTML += `<option value="${distrito.iddistrito}">${distrito.distrito}</option>`;
                });
            });
    }
});
