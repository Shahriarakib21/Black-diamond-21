<?php
$servername = "localhost"; // XAMPP default server
$username = "root"; // Default XAMPP MySQL user
$password = ""; // No password for root user
$database = "user_database"; // Use your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database Connection Failed!"]));
}
?>
