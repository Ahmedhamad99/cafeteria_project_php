<?php
try {

    $connection = new PDO("mysql:host=localhost:3307;dbname=cafeteria", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $profile_picture = $_FILES['profile_picture']['name'];
    move_uploaded_file($_FILES['profile_picture']['tmp_name'], "img/" . $_FILES['profile_picture']['name']);


    $stm = $connection->prepare("INSERT INTO users (username, email, password, role, profile_picture) VALUES (?, ?, ?, ?, ?)");


    $stm->execute([$username, $email, $password, $role, $profile_picture]);


    header("Location: ../ahmed/all_users.php");
    exit;
    
} catch (PDOException $e) {
    echo "*******  Error *************<br>";
    echo $e->getMessage();
}
