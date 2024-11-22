<?php
session_start();
include 'cartdb.php'; // Include the database connection file

// Initialize session arrays if they don't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
    $_SESSION['prices'] = [];
}

// Handle "Add to Cart" form submission
if (isset($_POST['add_to_cart'])) {
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];

    // Add the item to the session cart
    $_SESSION['cart'][] = $item_name;
    $_SESSION['prices'][] = $item_price;
}

// Clear cart if the "Clear Cart" button is pressed
if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
    unset($_SESSION['prices']);
    header('Location: cart.php'); // Refresh the page after clearing the cart
    exit();
}

// Handle Checkout
if (isset($_POST['checkout'])) {
    $session_id = session_id(); // Get the session ID
    $cart_items = $_SESSION['cart'];
    $cart_prices = $_SESSION['prices'];

    // Insert each cart item into the database
    for ($i = 0; $i < count($cart_items); $i++) {
        $item_name = $cart_items[$i];
        $item_price = $cart_prices[$i];

        // Prepare and execute the SQL query
        $query = "INSERT INTO cart_items (session_id, item_name, item_price) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssd',  $item_name, $item_price);
        $stmt->execute();
    }

    // Clear the cart after checkout
    unset($_SESSION['cart']);
    unset($_SESSION['prices']);

   
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
            height: 20vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        .footer {
            background-color: maroon;
            color: white;
            padding: 50px;
            text-align: center;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="background-image"></div>
    <center><h1>Cart</h1></center>

    <table>
        <tr>
            <th>Item Name</th>
            <th>Price</th>
        </tr>
        <?php
        // Display cart items
        if (count($_SESSION['cart']) > 0) {
            $total = 0;
            for ($i = 0; $i < count($_SESSION['cart']); $i++) {
                $item = $_SESSION['cart'][$i];
                $price = $_SESSION['prices'][$i];
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
    <a href="index.html">
        <button class="cart_button">Continue Shopping</button>
    </a>
    <form method="post" style="display:inline;">
        <button type="submit" name="clear_cart" class="clear_button">Clear Cart</button>
    </form>
    <form method="post" style="display:inline;">
        <button type="submit" name="checkout" class="checkout">Checkout</button>
    </form>
    <div class="footer"></div>
</body>
</html>


