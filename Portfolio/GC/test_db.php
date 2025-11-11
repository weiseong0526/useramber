<?php
// Database Connection Test Script
// Access this file at: http://localhost/GC/test_db.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Database Connection Test</h2>";
echo "<pre>";

// Test 1: Check if config file exists
echo "1. Checking config.php...\n";
if (file_exists('config.php')) {
    echo "   ✅ config.php exists\n";
    require_once 'config.php';
} else {
    echo "   ❌ config.php NOT FOUND\n";
    exit;
}

// Test 2: Check database constants
echo "\n2. Checking database configuration...\n";
echo "   DB_HOST: " . (defined('DB_HOST') ? DB_HOST : 'NOT DEFINED') . "\n";
echo "   DB_USER: " . (defined('DB_USER') ? DB_USER : 'NOT DEFINED') . "\n";
echo "   DB_PASS: " . (defined('DB_PASS') ? (DB_PASS === '' ? '(empty)' : '***') : 'NOT DEFINED') . "\n";
echo "   DB_NAME: " . (defined('DB_NAME') ? DB_NAME : 'NOT DEFINED') . "\n";

// Test 3: Try to connect
echo "\n3. Testing database connection...\n";
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        echo "   ❌ Connection FAILED: " . $conn->connect_error . "\n";
        echo "\n   Possible solutions:\n";
        echo "   - Make sure MySQL is running in XAMPP Control Panel\n";
        echo "   - Check if database '" . DB_NAME . "' exists\n";
        echo "   - Verify username and password in config.php\n";
    } else {
        echo "   ✅ Connection SUCCESSFUL!\n";
        
        // Test 4: Check if users table exists
        echo "\n4. Checking if 'users' table exists...\n";
        $result = $conn->query("SHOW TABLES LIKE 'users'");
        if ($result && $result->num_rows > 0) {
            echo "   ✅ 'users' table exists\n";
            
            // Test 5: Check table structure
            echo "\n5. Checking 'users' table structure...\n";
            $result = $conn->query("DESCRIBE users");
            if ($result) {
                echo "   Table columns:\n";
                while ($row = $result->fetch_assoc()) {
                    echo "   - " . $row['Field'] . " (" . $row['Type'] . ")\n";
                }
            }
            
            // Test 6: Count existing users
            echo "\n6. Checking existing users...\n";
            $result = $conn->query("SELECT COUNT(*) as count FROM users");
            if ($result) {
                $row = $result->fetch_assoc();
                echo "   Total users in database: " . $row['count'] . "\n";
            }
        } else {
            echo "   ❌ 'users' table NOT FOUND\n";
            echo "\n   Solution: Import database.sql file in phpMyAdmin\n";
            echo "   Steps:\n";
            echo "   1. Go to http://localhost/phpmyadmin\n";
            echo "   2. Select database '" . DB_NAME . "'\n";
            echo "   3. Click 'Import' tab\n";
            echo "   4. Choose file: database.sql\n";
            echo "   5. Click 'Go'\n";
        }
        
        $conn->close();
    }
} catch (Exception $e) {
    echo "   ❌ Exception: " . $e->getMessage() . "\n";
}

echo "\n</pre>";
echo "<hr>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ul>";
echo "<li>If connection failed: Check XAMPP MySQL service is running</li>";
echo "<li>If database doesn't exist: Create database 'AmberSS15' in phpMyAdmin</li>";
echo "<li>If table doesn't exist: Import database.sql file</li>";
echo "<li>If all tests pass: Try registering a new user at <a href='login.php'>login.php</a></li>";
echo "</ul>";
?>

