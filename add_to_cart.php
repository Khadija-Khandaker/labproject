<?php
session_start(); // Start the session to access user ID

// Include the database connection
require_once("./backend/config.php");

$current_user = $_SESSION['username'];
$sql = "SELECT * FROM user WHERE Username = '$current_user'";
$data = mysqli_query($connection, $sql);

// Check if the query was successful
if ($data) {
    $total = mysqli_num_rows($data);
    if ($total > 0) {
        // Fetch the user data
        $user_data = mysqli_fetch_assoc($data); // Fetch the first row as an associative array
        $user_id = $user_data["UserID"];
    } else {
        echo "No user found with the username: " . htmlspecialchars($current_user);
    }
} else {
    echo "Error executing query: " . mysqli_error($connection);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $food_item_id = $_POST['food_item_id'];
    $quantity = $_POST['quantity'];
    $food_price = $_POST['food_price'];
    $food_name = $_POST['food_name'];    
    // Calculate total amount
    $total_amount = $food_price * $quantity;

    // Prepare and execute the insert statement for the orders table
    $insert_cart_sql = "INSERT INTO cart (UserID, food_name, Quantity, total_price) VALUES ('$user_id', '$food_name', '$quantity', '$total_amount')";
    mysqli_query($connection, $insert_cart_sql);
    
    // Redirect back to the menu page or cart page
    header("Location: menu.php"); // Change to your desired redirect page
    exit();
}
?>