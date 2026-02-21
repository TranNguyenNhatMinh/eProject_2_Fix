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
 * Update user personal information (full_name, email, phone, address)
 * Returns ['success' => true] or ['success' => false, 'message' => '...']
 */
function updateUserProfile($user_id, $full_name, $email, $phone = '', $address = '') {
    $conn = getDBConnection();
    $user_id = (int) $user_id;
    $full_name = trim($full_name);
    $email = trim($email);
    $phone = trim($phone);
    $address = trim($address);

    if (empty($email)) {
        $conn->close();
        return ['success' => false, 'message' => 'Email cannot be empty.'];
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $conn->close();
        return ['success' => false, 'message' => 'Invalid email address.'];
    }

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ? AND user_id != ?");
    $stmt->bind_param("si", $email, $user_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $stmt->close();
        $conn->close();
        return ['success' => false, 'message' => 'This email is already used by another account.'];
    }
    $stmt->close();

    $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, phone = ?, address = ? WHERE user_id = ?");
    $stmt->bind_param("ssssi", $full_name, $email, $phone, $address, $user_id);
    if ($stmt->execute()) {
        $_SESSION['email'] = $email;
        $stmt->close();
        $conn->close();
        return ['success' => true];
    }
    $stmt->close();
    $conn->close();
    return ['success' => false, 'message' => 'Update failed. Please try again.'];
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
    // Get items including experiences (product_id = 0)
    $stmt = $conn->prepare("SELECT oi.*, p.image FROM order_items oi LEFT JOIN products p ON oi.product_id = p.product_id WHERE oi.order_id = ? ORDER BY oi.item_id");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = [];
    
    // Detect calling context to determine correct image path prefix
    // Check multiple ways to detect if we're in a subfolder
    $script_name = $_SERVER['SCRIPT_NAME'] ?? '';
    $script_filename = $_SERVER['SCRIPT_FILENAME'] ?? '';
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    
    // Determine if we're in a subfolder (product/, admin/, auth/, componets/)
    $is_subfolder = false;
    if (strpos($script_name, '/product/') !== false || 
        strpos($script_name, '/admin/') !== false || 
        strpos($script_name, '/auth/') !== false ||
        strpos($script_name, '/componets/') !== false ||
        strpos($request_uri, '/product/') !== false ||
        strpos($request_uri, '/admin/') !== false ||
        strpos($request_uri, '/auth/') !== false ||
        strpos($request_uri, '/componets/') !== false) {
        $is_subfolder = true;
    }
    
    $image_prefix = $is_subfolder ? '../' : '';
    
    while ($row = $result->fetch_assoc()) {
        // For products (product_id > 0), ensure image path has correct prefix
        if ($row['product_id'] > 0 && !empty($row['image'])) {
            $image_path = trim($row['image']);
            // Skip if already absolute URL or absolute path
            if (preg_match('/^(http|https|\/)/', $image_path)) {
                $row['image'] = $image_path;
            } else {
                // Normalize path: remove any existing '../' or './' prefixes to avoid double prefix
                $image_path = preg_replace('/^(\.\.\/|\.\/)+/', '', $image_path);
                // Add correct prefix based on context
                $row['image'] = $image_prefix . $image_path;
            }
        }
        
        // For experiences (product_id = 0), try to get image from experience data
        if ($row['product_id'] == 0) {
            if (file_exists(__DIR__ . '/experience-data.php')) {
                require_once __DIR__ . '/experience-data.php';
                // Try to extract experience title from product_name
                // Format: "Experience Title (Certificate: name)" or "Experience Title"
                $product_name = $row['product_name'];
                $exp_title = preg_replace('/\s*\(Certificate:\s*[^)]+\)\s*$/i', '', $product_name);
                $exp_title = trim($exp_title);
                // Find matching experience
                if (isset($experiences) && is_array($experiences)) {
                    foreach ($experiences as $slug => $exp) {
                        if (isset($exp['title']) && trim($exp['title']) === $exp_title) {
                            $image_path = trim($exp['image']);
                            // Skip if already absolute URL or absolute path
                            if (preg_match('/^(http|https|\/)/', $image_path)) {
                                $row['image'] = $image_path;
                            } else {
                                // Normalize path: remove any existing '../' or './' prefixes
                                $image_path = preg_replace('/^(\.\.\/|\.\/)+/', '', $image_path);
                                // Add correct prefix based on context
                                $row['image'] = $image_prefix . $image_path;
                            }
                            $row['is_experience'] = true;
                            $row['is_event'] = (isset($exp['category']) && $exp['category'] === 'EVENT');
                            $row['experience_slug'] = $slug;
                            break;
                        }
                    }
                }
            }
        }
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
 * Get cart count (products + experiences from all pages)
 */
function getCartCount() {
    $product_count = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $product_count = array_sum($_SESSION['cart']);
    }
    
    $experience_count = getExperienceCartCount();
    
    return $product_count + $experience_count;
}

/**
 * Add experience to cart (session-based)
 */
function addExperienceToCart($experience_slug, $quantity = 1, $certificate_name = '') {
    if (!isset($_SESSION['experience_cart'])) {
        $_SESSION['experience_cart'] = [];
    }
    
    $key = $experience_slug . ($certificate_name ? '_' . md5($certificate_name) : '');
    
    if (isset($_SESSION['experience_cart'][$key])) {
        $_SESSION['experience_cart'][$key]['quantity'] += $quantity;
    } else {
        $_SESSION['experience_cart'][$key] = [
            'slug' => $experience_slug,
            'quantity' => $quantity,
            'certificate_name' => $certificate_name
        ];
    }
    
    return true;
}

/**
 * Get experience cart items
 */
function getExperienceCartItems() {
    if (!isset($_SESSION['experience_cart']) || empty($_SESSION['experience_cart'])) {
        return [];
    }
    return $_SESSION['experience_cart'];
}

/**
 * Remove experience from cart
 */
function removeExperienceFromCart($key) {
    if (isset($_SESSION['experience_cart'][$key])) {
        unset($_SESSION['experience_cart'][$key]);
        return true;
    }
    return false;
}

/**
 * Update experience cart quantity
 */
function updateExperienceCartQuantity($key, $quantity) {
    if (!isset($_SESSION['experience_cart'])) {
        $_SESSION['experience_cart'] = [];
    }
    
    if ($quantity <= 0) {
        if (isset($_SESSION['experience_cart'][$key])) {
            unset($_SESSION['experience_cart'][$key]);
        }
    } else {
        if (isset($_SESSION['experience_cart'][$key])) {
            $_SESSION['experience_cart'][$key]['quantity'] = $quantity;
        }
    }
    
    return true;
}

/**
 * Clear experience cart
 */
function clearExperienceCart() {
    unset($_SESSION['experience_cart']);
}

/**
 * Get experience cart count
 */
function getExperienceCartCount() {
    if (!isset($_SESSION['experience_cart']) || empty($_SESSION['experience_cart'])) {
        return 0;
    }
    $total = 0;
    foreach ($_SESSION['experience_cart'] as $item) {
        $total += $item['quantity'];
    }
    return $total;
}

/**
 * Get experience cart total
 */
function getExperienceCartTotal() {
    require_once __DIR__ . '/experience-data.php';
    
    if (!isset($_SESSION['experience_cart']) || empty($_SESSION['experience_cart'])) {
        return 0;
    }
    
    $total = 0;
    foreach ($_SESSION['experience_cart'] as $item) {
        $experience = getExperienceBySlug($item['slug']);
        if ($experience) {
            $total += $experience['price'] * $item['quantity'];
        }
    }
    
    return $total;
}

/**
 * Get all cart total (products + experiences)
 */
function getAllCartTotal() {
    return getCartTotal() + getExperienceCartTotal();
}

/**
 * Register user for event - save to event_registrations table
 */
function registerForEvent($event_slug, $user_id, $full_name, $email, $phone = '', $notes = '', $quantity = 1) {
    $conn = getDBConnection();
    
    $uid = $user_id ?: 0;
    if ($uid == 0) {
        $stmt = $conn->prepare("INSERT INTO event_registrations (event_slug, user_id, full_name, email, phone, notes, quantity, status) VALUES (?, NULL, ?, ?, ?, ?, ?, 'pending')");
        $stmt->bind_param("sssssi", $event_slug, $full_name, $email, $phone, $notes, $quantity);
    } else {
        $stmt = $conn->prepare("INSERT INTO event_registrations (event_slug, user_id, full_name, email, phone, notes, quantity, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->bind_param("sissssi", $event_slug, $user_id, $full_name, $email, $phone, $notes, $quantity);
    }
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}

/**
 * Get event registrations by event slug
 */
function getEventRegistrations($event_slug) {
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("SELECT er.*, u.username FROM event_registrations er LEFT JOIN users u ON er.user_id = u.user_id WHERE er.event_slug = ? ORDER BY er.created_at DESC");
    $stmt->bind_param("s", $event_slug);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $rows;
}

/**
 * Get list of events (for admin)
 */
function getEventsForAdmin() {
    return [
        'junior-keepers' => ['title' => 'Junior Keepers (11-15 Years Old)', 'date' => '02-13-2026'],
        'yoga' => ['title' => 'Yoga', 'date' => '02-22-2026'],
        'world-whale-day' => ['title' => 'World Whale Day', 'date' => '02-15-2026'],
        'sensory-saturdays' => ['title' => 'Sensory Saturday', 'date' => '02-28-2026'],
    ];
}

/**
 * Get registration count for an event
 */
function getEventRegistrationCount($event_slug) {
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM event_registrations WHERE event_slug = ?");
    $stmt->bind_param("s", $event_slug);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $conn->close();
    return (int)($row['cnt'] ?? 0);
}

?>
