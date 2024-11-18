<?php
session_start();
require_once("./backend/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM User WHERE Email = ? LIMIT 1";
    if ($stmt = $connection->prepare($query)) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            // Verify the password
            if (password_verify($password, $user['Password'])) {
                $_SESSION['username'] = $user['Username'];
                header("Location: index.php");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with that email address.";
        }
        $stmt->close();
    } else {
        echo "Database query error.";
    }
}
$connection->close();
?>
