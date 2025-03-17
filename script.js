// Toggle to show the register form
function showRegister() {
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('register-form').style.display = 'block';
}

// Toggle to show the login form
function showLogin() {
    document.getElementById('login-form').style.display = 'block';
    document.getElementById('register-form').style.display = 'none';
}

// Register function: Sending registration details to the server
async function register() {
    const username = document.getElementById('register-username').value;
    const email = document.getElementById('register-email').value;
    const password = document.getElementById('register-password').value;

    const response = await fetch('http://localhost:8080/register2.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, email, password })
    });

    const result = await response.json();
    alert(result.message); // Show response message from the server

    if (result.success) {
        showLogin(); // Show login form after successful registration
    }
}

// Login function: Sending login details and token handling
async function login() {
    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;

    const response = await fetch('http://localhost:8080/login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
    });

    const result = await response.json();
    if (result.token) {
        localStorage.setItem('token', result.token); // Store JWT in localStorage
        window.location.href = 'dashboard.html'; // Redirect to dashboard if login is successful
    } else {
        alert(result.message); // Display error message from server
    }
}
