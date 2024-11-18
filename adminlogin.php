<?php
session_start();
require_once("./backend/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the connection is established
    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Use the correct table name 'Admin'
    $query = "SELECT * FROM Admin WHERE Username = ? AND Password = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        // Fetch admin details
        $admin = mysqli_fetch_assoc($result);
        $_SESSION['admin_username'] = $admin['Username'];
        header("Location: home.php");
        exit();
    } else {
        echo "<script>alert('Invalid Username or Password');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Food Delivery System</title>
    <link rel="stylesheet" href="adminlogin.css">
</head>
<body>
    <div class="main-container">
        <div class="container">
            <div class="login-box">
                <h2>Admin Login</h2>
                <form method="POST" action="adminlogin.php">
    <div class="user-box">
        <input type="text" name="username" required>
        <label>Username</label>
    </div>
    <div class="user-box">
        <input type="password" name="password" id="password" required>
        <label>Password</label>
    </div>
    <div class="button-container">
        <button type="submit">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Login
        </button>
    </div>
</form>

            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
            passwordField.setAttribute("type", type);
        }
    </script>
</body>
</html>
