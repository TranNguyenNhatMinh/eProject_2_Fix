<?php
$currentSite = 'boardwalk';
$currentPage = 'mini-golf';
include __DIR__ . '/../includes/header.php';
?>
<main class="mini-golf-page">
    <!-- Hero Section -->
    <div class="mini-golf-hero-wrap">
        <div class="mini-golf-hero-image">
            <img src="../img/boardwalk/mini-golf-hero.jpg" alt="Jenkinson's Miniature Golf" onerror="this.src='https://images.unsplash.com/photo-1535131749006-b7f58c99034b?w=1920&q=80'">
        </div>
        <div class="mini-golf-hero-overlay"></div>
        <div class="container">
            <div class="mini-golf-hero-content">
                <h1 class="mini-golf-hero-title">JENKINSON'S MINIATURE GOLF</h1>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="mini-golf-content-section">
        <div class="container">
            <div class="mini-golf-grid">
                <!-- Lighthouse Point Mini Golf -->
                <div class="mini-golf-card">
                    <div class="mini-golf-card-image">
                        <img src="../img/boardwalk/lighthouse-point.jpg" alt="Lighthouse Point Mini Golf" onerror="this.src='https://images.unsplash.com/photo-1535131749006-b7f58c99034b?w=800&q=80'">
                    </div>
                    <div class="mini-golf-card-content">
                        <h2 class="mini-golf-card-title">LIGHTHOUSE POINT MINI GOLF</h2>
                        <div class="mini-golf-card-text">
                            <p><strong>HOURS OF OPERATION</strong> - Lighthouse Point follows the hours of the Amusement Park.</p>
                            <p class="mini-golf-note">*Weather permitting</p>
                            <p>Located at the southern most end of Jenkinson's Boardwalk, Lighthouse Point Miniature Golf Course features two state-of-the-art 18-hole courses complete with hazards and a replica lighthouse.</p>
                        </div>
                    </div>
                </div>

                <!-- Castaway Cove Mini Golf -->
                <div class="mini-golf-card">
                    <div class="mini-golf-card-image">
                        <img src="../img/boardwalk/castaway-cove.jpg" alt="Castaway Cove Mini Golf" onerror="this.src='https://images.unsplash.com/photo-1535131749006-b7f58c99034b?w=800&q=80'">
                    </div>
                    <div class="mini-golf-card-content">
                        <h2 class="mini-golf-card-title">CASTAWAY COVE MINI GOLF</h2>
                        <div class="mini-golf-card-text">
                            <p>Explore Castaway Cove where the Wheeler family became shipwrecked and used remains from the ship to design two unique adventures. Choose from the shipwreck bay course which takes you through caves, and past thunderous waterfalls, or head to the Crow's nest, which travels to the top of the cove with amazing aerial views of waterfalls and plant life.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
