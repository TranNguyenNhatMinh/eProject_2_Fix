<?php
/**
 * Simple Admin Test - No requireAdmin for testing
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/auth.php';

echo "<h1>Simple Admin Test</h1>";
echo "<style>body { font-family: Arial; padding: 20px; }</style>";

echo "<h2>Session Info:</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<h2>isLoggedIn(): " . (isLoggedIn() ? 'YES' : 'NO') . "</h2>";
echo "<h2>isAdmin(): " . (isAdmin() ? 'YES' : 'NO') . "</h2>";

if (isLoggedIn()) {
    $user = getCurrentUser();
    echo "<h2>User Info:</h2>";
    echo "<pre>";
    print_r($user);
    echo "</pre>";
    
    if ($user['role'] === 'admin' || isAdmin()) {
        echo "<h2 style='color: green;'>✅ You are ADMIN! You can access the admin panel.</h2>";
        echo "<p><a href='index.php'>Go to Admin Dashboard</a></p>";
    } else {
        echo "<h2 style='color: red;'>❌ You are NOT an admin.</h2>";
        echo "<p>Role in database: <strong>" . htmlspecialchars($user['role']) . "</strong></p>";
        echo "<p>Role in session: <strong>" . htmlspecialchars($_SESSION['role'] ?? 'not set') . "</strong></p>";
        echo "<p><a href='../make_admin.php'>Set as admin</a></p>";
    }
} else {
    echo "<h2 style='color: red;'>❌ You are not logged in!</h2>";
    echo "<p><a href='../login.php'>Log in</a></p>";
}

echo "<hr>";
echo "<p><a href='../index.php'>Back to homepage</a></p>";
?>
