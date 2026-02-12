<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $debug_mode = isset($_GET['debug']);
    if ($debug_mode) {
        echo "<pre>POST data: "; print_r($_POST); echo "</pre>";
    }

    $username = sanitize($_POST['username'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $full_name = sanitize($_POST['full_name'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');

    if (empty($username) || empty($email) || empty($password)) {
        $error = 'Please fill in all required fields';
    } elseif ($password !== $confirm_password) {
        $error = 'Password confirmation does not match';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address';
    } else {
        $result = register($username, $email, $password, $full_name, $phone);
        if ($result['success']) {
            if (!isset($_GET['test'])) {
                header('Location: index.php');
                exit();
            }
            $success = 'Registration successful! (Test mode - no redirect)';
        } else {
            if (strpos($result['message'], 'already exists') !== false) {
                $error = 'Username or email already exists';
            } else {
                $error = 'Registration failed. Please try again.';
            }
            error_log("Registration error: " . $result['message']);
            if ($debug_mode) {
                $error .= "<br><small style='color: #666;'>Debug: " . htmlspecialchars($result['message']) . "</small>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Jenkinson's Aquarium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="css/variables.css">
    <link rel="stylesheet" href="css/auth.css">
</head>
<body class="auth-page">
    <?php include 'includes/header.php'; ?>

    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-12 d-flex justify-content-center">
                    <div class="auth-bar">
                        <div class="auth-bar-left">
                            <div class="auth-bar-left-content">
                                <h2>Join Us</h2>
                                <div class="subtitle">Create your account and dive into amazing experiences</div>
                                <div class="aquarium-features">
                                    <div class="feature-item">
                                        <i class="fa-solid fa-star"></i>
                                        <span>Free Account</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fa-solid fa-percent"></i>
                                        <span>Special Discounts</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fa-solid fa-bell"></i>
                                        <span>Event Notifications</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fa-solid fa-heart"></i>
                                        <span>Unique Experiences</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="auth-bar-right">
                            <h3><i class="fa-solid fa-user-plus"></i> Create New Account</h3>
                            <div class="subtitle-small">Fill in your information to get started</div>

                            <?php if ($error): ?>
                                <div class="alert alert-danger">
                                    <i class="fa-solid fa-exclamation-circle"></i>
                                    <div><strong>Error:</strong> <?php echo $error; ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if ($success): ?>
                                <div class="alert alert-success">
                                    <i class="fa-solid fa-check-circle"></i>
                                    <div><?php echo htmlspecialchars($success); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($_GET['test'])): ?>
                                <div class="alert alert-info">
                                    <i class="fa-solid fa-info-circle"></i>
                                    <div><strong>Test mode:</strong> Form will submit but not redirect.</div>
                                </div>
                            <?php endif; ?>

                            <form method="POST" action="" id="registerForm" class="auth-form">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="username" class="form-label"><i class="fa-solid fa-user"></i> Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="email" class="form-label"><i class="fa-solid fa-envelope"></i> Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="your@email.com" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="password" class="form-label"><i class="fa-solid fa-lock"></i> Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Minimum 6 characters" required minlength="6">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="confirm_password" class="form-label"><i class="fa-solid fa-lock"></i> Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-enter your password" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="full_name" class="form-label"><i class="fa-solid fa-id-card"></i> Full Name</label>
                                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter your full name">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="phone" class="form-label"><i class="fa-solid fa-phone"></i> Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="(123) 456-7890">
                                    </div>
                                </div>
                                <button type="submit" name="register" class="auth-btn"><i class="fa-solid fa-user-plus me-2"></i>Create Account</button>
                            </form>

                            <div class="auth-footer">
                                <p class="mb-0">Already have an account? <a href="login.php" class="auth-link">Sign In</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
