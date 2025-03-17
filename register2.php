<?php
// Start session
session_start();

// Include database connection
include 'config.php'; // Ensure this file contains a valid $mysqli connection

// Check if form was submitted using POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Check if all fields are set
    if (!isset($_POST['username'], $_POST['email'], $_POST['password'])) {
        http_response_code(400);
        exit("Error: Missing form fields.");
    }

    // Get and sanitize form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate form fields
    if (empty($username) || empty($email) || empty($password)) {
        http_response_code(400);
        exit("Error: All fields are required.");
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        exit("Error: Invalid email format.");
    }

    // Password strength validation
    if (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/\d/", $password)) {
        http_response_code(400);
        exit("Error: Password must be at least 8 characters long, contain at least one uppercase letter and one number.");
    }

    // Check if email is already registered
    $check_stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
    if (!$check_stmt) {
        http_response_code(500);
        exit("Error: " . $mysqli->error);
    }
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        http_response_code(409); // Conflict: Email already exists
        exit("Error: Email is already registered.");
    }
    $check_stmt->close();

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into database
    $stmt = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        http_response_code(500);
        exit("Error: " . $mysqli->error);
    }
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['registration_success'] = true; // Store success status in session
        header("Location: login.php?success=1"); // Redirect to login page with success flag
        exit();
    } else {
        http_response_code(500);
        exit("Error: " . $stmt->error);
    }

    // Close statement and connection
    $stmt->close();
    $mysqli->close();
} else {
    http_response_code(405); // Method Not Allowed
    exit("Error: Invalid request method.");
}
?>
