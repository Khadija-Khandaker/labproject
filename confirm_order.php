<?php
require_once("./backend/config.php");

$input = json_decode(file_get_contents("php://input"), true);

if ($input && $connection) {
    foreach ($input as $item) {
        $title = $item['title'];
        $quantity = $item['quantity'];
        $price = $item['price'];
     
    }
}
?>