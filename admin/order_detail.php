<?php
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireAdmin();

$order_id = intval($_GET['id'] ?? 0);

if (!$order_id) {
    header('Location: orders.php');
    exit();
}

$conn = getDBConnection();
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$order) {
    header('Location: orders.php');
    exit();
}

$order_items = getOrderItems($order_id);

// Extract source site from notes
$source_site = 'Unknown';
$display_notes = $order['notes'] ?? '';
if (preg_match('/\[SOURCE:\s*([A-Z\-]+)\]/i', $order['notes'] ?? '', $matches)) {
    $source_site = strtolower($matches[1]);
    // Remove source tag from display notes
    $display_notes = preg_replace('/\[SOURCE:\s*[A-Z\-]+\]\s*/i', '', $display_notes);
    $display_notes = trim($display_notes);
}

$source_site_names = [
    'aquarium' => 'Aquarium',
    'boardwalk' => 'Boardwalk',
    'sweet-shop' => 'Sweet Shop'
];
$source_site_display = $source_site_names[$source_site] ?? ucfirst(str_replace('-', ' ', $source_site));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../css/variables.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/admin-order-detail.css">
</head>
<body class="admin-page">
    <div class="container-fluid admin-container-fluid">
        <div class="row admin-row">
            <?php include 'includes/sidebar.php'; ?>
            
            <div class="admin-content">
                <div class="admin-header">
                    <button type="button" class="admin-menu-toggle" id="adminMenuToggle" aria-label="Open menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h2><i class="fa-solid fa-file-invoice"></i> Order #<?php echo htmlspecialchars($order['order_number']); ?></h2>
                </div>
                
                <div class="row g-4 admin-order-row">
                    <div class="col-lg-8">
                        <div class="admin-card mb-4">
                            <div class="admin-card-header">
                                <h5><i class="fa-solid fa-box me-2"></i>Products & Experiences</h5>
                            </div>
                            <div class="admin-card-body">
                                <div class="table-responsive">
                                    <table class="table admin-order-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px;">Image</th>
                                                <th>Product / Experience</th>
                                                <th style="width: 100px;">Price</th>
                                                <th style="width: 80px;">Qty</th>
                                                <th style="width: 120px;">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($order_items as $item): ?>
                                                <tr>
                                                    <td>
                                                        <?php if (!empty($item['image'])): ?>
                                                            <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                                                                 alt="<?php echo htmlspecialchars($item['product_name']); ?>" 
                                                                 class="admin-product-thumb">
                                                        <?php else: ?>
                                                            <div class="admin-product-thumb admin-product-thumb-placeholder">
                                                                <i class="fa-solid fa-image"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="admin-product-name">
                                                            <?php echo htmlspecialchars($item['product_name']); ?>
                                                            <?php if (!empty($item['is_event'])): ?>
                                                                <span class="badge bg-primary ms-2">Event</span>
                                                            <?php elseif (isset($item['is_experience']) && $item['is_experience']): ?>
                                                                <span class="badge bg-info ms-2">Experience</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td><?php echo formatCurrency($item['product_price']); ?></td>
                                                    <td><?php echo $item['quantity']; ?></td>
                                                    <td><strong><?php echo formatCurrency($item['subtotal']); ?></strong></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h5><i class="fa-solid fa-info-circle me-2"></i>Order Information</h5>
                            </div>
                            <div class="admin-card-body">
                                <form method="POST" action="orders.php">
                                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Order Status</label>
                                        <select name="order_status" class="form-select">
                                            <option value="pending" <?php echo $order['order_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="processing" <?php echo $order['order_status'] == 'processing' ? 'selected' : ''; ?>>Processing</option>
                                            <option value="shipped" <?php echo $order['order_status'] == 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                            <option value="delivered" <?php echo $order['order_status'] == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                            <option value="cancelled" <?php echo $order['order_status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Payment Status</label>
                                        <select name="payment_status" class="form-select">
                                            <option value="pending" <?php echo $order['payment_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="paid" <?php echo $order['payment_status'] == 'paid' ? 'selected' : ''; ?>>Paid</option>
                                            <option value="failed" <?php echo $order['payment_status'] == 'failed' ? 'selected' : ''; ?>>Failed</option>
                                            <option value="refunded" <?php echo $order['payment_status'] == 'refunded' ? 'selected' : ''; ?>>Refunded</option>
                                        </select>
                                    </div>
                                    
                                    <button type="submit" name="update_status" class="admin-btn admin-btn-primary w-100 mb-4">
                                        <i class="fa-solid fa-save me-2"></i>Update Status
                                    </button>
                                </form>
                                
                                <div class="admin-info-divider"></div>
                                
                                <div class="admin-info-section">
                                    <div class="admin-info-item">
                                        <span class="admin-info-label">Order #:</span>
                                        <span class="admin-info-value"><?php echo htmlspecialchars($order['order_number']); ?></span>
                                    </div>
                                    <div class="admin-info-item">
                                        <span class="admin-info-label">Order Date:</span>
                                        <span class="admin-info-value"><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></span>
                                    </div>
                                    <div class="admin-info-item admin-info-item-highlight">
                                        <span class="admin-info-label"><i class="fa-solid fa-store me-1"></i>Purchased From:</span>
                                        <span class="admin-info-value admin-source-badge admin-source-<?php echo htmlspecialchars($source_site); ?>">
                                            <?php echo htmlspecialchars($source_site_display); ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="admin-info-divider"></div>
                                
                                <div class="admin-info-section">
                                    <h6 class="admin-info-section-title">Order Summary</h6>
                                    <div class="admin-info-item">
                                        <span class="admin-info-label">Subtotal:</span>
                                        <span class="admin-info-value"><?php echo formatCurrency($order['subtotal']); ?></span>
                                    </div>
                                    <div class="admin-info-item">
                                        <span class="admin-info-label">Tax:</span>
                                        <span class="admin-info-value"><?php echo formatCurrency($order['tax']); ?></span>
                                    </div>
                                    <div class="admin-info-item">
                                        <span class="admin-info-label">Shipping:</span>
                                        <span class="admin-info-value"><?php echo formatCurrency($order['shipping_fee']); ?></span>
                                    </div>
                                    <div class="admin-info-divider"></div>
                                    <div class="admin-info-item admin-info-total">
                                        <span class="admin-info-label">Total:</span>
                                        <span class="admin-info-value"><?php echo formatCurrency($order['total_amount']); ?></span>
                                    </div>
                                </div>
                                
                                <div class="admin-info-divider"></div>
                                
                                <div class="admin-info-section">
                                    <h6 class="admin-info-section-title">Customer Information</h6>
                                    <div class="admin-info-item">
                                        <span class="admin-info-label">Name:</span>
                                        <span class="admin-info-value"><?php echo htmlspecialchars($order['customer_name']); ?></span>
                                    </div>
                                    <div class="admin-info-item">
                                        <span class="admin-info-label">Email:</span>
                                        <span class="admin-info-value">
                                            <a href="mailto:<?php echo htmlspecialchars($order['customer_email']); ?>" class="admin-link">
                                                <?php echo htmlspecialchars($order['customer_email']); ?>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="admin-info-item">
                                        <span class="admin-info-label">Phone:</span>
                                        <span class="admin-info-value">
                                            <a href="tel:<?php echo htmlspecialchars($order['customer_phone']); ?>" class="admin-link">
                                                <?php echo htmlspecialchars($order['customer_phone']); ?>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="admin-info-item admin-info-item-full">
                                        <span class="admin-info-label">Address:</span>
                                        <span class="admin-info-value admin-address-text"><?php echo nl2br(htmlspecialchars($order['customer_address'])); ?></span>
                                    </div>
                                </div>
                                
                                <?php if (!empty($display_notes)): ?>
                                    <div class="admin-info-divider"></div>
                                    <div class="admin-info-section">
                                        <h6 class="admin-info-section-title">Notes</h6>
                                        <div class="admin-notes-text"><?php echo nl2br(htmlspecialchars($display_notes)); ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="admin-action-bar">
                    <a href="orders.php" class="admin-btn admin-btn-secondary">
                        <i class="fa-solid fa-arrow-left me-2"></i>Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
