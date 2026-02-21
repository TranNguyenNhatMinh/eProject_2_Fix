<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['experience_slug'])) {
    $experience_slug = trim($_POST['experience_slug']);
    $quantity = intval($_POST['quantity'] ?? 1);
    $certificate_name = trim($_POST['certificate_name'] ?? '');
    $guardian_email = trim($_POST['guardian_email'] ?? '');
    $guardian_phone = trim($_POST['guardian_phone'] ?? '');
    $event_slug = trim($_POST['event_slug'] ?? '');

    if (!empty($experience_slug) && $quantity > 0) {
        addExperienceToCart($experience_slug, $quantity, $certificate_name);
        
        // Lưu đăng ký event vào database
        if (!empty($event_slug) && !empty($guardian_email) && !empty($certificate_name)) {
            $user_id = isLoggedIn() ? $_SESSION['user_id'] : null;
            registerForEvent($event_slug, $user_id, $certificate_name, $guardian_email, $guardian_phone, '', $quantity);
        }
        
        // Set success message
        $isEvent = isset($_POST['redirect']) && strpos($_POST['redirect'], 'event-detail.php') !== false;
        $_SESSION['cart_message'] = $isEvent ? 'Registration added to cart! Proceed to checkout to complete.' : 'Experience added to cart successfully!';
        $_SESSION['cart_message_type'] = 'success';
        
        // Redirect: whitelist relative paths only (no open redirect)
        $raw = trim($_POST['redirect'] ?? '');
        $safe_default = '../componets/experience-detail.php?experience=' . urlencode($experience_slug);
        if ($raw === '' || strpos($raw, '://') !== false || strpos($raw, '//') === 0 || !preg_match('#^[a-zA-Z0-9_./\-?=&]+$#', $raw)) {
            $redirect = $safe_default;
        } elseif (strpos($raw, 'experience-detail.php') === 0 || strpos($raw, 'event-detail.php') === 0) {
            $redirect = '../componets/' . $raw;
        } elseif ($raw === 'cart.php' || $raw === '../product/cart.php') {
            $redirect = '../product/cart.php';
        } else {
            $redirect = $safe_default;
        }
        header('Location: ' . $redirect);
        exit();
    }
}

// Default redirect
header('Location: ../index.php');
exit();
?>
