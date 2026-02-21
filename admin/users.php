<?php
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireAdmin();

$conn = getDBConnection();

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_user'])) {
        $user_id = intval($_POST['user_id']);
        
        // Prevent deleting own account
        if ($user_id == $_SESSION['user_id']) {
            header('Location: users.php?error=cannot_delete_self');
            exit();
        }
        
        // Prevent deleting admin accounts
        $check_stmt = $conn->prepare("SELECT role FROM users WHERE user_id = ?");
        $check_stmt->bind_param("i", $user_id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        $user = $result->fetch_assoc();
        $check_stmt->close();
        
        if ($user && $user['role'] === 'admin') {
            header('Location: users.php?error=cannot_delete_admin');
            exit();
        }
        
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
        
        header('Location: users.php?success=user_deleted');
        exit();
    } elseif (isset($_POST['update_status'])) {
        $user_id = intval($_POST['user_id']);
        $status = sanitize($_POST['status']);
        
        // Prevent blocking own account
        if ($user_id == $_SESSION['user_id'] && $status !== 'active') {
            header('Location: users.php?error=cannot_block_self');
            exit();
        }
        
        $stmt = $conn->prepare("UPDATE users SET status = ? WHERE user_id = ?");
        $stmt->bind_param("si", $status, $user_id);
        $stmt->execute();
        $stmt->close();
        
        header('Location: users.php?success=status_updated');
        exit();
    }
}

// Fetch users list with filters
$filter_role = $_GET['role'] ?? '';
$filter_status = $_GET['status'] ?? '';
$search = $_GET['search'] ?? '';

$sql = "SELECT u.*, 
        (SELECT COUNT(*) FROM orders WHERE user_id = u.user_id) as total_orders,
        (SELECT SUM(total_amount) FROM orders WHERE user_id = u.user_id AND payment_status = 'paid') as total_spent
        FROM users u WHERE 1=1";

$params = [];
$types = '';

if ($filter_role) {
    $sql .= " AND u.role = ?";
    $params[] = $filter_role;
    $types .= 's';
}

if ($filter_status) {
    $sql .= " AND u.status = ?";
    $params[] = $filter_status;
    $types .= 's';
}

if ($search) {
    $sql .= " AND (u.username LIKE ? OR u.email LIKE ? OR u.full_name LIKE ?)";
    $search_param = "%{$search}%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= 'sss';
}

$sql .= " ORDER BY u.created_at DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin</title>
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
                    <h2><i class="fa-solid fa-users"></i> Users Management</h2>
                </div>
                
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-check-circle me-2"></i>
                        <?php 
                        if ($_GET['success'] === 'user_deleted') echo 'User deleted successfully!';
                        elseif ($_GET['success'] === 'status_updated') echo 'User status updated successfully!';
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-exclamation-circle me-2"></i>
                        <?php 
                        if ($_GET['error'] === 'cannot_delete_self') echo 'You cannot delete your own account!';
                        elseif ($_GET['error'] === 'cannot_delete_admin') echo 'You cannot delete admin accounts!';
                        elseif ($_GET['error'] === 'cannot_block_self') echo 'You cannot block your own account!';
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <!-- Filters and Search -->
                <div class="admin-form-card mb-4">
                    <form method="GET" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">Search</label>
                            <input type="text" class="form-control" name="search" placeholder="Username, Email, or Name..." value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Role</label>
                            <select class="form-select" name="role">
                                <option value="">All Roles</option>
                                <option value="admin" <?php echo $filter_role === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="customer" <?php echo $filter_role === 'customer' ? 'selected' : ''; ?>>Customer</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="">All Status</option>
                                <option value="active" <?php echo $filter_status === 'active' ? 'selected' : ''; ?>>Active</option>
                                <option value="inactive" <?php echo $filter_status === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                <option value="banned" <?php echo $filter_status === 'banned' ? 'selected' : ''; ?>>Banned</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="admin-btn admin-btn-primary w-100">
                                <i class="fa-solid fa-search"></i> Filter
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Users Table -->
                <div class="admin-table">
                    <div class="admin-table-header">
                        <i class="fa-solid fa-users"></i> All Users
                        <span class="badge bg-primary ms-2"><?php echo count($users); ?></span>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">ID</th>
                                    <th style="width: 15%;">Username</th>
                                    <th style="width: 18%;">Email</th>
                                    <th style="width: 15%;">Full Name</th>
                                    <th style="width: 10%;">Phone</th>
                                    <th style="width: 8%;">Role</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 8%;">Orders</th>
                                    <th style="width: 8%;">Spent</th>
                                    <th style="width: 8%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($users)): ?>
                                    <tr>
                                        <td colspan="10" class="text-center py-5">
                                            <div class="admin-empty-state">
                                                <i class="fa-solid fa-user-slash"></i>
                                                <p class="mb-0">No users found</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo $user['user_id']; ?></td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                                                <?php if ($user['user_id'] == $_SESSION['user_id']): ?>
                                                    <span class="badge bg-info ms-1">You</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td><?php echo htmlspecialchars($user['full_name'] ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($user['phone'] ?? '-'); ?></td>
                                            <td>
                                                <span class="badge <?php echo $user['role'] === 'admin' ? 'bg-danger' : 'bg-primary'; ?>">
                                                    <?php echo ucfirst($user['role']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <form method="POST" style="display:inline;" class="d-inline">
                                                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                                    <select name="status" class="form-select form-select-sm" 
                                                            onchange="if(confirm('Are you sure you want to change this user\'s status?')) this.form.submit(); else this.value='<?php echo htmlspecialchars($user['status'] ?? '', ENT_QUOTES, 'UTF-8'); ?>';"
                                                            <?php echo ($user['user_id'] == $_SESSION['user_id'] && $user['status'] !== 'active') ? 'disabled' : ''; ?>>
                                                        <option value="active" <?php echo $user['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                                                        <option value="inactive" <?php echo $user['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                                        <option value="banned" <?php echo $user['status'] === 'banned' ? 'selected' : ''; ?>>Banned</option>
                                                    </select>
                                                    <input type="hidden" name="update_status" value="1">
                                                </form>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary"><?php echo $user['total_orders'] ?? 0; ?></span>
                                            </td>
                                            <td>
                                                <?php if ($user['total_spent']): ?>
                                                    <strong><?php echo formatCurrency($user['total_spent']); ?></strong>
                                                <?php else: ?>
                                                    <span class="text-muted">$0.00</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <?php if ($user['user_id'] != $_SESSION['user_id'] && $user['role'] !== 'admin'): ?>
                                                        <form method="POST" style="display:inline;" 
                                                              onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone!');">
                                                            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                                            <button type="submit" name="delete_user" class="admin-btn admin-btn-danger admin-btn-sm" title="Delete User">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    <?php else: ?>
                                                        <span class="admin-btn admin-btn-secondary admin-btn-sm" style="opacity: 0.5; cursor: not-allowed;" title="Cannot delete">
                                                            <i class="fa-solid fa-ban"></i>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
