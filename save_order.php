<?php
require_once("./backend/config.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data)) {
    foreach ($data as $item) {
        $stmt = $connection->prepare("INSERT INTO orders (title, description, price, quantity) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $item['title'], $item['description'], $item['price'], $item['quantity']);
        $stmt->execute();
    }
    echo "Order saved successfully!";
} else {
    echo "No items to save.";
}
?>