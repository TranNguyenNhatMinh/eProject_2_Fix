<?php
// includes/header.php
// $currentSite: 'aquarium'

if (!isset($currentSite)) {
    $currentSite = 'aquarium';
}

// Load auth and functions if not already loaded
if (!function_exists('isLoggedIn')) {
    require_once __DIR__ . '/auth.php';
    require_once __DIR__ . '/functions.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Jenkinson's Aquarium - Discover the wonders of the deep sea">
    <title>Jenkinson's - <?= ucfirst(str_replace('-', ' ', $currentSite)) ?></title>

    <!-- Google Fonts - Professional Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Source+Sans+3:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Component CSS Files -->
    <?php 
    // Set CSS path: use provided $cssPath or determine based on currentSite
    if (!isset($cssPath)) {
        $cssPath = ($currentSite === 'boardwalk' || $currentSite === 'sweet-shop') ? '../' : '';
    }
    
    // Detect if we're in componets directory - use for all paths (logo, links, etc.)
    // If $cssPath is set to '../', we're likely in componets/
    $basePath = ($cssPath === '../' || $currentSite === 'boardwalk' || $currentSite === 'sweet-shop') ? '../' : '';
    ?>
    <!-- Base Styles - Load First -->
    <link rel="stylesheet" href="<?= $cssPath ?>css/variables.css">
    <link rel="stylesheet" href="<?= $cssPath ?>css/reset.css">
    
    <!-- Component Styles -->
    <link rel="stylesheet" href="<?= $cssPath ?>css/header.css">
    <link rel="stylesheet" href="<?= $cssPath ?>css/hero.css">
    <link rel="stylesheet" href="<?= $cssPath ?>css/features.css">
    
    <!-- Page-Specific Styles -->
    <?php if ($currentSite === 'aquarium'): ?>
        <link rel="stylesheet" href="<?= $cssPath ?>css/homepage.css">
    <?php endif; ?>
    
    <?php if ($currentSite === 'sweet-shop'): ?>
        <link rel="stylesheet" href="<?= $cssPath ?>css/sweet-shop.css">
    <?php endif; ?>

    <?php if ($currentSite === 'boardwalk'): ?>
        <link rel="stylesheet" href="<?= $cssPath ?>css/boardwalk.css">
    <?php endif; ?>
    
    <?php if (isset($currentPage) && $currentPage === 'ourmission'): ?>
        <link rel="stylesheet" href="<?= $cssPath ?>css/ourmission.css">
    <?php endif; ?>
    
    <link rel="stylesheet" href="<?= $cssPath ?>css/footer.css">
    
    <!-- Utilities & Responsive - Load Last -->
    <link rel="stylesheet" href="<?= $cssPath ?>css/utilities.css">
    <link rel="stylesheet" href="<?= $cssPath ?>css/responsive.css">
</head>
<body>
    <!-- Header -->
    <header class="main-header site-<?= $currentSite ?>" role="banner">
        <!-- Thin top links bar -->
        <div class="top-links-bar border-bottom">
            <div class="container">
                <div class="top-bar-content d-flex justify-content-end align-items-center gap-3 small flex-wrap py-2">
                    <nav class="d-flex gap-3 me-auto text-uppercase top-links-nav" aria-label="Site navigation">
                        <a href="<?= $basePath ?>componets/boardwalk.php"
                           class="top-link fw-semibold <?= $currentSite === 'boardwalk' ? 'text-boardwalk' : 'text-dark' ?>">
                            Boardwalk
                        </a>
                        <a href="<?= $basePath ?>index.php"
                           class="top-link fw-semibold <?= $currentSite === 'aquarium' ? 'text-aqua' : 'text-dark' ?>">
                            Aquarium
                        </a>
                        <a href="<?= $basePath ?>componets/sweet-shop.php"
                           class="top-link fw-semibold <?= $currentSite === 'sweet-shop' ? 'text-pink' : 'text-dark' ?>">
                            Sweet Shop
                        </a>
                    </nav>

                    
                    <a href="#" 
                       class="top-link text-dark d-flex align-items-center gap-1"
                       aria-label="View hours and schedule">
                        <span class="calendar-icon" aria-hidden="true">
                            <i class="fa-solid fa-calendar-days"></i>
                        </span>
                        <span class="d-none d-sm-inline">VIEW HOURS</span>
                    </a>

                    <div class="d-flex align-items-center gap-2 social-links" role="list">
                        <a href="https://www.facebook.com/JenksBoardwalk/" 
                           class="top-link text-dark"
                           aria-label="Visit our Facebook page"
                           target="_blank"
                           rel="noopener noreferrer"
                           role="listitem">
                            <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
                        </a>
                        <a href="https://www.instagram.com/JenksBoardwalk/" 
                           class="top-link text-dark"
                           aria-label="Visit our Instagram page"
                           target="_blank"
                           rel="noopener noreferrer"
                           role="listitem">
                            <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                        </a>
                        <a href="https://x.com/JenksBoardwalk/" 
                           class="top-link text-dark"
                           aria-label="Visit our Twitter page"
                           target="_blank"
                           rel="noopener noreferrer"
                           role="listitem">
                            <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
                        </a>
                        <a href="https://www.youtube.com/user/JenkinsonsBoardwalk" 
                           class="top-link text-dark"
                           aria-label="Visit our YouTube channel"
                           target="_blank"
                           rel="noopener noreferrer"
                           role="listitem">
                            <i class="fa-brands fa-youtube" aria-hidden="true"></i>
                        </a>
                    </div>

                    <button class="btn btn-link p-0 ms-2 search-btn" 
                            type="button"
                            aria-label="Open search"
                            data-bs-toggle="modal"
                            data-bs-target="#searchModal">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    </button>

                    <!-- Cart & Auth Links -->
                    <a href="<?= $basePath ?>cart.php" 
                       class="top-link text-dark d-flex align-items-center gap-1 ms-2"
                       aria-label="Shopping cart">
                        <i class="fa-solid fa-shopping-cart" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline">Cart</span>
                        <?php if (getCartCount() > 0): ?>
                            <span class="badge bg-danger rounded-pill"><?php echo getCartCount(); ?></span>
                        <?php endif; ?>
                    </a>

                    <!-- User Account Section -->
                    <?php if (isLoggedIn()): ?>
                        <?php $user = getCurrentUser(); ?>
                        <div class="user-account-dropdown dropdown-hover ms-2">
                            <a href="#" class="user-account-toggle">
                                <div class="user-avatar-wrapper">
                                    <div class="user-avatar">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <?php if (isAdmin()): ?>
                                        <span class="admin-badge-small">
                                            <i class="fa-solid fa-shield-halved"></i>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <span class="user-name-text d-none d-md-inline"><?php echo htmlspecialchars($user['username']); ?></span>
                                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
                            </a>
                            <div class="dropdown-menu user-dropdown-menu">
                                <!-- User Info Header -->
                                <div class="user-dropdown-header">
                                    <div class="user-header-avatar">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div class="user-header-info">
                                        <div class="user-header-name"><?php echo htmlspecialchars($user['username']); ?></div>
                                        <div class="user-header-email"><?php echo htmlspecialchars($user['email'] ?? 'user@example.com'); ?></div>
                                        <?php if (isAdmin()): ?>
                                            <span class="user-header-badge">Administrator</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="dropdown-divider"></div>
                                
                                <!-- Menu Items -->
                                <a href="<?= $basePath ?>my_orders.php" class="dropdown-item">
                                    <i class="fa-solid fa-box item-icon"></i>
                                    <span class="item-text">My Orders</span>
                                </a>
                                
                                <a href="<?= $basePath ?>cart.php" class="dropdown-item">
                                    <i class="fa-solid fa-shopping-cart item-icon"></i>
                                    <span class="item-text">Cart <span class="item-badge"><?php echo getCartCount(); ?></span></span>
                                </a>
                                
                                <?php if (isAdmin()): ?>
                                    <div class="dropdown-divider"></div>
                                    <a href="<?= $basePath ?>admin/index.php" class="dropdown-item admin-item">
                                        <i class="fa-solid fa-gear item-icon"></i>
                                        <span class="item-text">Admin Panel</span>
                                    </a>
                                <?php endif; ?>
                                
                                <div class="dropdown-divider"></div>
                                
                                <a href="<?= $basePath ?>logout.php" class="dropdown-item logout-item">
                                    <i class="fa-solid fa-right-from-bracket item-icon"></i>
                                    <span class="item-text">Sign Out</span>
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= $basePath ?>login.php" class="login-link ms-2">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            <span class="d-none d-sm-inline">Login</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Logo + main menu (second row) -->
        <div class="main-header-content">
            <div class="container">
                <div class="header-main-row d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3 py-3">
                    <div class="logo-section d-flex align-items-center">
                        <?php 
                        if ($currentSite === 'aquarium'): ?>
                            <a href="<?= $basePath ?>index.php" class="aquarium-logo-wrapper text-decoration-none" aria-label="Jenkinson's Aquarium Home">
                                <img src="<?= $basePath ?>img/aquarium-logo-768x318.png"
                                     alt="Jenkinson's Aquarium"
                                     class="img-fluid aquarium-logo-img"
                                     loading="eager">
                            </a>
                        <?php elseif ($currentSite === 'sweet-shop'): ?>
                            <a href="<?= $basePath ?>componets/sweet-shop.php" class="aquarium-logo-wrapper text-decoration-none" aria-label="Jenkinson's Sweet Shop Home">
                                <img src="<?= $basePath ?>img/sweetshop.png"
                                     alt="Jenkinson's Sweet Shop"
                                     class="img-fluid aquarium-logo-img"
                                     loading="eager"
                                     onerror="this.src='<?= $basePath ?>img/aquarium-logo-768x318.png'">
                            </a>
                        <?php else: ?>
                            <a href="<?= $basePath ?>componets/boardwalk.php" class="aquarium-logo-wrapper text-decoration-none" aria-label="Jenkinson's Boardwalk Home">
                                <img src="<?= $basePath ?>img/boardwalk.png"
                                     alt="Jenkinson's Boardwalk"
                                     class="img-fluid aquarium-logo-img"
                                     loading="eager"
                                     onerror="this.src='<?= $basePath ?>img/aquarium-logo-768x318.png'">
                            </a>
                        <?php endif; ?>
                    </div>

                    <nav class="main-navigation" aria-label="Main navigation">
                        <button class="navbar-toggler d-lg-none" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#mainMenuCollapse"
                                aria-controls="mainMenuCollapse"
                                aria-expanded="false"
                                aria-label="Toggle navigation menu">
                            <span class="navbar-toggler-icon">
                                <i class="fa-solid fa-bars"></i>
                            </span>
                        </button>
                        
                        <div class="collapse navbar-collapse" id="mainMenuCollapse">
                            <ul class="nav main-menu text-uppercase fw-semibold small flex-wrap" role="menubar">
                                <?php if ($currentSite === 'sweet-shop'): ?>
                                    <!-- Sweet Shop Menu -->
                                    <li class="nav-item" role="none">
                                        <a href="#" class="nav-link px-3 text-dark" role="menuitem">Online Store</a>
                                    </li>
                                    <li class="nav-item" role="none">
                                        <a href="#" class="nav-link px-3 text-dark" role="menuitem">Seasonal Sweets &amp; Treats</a>
                                    </li>
                                    <li class="nav-item" role="none">
                                        <a href="#" class="nav-link px-3 text-dark" role="menuitem">Weddings &amp; Custom Favors</a>
                                    </li>
                                <?php elseif ($currentSite === 'boardwalk'): ?>
                                    <!-- Boardwalk Menu -->
                                    <li class="nav-item" role="none">
                                        <a href="#" class="nav-link px-3 text-dark" role="menuitem">Explore</a>
                                    </li>
                                    <li class="nav-item" role="none">
                                        <a href="#" class="nav-link px-3 text-dark" role="menuitem">Events</a>
                                    </li>
                                    <li class="nav-item" role="none">
                                        <a href="#" class="nav-link px-3 text-dark" role="menuitem">Groups &amp; Parties</a>
                                    </li>
                                    <li class="nav-item" role="none">
                                        <a href="#" class="nav-link px-3 text-dark" role="menuitem">Plan Your Visit</a>
                                    </li>
                                    <li class="nav-item" role="none">
                                        <a href="#" class="nav-link px-3 text-dark" role="menuitem">Shop</a>
                                    </li>
                                    <li class="nav-item" role="none">
                                        <a href="#" class="nav-link px-3 text-dark" role="menuitem">Join Our Team</a>
                                    </li>
                                <?php else: ?>
                                    <!-- Aquarium Menu -->
                                    <li class="nav-item dropdown-hover" role="none">
                                        <a href="#" 
                                           class="nav-link px-3 text-dark" 
                                           role="menuitem"
                                           aria-haspopup="true"
                                           aria-expanded="false">
                                            <span>Visit</span>
                                            <span class="menu-caret" aria-hidden="true">▼</span>
                                        </a>
                                    <ul class="dropdown-menu visit-mega-menu">
                                        <li><a class="dropdown-item" href="#">HOURS & ADMISSION</a></li>
                                        <li><a class="dropdown-item" href="#">UPCOMING EVENTS</a></li>
                                        <li><a class="dropdown-item" href="#">EXPERIENCES</a></li>
                                        <li><a class="dropdown-item" href="#">PROMOTIONS</a></li>
                                        <li class="dropdown-submenu">
                                            <a class="dropdown-item" href="#">JOIN OUR TEAM <i class="fa-solid fa-chevron-right join-team-arrow"></i></a>
                                            <ul class="dropdown-menu submenu">
                                                <li><a class="dropdown-item" href="#">INTERNSHIPS</a></li>
                                                <li><a class="dropdown-item" href="#">EMPLOYMENT</a></li>
                                                <li><a class="dropdown-item" href="#">VOLUNTEER</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="dropdown-item" href="<?= $basePath ?>componets/ourmission.php">OUR MISSION</a></li>
                                        <li><a class="dropdown-item" href="#">OUR PARTNERS</a></li>
                                        <li><a class="dropdown-item" href="#">SELF GUIDED TOUR</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item" role="none">
                                    <a href="#" 
                                       class="nav-link px-3 text-dark"
                                       role="menuitem">
                                        <i class="fa-solid fa-video me-1" aria-hidden="true"></i>
                                        <span>Penguin Cam</span>
                                    </a>
                                </li>
                                <li class="nav-item dropdown-hover" role="none">
                                    <a href="#" 
                                       class="nav-link px-3 text-dark" 
                                       role="menuitem"
                                       aria-haspopup="true"
                                       aria-expanded="false">
                                        <span>Groups &amp; Education</span>
                                        <span class="menu-caret" aria-hidden="true">▼</span>
                                    </a>
                                    <ul class="dropdown-menu visit-mega-menu">
                                        <li><a class="dropdown-item" href="#">EXPERIENCES</a></li>
                                        <li class="dropdown-submenu">
                                            <a class="dropdown-item" href="#">GROUPS <i class="fa-solid fa-chevron-right join-team-arrow"></i></a>
                                            <ul class="dropdown-menu submenu">
                                                <li><a class="dropdown-item" href="#">GROUP RATES</a></li>
                                                <li><a class="dropdown-item" href="#">TEACHER TIPS (CHECKING IN &amp; PARKING)</a></li>
                                                <li><a class="dropdown-item" href="#">PRE &amp; POST VISIT ACTIVITIES</a></li>
                                                <li><a class="dropdown-item" href="#">OUTREACH &amp; FOCUS PROGRAMS</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="dropdown-item" href="#">OUTREACH &amp; FOCUS PROGRAMS</a></li>
                                        <li><a class="dropdown-item" href="#">VIRTUAL PROGRAMS</a></li>
                                        <li><a class="dropdown-item" href="#">SUMMER CAMPS</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown-hover" role="none">
                                    <a href="#" 
                                       class="nav-link px-3 text-dark"
                                       role="menuitem"
                                       aria-haspopup="true"
                                       aria-expanded="false">
                                        <span>Adoption, Encounters &amp; Programs</span>
                                        <span class="menu-caret" aria-hidden="true">▼</span>
                                    </a>
                                    <ul class="dropdown-menu visit-mega-menu">
                                        <li><a class="dropdown-item" href="#">ADOPT-AN-ANIMAL</a></li>
                                        <li><a class="dropdown-item" href="#">ANIMAL ENCOUNTERS</a></li>
                                        <li><a class="dropdown-item" href="#">ANIMAL PROGRAMS</a></li>
                                        <li><a class="dropdown-item" href="#">PROMOTIONS</a></li>
                                        <li><a class="dropdown-item" href="#">UPCOMING EVENTS</a></li>
                                    </ul>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>