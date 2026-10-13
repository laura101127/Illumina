document.addEventListener("DOMContentLoaded", function () {

    const formulario = document.getElementById("registro-form");
    const correo = document.getElementById("correo");
    const fechaNacimiento = document.getElementById("fecha");
    const contrasena = document.getElementById("contrasena");
    const confirmarContrasena = document.getElementById("confirmar-contrasena");
    const passwordMessage = document.getElementById("password-message");
    const ageMessage = document.getElementById("age-message");
    const emailMessage = document.getElementById("email-message");
    const tieneAlergias = document.getElementById("tieneAlergias");
    const alergiasContainer = document.getElementById("alergias-container");
    const alergias = document.getElementById("alergias");

    window.togglePassword = function (id, boton) {
        const campo = document.getElementById(id);
        if (campo.type === "password") {
            campo.type = "text";
            boton.textContent = "🙈";
            boton.setAttribute("aria-label", "Ocultar contraseña");
        } else {
            campo.type = "password";
            boton.textContent = "👁";
            boton.setAttribute("aria-label", "Mostrar contraseña");
        }
    };

    function comprobarContrasenas() {
        if (!confirmarContrasena || confirmarContrasena.value === "") {
            passwordMessage.textContent = "";
            if (confirmarContrasena) confirmarContrasena.setCustomValidity("");
            return true;
        }

        if (contrasena.value !== confirmarContrasena.value) {
            passwordMessage.textContent = "Las contraseñas no coinciden.";
            passwordMessage.style.color = "#c66b6b";
            confirmarContrasena.setCustomValidity("Las contraseñas no coinciden.");
            return false;
        }

        passwordMessage.textContent = "Las contraseñas coinciden.";
        passwordMessage.style.color = "#6f9d7c";
        confirmarContrasena.setCustomValidity("");
        return true;
    }

    if (contrasena && confirmarContrasena) {
        contrasena.addEventListener("input", comprobarContrasenas);
        confirmarContrasena.addEventListener("input", comprobarContrasenas);
    }

    function calcularEdad(fecha) {
        const hoy = new Date();
        const nacimiento = new Date(fecha + "T00:00:00");
        let edad = hoy.getFullYear() - nacimiento.getFullYear();
        const mes = hoy.getMonth() - nacimiento.getMonth();

        if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
            edad--;
        }
        return edad;
    }

    function comprobarEdad() {
        if (!fechaNacimiento || !fechaNacimiento.value) {
            if (ageMessage) ageMessage.textContent = "";
            return false;
        }

        const edad = calcularEdad(fechaNacimiento.value);

        if (edad < 14) {
            ageMessage.textContent = "Debes tener al menos 14 años para crear una cuenta.";
            ageMessage.style.color = "#c66b6b";
            fechaNacimiento.setCustomValidity("Debes tener al menos 14 años.");
            return false;
        }

        ageMessage.textContent = "Edad válida.";
        ageMessage.style.color = "#6f9d7c";
        fechaNacimiento.setCustomValidity("");
        return true;
    }

    if (fechaNacimiento) {
        fechaNacimiento.addEventListener("change", comprobarEdad);
    }

    function establecerFechaMaxima() {
        if (!fechaNacimiento) return;
        const hoy = new Date();
        const fechaLimite = new Date(
            hoy.getFullYear() - 14,
            hoy.getMonth(),
            hoy.getDate()
        );
        const año = fechaLimite.getFullYear();
        const mes = String(fechaLimite.getMonth() + 1).padStart(2, "0");
        const dia = String(fechaLimite.getDate()).padStart(2, "0");
        fechaNacimiento.max = `${año}-${mes}-${dia}`;
    }

    establecerFechaMaxima();

    if (correo) {
        correo.addEventListener("input", function () {
            emailMessage.textContent = "";
            correo.setCustomValidity("");

            if (correo.value === "") return;

            if (!correo.validity.valid) {
                emailMessage.textContent = "Escribe un correo electrónico válido.";
                emailMessage.style.color = "#c66b6b";
                correo.setCustomValidity("Correo electrónico inválido.");
                return;
            }

            emailMessage.textContent = "Formato de correo válido.";
            emailMessage.style.color = "#6f9d7c";
        });
    }

    if (tieneAlergias) {
        tieneAlergias.addEventListener("change", function () {
            if (this.value === "si") {
                alergiasContainer.style.display = "block";
                alergias.required = true;
            } else {
                alergiasContainer.style.display = "none";
                alergias.required = false;
                alergias.value = "";
            }
        });
    }

    if (formulario) {
        formulario.addEventListener("submit", function (event) {
            event.preventDefault();

            if (!comprobarEdad()) {
                alert("Debes tener al menos 14 años para crear una cuenta.");
                fechaNacimiento.focus();
                return;
            }

            if (!comprobarContrasenas()) {
                alert("Las contraseñas no coinciden. Por favor, revísalas.");
                confirmarContrasena.focus();
                return;
            }

            if (!formulario.checkValidity()) {
                formulario.reportValidity();
                return;
            }

            const peso = document.querySelector('input[name="peso"]');
            if (!peso.value || Number(peso.value) <= 0) {
                alert("Por favor, ingresa tu peso.");
                peso.focus();
                return;
            }

            const altura = document.querySelector('input[name="altura"]');
            if (!altura.value || Number(altura.value) <= 0) {
                alert("Por favor, ingresa tu altura.");
                altura.focus();
                return;
            }

            formulario.submit();
        });
    }

});