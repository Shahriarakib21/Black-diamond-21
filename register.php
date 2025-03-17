<?php
require 'db.php';  // Ensure this file is properly connected to your database

$data = json_decode(file_get_contents("php://input"), true);
if ($_SERVER["REQUEST_METHOD"]  === "POST")
{$username = $data['username'];
    $email = $data['email'];
    $password = password_hash($data['password'], PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username','$email', '$password' )";
    $result = $conn->query($sql);
} // Hash password for security



// $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $password);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Registration successful!"]);
} else {
    echo json_encode(["success" => false, "message" => "Registration failed. Please try again."]);
}
?>
