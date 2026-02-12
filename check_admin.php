<?php
/**
 * Check Admin Status - Debug tool
 */
require_once 'includes/auth.php';

echo "<h2>Check Admin Status</h2>";
echo "<style>body { font-family: Arial; padding: 20px; } .success { color: green; } .error { color: red; } pre { background: #f5f5f5; padding: 10px; }</style>";

echo "<h3>Session Data:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<h3>isLoggedIn():</h3>";
echo isLoggedIn() ? "<p class='success'>✅ TRUE</p>" : "<p class='error'>❌ FALSE</p>";

echo "<h3>isAdmin():</h3>";
echo isAdmin() ? "<p class='success'>✅ TRUE</p>" : "<p class='error'>❌ FALSE</p>";

if (isLoggedIn()) {
    $user = getCurrentUser();
    echo "<h3>Current User Data:</h3>";
    echo "<pre>";
    print_r($user);
    echo "</pre>";
    
    echo "<h3>User Role:</h3>";
    echo "<p>Role in database: <strong>" . htmlspecialchars($user['role'] ?? 'NOT SET') . "</strong></p>";
    echo "<p>Role in session: <strong>" . htmlspecialchars($_SESSION['role'] ?? 'NOT SET') . "</strong></p>";
    
    if (($user['role'] ?? '') === 'admin' && ($_SESSION['role'] ?? '') !== 'admin') {
        echo "<p class='error'>⚠️ Role mismatch! Database says admin but session doesn't.</p>";
        echo "<p><a href='logout.php'>Logout and login again</a></p>";
    }
} else {
    echo "<p class='error'>❌ Not logged in. <a href='login.php'>Login here</a></p>";
}

echo "<hr>";
echo "<p><a href='index.php'>Back to homepage</a></p>";
?>
