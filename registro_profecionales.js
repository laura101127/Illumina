document.addEventListener("DOMContentLoaded", function () {

    const buttons = document.querySelectorAll('a[href="#tipo-usuario"]');
    const section = document.getElementById("tipo-usuario");

    buttons.forEach(function (button) {

        button.addEventListener("click", function (event) {

            event.preventDefault();

            if (section) {
                section.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }

        });

    });

});