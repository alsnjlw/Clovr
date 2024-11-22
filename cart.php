<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "cartdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add items to the database when the form is submitted
if (isset($_POST['add_to_cart'])) {
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];

    $stmt = $conn->prepare("INSERT INTO cart_items (item_name, price) VALUES (?, ?)");
    $stmt->bind_param("sd", $item_name, $item_price);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Item added to cart successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Clear cart when the "Clear Cart" button is clicked
if (isset($_POST['clear_cart'])) {
    $conn->query("TRUNCATE TABLE cart_items");
    echo "<p style='color: blue;'>Cart cleared successfully!</p>";
}

// Fetch cart items from the database
$result = $conn->query("SELECT item_name, price FROM cart_items");

$cart_items = [];
$cart_prices = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row['item_name'];
        $cart_prices[] = $row['price'];
    }
}

$conn->close();
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
            text-decoration: none;
            border: none;
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
    <div class="background-image">
     
    </div>

    <center><h1>Cart</h1></center>

    <table>
        <tr>
            <th>Item Name</th>
            <th>Price</th>
        </tr>
        <?php
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
    <a href="index.html">
        <button class="cart_button">Continue Shopping</button>
    </a>

    <!-- Clear Cart Form -->
    <form method="post" style="display:inline;">
        <button type="submit" name="clear_cart" class="clear_button">Clear Cart</button>
    </form>

    <!-- Checkout Button -->
    <a href="checkout.php">
        <button class="checkout">Checkout</button>
    </a>

    <div class="footer">
        <p>© Clover. All rights reserved.</p>
    </div>
</body>
</html>

