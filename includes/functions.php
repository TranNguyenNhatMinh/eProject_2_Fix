<?php
/**
 * Helper Functions
 * Các hàm tiện ích dùng chung
 */

require_once __DIR__ . '/../database/config.php';

/**
 * Sanitize input data
 */
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Format currency
 */
function formatCurrency($amount) {
    return '$' . number_format($amount, 2);
}

/**
 * Generate order number
 */
function generateOrderNumber() {
    return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
}

/**
 * Get all categories
 */
function getCategories() {
    $conn = getDBConnection();
    $result = $conn->query("SELECT * FROM categories WHERE status = 'active' ORDER BY display_order ASC");
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    $conn->close();
    return $categories;
}

/**
 * Get products by category
 */
function getProductsByCategory($category_id = null, $limit = null) {
    $conn = getDBConnection();
    
    $sql = "SELECT * FROM products WHERE status = 'active'";
    if ($category_id) {
        $sql .= " AND category_id = " . intval($category_id);
    }
    $sql .= " ORDER BY display_order ASC, created_at DESC";
    
    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }
    
    $result = $conn->query($sql);
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $conn->close();
    return $products;
}

/**
 * Get product by ID
 */
function getProductById($product_id) {
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ? AND status = 'active'");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $product;
}

/**
 * Get featured products
 */
function getFeaturedProducts($limit = 6) {
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT * FROM products WHERE status = 'active' AND featured = 1 ORDER BY display_order ASC LIMIT ?");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $products;
}

/**
 * Get user orders
 */
function getUserOrders($user_id) {
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $orders;
}

/**
 * Get order items
 */
function getOrderItems($order_id) {
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT oi.*, p.image FROM order_items oi LEFT JOIN products p ON oi.product_id = p.product_id WHERE oi.order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $items;
}

/**
 * Add to cart (session-based)
 */
function addToCart($product_id, $quantity = 1) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    
    return true;
}

/**
 * Get cart items
 */
function getCartItems() {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return [];
    }
    
    $conn = getDBConnection();
    $product_ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
    
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id IN ($placeholders) AND status = 'active'");
    $stmt->bind_param(str_repeat('i', count($product_ids)), ...$product_ids);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $row['cart_quantity'] = $_SESSION['cart'][$row['product_id']];
        $items[] = $row;
    }
    
    $stmt->close();
    $conn->close();
    
    return $items;
}

/**
 * Get cart total
 */
function getCartTotal() {
    $items = getCartItems();
    $total = 0;
    foreach ($items as $item) {
        $price = $item['sale_price'] ? $item['sale_price'] : $item['price'];
        $total += $price * $item['cart_quantity'];
    }
    return $total;
}

/**
 * Update cart quantity
 */
function updateCartQuantity($product_id, $quantity) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if ($quantity <= 0) {
        unset($_SESSION['cart'][$product_id]);
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    
    return true;
}

/**
 * Remove from cart
 */
function removeFromCart($product_id) {
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    return true;
}

/**
 * Clear cart
 */
function clearCart() {
    unset($_SESSION['cart']);
    return true;
}

/**
 * Get cart count
 */
function getCartCount() {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return 0;
    }
    return array_sum($_SESSION['cart']);
}

?>
