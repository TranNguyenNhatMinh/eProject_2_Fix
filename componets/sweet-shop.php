<?php
$currentSite = 'sweet-shop';
require_once __DIR__ . '/../includes/functions.php';
include '../includes/header.php';

// Sweet Shop category_id = 3
$sweet_products = getProductsByCategory(3);
?>

<!-- Hero Section - cùng format bên xanh (tagline, title 2 dòng, nút CTA) -->
<section class="sweetshop-hero-banner">
    <div class="sweetshop-hero-image">
        <img src="../img/mainimg/cc.webp" alt="Jenkinson's Sweet Shop">
        <div class="sweetshop-hero-overlay"></div>
    </div>
    <div class="container">
        <div class="sweetshop-hero-content">
            <div class="sweetshop-hero-subtitle">
                <span class="sweetshop-subtitle-text">THE BEST SWEET SHOP EXPERIENCE</span>
                <div class="sweetshop-subtitle-underline"></div>
            </div>
            <h1 class="sweetshop-hero-title">WELCOME TO<br>JENKINSON'S <span class="sweetshop-hero-accent">SWEET SHOP</span></h1>
            <a href="sweet-shop-order.php" class="sweetshop-btn sweetshop-btn-cta">Add to cart</a>
        </div>
    </div>
</section>

<!-- Intro Section -->
<section class="sweetshop-intro">
    <div class="container">
        <div class="sweetshop-intro-inner">
            <h2 class="sweetshop-intro-title">Looking to satisfy that sweet tooth?</h2>
            <div class="sweetshop-intro-underline" aria-hidden="true"></div>
            <p class="sweetshop-intro-text">Look no further. We offer a wide variety of tempting treats, salt water taffy, homemade fudge, and more. Jenkinson's Sweet Shop is open year round with gift baskets for all occasions and online shopping available.</p>
        </div>
    </div>
</section>

<!-- Product Grid -->
<section class="sweetshop-products" id="sweetshop-products">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($sweet_products as $p):
                $price = !empty($p['sale_price']) ? $p['sale_price'] : $p['price'];
                $imgSrc = !empty($p['image']) ? '../' . htmlspecialchars($p['image']) : '../img/sweetshop/p1.jpg';
            ?>
            <div class="col-md-6 col-lg-4">
                <div class="sweetshop-card">
                    <div class="sweetshop-card-img-wrap">
                        <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($p['product_name']) ?>" class="sweetshop-card-img">
                    </div>
                    <div class="sweetshop-card-info">
                        <h3 class="sweetshop-card-title"><?= htmlspecialchars($p['product_name']) ?></h3>
                        <p class="sweetshop-card-price"><?= formatCurrency($price) ?></p>
                    </div>
                    <a href="product-detail.php?id=<?= $p['product_id'] ?>" class="sweetshop-btn sweetshop-btn-card d-inline-block text-center text-decoration-none">Add to cart</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>

