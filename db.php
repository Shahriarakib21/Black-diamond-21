<?php
// include 'db.php';

$host = 'mysql'; // Use 'mysql' as the service name in Docker Compose
$dbname = 'quiz_db'; // Database name
$username = 'root'; // MySQL username (default in this case)
$password = 'root'; // MySQL password (should be more secure in production)

// Create a PDO instance for database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set PDO to throw exceptions on errors
} catch (PDOException $e) {
    // If there is a connection error, display it
    die("Database connection failed: " . $e->getMessage());
}

// Optionally store the connection globally
$GLOBALS['pdo'] = $pdo;
