document.addEventListener("DOMContentLoaded", function () {
    var username = document.querySelector("#uname");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    let errorContainer = document.getElementById("message");
    let registerForm = document.getElementById('registerForm');

    if (!errorContainer) {
        errorContainer = document.createElement("p");
        errorContainer.id = "message";
        let form = document.querySelector("form");
        form.insertBefore(errorContainer, form.firstChild);
    }

    errorContainer.style.color = "red";
    errorContainer.style.fontSize = "14px";
    errorContainer.style.marginBottom = "10px";

    username.addEventListener("input", function () {
        let nameRegex = /^[A-Za-z\s]+$/;
        if (!nameRegex.test(username.value.trim())) {
            showError(username, "The name must contain only letters without numbers!");
        } else if (username.value.trim().length < 3) {
            showError(username, "The name must be at least 3 characters long!");
        } else {
            showError(username, "");
        }
    });

    email.addEventListener("input", function () {
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value.trim())) {
            showError(email, "Invalid email format!");
        } else {
            showError(email, "");
        }
    });

    password.addEventListener("input", function () {
        if (password.value.length < 7) {
            showError(password, "The password must be at least 7 characters long!");
        } else {
            showError(password, "");
        }
    });

    function handleRegister(event) {
        event.preventDefault(); 

        let isValid = true;

        if (username.closest(".input-group")?.querySelector("p") !== null) isValid = false;
        if (email.closest(".input-group")?.querySelector("p") !== null) isValid = false;
        if (password.closest(".input-group")?.querySelector("p") !== null) isValid = false;

        if (!isValid) {
            return;
        }

        registerForm.submit(); // ✅ Allow form submission
    }

    registerForm.addEventListener("submit", handleRegister);

    function showError(input, message) {
        let errorElement = input.nextElementSibling; 

        if (!errorElement || errorElement.tagName.toLowerCase() !== "p") {
            errorElement = document.createElement("p");
            errorElement.style.color = "red";
            input.parentNode.insertBefore(errorElement, input.nextSibling);
        }

        errorElement.textContent = message; 
    }
});
