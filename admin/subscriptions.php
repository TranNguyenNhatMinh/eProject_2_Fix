<?php
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireAdmin();

$conn = getDBConnection();

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_subscription'])) {
        $subscription_id = intval($_POST['subscription_id']);
        $stmt = $conn->prepare("DELETE FROM subscriptions WHERE subscription_id = ?");
        $stmt->bind_param("i", $subscription_id);
        $stmt->execute();
        $stmt->close();
        
        header('Location: subscriptions.php?success=deleted');
        exit();
    } elseif (isset($_POST['update_status'])) {
        $subscription_id = intval($_POST['subscription_id']);
        $status = sanitize($_POST['status']);
        
        $stmt = $conn->prepare("UPDATE subscriptions SET status = ? WHERE subscription_id = ?");
        $stmt->bind_param("si", $status, $subscription_id);
        $stmt->execute();
        $stmt->close();
        
        header('Location: subscriptions.php?success=updated');
        exit();
    }
}

// Get all subscriptions
$sql = "SELECT * FROM subscriptions ORDER BY created_at DESC";
$result = $conn->query($sql);
$subscriptions = [];
while ($row = $result->fetch_assoc()) {
    $subscriptions[] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Subscriptions - Admin</title>
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
                    <h2><i class="fa-solid fa-envelope"></i> Email Subscriptions</h2>
                </div>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-check-circle me-2"></i>
                        <?php
                        if ($_GET['success'] === 'deleted') {
                            echo 'Subscription deleted successfully!';
                        } elseif ($_GET['success'] === 'updated') {
                            echo 'Subscription status updated successfully!';
                        }
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Subscriptions Table -->
                <div class="admin-table">
                    <div class="admin-table-header">
                        <i class="fa-solid fa-envelope"></i> All Subscriptions
                        <span class="badge bg-primary ms-2"><?php echo count($subscriptions); ?></span>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">ID</th>
                                    <th style="width: 30%;">Email</th>
                                    <th style="width: 15%;">Status</th>
                                    <th style="width: 20%;">Subscribed Date</th>
                                    <th style="width: 30%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($subscriptions)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="admin-empty-state">
                                                <i class="fa-solid fa-envelope-open"></i>
                                                <p class="mb-0">No subscriptions yet.</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($subscriptions as $sub): ?>
                                    <tr>
                                        <td><?php echo $sub['subscription_id']; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($sub['email']); ?></strong>
                                        </td>
                                        <td>
                                            <form method="POST" style="display:inline;" class="d-inline">
                                                <input type="hidden" name="subscription_id" value="<?php echo $sub['subscription_id']; ?>">
                                                <select name="status" class="form-select form-select-sm" 
                                                        onchange="this.form.submit();">
                                                    <option value="active" <?php echo $sub['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                                                    <option value="unsubscribed" <?php echo $sub['status'] === 'unsubscribed' ? 'selected' : ''; ?>>Unsubscribed</option>
                                                </select>
                                                <input type="hidden" name="update_status" value="1">
                                            </form>
                                        </td>
                                        <td><?php echo date('M d, Y', strtotime($sub['created_at'])); ?></td>
                                        <td>
                                            <form method="POST" style="display:inline;" 
                                                  onsubmit="return confirm('Are you sure you want to delete this subscription?');">
                                                <input type="hidden" name="subscription_id" value="<?php echo $sub['subscription_id']; ?>">
                                                <input type="hidden" name="delete_subscription" value="1">
                                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" title="Delete Subscription">
                                                    <i class="fa-solid fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.js"></script>
</body>
</html>
