<?php
header("Content-Type: application/json");
$input = json_decode(file_get_contents("php://input"), true);

$conn = new mysqli("db", "root", "password", "auth_db");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}

$firstName = $input["firstName"];
$lastName = $input["lastName"];
$username = $input["username"];
$password = password_hash($input["password"], PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $firstName, $lastName, $username, $password);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Registration successful"]);
} else {
    echo json_encode(["status" => "error", "message" => "Registration failed"]);
}
?>
