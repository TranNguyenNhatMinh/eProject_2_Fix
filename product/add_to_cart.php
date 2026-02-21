<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

// Check if this is an AJAX request
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity'] ?? 1);

    if ($product_id > 0 && $quantity > 0) {
        $product = getProductById($product_id);
        if ($product) {
            addToCart($product_id, $quantity);
            
            // If AJAX request, return JSON response
            if ($isAjax) {
                header('Content-Type: application/json');
                $cartCount = getCartCount();
                echo json_encode([
                    'success' => true,
                    'message' => 'Product added to cart successfully!',
                    'cart_count' => $cartCount
                ]);
                exit();
            }
            
            // Otherwise, redirect as before (whitelist: only relative paths, no open redirect)
            $_SESSION['cart_message'] = 'Product added to cart successfully!';
            $_SESSION['cart_message_type'] = 'success';
            $raw = trim($_POST['redirect'] ?? 'index.php');
            if (strpos($raw, '://') !== false || strpos($raw, '//') === 0) {
                $redirect = '../index.php';
            } elseif (preg_match('#^[a-zA-Z0-9_./\-?=&]+$#', $raw)) {
                $redirect = ($raw === 'index.php' || $raw === 'cart.php') ? '../' . $raw : '../index.php';
            } else {
                $redirect = '../index.php';
            }
            header('Location: ' . $redirect);
            exit();
        } else {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Product not found.'
                ]);
                exit();
            }
        }
    } else {
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Invalid product ID or quantity.'
            ]);
            exit();
        }
    }
}

if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request.'
    ]);
    exit();
}

header('Location: ../index.php');
exit();
?>
