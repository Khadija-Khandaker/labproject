<?php
session_start();
require_once("./backend/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $contact = $_POST['contact'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO User (Username, Email, Password, Contact) VALUES (?, ?, ?, ?)";
    if ($stmt = $connection->prepare($query)) {
        $stmt->bind_param('ssss', $username, $email, $hashed_password, $contact);
        if ($stmt->execute()) {
            echo "User registered successfully.";
            // Redirect to login page or index page
            header("Location: practice.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Database query error.";
    }
}
$connection->close();
?>
