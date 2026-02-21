<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireLogin();

$user = getCurrentUser();
$currentSite = $_SESSION['current_site'] ?? 'aquarium';

$error = '';
$success = '';
$edit_mode = isset($_GET['edit']) && $_GET['edit'] === '1';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $full_name = sanitize($_POST['full_name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $address = sanitize($_POST['address'] ?? '');

    $result = updateUserProfile($user['user_id'], $full_name, $email, $phone, $address);
    if ($result['success']) {
        $user = getCurrentUser();
        $success = 'Profile updated successfully.';
        $edit_mode = false;
    } else {
        $error = $result['message'];
        $edit_mode = true;
    }
}

if (isset($_GET['updated']) && $_GET['updated'] === '1') {
    $success = 'Profile updated successfully.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Information - Jenkinson's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../css/variables.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body class="page-profile">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="flex-grow-1">
        <div class="profile-container container py-5">
            <h1 class="profile-title">Personal Information</h1>

            <?php if ($success): ?>
                <div class="profile-alert profile-alert--success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?php echo htmlspecialchars($success); ?></span>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="profile-alert profile-alert--error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php endif; ?>

            <?php if (!$edit_mode): ?>
                <!-- View Mode -->
                <div class="profile-card profile-view">
                    <div class="profile-view-top">
                        <div class="profile-view-intro">
                            <div class="profile-avatar">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="profile-intro-text">
                                <h2 class="profile-name"><?php echo htmlspecialchars($user['full_name'] ?: $user['username']); ?></h2>
                                <p class="profile-username">@<?php echo htmlspecialchars($user['username']); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="profile-view-body">
                        <p class="profile-section-label">Account Information</p>
                        <div class="profile-fields">
                            <div class="profile-field">
                                <span class="profile-label"><i class="fa-solid fa-at"></i> Username</span>
                                <span class="profile-value"><?php echo htmlspecialchars($user['username']); ?></span>
                            </div>
                            <div class="profile-field">
                                <span class="profile-label"><i class="fa-solid fa-id-card"></i> Full Name</span>
                                <span class="profile-value <?php echo empty($user['full_name']) ? 'profile-value--empty' : ''; ?>"><?php echo htmlspecialchars($user['full_name'] ?: 'Not updated'); ?></span>
                            </div>
                            <div class="profile-field">
                                <span class="profile-label"><i class="fa-solid fa-envelope"></i> Email</span>
                                <span class="profile-value"><?php echo htmlspecialchars($user['email']); ?></span>
                            </div>
                            <div class="profile-field">
                                <span class="profile-label"><i class="fa-solid fa-phone"></i> Phone Number</span>
                                <span class="profile-value <?php echo empty($user['phone']) ? 'profile-value--empty' : ''; ?>"><?php echo htmlspecialchars($user['phone'] ?: 'Not updated'); ?></span>
                            </div>
                            <div class="profile-field">
                                <span class="profile-label"><i class="fa-solid fa-location-dot"></i> Address</span>
                                <span class="profile-value <?php echo empty($user['address']) ? 'profile-value--empty' : ''; ?>"><?php echo nl2br(htmlspecialchars($user['address'] ?: 'Not updated')); ?></span>
                            </div>
                        </div>
                        <div class="profile-view-footer">
                            <a href="profile.php?edit=1" class="btn-edit-profile">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>Edit Information</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Edit Mode -->
                <div class="profile-card profile-edit">
                    <h2 class="profile-edit-title"><i class="fa-solid fa-pen-to-square"></i> Edit Information</h2>
                    <form method="POST" action="" class="profile-edit-form">
                        <div class="profile-form-group">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                            <small class="profile-form-hint">Username cannot be changed.</small>
                        </div>
                        <div class="profile-form-group">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" placeholder="Enter full name">
                        </div>
                        <div class="profile-form-group">
                            <label for="email" class="form-label">Email <span class="required">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required placeholder="email@example.com">
                        </div>
                        <div class="profile-form-group">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" placeholder="0123456789">
                        </div>
                        <div class="profile-form-group">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Shipping address"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                        </div>
                        <div class="profile-edit-actions">
                            <button type="submit" name="update_profile" value="1" class="btn btn-save-profile"><i class="fa-solid fa-check"></i> Save Changes</button>
                            <a href="profile.php" class="btn btn-cancel-profile"><i class="fa-solid fa-arrow-left"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
