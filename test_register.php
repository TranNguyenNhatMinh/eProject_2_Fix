<?php
/**
 * Test Registration - Debug tool
 * This file is for testing and debugging registration
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'database/config.php';
require_once 'includes/auth.php';

echo "<h2>Test Registration Debug</h2>";

// Test 1: Database connection
echo "<h3>1. Testing Database Connection</h3>";
try {
    $conn = getDBConnection();
    echo "✅ Database connection: OK<br>";
    
    // Test 2: Check if users table exists
    echo "<h3>2. Checking users table structure</h3>";
    $result = $conn->query("DESCRIBE users");
    if ($result) {
        echo "✅ Table 'users' exists<br>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['Field']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Type']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Null']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Key']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Default'] ?? 'NULL') . "</td>";
            echo "<td>" . htmlspecialchars($row['Extra']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "❌ Error describing table: " . $conn->error . "<br>";
    }
    
    // Test 3: Try to insert a test record
    echo "<h3>3. Testing INSERT query</h3>";
    $test_username = 'test_' . time();
    $test_email = 'test_' . time() . '@test.com';
    $test_password = password_hash('test123', PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'customer')");
    if ($stmt) {
        $stmt->bind_param("sss", $test_username, $test_email, $test_password);
        if ($stmt->execute()) {
            $test_user_id = $conn->insert_id;
            echo "✅ Test INSERT successful! User ID: " . $test_user_id . "<br>";
            
            // Clean up test record
            $stmt2 = $conn->prepare("DELETE FROM users WHERE user_id = ?");
            $stmt2->bind_param("i", $test_user_id);
            $stmt2->execute();
            $stmt2->close();
            echo "✅ Test record cleaned up<br>";
        } else {
            echo "❌ INSERT failed: " . $stmt->error . " (Error code: " . $stmt->errno . ")<br>";
        }
        $stmt->close();
    } else {
        echo "❌ Prepare failed: " . $conn->error . "<br>";
    }
    
    // Test 4: Check existing users
    echo "<h3>4. Existing users in database</h3>";
    $result = $conn->query("SELECT user_id, username, email, role, created_at FROM users ORDER BY user_id DESC LIMIT 10");
    if ($result && $result->num_rows > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Created</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['role']) . "</td>";
            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No users found in database<br>";
    }
    
    $conn->close();
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Test 5: Test register function
echo "<h3>5. Testing register() function</h3>";
$test_result = register('testuser_' . time(), 'testemail_' . time() . '@test.com', 'testpass123', 'Test User', '1234567890');
if ($test_result['success']) {
    echo "✅ register() function works!<br>";
    echo "User ID in session: " . ($_SESSION['user_id'] ?? 'Not set') . "<br>";
} else {
    echo "❌ register() failed: " . htmlspecialchars($test_result['message']) . "<br>";
}

echo "<hr>";
echo "<p><a href='register.php'>Go to Registration Page</a></p>";
?>
