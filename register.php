<?php
include 'db_connection.php'; // Include your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $email = $_POST['email'];

    echo "Hashed password: " . $password . "<br>"; // Debugging output

    $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
    $stmt = $reg_conn->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
