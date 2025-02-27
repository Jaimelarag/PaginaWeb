document.addEventListener("DOMContentLoaded", function () {
    const productoSelect = document.getElementById("producto");
    const plazoInput = document.getElementById("plazo");
    const extra1 = document.getElementById("extra1");
    const extra2 = document.getElementById("extra2");
    const extra3 = document.getElementById("extra3");
    const privacidadCheckbox = document.getElementById("privacidad");
    const presupuestoFinal = document.getElementById("presupuestoFinal");
    const enviarPresupuestoButton = document.getElementById("enviarBtn");

    // Función para actualizar el presupuesto
    function actualizarPresupuesto() {
        let productoPrecio = parseInt(productoSelect.value);
        let plazo = parseInt(plazoInput.value);
        let extras = 0;

         // Validar que el plazo no sea mayor a 6 meses
         if (plazo > 6) {
            plazo = 6;
            plazoInput.value = plazo; // Restablecer el valor en el input
            alert("El plazo de entrega no puede ser mayor a 6 meses.");
        }

        // Calcular precio de extras seleccionados
        if (extra1.checked) extras += parseInt(extra1.value);
        if (extra2.checked) extras += parseInt(extra2.value);
        if (extra3.checked) extras += parseInt(extra3.value);

        // Descuento por plazo
        let descuento = (plazo - 1) * 0.025 * productoPrecio;
        let precioFinal = productoPrecio + extras - descuento;

        // Actualizar el presupuesto final
        presupuestoFinal.textContent = `${precioFinal.toFixed(2)}€`;

        // Habilitar el botón de envío solo si se aceptan las condiciones
        enviarPresupuestoButton.disabled = !privacidadCheckbox.checked;
    }

    // Eventos para actualizar el presupuesto al cambiar opciones
    productoSelect.addEventListener("change", actualizarPresupuesto);
    plazoInput.addEventListener("input", actualizarPresupuesto);
    extra1.addEventListener("change", actualizarPresupuesto);
    extra2.addEventListener("change", actualizarPresupuesto);
    extra3.addEventListener("change", actualizarPresupuesto);
    privacidadCheckbox.addEventListener("change", actualizarPresupuesto);

    // Inicializar el presupuesto al cargar la página
    actualizarPresupuesto();
});

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("presupuestoForm");
    const nombreInput = document.getElementById("nombre");
    const apellidosInput = document.getElementById("apellidos");
    const telefonoInput = document.getElementById("telefono");
    const emailInput = document.getElementById("email");

    // Función para validar el nombre
    function validarNombre(nombre) {
        const regexNombre = /^[A-Za-z]{1,15}$/;
        return regexNombre.test(nombre);
    }

    // Función para validar los apellidos
    function validarApellidos(apellidos) {
        const regexApellidos = /^[A-Za-z]{1,40}$/;
        return regexApellidos.test(apellidos);
    }

    // Función para validar el teléfono
    function validarTelefono(telefono) {
        const regexTelefono = /^[0-9]{9}$/;
        return regexTelefono.test(telefono);
    }

    // Función para validar el correo electrónico
    function validarEmail(email) {
        const regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return regexEmail.test(email);
    }

    // Función para validar el formulario
    function validarFormulario(event) {
        event.preventDefault(); // Evitar el envío del formulario hasta que se valide

        const nombreValido = validarNombre(nombreInput.value);
        const apellidosValidos = validarApellidos(apellidosInput.value);
        const telefonoValido = validarTelefono(telefonoInput.value);
        const emailValido = validarEmail(emailInput.value);

        // Validación del nombre
        if (!nombreValido) {
            alert("El nombre debe contener solo letras y un máximo de 15 caracteres.");
            return;
        }

        // Validación de apellidos
        if (!apellidosValidos) {
            alert("Los apellidos deben contener solo letras y un máximo de 40 caracteres.");
            return;
        }

        // Validación del teléfono
        if (!telefonoValido) {
            alert("El teléfono debe contener solo 9 dígitos numéricos.");
            return;
        }

        // Validación del correo electrónico
        if (!emailValido) {
            alert("Por favor, ingrese un correo electrónico válido.");
            return;
        }

        // Si todo es válido, enviar el formulario
        alert("Formulario enviado correctamente.");
        form.submit();
    }

    // Agregar el evento submit al formulario
    form.addEventListener("submit", validarFormulario);
});
