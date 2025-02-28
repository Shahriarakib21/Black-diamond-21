<?php
include 'config.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$password = $data['password'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    echo json_encode(["status" => "success", "message" => "Login successful!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid credentials."]);
}
?>
