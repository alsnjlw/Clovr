<?php
session_start();
include 'cartdb.php'; // Include the database connection file

// Retrieve cart items from session
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$cart_prices = isset($_SESSION['prices']) ? $_SESSION['prices'] : [];

// Clear cart if the "Clear Cart" button is pressed
if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
    unset($_SESSION['prices']);
    header('Location: cart.php'); // Refresh the page after clearing the cart
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Page</title>
    <style>
        .cart_button, .clear_button, .checkout {
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
<div class = "background-image"> </div>

    <center><h1>Cart</h1><center>

    <table>
        <tr>
            <th>Item Name</th>
            <th>Price</th>
        </tr>
        <?php
        // Display cart items
        if (count($cart_items) > 0) {
            $total = 0;
            for ($i = 0; $i < count($cart_items); $i++) {
                $item = $cart_items[$i];
                $price = $cart_prices[$i];
                $total += $price;
                echo "<tr><td>$item</td><td>\$$price</td></tr>";
            }
            echo "<tr><td><strong>Total</strong></td><td><strong>\$$total</strong></td></tr>";
        } else {
            echo "<tr><td colspan='2'>Your cart is empty.</td></tr>";
        }
        ?>
    </table>

    <br>
    <!-- Continue Shopping Button -->
    <a href="index.php">
        <button class="cart_button">Continue Shopping</button>
    </a>

    <!-- Clear Cart Form -->
    <form method="post" style="display:inline;">
        <button type="submit" name="clear_cart" class="clear_button">Clear Cart</button>
    </form>
    <a href ="checkout.php">
        <button class="checkout">Checkout</button>
    </a>
    <div class= "footer">
    </div>

</body>
</html>
