<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'], $_POST['email'], $_POST['password'])) {
        
        require 'connection.php';

        $username = trim($_POST['username']);
        $email    = trim($_POST['email']);
        $password = trim($_POST['password']);
        $role     = isset($_POST['role']) && in_array($_POST['role'], ['user', 'admin']) ? trim($_POST['role']) : 'user';

        if (empty($username) || empty($email) || empty($password)) {
            echo "Please fill in all fields.";
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format.";
            exit;
        }

        // Check if the user exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$email, $username]);
        if ($stmt->rowCount() > 0) {
            session_start();
            $_SESSION['message'] = "User already exists with this email or username.";
            header("Location: register.php");
            
            exit;
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, profile_picture, role) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$username, $email, $hashedPassword, "default.png", $role])) {
            echo "Registration successful. You can now log in.";
            header("Location: login.html");
            exit;
        } else {
            echo "Registration failed. Please try again.";
        }
    } else {
        echo "Required fields are missing.";
    }
} else {
    echo "Invalid request.";
}
?>
