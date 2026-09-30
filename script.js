const form = document.getElementById("registerForm");

if (form) {

    form.addEventListener("submit", function(event) {

        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;

        const nameError = document.getElementById("nameError");
        const emailError = document.getElementById("emailError");
        const passwordError = document.getElementById("passwordError");

        nameError.textContent = "";
        emailError.textContent = "";
        passwordError.textContent = "";

        let valid = true;


        if (name === "") {

            nameError.textContent = "Please enter your full name.";
            valid = false;

        }


        if (email === "") {

            emailError.textContent = "Please enter your email address.";
            valid = false;

        }


        if (password === "") {

            passwordError.textContent = "Please enter your password.";
            valid = false;

        } else if (password.length < 6) {

            passwordError.textContent = "Password must be at least 6 characters.";
            valid = false;

        }


        if (!valid) {

            event.preventDefault();

        }

    });

}