<?php
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireAdmin();

$conn = getDBConnection();

// Update order status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $order_status = sanitize($_POST['order_status']);
    $payment_status = sanitize($_POST['payment_status']);
    
    $stmt = $conn->prepare("UPDATE orders SET order_status = ?, payment_status = ? WHERE order_id = ?");
    $stmt->bind_param("ssi", $order_status, $payment_status, $order_id);
    $stmt->execute();
    $stmt->close();
    
    header('Location: orders.php?success=1');
    exit();
}

// Fetch orders list
$filter_status = $_GET['status'] ?? '';
$sql = "SELECT * FROM orders";
if ($filter_status) {
    $sql .= " WHERE order_status = '" . $conn->real_escape_string($filter_status) . "'";
}
$sql .= " ORDER BY created_at DESC";

$result = $conn->query($sql);
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../css/variables.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body class="admin-page">
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?>
            
            <div class="admin-content">
                <div class="admin-header">
                    <button type="button" class="admin-menu-toggle" id="adminMenuToggle" aria-label="Open menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h2><i class="fa-solid fa-shopping-cart"></i> Orders</h2>
                </div>
                
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">Update successful!</div>
                <?php endif; ?>
                
                <!-- Filter -->
                <div class="mb-3">
                    <a href="orders.php" class="btn btn-sm <?php echo !$filter_status ? 'btn-primary' : 'btn-outline-primary'; ?>">All</a>
                    <a href="?status=pending" class="btn btn-sm <?php echo $filter_status == 'pending' ? 'btn-primary' : 'btn-outline-primary'; ?>">Pending</a>
                    <a href="?status=processing" class="btn btn-sm <?php echo $filter_status == 'processing' ? 'btn-primary' : 'btn-outline-primary'; ?>">Processing</a>
                    <a href="?status=shipped" class="btn btn-sm <?php echo $filter_status == 'shipped' ? 'btn-primary' : 'btn-outline-primary'; ?>">Shipped</a>
                    <a href="?status=delivered" class="btn btn-sm <?php echo $filter_status == 'delivered' ? 'btn-primary' : 'btn-outline-primary'; ?>">Delivered</a>
                </div>
                
                <div class="admin-table">
                    <div class="table-responsive">
                        <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Total</th>
                                        <th>Order Status</th>
                                        <th>Payment</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($order['order_number']); ?></td>
                                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                            <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
                                            <td><?php echo formatCurrency($order['total_amount']); ?></td>
                                            <td>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                    <select name="order_status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                        <option value="pending" <?php echo $order['order_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="processing" <?php echo $order['order_status'] == 'processing' ? 'selected' : ''; ?>>Processing</option>
                                                        <option value="shipped" <?php echo $order['order_status'] == 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                                        <option value="delivered" <?php echo $order['order_status'] == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                                        <option value="cancelled" <?php echo $order['order_status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                                    </select>
                                                    <input type="hidden" name="payment_status" value="<?php echo htmlspecialchars($order['payment_status']); ?>">
                                                    <input type="hidden" name="update_status" value="1">
                                                </form>
                                            </td>
                                            <td>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                    <select name="payment_status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                        <option value="pending" <?php echo $order['payment_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="paid" <?php echo $order['payment_status'] == 'paid' ? 'selected' : ''; ?>>Paid</option>
                                                        <option value="failed" <?php echo $order['payment_status'] == 'failed' ? 'selected' : ''; ?>>Failed</option>
                                                        <option value="refunded" <?php echo $order['payment_status'] == 'refunded' ? 'selected' : ''; ?>>Refunded</option>
                                                    </select>
                                                    <input type="hidden" name="order_status" value="<?php echo htmlspecialchars($order['order_status']); ?>">
                                                    <input type="hidden" name="update_status" value="1">
                                                </form>
                                            </td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                            <td>
                                                <a href="order_detail.php?id=<?php echo $order['order_id']; ?>" class="admin-btn admin-btn-primary admin-btn-sm">
                                                    <i class="fa-solid fa-eye me-1"></i>View Details
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
