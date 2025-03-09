<?php
require_once("db_class.php");
$connection = new db();

// Read the raw JSON data from the request body
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if($data){
    file_put_contents('debug.log', json_encode($data, JSON_PRETTY_PRINT));
}

if (file_exists('debug.log') && filesize('debug.log') > 0 ) {
    //get data from file
    $jsonContents = file_get_contents('debug.log');
    $fileData = json_decode($jsonContents, true);
    //prepare order data
    $userId=$fileData["cart"][0]["user_Id"];
    $totalPrice=$fileData["total_price"];
    $roomNumber=$fileData["roomNum"];
    // get roomId
    $roomId=$connection->get_data("rooms","room_number = '$roomNumber'");
    $roomId=$roomId->fetch(PDO::FETCH_ASSOC)["id"];
    // insert new order
    $connection->insert("orders","user_id,total_price,room_id","$userId,$totalPrice,$roomId");
    // get orderId
    $stm=$connection->get_data("orders","user_id=$userId && status='processing' ORDER BY created_at desc limit
    1");
    $data=$stm->fetch(PDO::FETCH_ASSOC);
    $orderId=$data["id"];
    print_r($orderId);
    foreach($fileData["cart"] as $product){
        $productId=$product["product_Id"];
        $productQuantity=$product["product_Quantity"];
        $connection->insert("order_items","order_id,product_id,quantity","$orderId,$productId,$productQuantity");
    }
    
} else {
    echo "Debug log file not found.";
}
// clear the file
file_put_contents('debug.log', '');
// Exit the script without sending a JSON response
exit;
?>