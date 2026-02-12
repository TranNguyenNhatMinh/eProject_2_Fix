<?php
/**
 * Debug Registration - Kiểm tra tại sao đăng ký không hoạt động
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/auth.php';
require_once 'includes/functions.php';

echo "<h2>Debug Registration Process</h2>";
echo "<style>body { font-family: Arial; padding: 20px; } .success { color: green; } .error { color: red; } pre { background: #f5f5f5; padding: 10px; border: 1px solid #ddd; }</style>";

// Test 1: Check if form data is received
echo "<h3>1. Check POST Data</h3>";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<p class='success'>✅ POST request received</p>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
} else {
    echo "<p class='error'>❌ No POST data. Submit form below to test.</p>";
}

// Test 2: Database connection
echo "<h3>2. Database Connection</h3>";
try {
    $conn = getDBConnection();
    echo "<p class='success'>✅ Database connected</p>";
    
    // Test 3: Check table structure
    echo "<h3>3. Users Table Structure</h3>";
    $result = $conn->query("DESCRIBE users");
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['Field']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Type']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Null']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Key']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Default'] ?? 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Test 4: Try manual insert
    echo "<h3>4. Test Manual INSERT</h3>";
    if (isset($_POST['test_insert'])) {
        $test_username = 'test_' . time();
        $test_email = 'test_' . time() . '@test.com';
        $test_password = password_hash('test123', PASSWORD_DEFAULT);
        $test_full_name = 'Test User';
        $test_phone = '1234567890';
        
        echo "<p>Attempting to insert:</p>";
        echo "<ul>";
        echo "<li>Username: $test_username</li>";
        echo "<li>Email: $test_email</li>";
        echo "<li>Password: (hashed)</li>";
        echo "</ul>";
        
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, full_name, phone, role) VALUES (?, ?, ?, ?, ?, 'customer')");
        if ($stmt) {
            $stmt->bind_param("sssss", $test_username, $test_email, $test_password, $test_full_name, $test_phone);
            if ($stmt->execute()) {
                $new_id = $conn->insert_id;
                echo "<p class='success'>✅ INSERT successful! New user ID: $new_id</p>";
                
                // Clean up
                $stmt2 = $conn->prepare("DELETE FROM users WHERE user_id = ?");
                $stmt2->bind_param("i", $new_id);
                $stmt2->execute();
                $stmt2->close();
                echo "<p>Test record cleaned up.</p>";
            } else {
                echo "<p class='error'>❌ INSERT failed: " . $stmt->error . " (Error code: " . $stmt->errno . ")</p>";
            }
            $stmt->close();
        } else {
            echo "<p class='error'>❌ Prepare failed: " . $conn->error . "</p>";
        }
    }
    
    // Test 5: Test register function
    echo "<h3>5. Test register() Function</h3>";
    if (isset($_POST['test_register'])) {
        $username = sanitize($_POST['username'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $full_name = sanitize($_POST['full_name'] ?? '');
        $phone = sanitize($_POST['phone'] ?? '');
        
        echo "<p>Calling register() with:</p>";
        echo "<ul>";
        echo "<li>Username: $username</li>";
        echo "<li>Email: $email</li>";
        echo "<li>Password: (hidden)</li>";
        echo "<li>Full name: $full_name</li>";
        echo "<li>Phone: $phone</li>";
        echo "</ul>";
        
        $result = register($username, $email, $password, $full_name, $phone);
        
        if ($result['success']) {
            echo "<p class='success'>✅ register() returned success!</p>";
            echo "<p>Session user_id: " . ($_SESSION['user_id'] ?? 'Not set') . "</p>";
        } else {
            echo "<p class='error'>❌ register() failed: " . htmlspecialchars($result['message']) . "</p>";
        }
    }
    
    // Show current users
    echo "<h3>6. Current Users in Database</h3>";
    $result = $conn->query("SELECT user_id, username, email, role, created_at FROM users ORDER BY user_id DESC");
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
        echo "<p>No users found.</p>";
    }
    
    $conn->close();
} catch (Exception $e) {
    echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
}

// Test form
echo "<hr>";
echo "<h3>Test Registration Form</h3>";
echo "<form method='POST' style='max-width: 500px;'>";
echo "<div style='margin-bottom: 10px;'>";
echo "<label>Username: <input type='text' name='username' value='testuser_" . time() . "' required></label>";
echo "</div>";
echo "<div style='margin-bottom: 10px;'>";
echo "<label>Email: <input type='email' name='email' value='test" . time() . "@test.com' required></label>";
echo "</div>";
echo "<div style='margin-bottom: 10px;'>";
echo "<label>Password: <input type='password' name='password' value='test123' required></label>";
echo "</div>";
echo "<div style='margin-bottom: 10px;'>";
echo "<label>Full Name: <input type='text' name='full_name' value='Test User'></label>";
echo "</div>";
echo "<div style='margin-bottom: 10px;'>";
echo "<label>Phone: <input type='text' name='phone' value='1234567890'></label>";
echo "</div>";
echo "<button type='submit' name='test_register' style='padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer;'>Test register() Function</button>";
echo "<button type='submit' name='test_insert' style='padding: 10px 20px; background: #28a745; color: white; border: none; cursor: pointer; margin-left: 10px;'>Test Direct INSERT</button>";
echo "</form>";

echo "<hr>";
echo "<p><a href='register.php'>Go to Registration Page</a> | <a href='fix_admin_password.php'>Fix Admin Password</a></p>";
?>
