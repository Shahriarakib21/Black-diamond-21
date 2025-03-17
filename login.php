<?php
session_start();
include 'config.php';
header('Content-Type: application/json');

// Handle JSON and form data
$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'] ?? $_POST['username'] ?? null;
$password = $data['password'] ?? $_POST['password'] ?? null;

if (!$username || !$password) {
    echo json_encode(["status" => "error", "message" => "Username and password required."]);
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    if ($user['is_verified'] == 0) {
        echo json_encode(["status" => "error", "message" => "Please verify your email first."]);
        exit();
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    echo json_encode(["status" => "success", "message" => "Login successful! Redirecting..."]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid credentials."]);
}
?>
