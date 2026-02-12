<?php
/**
 * Test Admin Access
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/auth.php';

echo "<h2>Admin Test Page</h2>";
echo "<style>body { font-family: Arial; padding: 20px; } .success { color: green; } .error { color: red; }</style>";

echo "<h3>Session:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<h3>isLoggedIn():</h3>";
echo isLoggedIn() ? "<p class='success'>✅ TRUE</p>" : "<p class='error'>❌ FALSE</p>";

echo "<h3>isAdmin():</h3>";
echo isAdmin() ? "<p class='success'>✅ TRUE</p>" : "<p class='error'>❌ FALSE</p>";

if (isLoggedIn()) {
    $user = getCurrentUser();
    echo "<h3>User Role:</h3>";
    echo "<p>Database role: <strong>" . htmlspecialchars($user['role'] ?? 'not set') . "</strong></p>";
    echo "<p>Session role: <strong>" . htmlspecialchars($_SESSION['role'] ?? 'not set') . "</strong></p>";
}

echo "<hr>";
echo "<p><a href='index.php'>Try Admin Dashboard</a></p>";
echo "<p><a href='../index.php'>Back to Homepage</a></p>";
?>
