<?php
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireAdmin();

$events = getEventsForAdmin();
$counts = [];
foreach (array_keys($events) as $slug) {
    $counts[$slug] = getEventRegistrationCount($slug);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - Admin</title>
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
                    <h2><i class="fa-solid fa-calendar-days"></i> Events</h2>
                </div>

                <div class="admin-table">
                    <div class="admin-table-header">
                        <i class="fa-solid fa-calendar-check"></i> Danh sách sự kiện
                        <span class="badge bg-primary ms-2"><?php echo count($events); ?></span>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 40%;">Sự kiện</th>
                                    <th style="width: 20%;">Ngày</th>
                                    <th style="width: 20%;">Số người đăng ký</th>
                                    <th style="width: 20%;">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($events as $slug => $info): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($info['title']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($info['date']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $counts[$slug] > 0 ? 'success' : 'secondary'; ?>">
                                            <?php echo $counts[$slug]; ?> người
                                        </span>
                                    </td>
                                    <td>
                                        <a href="event_registrations.php?event=<?php echo urlencode($slug); ?>" class="admin-btn admin-btn-primary admin-btn-sm">
                                            <i class="fa-solid fa-users"></i> Xem đăng ký
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
