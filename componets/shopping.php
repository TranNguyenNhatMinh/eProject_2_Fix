<?php
$currentSite = 'boardwalk';
$currentPage = 'shopping';
include __DIR__ . '/../includes/header.php';
?>

<main class="flex-grow-1 page-shopping">
    <div class="shopping-container">
        <!-- Hero Banner -->
        <section class="shopping-hero-banner">
            <div class="shopping-hero-image">
                <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1920&q=95&auto=format&fit=crop" alt="Shopping - Jenkinson's Boardwalk" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1920&q=80'">
                <div class="shopping-hero-overlay"></div>
            </div>
            <div class="shopping-hero-content">
                <h1 class="shopping-hero-title">SHOPPING</h1>
            </div>
        </section>

        <div class="container">
            <!-- Intro Section -->
            <section class="shopping-intro">
                <h2 class="shopping-intro-heading">Shopping at Jenkinson's</h2>
                <p class="shopping-intro-text">
                    Discover unique gifts, souvenirs, and treats. Choose your shopping destination below.
                </p>
            </section>

            <!-- Two Column Shopping Links -->
            <section class="shopping-links">
                <div class="row g-4">
                    <!-- Aquarium Shop -->
                    <div class="col-md-6">
                        <a href="../index.php" class="shopping-link-card shopping-card-aquarium">
                            <div class="shopping-link-image">
                                <img src="../img/body2/b3.jpg" alt="Aquarium Shop" onerror="this.src='https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800&q=80'">
                                <div class="shopping-link-overlay"></div>
                            </div>
                            <div class="shopping-link-content">
                                <div class="shopping-link-header">
                                    <div class="shopping-link-icon">
                                        <i class="bi bi-water"></i>
                                    </div>
                                    <h3 class="shopping-link-title">Aquarium Shop</h3>
                                </div>
                                <p class="shopping-link-description">
                                    Explore marine-themed gifts, souvenirs, and educational items from the aquarium.
                                </p>
                                <span class="shopping-link-cta">
                                    Shop Now <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                    </div>

                    <!-- Sweet Shop -->
                    <div class="col-md-6">
                        <a href="sweet-shop.php" class="shopping-link-card shopping-card-sweet">
                            <div class="shopping-link-image">
                                <img src="../img/mainimg/cc.webp" alt="Sweet Shop" onerror="this.src='https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=800&q=80'">
                                <div class="shopping-link-overlay"></div>
                            </div>
                            <div class="shopping-link-content">
                                <div class="shopping-link-header">
                                    <div class="shopping-link-icon">
                                        <i class="bi bi-heart-fill"></i>
                                    </div>
                                    <h3 class="shopping-link-title">Sweet Shop</h3>
                                </div>
                                <p class="shopping-link-description">
                                    Indulge in delicious treats, salt water taffy, homemade fudge, and gift baskets.
                                </p>
                                <span class="shopping-link-cta">
                                    Shop Now <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
