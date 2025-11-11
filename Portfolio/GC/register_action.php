<?php
require_once 'config.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJSONResponse(false, 'Invalid request method');
}

// Get and sanitize input data
$username = sanitizeInput($_POST['username'] ?? '');
$email = sanitizeInput($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Validate all fields are provided
if (empty($username) || empty($email) || empty($password)) {
    sendJSONResponse(false, 'All fields are required');
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    sendJSONResponse(false, 'Invalid email format');
}

// Validate password strength
if (strlen($password) < 8) {
    sendJSONResponse(false, 'Password must be at least 8 characters long');
}

if (!preg_match('/[A-Z]/', $password)) {
    sendJSONResponse(false, 'Password must contain at least one uppercase letter');
}

if (!preg_match('/[a-z]/', $password)) {
    sendJSONResponse(false, 'Password must contain at least one lowercase letter');
}

if (!preg_match('/[0-9]/', $password)) {
    sendJSONResponse(false, 'Password must contain at least one number');
}

if (!preg_match('/[!@#$%^&*]/', $password)) {
    sendJSONResponse(false, 'Password must contain at least one special character (!@#$%^&*)');
}

// Validate username (alphanumeric and underscore, 3-20 characters)
if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
    sendJSONResponse(false, 'Username must be 3-20 characters and contain only letters, numbers, and underscores');
}

// Connect to database
$conn = getDBConnection();

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $stmt->close();
    $conn->close();
    sendJSONResponse(false, 'Email already registered');
}

// Check if username already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $stmt->close();
    $conn->close();
    sendJSONResponse(false, 'Username already taken');
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashedPassword);

if ($stmt->execute()) {
    $userId = $conn->insert_id;
    $stmt->close();
    $conn->close();
    
    sendJSONResponse(true, 'Registration successful! Please login.', [
        'user_id' => $userId,
        'username' => $username,
        'email' => $email
    ]);
} else {
    $error = $stmt->error;
    $stmt->close();
    $conn->close();
    sendJSONResponse(false, 'Registration failed: ' . $error);
}

?>

