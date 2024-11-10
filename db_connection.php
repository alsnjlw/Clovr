<?php
// Connection to registration database (login_app)
$reg_servername = "localhost";
$reg_username = "root";
$reg_password = "";
$reg_dbname = "login_app"; // Registration database

$reg_conn = new mysqli($reg_servername, $reg_username, $reg_password, $reg_dbname);
if ($reg_conn->connect_error) {
    die("Connection failed: " . $reg_conn->connect_error);
}

// Connection to login database (register_app)
$login_servername = "localhost";
$login_username = "root";
$login_password = "";
$login_dbname = "register_app"; // Login attempts database

$login_conn = new mysqli($login_servername, $login_username, $login_password, $login_dbname);
if ($login_conn->connect_error) {
    die("Connection failed: " . $login_conn->connect_error);
}
?>
