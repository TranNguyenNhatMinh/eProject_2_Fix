<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity'] ?? 1);
    
    if ($product_id > 0 && $quantity > 0) {
        $product = getProductById($product_id);
        if ($product) {
            addToCart($product_id, $quantity);
            header('Location: ' . ($_POST['redirect'] ?? 'index.php') . '?added=1');
            exit();
        }
    }
}

header('Location: index.php');
exit();
?>
