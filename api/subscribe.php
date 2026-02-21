<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../database/config.php';

// Check if AJAX request
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

$message = '';
$message_type = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);
    
    if (empty($email)) {
        $message = 'Please enter your email address.';
        $message_type = 'danger';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
        $message_type = 'danger';
    } else {
        $conn = getDBConnection();
        
        // Check if email already exists
        $stmt = $conn->prepare("SELECT subscription_id FROM subscriptions WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $message = 'This email is already subscribed.';
            $message_type = 'info';
        } else {
            // Insert new subscription
            $stmt = $conn->prepare("INSERT INTO subscriptions (email, status, created_at) VALUES (?, 'active', NOW())");
            $stmt->bind_param("s", $email);
            
            if ($stmt->execute()) {
                $message = 'Thank you for subscribing!';
                $message_type = 'success';
                $success = true;
            } else {
                $message = 'An error occurred. Please try again later.';
                $message_type = 'danger';
            }
        }
        
        $stmt->close();
        $conn->close();
    }
}

// If AJAX request, return JSON response
if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'message_type' => $message_type
    ]);
    exit();
}

// If not AJAX, redirect back with message (backward compatibility)
$_SESSION['subscribe_message'] = $message;
$_SESSION['subscribe_message_type'] = $message_type;

// Get referrer or default to index
$redirect = $_SERVER['HTTP_REFERER'] ?? '../index.php';
header('Location: ' . $redirect);
exit();
?>
