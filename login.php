<?php
session_start();
header("Content-Type: application/json");
require 'maindatabase.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['username'], $data['password'])) {
    $username = $data['username'];
    $password = $data['password'];

    // Check user
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $hashed_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            echo json_encode(["status" => "success", "message" => "Login successful!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid credentials!"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "User not found!"]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request!"]);
}

$conn->close();
?>
