<?php
  require_once("./backend/config.php");
    session_start(); 
    if ($connection) {
        echo ('');
    }
    $current_user = $_SESSION['username'];
    $sql = "SELECT * FROM user WHERE Username = '$current_user'";
    $data = mysqli_query($connection, $sql);

    // Check if the query was successful
    if ($data) {
        $total = mysqli_num_rows($data);
        if ($total > 0) {
            // Fetch the user data
            $user_data = mysqli_fetch_assoc($data); // Fetch the first row as an associative array
            $current_user_id = $user_data["UserID"];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Cart.css">
    <title>Shopping Cart</title>
</head>
<body>

    <!-- Header Section -->
    <header class="header">
         <div class="site-title">MKS</div>
        <nav class="nav">
            <a href="index.php">Home</a>
            <a href="Cart.php">Cart</a>
            <a href="aboutus.php">About</a>
            <a href="practice.php">Login</a>
            <a href="adminlogin.php">Admin Login</a>
        </nav>
    </header>
    <!-- Cart Title -->
    <h1 class="cart-title">Shopping Cart</h1>
    <!-- Main Section -->
    <section class="cart-section">
            <div class="cart-container">
                <div id="cart-items" class="cart-items">
                <?php
                    $sql = "SELECT * FROM cart where UserID = '$current_user_id'";
                    $result = mysqli_query($connection,$sql);
                    $total_ammount = 0; 
                    if (!$result) {
                        die("Invalid query!");
                    }
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <br>
                        <p>Food Name: <?php echo $row['food_name'] ?></p>
                        <p>Total Price: <?php echo $row['total_price'] ?></p>
                        <p>Quantity: <?php echo $row['Quantity'] ?></p>
                        <br>
                        <hr>
                        <?php
                            $total_ammount += $row['total_price'];
                        ?>
                    <?php
                    }
                ?>
            </div>
            <div class="total-summary">
                <h2>Total Amount</h2>
                <p id="total-amount"><?php echo $total_ammount; ?></p>
                <form action="Cart.php" method="post">
                    <input type="hidden" name="cart_total_ammount" value="<?php echo $total_ammount?>">
                    <input type="hidden" name="cart_user_id" value="<?php echo $current_user_id?>">
                    <button type="submit" name="confirm_cart" class="checkout-button">Confirm</button>
                </form>
                <?php
                    if (isset($_POST["confirm_cart"])) {
                        $cart_user_id = $_POST["cart_user_id"];
                        $cart_total_ammount = $_POST["cart_total_ammount"];
                        $insert_cart_to_orders_sql = "INSERT INTO orders (UserID, TotalAmount, order_Status) VALUES ('$cart_user_id', '$cart_total_ammount', 'Pending')";
                        mysqli_query($connection, $insert_cart_to_orders_sql);
                        header("Location: Cart.php"); // Change to your desired redirect page
                    }
                ?>
            </div>
        </div>
    </section>
</body>
</html>