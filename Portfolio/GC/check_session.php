<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    sendJSONResponse(true, 'User is logged in', [
        'user_id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'email' => $_SESSION['email']
    ]);
} else {
    sendJSONResponse(false, 'User is not logged in');
}

?>

