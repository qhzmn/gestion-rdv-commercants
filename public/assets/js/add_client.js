document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector('form[action="/client/add"]');

    const lastName = document.getElementById("last_name");
    const firstName = document.getElementById("first_name");
    const phone = document.getElementById("phone");

    const lastNameError = document.getElementById("lastNameError");
    const firstNameError = document.getElementById("firstNameError");
    const phoneError = document.getElementById("phoneError");

    // Formatage à la sortie du champ
    lastName.addEventListener("blur", function() {
        lastName.value = lastName.value.trim().toUpperCase();
    });

    firstName.addEventListener("blur", function() {
        firstName.value = capitalizeFirstLetter(firstName.value.trim());
    });

    form.addEventListener("submit", function (e) {
        let valid = true;
        lastNameError.textContent = "";
        firstNameError.textContent = "";
        phoneError.textContent = "";

        // Au submit on applique aussi au cas où l'utilisateur n'a pas quitté les champs
        lastName.value = lastName.value.trim().toUpperCase();
        firstName.value = capitalizeFirstLetter(firstName.value.trim());

        if (lastName.value.length < 2) {
            lastNameError.textContent = "Nom invalide.";
            valid = false;
        }

        if (firstName.value.length < 2) {
            firstNameError.textContent = "Prénom invalide.";
            valid = false;
        }

        const phoneRegex = /^[0-9\s\-\+\(\)]{8,15}$/;
        if (!phoneRegex.test(phone.value.trim())) {
            phoneError.textContent = "Numéro de téléphone invalide.";
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
        }
    });

    // Fonction pour mettre la première lettre en majuscule
    function capitalizeFirstLetter(str) {
        return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
    }
});
