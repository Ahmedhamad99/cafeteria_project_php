<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'], $_POST['password'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (empty($email) || empty($password)) {
            echo "Please fill in all fields.";
            exit;
        }

        require 'connection.php';

        $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $user['password'])) {
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                
                header("Location: " . ($user['role'] === 'admin' ? "../abdalla/index.php" : "../aya_ayman/index.php"));
                
                exit;
            } elseif ($user['password'] === $password) {
                
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                $updateStmt->execute([$hashedPassword, $user['id']]);

                if (password_verify($password, $hashedPassword)) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    
                   

                    header("Location: " . ($user['role'] === 'admin' ? "../abdalla/index.php" : "../aya_ayman/index.html"));
                    exit;
                }
            }
        }
        session_start();
        $_SESSION['message'] = "Invalid email or password.";
        header("Location: loginn.php");
        exit;
    }
    echo "Required fields are missing.";
    exit;
} else {
    echo "Invalid request.";
}
?>



<script>

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

    </script>

