<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

requireLogin();

$cart_items = getCartItems();
$cart_total = getCartTotal();
$user = getCurrentUser();

$error = '';
$success = '';

// Xử lý đặt hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    if (empty($cart_items)) {
        $error = 'Giỏ hàng của bạn đang trống';
    } else {
        $conn = getDBConnection();
        
        // Lấy thông tin từ form
        $customer_name = sanitize($_POST['customer_name'] ?? $user['full_name'] ?? $user['username']);
        $customer_email = sanitize($_POST['customer_email'] ?? $user['email']);
        $customer_phone = sanitize($_POST['customer_phone'] ?? $user['phone'] ?? '');
        $customer_address = sanitize($_POST['customer_address'] ?? $user['address'] ?? '');
        $payment_method = sanitize($_POST['payment_method'] ?? 'cash');
        $notes = sanitize($_POST['notes'] ?? '');
        
        // Validation
        if (empty($customer_name) || empty($customer_email) || empty($customer_address)) {
            $error = 'Vui lòng điền đầy đủ thông tin giao hàng';
        } else {
            // Tính toán tổng tiền
            $subtotal = $cart_total;
            $tax = $subtotal * 0.1; // 10% tax
            $shipping_fee = 5.00; // Fixed shipping
            $total_amount = $subtotal + $tax + $shipping_fee;
            
            // Tạo đơn hàng
            $order_number = generateOrderNumber();
            $stmt = $conn->prepare("INSERT INTO orders (user_id, order_number, customer_name, customer_email, customer_phone, customer_address, subtotal, tax, shipping_fee, total_amount, payment_method, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssddddss", $user['user_id'], $order_number, $customer_name, $customer_email, $customer_phone, $customer_address, $subtotal, $tax, $shipping_fee, $total_amount, $payment_method, $notes);
            
            if ($stmt->execute()) {
                $order_id = $conn->insert_id;
                
                // Thêm chi tiết đơn hàng
                $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_price, quantity, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
                
                foreach ($cart_items as $item) {
                    $price = $item['sale_price'] ? $item['sale_price'] : $item['price'];
                    $item_subtotal = $price * $item['cart_quantity'];
                    $stmt2->bind_param("iisidi", $order_id, $item['product_id'], $item['product_name'], $price, $item['cart_quantity'], $item_subtotal);
                    $stmt2->execute();
                }
                
                $stmt2->close();
                $stmt->close();
                $conn->close();
                
                // Xóa giỏ hàng
                clearCart();
                
                header('Location: order_success.php?order_id=' . $order_id);
                exit();
            } else {
                $error = 'Đặt hàng thất bại. Vui lòng thử lại.';
                $stmt->close();
                $conn->close();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - Jenkinson's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container my-5">
        <h2 class="mb-4">Thanh toán</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (empty($cart_items)): ?>
            <div class="alert alert-warning">
                <p class="mb-0">Giỏ hàng của bạn đang trống. <a href="index.php">Tiếp tục mua sắm</a></p>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Thông tin giao hàng</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($user['full_name'] ?? $user['username']); ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="customer_email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="customer_email" name="customer_email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="customer_phone" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="customer_phone" name="customer_phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="customer_address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="customer_address" name="customer_address" rows="3" required><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Phương thức thanh toán</label>
                                    <select class="form-select" id="payment_method" name="payment_method">
                                        <option value="cash">Tiền mặt</option>
                                        <option value="bank_transfer">Chuyển khoản</option>
                                        <option value="credit_card">Thẻ tín dụng</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Ghi chú</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                </div>
                                
                                <button type="submit" name="place_order" class="btn btn-primary">Đặt hàng</button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Tóm tắt đơn hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính:</span>
                                <span><?php echo formatCurrency($cart_total); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Thuế (10%):</span>
                                <span><?php echo formatCurrency($cart_total * 0.1); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Phí vận chuyển:</span>
                                <span><?php echo formatCurrency(5.00); ?></span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Tổng cộng:</strong>
                                <strong><?php echo formatCurrency($cart_total + ($cart_total * 0.1) + 5.00); ?></strong>
                            </div>
                            
                            <div class="mt-3">
                                <h6>Sản phẩm trong giỏ:</h6>
                                <?php foreach ($cart_items as $item): ?>
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span><?php echo htmlspecialchars($item['product_name']); ?> x<?php echo $item['cart_quantity']; ?></span>
                                        <span><?php echo formatCurrency(($item['sale_price'] ? $item['sale_price'] : $item['price']) * $item['cart_quantity']); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <?php include 'includes/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
