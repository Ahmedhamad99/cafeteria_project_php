<?php

$dbType = "mysql";
$dbName = "cafeteria";
$host = "localhost:3307";
// $dbDatabase = "data";  
$userName = "root";
$userPassword = ""; 

  
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $userName, $userPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>
