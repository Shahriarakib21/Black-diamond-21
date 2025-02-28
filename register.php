<?php
include 'config.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$firstName = $data['firstName'];
$lastName = $data['lastName'];
$username = $data['username'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, username, password) VALUES (?, ?, ?, ?)");
if ($stmt->execute([$firstName, $lastName, $username, $password])) {
    echo json_encode(["status" => "success", "message" => "Registration successful!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Registration failed."]);
}
?>
