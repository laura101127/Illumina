document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    const correoInput = document.getElementById('correo');
    const passwordInput = document.getElementById('contrasena');
    const toggleBtn = document.querySelector('.toggle-password');
    const forgotLink = document.querySelector('.forgot-link');

    let loginError = document.getElementById('loginError');
    if (!loginError) {
        loginError = document.createElement('div');
        loginError.id = 'loginError';
        loginError.style.color = '#e53e3e';
        loginError.style.fontSize = '13px';
        loginError.style.marginTop = '12px';
        loginError.style.textAlign = 'center';
        loginForm.appendChild(loginError);
    }

    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.textContent = '🙈';
                toggleBtn.setAttribute('aria-label', 'Ocultar contraseña');
            } else {
                passwordInput.type = 'password';
                toggleBtn.textContent = '👁';
                toggleBtn.setAttribute('aria-label', 'Mostrar contraseña');
            }
        });
    }

    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            loginError.textContent = '';

            const correo = correoInput ? correoInput.value.trim().toLowerCase() : '';
            const password = passwordInput ? passwordInput.value : '';
            const tipoUsuario = document.querySelector('input[name="tipo_usuario"]:checked')?.value || 'paciente';

            if (!correo || !password) {
                e.preventDefault();
                loginError.textContent = 'Por favor completa todos los campos.';
                return;
            }

            const storageKey = tipoUsuario === 'profesional' ? 'illuminaProfesional' : 'illuminaUsuario';
            const usuarioGuardado = localStorage.getItem(storageKey);

            if (usuarioGuardado) {
                const usuario = JSON.parse(usuarioGuardado);

                if (usuario.correo && usuario.correo.toLowerCase() === correo) {
                    if (usuario.contrasena && usuario.contrasena !== password) {
                        e.preventDefault();
                        loginError.textContent = 'La contraseña es incorrecta.';
                        return;
                    }

                    e.preventDefault();
                    localStorage.setItem('illuminaSesion', 'activa');
                    localStorage.setItem('illuminaTipoSesion', tipoUsuario);
                    localStorage.setItem('illuminaUsuarioActual', JSON.stringify(usuario));

                    if (tipoUsuario === 'profesional') {
                        window.location.href = 'perfil_profesional.php';
                    } else {
                        window.location.href = 'perfil.php';
                    }
                }
            }
        });
    }

    if (forgotLink) {
        forgotLink.addEventListener('click', (e) => {
            e.preventDefault();
            const tipoUsuario = document.querySelector('input[name="tipo_usuario"]:checked')?.value || 'paciente';
            const storageKey = tipoUsuario === 'profesional' ? 'illuminaProfesional' : 'illuminaUsuario';
            const usuarioGuardado = localStorage.getItem(storageKey);

            if (!usuarioGuardado) {
                loginError.textContent = 'No existe una cuenta registrada para este perfil.';
                return;
            }

            const usuario = JSON.parse(usuarioGuardado);
            if (usuario.correo) {
                loginError.textContent = 'Para recuperar tu contraseña, te enviaremos instrucciones al correo asociado a tu cuenta.';
            } else {
                loginError.textContent = 'No encontramos información suficiente para recuperar la cuenta.';
            }
        });
    }
});