<?php
require_once 'config.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJSONResponse(false, 'Invalid request method');
}

// Get and sanitize input
$phone = sanitizeInput($_POST['phone'] ?? '');
$otp = sanitizeInput($_POST['otp'] ?? '');

// Validate inputs
if (empty($phone) || empty($otp)) {
    sendJSONResponse(false, 'Phone number and OTP are required');
}

if (!preg_match('/^[0-9]{6}$/', $otp)) {
    sendJSONResponse(false, 'OTP must be 6 digits');
}

// Connect to database
$conn = getDBConnection();

// Verify OTP
$stmt = $conn->prepare("SELECT id, otp_code, otp_expires_at FROM users WHERE phone = ? AND otp_code = ?");
$stmt->bind_param("ss", $phone, $otp);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $conn->close();
    sendJSONResponse(false, 'Invalid OTP');
}

$user = $result->fetch_assoc();

// Check if OTP has expired
$now = date('Y-m-d H:i:s');
if ($user['otp_expires_at'] < $now) {
    $stmt->close();
    $conn->close();
    sendJSONResponse(false, 'OTP has expired. Please request a new one.');
}

// OTP is valid
$stmt->close();
$conn->close();

sendJSONResponse(true, 'OTP verified successfully');

?>

