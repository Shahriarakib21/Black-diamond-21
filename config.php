<?php
$servername = "mysql"; // Change to "mysql" if using Docker
$username = "root";
$password = ""; // Use your MySQL root password
$dbname = "quiz_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
