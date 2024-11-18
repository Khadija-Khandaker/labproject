<?php
session_start();
require_once("./backend/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="menu.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-content">
            <div class="restaurant-info">
                <img src="img/food.jpg" alt="Restaurant 1" class="restaurant-image">
                <h1 class="restaurant-name">Chunks</h1>
            </div>
            <div class="navbar">
                <a href="index.php" style="text-decoration: none;">Home</a>
                <a href="Cart.php">Cart</a>
                <a href="aboutus.php">About</a>
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="#"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
                    <a href="logout.php" style="text-decoration: none;">Logout</a>
                <?php else: ?>
                    <a href="practice.php" style="text-decoration: none;">Login</a>
                <?php endif; ?>
                <a href="adminlogin.php" style="text-decoration: none;">Admin Login</a>
            </div>
        </div>
    </header>

    <h2 class="menu-title">Menu</h2>
    
    <div class="menu-section">
        <div class="food-item" onclick="showPopup('Chicken Sandwich', 'Grilled chicken sandwich with lettuce and sauce.', 'img/chicken.jpg', '1', 8.99)">
            <img src="img/chicken.jpg" alt="Food 1">
            <h2>Chicken Sandwich</h2>
            <p>Grilled chicken sandwich with lettuce and sauce.</p>
            <p class="price">$8.99</p>
            <button>View</button>
        </div>
        <!-- Add more food items here... -->
    </div>

    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="hidePopup()">&times;</span>
            <img id="popup-image" src="" alt="Food Image">
            <h2 id="popup-title"></h2>
            <p id="popup-description"></p>
            <p id="popup-price" class="price"></p>
            <label for="quantity">Quantity:</label>
            <div class="quantity-controls">
                <button onclick="updateQuantity(-1)">-</button>
                <input type="number" id="quantity" name="quantity" min="1" value="1">
                <button onclick="updateQuantity(1)">+</button>
            </div>
            
            <form id="addToCartForm" action="add_to_cart.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?? ''; ?>"> 
                <input type="hidden" name="food_item_id" id="food_item_id" value="">
                <input type="hidden" name="food_price" id="food_price" value="">
                <input type="hidden" name="food_name" id="food_name" value="">
                <input type="hidden" name="quantity" id="quantity_hidden" value="1">
                <button type="submit" onclick="addToCart()">Add to Cart</button>
            </form>
        </div>
    </div>

    <script>
function showPopup(title, description, imageUrl, foodItemId, price) {
    document.getElementById('popup-title').innerText = title;
    document.getElementById('food_name').value = title;
    document.getElementById('popup-description').innerText = description;
    document.getElementById('popup-image').src = imageUrl;
    document.getElementById('food_item_id').value = foodItemId;
    document.getElementById('food_price').value = price;
    document.getElementById('popup-price').innerText = `Price: $${price.toFixed(2)}`;
    document.getElementById('popup').classList.add('active');
}

function hidePopup() {
    document.getElementById('popup').classList.remove('active');
}

function updateQuantity(amount) {
    const quantityInput = document.getElementById('quantity');
    let currentQuantity = parseInt(quantityInput.value);
    currentQuantity += amount;
    if (currentQuantity < 1) {
        currentQuantity = 1;
    }
    quantityInput.value = currentQuantity;
}

function addToCart() {
    const quantity = document.getElementById('quantity').value;
    document.getElementById('quantity_hidden').value = quantity;
    alert(`Item added to cart! Quantity: ${quantity}`);
    hidePopup();
}
    </script>
</body>
</html>