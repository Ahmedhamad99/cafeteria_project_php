<?php

require "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_id = intval($_POST['id']);
    $stmt = $pdo->prepare("DELETE FROM products  WHERE id = :id");
    $stmt->execute(['id'=>$product_id]);
    header("Location: all_products.php");

}



?>