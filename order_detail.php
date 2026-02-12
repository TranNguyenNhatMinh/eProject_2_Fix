<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

requireLogin();

$order_id = intval($_GET['id'] ?? 0);

if (!$order_id) {
    header('Location: my_orders.php');
    exit();
}

$user = getCurrentUser();
$conn = getDBConnection();
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND user_id = ?");
$stmt->bind_param("ii", $order_id, $user['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$order) {
    header('Location: my_orders.php');
    exit();
}

$order_items = getOrderItems($order_id);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng - Jenkinson's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container my-5">
        <h2 class="mb-4">Chi tiết đơn hàng #<?php echo htmlspecialchars($order['order_number']); ?></h2>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Sản phẩm</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order_items as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                        <td><?php echo formatCurrency($item['product_price']); ?></td>
                                        <td><?php echo $item['quantity']; ?></td>
                                        <td><?php echo formatCurrency($item['subtotal']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Thông tin đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Mã đơn:</strong> <?php echo htmlspecialchars($order['order_number']); ?></p>
                        <p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
                        <p><strong>Trạng thái:</strong> 
                            <span class="badge bg-warning"><?php 
                                $status_labels = ['pending' => 'Chờ xử lý', 'processing' => 'Đang xử lý', 'shipped' => 'Đã giao hàng', 'delivered' => 'Đã nhận hàng', 'cancelled' => 'Đã hủy'];
                                echo $status_labels[$order['order_status']] ?? $order['order_status'];
                            ?></span>
                        </p>
                        <p><strong>Thanh toán:</strong> 
                            <span class="badge bg-<?php echo $order['payment_status'] === 'paid' ? 'success' : 'warning'; ?>">
                                <?php 
                                $payment_labels = ['pending' => 'Chờ thanh toán', 'paid' => 'Đã thanh toán', 'failed' => 'Thất bại', 'refunded' => 'Đã hoàn tiền'];
                                echo $payment_labels[$order['payment_status']] ?? $order['payment_status'];
                                ?>
                            </span>
                        </p>
                        <hr>
                        <p><strong>Tạm tính:</strong> <?php echo formatCurrency($order['subtotal']); ?></p>
                        <p><strong>Thuế:</strong> <?php echo formatCurrency($order['tax']); ?></p>
                        <p><strong>Phí vận chuyển:</strong> <?php echo formatCurrency($order['shipping_fee']); ?></p>
                        <hr>
                        <p><strong>Tổng cộng:</strong> <?php echo formatCurrency($order['total_amount']); ?></p>
                        
                        <h6 class="mt-3">Thông tin giao hàng:</h6>
                        <p><?php echo nl2br(htmlspecialchars($order['customer_address'])); ?></p>
                        <p><strong>Điện thoại:</strong> <?php echo htmlspecialchars($order['customer_phone']); ?></p>
                        
                        <?php if ($order['notes']): ?>
                            <h6 class="mt-3">Ghi chú:</h6>
                            <p><?php echo nl2br(htmlspecialchars($order['notes'])); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <a href="my_orders.php" class="btn btn-secondary">Quay lại</a>
    </div>
    
    <?php include 'includes/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
