<?php
session_start();
include 'db_connection.php'; // Include your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check user in the registration database
    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $reg_conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Debugging: Print the entered password and stored hash
        echo "Entered password: " . $password . "<br>";
        echo "Stored hash: " . $row['password'] . "<br>";
        echo "Password verification result: " . (password_verify($password, $row['password']) ? 'true' : 'false') . "<br>";

        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            echo "Login successful!";

            // Log the login attempt in the login database
            $log_sql = "INSERT INTO login_attempts (username, password) VALUES (?, ?)";
            $log_stmt = $login_conn->prepare($log_sql);
            $log_stmt->bind_param("ss", $username, $password);
            $log_stmt->execute();
            $log_stmt->close();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found.";
    }

    $stmt->close();
}
?>
