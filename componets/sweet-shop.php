<?php
$currentSite = 'sweet-shop';
include '../includes/header.php';
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
            <a href="#" class="sweetshop-btn sweetshop-btn-cta">Shop Our Store</a>
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
<section class="sweetshop-products">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="sweetshop-card">
                    <div class="sweetshop-card-img-wrap">
                        <img src="../img/sweetshop/p1.jpg" alt="Apples" class="sweetshop-card-img">
                    </div>
                    <h3 class="sweetshop-card-title">Apples</h3>
                    <p class="sweetshop-card-price">$6.00 – $11.00</p>
                    <button type="button" class="sweetshop-btn sweetshop-btn-card">Select options</button>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="sweetshop-card">
                    <div class="sweetshop-card-img-wrap">
                        <img src="../img/sweetshop/p2.jpg" alt="Souvenir Salt Water Taffy" class="sweetshop-card-img">
                    </div>
                    <h3 class="sweetshop-card-title">Souvenir Salt Water Taffy</h3>
                    <p class="sweetshop-card-price">$14.99</p>
                    <button type="button" class="sweetshop-btn sweetshop-btn-card">Add to cart</button>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="sweetshop-card">
                    <div class="sweetshop-card-img-wrap">
                        <img src="../img/sweetshop/p3.jpg" alt="Assortment of Fudges" class="sweetshop-card-img">
                    </div>
                    <h3 class="sweetshop-card-title">Assortment of Fudges</h3>
                    <p class="sweetshop-card-price">$7.50 – $18.99</p>
                    <button type="button" class="sweetshop-btn sweetshop-btn-card">Select options</button>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="sweetshop-card">
                    <div class="sweetshop-card-img-wrap">
                        <img src="../img/sweetshop/p4.jpg" alt="Sweet Shop Sampler Chocolate Box" class="sweetshop-card-img">
                    </div>
                    <h3 class="sweetshop-card-title">Sweet Shop Sampler Chocolate Box</h3>
                    <p class="sweetshop-card-price">$25.50 – $49.95</p>
                    <button type="button" class="sweetshop-btn sweetshop-btn-card">Select options</button>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="sweetshop-card">
                    <div class="sweetshop-card-img-wrap">
                        <img src="../img/sweetshop/p5.jpg" alt="Salt Water Taffy" class="sweetshop-card-img">
                    </div>
                    <h3 class="sweetshop-card-title">Salt Water Taffy</h3>
                    <p class="sweetshop-card-price">$8.25 – $29.99</p>
                    <button type="button" class="sweetshop-btn sweetshop-btn-card">Select options</button>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="sweetshop-card">
                    <div class="sweetshop-card-img-wrap">
                        <img src="../img/sweetshop/p6.avif" alt="More treats" class="sweetshop-card-img">
                    </div>
                    <h3 class="sweetshop-card-title">Gift Baskets</h3>
                    <p class="sweetshop-card-price">From $19.99</p>
                    <button type="button" class="sweetshop-btn sweetshop-btn-card">Select options</button>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>

