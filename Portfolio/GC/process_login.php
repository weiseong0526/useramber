<?php
require_once 'config.php';
session_start();

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJSONResponse(false, 'Invalid request method');
}

// Get and sanitize input data
$email = sanitizeInput($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Validate all fields are provided
if (empty($email) || empty($password)) {
    sendJSONResponse(false, 'Email and password are required');
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    sendJSONResponse(false, 'Invalid email format');
}

// Connect to database
$conn = getDBConnection();

// Check if user exists
$stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $conn->close();
    sendJSONResponse(false, 'User not found. Please register first.');
}

// Get user data
$user = $result->fetch_assoc();

// Verify password
if (!password_verify($password, $user['password'])) {
    $stmt->close();
    $conn->close();
    sendJSONResponse(false, 'Invalid email or password');
}

// Login successful - create session
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['email'] = $user['email'];
$_SESSION['logged_in'] = true;

$stmt->close();
$conn->close();

sendJSONResponse(true, 'Login successful!', [
    'user_id' => $user['id'],
    'username' => $user['username'],
    'email' => $user['email']
]);

?>

