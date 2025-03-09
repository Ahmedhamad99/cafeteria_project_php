<?php

require "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        die("Invalid product ID.");
    }
    $user_id = intval($_POST['id']);
    $username = htmlspecialchars($_POST['name']);
    $useremail = htmlspecialchars($_POST['email']); 
    $userpassword = htmlspecialchars($_POST['password']);

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $image_name = basename($image["name"]);
        $image_path = "userimage/" . $image_name;
        if (!move_uploaded_file($image["tmp_name"], $image_path)) {
            die("Error uploading image.");
        }
        
    }
    else{
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $user_id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $image_name=$data["profile_picture"];
    }
   
    // var_dump($image_name);
    
    $stmt = $pdo->prepare("UPDATE users SET username = :name, email = :email, profile_picture = :image,password = :password WHERE id = :id");
    $stmt->execute([
        'name' =>  $username,
        'email' => $useremail,
        'id' => $user_id,
        'image'=>$image_name,
        'password'=>$userpassword
    ]);
    
    header("Location: all_users.php");


   
    exit();
}

?>
