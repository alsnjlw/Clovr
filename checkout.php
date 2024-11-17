<?php
session_start();

// Retrieve cart items and prices from the session
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$cart_prices = isset($_SESSION['prices']) ? $_SESSION['prices'] : [];

// Calculate the total
$total = 0;
foreach ($cart_prices as $price) {
    $total += $price;
}

// Handle form submission for checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process the checkout (e.g., save order details, clear cart, etc.)
    unset($_SESSION['cart']);  // Clear the cart after checkout
    unset($_SESSION['prices']);
    header('Location: order_confirmation.php'); // Redirect to order confirmation
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        .checkout_button, .back_button {
            background-color: maroon;
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .background-image { 
            background-image: url('1.png'); /* Replace with your image path */
    background-size: cover;
    background-position: center;
    height: 20vh; /* Full viewport height */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
        }
        .footer{
    background-color: maroon;
            color: white;
            padding: 50px;
            text-align: center;
            position: relative;
            bottom: 0;
            width: 100%
      
    }
    </style>
</head>
<body>
<div class="background-image" > </div>
<center><h1>Checkout</h1></center>

<table>
    <tr>
        <th>Item Name</th>
        <th>Price</th>
    </tr>
    <?php
    if (count($cart_items) > 0) {
        for ($i = 0; $i < count($cart_items); $i++) {
            $item = $cart_items[$i];
            $price = $cart_prices[$i];
            echo "<tr><td>$item</td><td>\$$price</td></tr>";
        }
        echo "<tr><td><strong>Total</strong></td><td><strong>\$$total</strong></td></tr>";
    } else {
        echo "<tr><td colspan='2'>Your cart is empty.</td></tr>";
    }
    ?>
</table>

<!-- Checkout Form -->
<form method="post">
    <button type="submit" class="checkout_button">Confirm Order</button>
</form>

<!-- Back to Cart Button -->
<a href="cart.php">
    <button class="back_button">Back to Cart</button>
</a>
<div class="footer" > 

</div>
</body>
</html>

