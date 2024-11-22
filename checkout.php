<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "cartdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
} else {
    echo "<p style='color: red;'>Your cart is empty! Please add items before checking out.</p>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .checkout-container {
            margin: 0 auto;
            width: 80%;
            padding: 20px;
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
        .total-row {
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            background-color: maroon;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: darkred;
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
            padding: 20px;
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

    <div class="checkout-container">
        <h2>Your Order Summary</h2>
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
                echo "<tr class='total-row'><td>Total</td><td>\$$total</td></tr>";
            } else {
                echo "<tr><td colspan='2'>Your cart is empty.</td></tr>";
            }
            ?>
        </table>

        <div>
            <a href="cart.php" class="btn">Go Back to Cart</a>
            <a href="index.php" class="btn">Continue Shopping</a>
            <a href="order_confirmation.php" class="btn">confirm</a> 
        </div>
    </div>

    <div class="footer">
        <p>© Clover. All rights reserved.</p>
    </div>
</body>
</html>

