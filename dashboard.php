<?php
    include 'config.php';
    session_start();
    $name= $_SESSION['name'];
    $email=&$_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Welcome to Your Dashboard</h2>
        <p>Manage your profile and take quizzes.</p>
        <button onclick="logout()">Logout</button>
    </div>

    <script>
        // Ensure the user is authenticated before accessing the dashboard
        window.onload = function() {
            const token = localStorage.getItem('token');
            if (!token) {
                // If no token, redirect to login page
                window.location.href = 'index.html';
            }
        };

        function logout() {
            // Remove token and redirect to login page
            localStorage.removeItem('token');
            window.location.href = 'index.html';
        }
    </script>
</body>
</html>
