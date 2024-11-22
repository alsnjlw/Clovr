<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db_connection.php'; // Include your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user exists in the database
    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "Entered password: " . $password . "<br>";
        echo "Stored hash: " . $row['password'] . "<br>";
        if (password_verify($password, $row['password'])) { // Verify hashed password
            $_SESSION['username'] = $username;

            // Log the login attempt
            $log_sql = "INSERT INTO login_attempts (username, password) VALUES (?, ?)";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->bind_param("ss", $username, $password);

            if ($log_stmt->execute()) {
                // Redirect to index page after successful login
                header("Location: http://localhost/login_app/index.html");
                exit();
            } else {
                echo "Error: " . $log_stmt->error;
            }

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
