<?php

require "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = intval($_POST['id']);
    $stmt = $pdo->prepare("DELETE FROM users  WHERE id = :id");
    $stmt->execute(['id'=>$user_id]);
    header("Location: all_users.php");

}



?>