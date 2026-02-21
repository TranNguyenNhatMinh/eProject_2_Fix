<?php
/**
 * Authentication Helper Functions
 * Quản lý đăng nhập, đăng ký, session
 */

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../database/config.php';

/**
 * Kiểm tra user đã đăng nhập chưa
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Kiểm tra user có phải admin không
 */
function isAdmin() {
    return isLoggedIn() && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Lấy thông tin user hiện tại
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    $conn = getDBConnection();
    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("SELECT user_id, username, email, full_name, phone, address, role, status FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    $stmt->close();
    $conn->close();
    
    return $user;
}

/**
 * Đăng nhập
 */
function login($username, $password) {
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("SELECT user_id, username, email, password, role, status FROM users WHERE (username = ? OR email = ?) AND status = 'active'");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            
            $stmt->close();
            $conn->close();
            
            return ['success' => true, 'role' => $user['role']];
        }
    }
    
    $stmt->close();
    $conn->close();
    
        return ['success' => false, 'message' => 'Invalid username or password'];
}

/**
 * Đăng ký user mới
 */
function register($username, $email, $password, $full_name = '', $phone = '') {
    $conn = getDBConnection();
    
    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ? OR email = ?");
    if (!$stmt) {
        $conn->close();
        return ['success' => false, 'message' => 'Lỗi chuẩn bị câu lệnh SQL: ' . $conn->error];
    }
    
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $stmt->close();
        $conn->close();
        return ['success' => false, 'message' => 'Username or email already exists'];
    }
    $stmt->close();
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    if (!$hashed_password) {
        $conn->close();
        return ['success' => false, 'message' => 'Password hashing error'];
    }
    
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, full_name, phone, role) VALUES (?, ?, ?, ?, ?, 'customer')");
    if (!$stmt) {
        $conn->close();
        return ['success' => false, 'message' => 'Failed to prepare INSERT statement: ' . $conn->error];
    }
    
    $stmt->bind_param("sssss", $username, $email, $hashed_password, $full_name, $phone);
    
    if ($stmt->execute()) {
        $user_id = $conn->insert_id;
        $stmt->close();
        $conn->close();
        
        // Auto login after registration
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = 'customer';
        
        return ['success' => true];
    } else {
        $error = $stmt->error;
        $error_code = $stmt->errno;
        $stmt->close();
        $conn->close();
        return ['success' => false, 'message' => 'Registration failed: ' . $error . ' (Code: ' . $error_code . ')'];
    }
}

/**
 * Đăng xuất
 */
function logout() {
    session_unset();
    session_destroy();
    return true;
}

/**
 * Require login - redirect nếu chưa đăng nhập
 * @param string|null $returnUrl URL trả về sau khi đăng nhập (vd: product/checkout.php)
 */
function requireLogin($returnUrl = null) {
    if (!isLoggedIn()) {
        $script = $_SERVER['PHP_SELF'] ?? $_SERVER['SCRIPT_NAME'] ?? '';
        $basePath = (strpos($script, '/admin/') !== false || strpos($script, '/product/') !== false || strpos($script, '/auth/') !== false) ? '../' : '';
        $loginUrl = $basePath . 'auth/login.php';
        if (!empty($returnUrl) && strpos($returnUrl, '://') === false && strpos($returnUrl, '//') !== 0) {
            $loginUrl .= '?redirect=' . urlencode($returnUrl);
        }
        header('Location: ' . $loginUrl);
        exit();
    }
}

/**
 * Require admin - redirect nếu không phải admin
 */
function requireAdmin() {
    requireLogin();
    
    // Check both session and database role
    $user = getCurrentUser();
    $is_admin = isAdmin() || ($user && $user['role'] === 'admin');
    
    if (!$is_admin) {
        // Update session if database says admin but session doesn't
        if ($user && $user['role'] === 'admin') {
            $_SESSION['role'] = 'admin';
        } else {
            // Detect base path
            $basePath = '';
            if (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) {
                $basePath = '../';
            }
            $script = $_SERVER['PHP_SELF'] ?? $_SERVER['SCRIPT_NAME'] ?? '';
            $basePath = (strpos($script, '/admin/') !== false) ? '../' : '';
            header('Location: ' . $basePath . 'index.php');
            exit();
        }
    }
}

?>
