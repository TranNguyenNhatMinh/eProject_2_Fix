<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/experience-data.php';

requireLogin('product/checkout.php');

$currentSite = $_SESSION['current_site'] ?? 'aquarium';

$cart_items = getCartItems();
$cart_total = getCartTotal();
$experience_cart_items = getExperienceCartItems();
$experience_cart_total = getExperienceCartTotal();
$all_cart_total = getAllCartTotal();
$user = getCurrentUser();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    if (empty($cart_items) && empty($experience_cart_items)) {
        $error = 'Your cart is empty';
    } else {
        $conn = getDBConnection();
        $customer_name = sanitize($_POST['customer_name'] ?? $user['full_name'] ?? $user['username']);
        $customer_email = sanitize($_POST['customer_email'] ?? $user['email']);
        $customer_phone = sanitize($_POST['customer_phone'] ?? $user['phone'] ?? '');
        $customer_address = sanitize($_POST['customer_address'] ?? $user['address'] ?? '');
        $payment_method = sanitize($_POST['payment_method'] ?? 'cash');
        $notes = sanitize($_POST['notes'] ?? '');

        if (empty($customer_name) || empty($customer_email) || empty($customer_address)) {
            $error = 'Vui lòng điền đầy đủ thông tin giao hàng';
        } else {
            $subtotal = $all_cart_total;
            $tax = $subtotal * 0.1;
            $shipping_fee = 5.00;
            $total_amount = $subtotal + $tax + $shipping_fee;
            $order_number = generateOrderNumber();
            
            // Add source site info to notes
            $source_site = $_SESSION['current_site'] ?? 'aquarium';
            $source_site_name = ucfirst(str_replace('-', ' ', $source_site));
            $enhanced_notes = $notes;
            if (!empty($enhanced_notes)) {
                $enhanced_notes .= "\n\n[SOURCE: " . strtoupper($source_site) . "]";
            } else {
                $enhanced_notes = "[SOURCE: " . strtoupper($source_site) . "]";
            }
            
            $stmt = $conn->prepare("INSERT INTO orders (user_id, order_number, customer_name, customer_email, customer_phone, customer_address, subtotal, tax, shipping_fee, total_amount, payment_method, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssddddss", $user['user_id'], $order_number, $customer_name, $customer_email, $customer_phone, $customer_address, $subtotal, $tax, $shipping_fee, $total_amount, $payment_method, $enhanced_notes);

            if ($stmt->execute()) {
                $order_id = $conn->insert_id;
                $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_price, quantity, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
                
                // Insert products
                foreach ($cart_items as $item) {
                    $price = $item['sale_price'] ? $item['sale_price'] : $item['price'];
                    $item_subtotal = $price * $item['cart_quantity'];
                    $stmt2->bind_param("iisidi", $order_id, $item['product_id'], $item['product_name'], $price, $item['cart_quantity'], $item_subtotal);
                    $stmt2->execute();
                }
                
                // Insert experiences (with product_id = 0)
                foreach ($experience_cart_items as $key => $exp_item) {
                    $experience = getExperienceBySlug($exp_item['slug']);
                    if ($experience) {
                        $price = $experience['price'];
                        $item_subtotal = $price * $exp_item['quantity'];
                        $item_name = $experience['title'];
                        if (!empty($exp_item['certificate_name'])) {
                            $item_name .= ' (Certificate: ' . $exp_item['certificate_name'] . ')';
                        }
                        // Use product_id = 0 for experiences
                        $product_id = 0;
                        $stmt2->bind_param("iisidi", $order_id, $product_id, $item_name, $price, $exp_item['quantity'], $item_subtotal);
                        if (!$stmt2->execute()) {
                            // If fails due to foreign key, try with NULL (if column allows NULL)
                            // Or handle error appropriately
                            error_log("Failed to insert experience order item: " . $stmt2->error);
                        }
                    }
                }
                
                $stmt2->close();
                $stmt->close();
                $conn->close();
                clearCart();
                clearExperienceCart();
                header('Location: order_success.php?order_id=' . $order_id);
                exit();
            } else {
                $error = 'Order failed. Please try again.';
                $stmt->close();
                $conn->close();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Jenkinson's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <div class="container my-5">
        <h2 class="mb-4">Checkout</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <?php if (empty($cart_items) && empty($experience_cart_items)): ?>
            <div class="alert alert-warning">
                <p class="mb-0">Your cart is empty. <a href="../index.php">Continue Shopping</a></p>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header"><h5>Shipping Information</h5></div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($user['full_name'] ?? $user['username']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="customer_email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="customer_email" name="customer_email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="customer_phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="customer_phone" name="customer_phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="customer_address" class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="customer_address" name="customer_address" rows="3" required><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Payment Method</label>
                                    <select class="form-select" id="payment_method" name="payment_method">
                                        <option value="cash">Cash</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="credit_card">Credit Card</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                </div>
                                <button type="submit" name="place_order" class="btn btn-primary">Place Order</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header"><h5>Order Summary</h5></div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2"><span>Subtotal:</span><span><?php echo formatCurrency($all_cart_total); ?></span></div>
                            <div class="d-flex justify-content-between mb-2"><span>Tax (10%):</span><span><?php echo formatCurrency($all_cart_total * 0.1); ?></span></div>
                            <div class="d-flex justify-content-between mb-2"><span>Shipping:</span><span><?php echo formatCurrency(5.00); ?></span></div>
                            <hr>
                            <div class="d-flex justify-content-between"><strong>Total:</strong><strong><?php echo formatCurrency($all_cart_total + ($all_cart_total * 0.1) + 5.00); ?></strong></div>
                            <div class="mt-3">
                                <?php if (!empty($cart_items)): ?>
                                    <h6>Products:</h6>
                                    <?php foreach ($cart_items as $item): ?>
                                        <div class="d-flex justify-content-between small mb-1">
                                            <span><?php echo htmlspecialchars($item['product_name']); ?> x<?php echo $item['cart_quantity']; ?></span>
                                            <span><?php echo formatCurrency(($item['sale_price'] ? $item['sale_price'] : $item['price']) * $item['cart_quantity']); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                
                                <?php if (!empty($experience_cart_items)): ?>
                                    <h6 class="mt-3">Experiences:</h6>
                                    <?php foreach ($experience_cart_items as $key => $exp_item): 
                                        $experience = getExperienceBySlug($exp_item['slug']);
                                        if ($experience):
                                            $price = $experience['price'];
                                            $subtotal = $price * $exp_item['quantity'];
                                    ?>
                                        <div class="d-flex justify-content-between small mb-1">
                                            <span>
                                                <?php echo htmlspecialchars($experience['title']); ?> x<?php echo $exp_item['quantity']; ?>
                                                <?php if (!empty($exp_item['certificate_name'])): ?>
                                                    <br><small class="text-muted">Certificate: <?php echo htmlspecialchars($exp_item['certificate_name']); ?></small>
                                                <?php endif; ?>
                                            </span>
                                            <span><?php echo formatCurrency($subtotal); ?></span>
                                        </div>
                                    <?php 
                                        endif;
                                    endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
