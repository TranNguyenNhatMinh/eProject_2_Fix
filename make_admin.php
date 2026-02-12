<?php
/**
 * Make User Admin - Set user role to admin
 * Run this file to set user as admin
 */
require_once 'includes/auth.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    die("You need to log in first!");
}

$user = getCurrentUser();
$conn = getDBConnection();

echo "<h2>Make User Admin</h2>";
echo "<style>body { font-family: Arial; padding: 20px; } .success { color: green; } .error { color: red; }</style>";

// Update role to admin
$stmt = $conn->prepare("UPDATE users SET role = 'admin' WHERE user_id = ?");
$stmt->bind_param("i", $user['user_id']);

if ($stmt->execute()) {
    // Update session
    $_SESSION['role'] = 'admin';
    
    echo "<p class='success'>✅ Role set to admin!</p>";
    echo "<p>User ID: " . $user['user_id'] . "</p>";
    echo "<p>Username: " . htmlspecialchars($user['username']) . "</p>";
    echo "<p>Role in database: admin</p>";
    echo "<p>Role in session: " . htmlspecialchars($_SESSION['role']) . "</p>";
    
    echo "<hr>";
    echo "<p><a href='index.php'>Reload homepage to see changes</a></p>";
    echo "<p><a href='check_admin.php'>Check admin status</a></p>";
} else {
    echo "<p class='error'>❌ Error: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();
?>
