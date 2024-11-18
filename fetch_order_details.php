<?php
require_once("./backend/config.php");

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $sql = "SELECT * FROM cart WHERE OrderID = '$order_id'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        $order_details = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $order_details[] = $row;
        }
        echo json_encode($order_details);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>