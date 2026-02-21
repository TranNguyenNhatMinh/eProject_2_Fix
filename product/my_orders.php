<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireLogin();

$user = getCurrentUser();
$orders = getUserOrders($user['user_id']);

$currentSite = $_SESSION['current_site'] ?? 'aquarium';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Jenkinson's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/variables.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/my-orders.css">
</head>
<body class="page-my-orders">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="flex-grow-1">
    <div class="my-orders-container container my-5">
        <h2 class="my-orders-title">My Orders</h2>
        <?php if (empty($orders)): ?>
            <div class="my-orders-empty">
                <div class="alert alert-info">
                    <p class="mb-0">You don't have any orders yet. <a href="../index.php">Continue Shopping</a></p>
                </div>
            </div>
        <?php else: ?>
            <div class="my-orders-card">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Order Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order):
                            $status_labels = ['pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'];
                            $payment_labels = ['pending' => 'Pending', 'paid' => 'Paid', 'failed' => 'Failed', 'refunded' => 'Refunded'];
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['order_number']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                <td><?php echo formatCurrency($order['total_amount']); ?></td>
                                <td><span class="badge bg-<?php echo $order['order_status'] === 'delivered' ? 'success' : ($order['order_status'] === 'cancelled' ? 'danger' : 'warning'); ?>"><?php echo $status_labels[$order['order_status']] ?? $order['order_status']; ?></span></td>
                                <td><span class="badge bg-<?php echo $order['payment_status'] === 'paid' ? 'success' : ($order['payment_status'] === 'failed' ? 'danger' : 'warning'); ?>"><?php echo $payment_labels[$order['payment_status']] ?? $order['payment_status']; ?></span></td>
                                <td><a href="order_detail.php?id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-order-detail">View Details</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            </div>
        <?php endif; ?>
    </div>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
