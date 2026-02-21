<?php
$currentSite = 'boardwalk';
$currentPage = 'fun-games';
include __DIR__ . '/../includes/header.php';
?>

<main class="flex-grow-1 page-fun-games">
    <div class="fun-games-container">
        <!-- Hero Banner -->
        <section class="fun-games-hero-banner">
            <div class="fun-games-hero-image">
                <img src="../img/body2/b7.jpg" alt="Fun & Games - Jenkinson's Boardwalk">
                <div class="fun-games-hero-overlay"></div>
            </div>
            <div class="fun-games-hero-content">
                <h1 class="fun-games-hero-title">FUN & GAMES</h1>
            </div>
        </section>

        <div class="container">
            <!-- Intro Section -->
            <section class="fun-games-intro">
                <h2 class="fun-games-intro-heading">Fun and Games</h2>
                <p class="fun-games-intro-text">
                    Experience all of the fun that Jenkinson's Boardwalk has to offer!
                </p>
            </section>

            <!-- Hero Image Section -->
            <section class="fun-games-hero-image-section">
                <img src="../img/boardwalk/fun-games-hero.jpg" alt="Fun & Games at Jenkinson's Boardwalk" class="fun-games-main-image" onerror="this.src='https://images.unsplash.com/photo-1511882150382-421056c89033?w=1200&q=80'">
            </section>

            <!-- Three Column Activities -->
            <section class="fun-games-activities">
                <div class="row g-4">
                    <!-- Fun House -->
                    <div class="col-md-4">
                        <article class="fun-games-activity-card">
                            <div class="fun-games-activity-image">
                                <img src="../img/boardwalk/fun-house.jpg" alt="Fun House" onerror="this.src='https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80'">
                            </div>
                            <div class="fun-games-activity-content">
                                <h3 class="fun-games-activity-title">FUN HOUSE</h3>
                                <p class="fun-games-activity-desc">
                                    Find your way through a maze of mirrors, glowing lights, tunnels and turns. You'll be laughing, falling and absolutely amazed!
                                </p>
                            </div>
                        </article>
                    </div>

                    <!-- Batting Cages -->
                    <div class="col-md-4">
                        <article class="fun-games-activity-card">
                            <div class="fun-games-activity-image">
                                <img src="../img/boardwalk/batting-cages.jpg" alt="Batting Cages" onerror="this.src='https://images.unsplash.com/photo-1566577739112-5180d4bf9390?w=600&q=80'">
                            </div>
                            <div class="fun-games-activity-content">
                                <h3 class="fun-games-activity-title">BATTING CAGES</h3>
                                <p class="fun-games-activity-desc">
                                    Come practice your swing in our batting cages. Watch out for those fast balls!
                                </p>
                            </div>
                        </article>
                    </div>

                    <!-- Boardwalk Games -->
                    <div class="col-md-4">
                        <article class="fun-games-activity-card">
                            <div class="fun-games-activity-image">
                                <img src="../img/boardwalk/boardwalk-games.jpg" alt="Boardwalk Games" onerror="this.src='https://images.unsplash.com/photo-1511882150382-421056c89033?w=600&q=80'">
                            </div>
                            <div class="fun-games-activity-content">
                                <h3 class="fun-games-activity-title">BOARDWALK GAMES</h3>
                                <p class="fun-games-activity-desc">
                                    Everyone loves to play their favorite boardwalk games—basketball shoot, water races, whac-a-mole, ring toss, big loop toss and a few surprises!
                                </p>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
