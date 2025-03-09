<?php

$host = "localhost:3307";
$dbname = "cafeteria";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
  
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
