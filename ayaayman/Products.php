<?php
header("Content-Type: application/json");  
require 'Connection.php'; 

try {
    
    $sqlQuery = $db->prepare("select * from products");
    $sqlQuery->execute();
    $products = $sqlQuery->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($products);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error fetching products: " . $e->getMessage()]);
}
?>
