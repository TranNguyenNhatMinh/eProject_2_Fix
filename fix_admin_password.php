<?php
/**
 * Fix Admin Password - Re-hash admin password
 * Run this file once to re-hash the admin password
 */

require_once 'database/config.php';

echo "<h2>Fix Admin Password</h2>";

$conn = getDBConnection();

// New password for admin
$new_password = 'admin123'; // New password
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

echo "<p>Hashing password: <strong>$new_password</strong></p>";
echo "<p>Hashed: <code>" . substr($hashed_password, 0, 50) . "...</code></p>";

// Update password for admin
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = 'admin'");
$stmt->bind_param("s", $hashed_password);

if ($stmt->execute()) {
    echo "<p style='color: green;'>✅ Password has been hashed successfully!</p>";
    echo "<p>You can log in with:</p>";
    echo "<ul>";
    echo "<li>Username: <strong>admin</strong></li>";
    echo "<li>Password: <strong>$new_password</strong></li>";
    echo "</ul>";
} else {
    echo "<p style='color: red;'>❌ Error: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();

echo "<hr>";
echo "<p><a href='login.php'>Go to login page</a></p>";
?>
