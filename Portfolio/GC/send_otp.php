<?php
require_once 'config.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJSONResponse(false, 'Invalid request method');
}

// Get and sanitize input
$phone = sanitizeInput($_POST['phone'] ?? '');

// Validate phone number
if (empty($phone)) {
    sendJSONResponse(false, 'Phone number is required');
}

if (!preg_match('/^[\+]?[0-9\s\-\(\)]{10,}$/', $phone)) {
    sendJSONResponse(false, 'Invalid phone number format');
}

// Connect to database
$conn = getDBConnection();

// Generate 6-digit OTP
$otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

// Set OTP expiration (10 minutes from now)
$otpExpires = date('Y-m-d H:i:s', strtotime('+10 minutes'));

// Check if phone number already exists in database
$stmt = $conn->prepare("SELECT id FROM users WHERE phone = ?");
$stmt->bind_param("s", $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update existing OTP for this phone
    $stmt = $conn->prepare("UPDATE users SET otp_code = ?, otp_expires_at = ? WHERE phone = ?");
    $stmt->bind_param("sss", $otp, $otpExpires, $phone);
} else {
    // Insert new OTP record (temporary user record)
    // We'll use a placeholder email and username that will be updated during registration
    $tempEmail = 'temp_' . time() . '@temp.com';
    $tempUsername = 'temp_' . time();
    $tempPassword = password_hash('temp', PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO users (username, email, phone, password, otp_code, otp_expires_at) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $tempUsername, $tempEmail, $phone, $tempPassword, $otp, $otpExpires);
}

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    
    // In production, send OTP via SMS service (Twilio, AWS SNS, etc.)
    // For development, we'll just return the OTP in the response
    // REMOVE THIS IN PRODUCTION - OTP should only be sent via SMS/Email
    sendJSONResponse(true, 'OTP sent successfully', [
        'otp' => $otp, // REMOVE THIS IN PRODUCTION
        'message' => 'OTP has been sent to ' . $phone
    ]);
} else {
    $error = $stmt->error;
    $stmt->close();
    $conn->close();
    sendJSONResponse(false, 'Failed to send OTP: ' . $error);
}

?>

