const baseUrl = document
  .querySelector('meta[name="base-url"]')
  .getAttribute("content");

const fechainicioInput = document.getElementById("fechainicio");

const hoy = new Date().toISOString().split("T")[0];
fechainicioInput.value = hoy;

// Referencias a los elementos del DOM
const paisSelect = document.getElementById("pais");
const colaboradorSelect = document.getElementById("colaborador");
const rolesSelect = document.getElementById("rol");
const usuarioSelect = document.getElementById("usuario");

const formPersona = document.getElementById("form-persona");
const formColaborador = document.getElementById("form-colaborador");
const formUsuarioLogin = document.getElementById("form-usuario-login");

const cardPersona = document.querySelector(".add-persona-card");
const cardColaborador = document.querySelector(".add-colaborador-card");
const cardUsuarioLogin = document.querySelector(".add-usuario-login-card");

const fileNameDisplay = document.getElementById("file-name-display");
const fotoperfilInput = document.getElementById("fotoperfil");

// --- Funciones de Utilidad ---

/**
 * Muestra una notificación usando SweetAlert2.
 * @param {string} icon - 'success', 'error', 'warning', 'info', 'question'.
 * @param {string} title - Título de la notificación.
 * @param {string} text - Texto del cuerpo de la notificación.
 */
function showNotification(icon, title, text) {
  Swal.fire({
    icon: icon,
    title: title,
    text: text,
    toast: true, // Esto lo convierte en una notificación "toast"
    position: "top-end", // Posición en la esquina superior derecha
    showConfirmButton: false, // No mostrar botón de confirmación
    timer: 3000, // Duración en milisegundos
    timerProgressBar: true, // Barra de progreso del temporizador
    didOpen: (toast) => {
      toast.addEventListener("mouseenter", Swal.stopTimer);
      toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
  });
}

/**
 * Muestra una tarjeta y oculta las demás si se especifica.
 * @param {HTMLElement} cardToShow - La tarjeta que se quiere mostrar.
 */
function showCard(cardToShow) {
  const allCards = [cardPersona, cardColaborador, cardUsuarioLogin];
  allCards.forEach((card) => {
    if (card === cardToShow) {
      card.classList.remove("card-hidden");
      card.classList.add("card-visible");
    } else {
      card.classList.remove("card-visible");
      card.classList.add("card-hidden");
    }
  });
}

/**
 * Limpia un elemento select y lo rellena con nuevas opciones.
 * @param {HTMLSelectElement} selectElement - El elemento select a limpiar y rellenar.
 * @param {Array<Object>} data - Array de objetos con los datos para las opciones.
 * @param {string} valueKey - La clave del objeto para el atributo 'value' de la opción.
 * @param {string} textKey - La clave del objeto para el texto visible de la opción.
 * @param {string} defaultOptionText - Texto para la opción por defecto (ej. "Seleccione...").
 */
function populateSelect(
  selectElement,
  data,
  valueKey,
  textKey,
  defaultOptionText = "Seleccione una opción"
) {
  selectElement.innerHTML = `<option value="">${defaultOptionText}</option>`; // Limpia y añade opción por defecto
  data.forEach((item) => {
    const option = document.createElement("option");
    option.value = item[valueKey];
    option.textContent = item[textKey];
    selectElement.appendChild(option);
  });
}

// --- Event Listeners Iniciales ---

// Event listener para actualizar el nombre del archivo seleccionado en el input de foto de perfil
fotoperfilInput.addEventListener("change", function () {
  if (this.files && this.files.length > 0) {
    fileNameDisplay.textContent = this.files[0].name;
  } else {
    fileNameDisplay.textContent = "Ningún archivo seleccionado";
  }
});

// --- Funciones para Obtener Datos (Fetch) ---

async function fetchAndPopulate(
  url,
  selectElement,
  valueKey,
  textKey,
  defaultText
) {
  try {
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const data = await response.json();
    populateSelect(selectElement, data, valueKey, textKey, defaultText);
    return data; // Retorna los datos por si se necesitan
  } catch (error) {
    console.error(`Error al obtener datos de ${url}:`, error);
    showNotification(
      "error",
      "Error de carga",
      `No se pudieron cargar los datos necesarios: ${error.message}`
    );
    return [];
  }
}

async function obtenerPaises() {
  const paises = await fetchAndPopulate(
    `${baseUrl}app/controllers/PaisController`,
    paisSelect,
    "idpais",
    "pais",
    "Seleccione un país"
  );

  const peru = paises.find(
    (p) => p.pais.toLowerCase() === "perú" || p.pais.toLowerCase() === "peru"
  );
  if (peru) {
    paisSelect.value = peru.idpais;
  }
}

async function obtenerPersonaToColaborador() {
  const personas = await fetchAndPopulate(
    `${baseUrl}app/controllers/ColaboradorController`,
    colaboradorSelect,
    "idpersona",
    "nombrecompleto",
    "" // No poner texto de opción por defecto
  );

  // Si hay al menos una persona, se selecciona la primera automáticamente
  if (personas.length > 0) {
    colaboradorSelect.value = personas[0].idpersona;
  }
}

async function obtenerRoles() {
  await fetchAndPopulate(
    `${baseUrl}app/controllers/RolesController`,
    rolesSelect,
    "idrol",
    "rol",
    "Seleccione un rol"
  );
}

async function obtenerColaboradorToUsuario() {
  const colaborador = await fetchAndPopulate(
    `${baseUrl}app/controllers/UsuarioController`,
    usuarioSelect,
    "idcolaborador",
    "nombrecompleto",
    ""
  );

  if (colaborador.length > 0) {
    usuarioSelect.value = colaborador[0].idcolaborador;
  }
}

// --- Funciones para Enviar Formularios ---

async function agregarPersonaUsuario() {
  const formData = {
    idpais: paisSelect.value,
    apellidos: document.getElementById("apellidos").value,
    nombres: document.getElementById("nombres").value,
    fechanacimiento: document.getElementById("fechanacimiento").value,
    tipodocumento: document.getElementById("tipodocumento").value,
    numdocumento: document.getElementById("numdocumento").value,
    email: document.getElementById("email").value,
    telprincipal: document.getElementById("telprincipal").value,
    domicilio: document.getElementById("domicilio").value.trim() || null, // trim() para limpiar espacios
  };

  // Validación básica
  if (
    !formData.idpais ||
    !formData.apellidos ||
    !formData.nombres ||
    !formData.fechanacimiento ||
    !formData.tipodocumento ||
    !formData.numdocumento ||
    !formData.email ||
    !formData.telprincipal
  ) {
    showNotification(
      "warning",
      "Campos Requeridos",
      "Por favor, complete todos los campos de la Persona."
    );
    return;
  }

  try {
    const peticion = await fetch(
      `${baseUrl}app/controllers/PersonaUsuarioController`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
      }
    );

    const resultado = await peticion.json();

    if (resultado.status) {
      showNotification(
        "success",
        "¡Éxito!",
        resultado.message || "Persona agregada correctamente."
      );
      formPersona.reset(); // Limpia el formulario
      await obtenerPersonaToColaborador(); // Actualiza el select de colaborador
      showCard(cardColaborador); // Muestra la siguiente tarjeta
    } else {
      showNotification(
        "error",
        "Error",
        resultado.message || "No se pudo agregar a la persona."
      );
    }
  } catch (error) {
    console.error("Error al agregar persona:", error);
    showNotification(
      "error",
      "Error de Conexión",
      "Ocurrió un error al comunicarse con el servidor al agregar persona."
    );
  }
}

async function agregarColaboradorUsuario() {
  const formData = {
    idpersona: colaboradorSelect.value,
    idrol: rolesSelect.value,
    fechainicio: document.getElementById("fechainicio").value,
    fechafin: document.getElementById("fechafin").value.trim() || null, // Permitir nulo si está vacío
    observaciones:
      document.getElementById("observaciones").value.trim() || null,
  };

  // Validación básica
  if (!formData.idpersona || !formData.idrol || !formData.fechainicio) {
    showNotification(
      "warning",
      "Campos Requeridos",
      "Por favor, complete todos los campos del Colaborador."
    );
    return;
  }

  try {
    const peticion = await fetch(
      `${baseUrl}app/controllers/ColaboradorController`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
      }
    );

    const resultado = await peticion.json();

    if (resultado.status) {
      showNotification(
        "success",
        "¡Éxito!",
        resultado.message || "Colaborador agregado correctamente."
      );
      formColaborador.reset(); // Limpia el formulario
      await obtenerColaboradorToUsuario(); // Actualiza el select de usuario
      showCard(cardUsuarioLogin); // Muestra la siguiente tarjeta
    } else {
      showNotification(
        "error",
        "Error",
        resultado.message || "No se pudo agregar el colaborador."
      );
    }
  } catch (error) {
    console.error("Error al agregar colaborador:", error);
    showNotification(
      "error",
      "Error de Conexión",
      "Ocurrió un error al comunicarse con el servidor al agregar colaborador."
    );
  }
}

async function agregarUsuario() {
  const formData = new FormData(formUsuarioLogin);

  if (!formData.get("usuario") || !formData.get("password")) {
    // 'usuario' en este contexto es 'nombreusuario' del input
    showNotification(
      "warning",
      "Campos Requeridos",
      "Por favor, complete el nombre de usuario y la contraseña."
    );
    return;
  }
  if (!usuarioSelect.value) {
    // Validación para el select de colaborador
    showNotification(
      "warning",
      "Campos Requeridos",
      "Por favor, seleccione un colaborador."
    );
    return;
  }

  formData.append("idcolaborador", usuarioSelect.value);
  try {
    const peticion = await fetch(
      `${baseUrl}app/controllers/UsuarioController`,
      {
        method: "POST",
        // ¡IMPORTANTE! No especificar 'Content-Type' cuando se usa FormData.
        body: formData,
      }
    );

    const resultado = await peticion.json();

    if (resultado.status) {
      showNotification(
        "success",
        "¡Éxito!",
        resultado.message || "Usuario agregado correctamente."
      );
      setTimeout(() => {
        location.reload();
      }, 1000);
      formUsuarioLogin.reset();
      fileNameDisplay.textContent = "Ningún archivo seleccionado";
      showCard(cardPersona);
    } else {
      showNotification(
        "error",
        "Error",
        resultado.message || "No se pudo agregar el usuario."
      );
    }
  } catch (error) {
    console.error("Error al agregar usuario:", error);
    showNotification(
      "error",
      "Error de Conexión",
      "Ocurrió un error al comunicarse con el servidor al agregar usuario."
    );
  }
}

document.addEventListener("DOMContentLoaded", () => {
  showCard(cardPersona);

  // Cargar datos iniciales
  obtenerPaises();
  obtenerPersonaToColaborador();
  obtenerRoles();
  obtenerColaboradorToUsuario();
});

// Asignación de Event Listeners a los formularios
formPersona.addEventListener("submit", async (e) => {
  e.preventDefault();
  await agregarPersonaUsuario();
});

formColaborador.addEventListener("submit", async (e) => {
  e.preventDefault();
  await agregarColaboradorUsuario();
});

formUsuarioLogin.addEventListener("submit", async (e) => {
  e.preventDefault();
  await agregarUsuario();
});
