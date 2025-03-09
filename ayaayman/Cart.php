<?php
require ('Connection.php')

// Read the raw JSON data from the request body
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if($data){
    file_put_contents('debug.log', json_encode($data, JSON_PRETTY_PRINT));
}

if (file_exists('debug.log')) {

    $jsonContents = file_get_contents('debug.log');
    $data = json_decode($jsonContents, true);

    echo "<pre>Debug Log Contents:\n";
    print_r($data["cart"][0]); S
    echo "</pre>";
} else {
    echo "Debug log file not found.";
}

// Exit the script without sending a JSON response
exit;
?>