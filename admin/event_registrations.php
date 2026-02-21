<?php
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireAdmin();

$event_slug = $_GET['event'] ?? '';
$events = getEventsForAdmin();

if (empty($event_slug) || !isset($events[$event_slug])) {
    header('Location: events.php');
    exit();
}

$event_info = $events[$event_slug];
$registrations = getEventRegistrations($event_slug);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký: <?php echo htmlspecialchars($event_info['title']); ?> - Admin</title>
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
                <div class="admin-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <a href="events.php" class="text-decoration-none text-muted small me-2">
                            <i class="fa-solid fa-arrow-left"></i> Quay lại
                        </a>
                        <h2 class="mb-0"><i class="fa-solid fa-users"></i> <?php echo htmlspecialchars($event_info['title']); ?></h2>
                        <p class="text-muted small mb-0 mt-1"><?php echo htmlspecialchars($event_info['date']); ?></p>
                    </div>
                    <span class="badge bg-primary fs-6"><?php echo count($registrations); ?> người đăng ký</span>
                </div>

                <div class="admin-table mt-4">
                    <div class="admin-table-header">
                        <i class="fa-solid fa-list"></i> Danh sách người đăng ký
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">ID</th>
                                    <th style="width: 20%;">Họ tên</th>
                                    <th style="width: 22%;">Email</th>
                                    <th style="width: 15%;">SĐT</th>
                                    <th style="width: 10%;">Số lượng</th>
                                    <th style="width: 12%;">User</th>
                                    <th style="width: 8%;">Trạng thái</th>
                                    <th style="width: 12%;">Ngày đăng ký</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($registrations)): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-users-slash fa-2x mb-2 d-block"></i>
                                        Chưa có ai đăng ký
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($registrations as $r): ?>
                                <tr>
                                    <td><?php echo $r['registration_id']; ?></td>
                                    <td><strong><?php echo htmlspecialchars($r['full_name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($r['email']); ?></td>
                                    <td><?php echo htmlspecialchars($r['phone'] ?? '-'); ?></td>
                                    <td><?php echo (int)$r['quantity']; ?></td>
                                    <td>
                                        <?php if (!empty($r['username'])): ?>
                                            <span class="badge bg-info"><?php echo htmlspecialchars($r['username']); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">Guest</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php 
                                            echo $r['status'] === 'confirmed' ? 'success' : ($r['status'] === 'cancelled' ? 'danger' : 'warning'); 
                                        ?>"><?php echo ucfirst($r['status']); ?></span>
                                    </td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($r['created_at'])); ?></td>
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
