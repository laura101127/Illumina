document.addEventListener('DOMContentLoaded', () => {
    const progressForm = document.getElementById('progressForm');

    if (progressForm) {
        progressForm.addEventListener('submit', (e) => {
            const peso = document.getElementById('peso').value;
            const agua = document.getElementById('agua').value;

            if (peso <= 0 || agua < 0) {
                e.preventDefault();
                alert('Por favor ingresa valores válidos superiores a 0.');
            }
        });
    }
});