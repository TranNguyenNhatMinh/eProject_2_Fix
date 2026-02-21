<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireLogin();

$order_id = intval($_GET['order_id'] ?? 0);
if (!$order_id) {
    header('Location: ../index.php');
    exit();
}

$conn = getDBConnection();
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND user_id = ?");
$user_id = $_SESSION['user_id'];
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

if (!$order) {
    $conn->close();
    header('Location: ../index.php');
    exit();
}

$order_items = getOrderItems($order_id);
$conn->close();

$currentSite = $_SESSION['current_site'] ?? 'aquarium';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success - Jenkinson's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="green" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                        <h2 class="text-success mb-3">Order Placed Successfully!</h2>
                        <p class="mb-4">Thank you for your order. Your order number is: <strong><?php echo htmlspecialchars($order['order_number']); ?></strong></p>
                        <div class="text-start mb-4">
                            <h5>Order Details:</h5>
                            <table class="table table-bordered">
                                <tr><th>Order #:</th><td><?php echo htmlspecialchars($order['order_number']); ?></td></tr>
                                <tr><th>Order Date:</th><td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td></tr>
                                <tr><th>Total:</th><td><strong><?php echo formatCurrency($order['total_amount']); ?></strong></td></tr>
                                <tr><th>Status:</th><td><?php $status_labels = ['pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled']; echo $status_labels[$order['order_status']] ?? $order['order_status']; ?></td></tr>
                            </table>
                            <h6 class="mt-3">Products & Events Ordered:</h6>
                            <ul class="list-group">
                                <?php foreach ($order_items as $item): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <?php if (!empty($item['image'])): ?>
                                                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                            <?php endif; ?>
                                            <div>
                                                <span><?php echo htmlspecialchars($item['product_name']); ?></span> x<?php echo $item['quantity']; ?>
                                                <?php if (!empty($item['is_event'])): ?>
                                                    <span class="badge bg-primary ms-2">Event</span>
                                                <?php elseif (isset($item['is_experience'])): ?>
                                                    <span class="badge bg-info ms-2">Experience</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <span><?php echo formatCurrency($item['subtotal']); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="../index.php" class="btn btn-primary">Continue Shopping</a>
                            <a href="my_orders.php" class="btn btn-outline-secondary">View My Orders</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
