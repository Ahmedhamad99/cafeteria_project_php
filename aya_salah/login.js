document.addEventListener("DOMContentLoaded", function () {
    let loEmail = document.getElementById("Email");
    let loPassword = document.getElementById("Password");
    let errorContainer = document.getElementById("message");


    if (!errorContainer) {
        errorContainer = document.createElement("p");
        errorContainer.id = "message";
        let form = document.querySelector("form");
        form.insertBefore(errorContainer, form.firstChild);
    }

    errorContainer.style.color = "red";
    errorContainer.style.fontSize = "14px";
    errorContainer.style.marginBottom = "10px";

  
    window.login = function(event) {
        event.preventDefault(); 

      
        if (!loEmail.value || !loPassword.value) {
            errorContainer.textContent = "Please enter both email and password!";
            return;
        }

      
        let storeData = false; 

        if (!storeData) {
            errorContainer.textContent = "No account found! Please register.";
            return;
        }

      
        errorContainer.textContent = "Login successful!";
    }

   
    let loginButton = document.getElementById("logBtn");
    if (loginButton) {
        loginButton.addEventListener("click", login);
    }
});
