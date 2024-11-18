<?php
require_once("./backend/config.php");
session_start();

if (isset($_SESSION['username'])) {
    $current_user = $_SESSION['username'];

    // Fetch the user ID based on the username
    $sql_user = "SELECT UserID FROM user WHERE Username = '$current_user'";
    $result_user = mysqli_query($connection, $sql_user);
    $user_data = mysqli_fetch_assoc($result_user);
    $user_id = $user_data['User ID'];

    // Fetch cart items for the user
    $sql_cart = "SELECT food_name, Quantity, total_price FROM cart WHERE UserID = '$user_id'";
    $result_cart = mysqli_query($connection, $sql_cart);
    $cart_items = [];

    while ($row = mysqli_fetch_assoc($result_cart)) {
        $cart_items[] = $row;
    }

    echo json_encode($cart_items);
} else {
    echo json_encode([]);
}
?>