<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

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

$currentSite = $_SESSION['current_site'] ?? 'aquarium';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Jenkinson's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .order-item-thumb { width: 56px; height: 56px; object-fit: cover; }
        .order-item-thumb-placeholder { min-width: 56px; min-height: 56px; }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <div class="container my-5">
        <h2 class="mb-4">Order Details #<?php echo htmlspecialchars($order['order_number']); ?></h2>
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header"><h5>Products & Events</h5></div>
                    <div class="card-body">
                        <table class="table table-order-items">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $status_labels = ['pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'];
                                $status_badge = ['delivered' => 'success', 'cancelled' => 'danger', 'shipped' => 'info'];
                                foreach ($order_items as $item): 
                                    $item_status = $order['order_status'];
                                    $status_class = $status_badge[$item_status] ?? 'warning';
                                ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <?php if (!empty($item['image'])): ?>
                                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="" class="order-item-thumb rounded">
                                                <?php else: ?>
                                                    <div class="order-item-thumb order-item-thumb-placeholder rounded bg-light d-flex align-items-center justify-content-center text-muted"><small>—</small></div>
                                                <?php endif; ?>
                                                <div>
                                                    <div class="fw-semibold"><?php echo htmlspecialchars($item['product_name']); ?></div>
                                                    <?php if (!empty($item['is_event'])): ?>
                                                        <span class="badge bg-primary mt-1">Event</span>
                                                    <?php elseif (!empty($item['is_experience'])): ?>
                                                        <span class="badge bg-info mt-1">Experience</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-<?php echo $status_class; ?>"><?php echo strtoupper($status_labels[$item_status] ?? $item_status); ?></span></td>
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
                    <div class="card-header"><h5>Order Information</h5></div>
                    <div class="card-body">
                        <p><strong>Order #:</strong> <?php echo htmlspecialchars($order['order_number']); ?></p>
                        <p><strong>Order Date:</strong> <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
                        <p><strong>Status:</strong> <span class="badge bg-warning"><?php $status_labels = ['pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled']; echo $status_labels[$order['order_status']] ?? $order['order_status']; ?></span></p>
                        <p><strong>Payment:</strong> <span class="badge bg-<?php echo $order['payment_status'] === 'paid' ? 'success' : 'warning'; ?>"><?php $payment_labels = ['pending' => 'Pending', 'paid' => 'Paid', 'failed' => 'Failed', 'refunded' => 'Refunded']; echo $payment_labels[$order['payment_status']] ?? $order['payment_status']; ?></span></p>
                        <hr>
                        <p><strong>Subtotal:</strong> <?php echo formatCurrency($order['subtotal']); ?></p>
                        <p><strong>Tax:</strong> <?php echo formatCurrency($order['tax']); ?></p>
                        <p><strong>Shipping:</strong> <?php echo formatCurrency($order['shipping_fee']); ?></p>
                        <hr>
                        <p><strong>Total:</strong> <?php echo formatCurrency($order['total_amount']); ?></p>
                        <h6 class="mt-3">Shipping Information:</h6>
                        <p><?php echo nl2br(htmlspecialchars($order['customer_address'])); ?></p>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['customer_phone']); ?></p>
                        <?php if ($order['notes']): ?>
                            <h6 class="mt-3">Notes:</h6>
                            <p><?php echo nl2br(htmlspecialchars($order['notes'])); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <a href="my_orders.php" class="btn btn-secondary">Back</a>
    </div>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
