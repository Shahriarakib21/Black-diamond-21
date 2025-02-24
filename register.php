<?php
header("Content-Type: application/json");
require 'maindatabase.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['firstName'], $data['lastName'], $data['username'], $data['password'])) {
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $username = $data['username'];
    $password = password_hash($data['password'], PASSWORD_BCRYPT); // Hash password

    // Prepare SQL
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstName, $lastName, $username, $password);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Registration successful!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Username already exists!"]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request!"]);
}

$conn->close();
?>
