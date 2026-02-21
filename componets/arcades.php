<?php
$currentSite = 'boardwalk';
$currentPage = 'arcades';
include __DIR__ . '/../includes/header.php';
?>

<main class="flex-grow-1 page-arcades">
    <div class="arcades-container">
        <!-- Hero Banner -->
        <section class="arcades-hero-banner">
            <div class="arcades-hero-image">
                <img src="../img/body2/b4.jpg" alt="Jenkinson's Arcades - Games and Fun">
                <div class="arcades-hero-overlay"></div>
            </div>
            <div class="arcades-hero-content">
                <h1 class="arcades-hero-title">ARCADES</h1>
            </div>
        </section>

        <div class="container">
            <!-- Intro Text -->
            <section class="arcades-intro">
                <p class="arcades-intro-text">
                    A trip to the boardwalk, a rainy-day, or a milestone celebration is a great excuse for a fun-filled arcade visit. Filled with classic video games, tin-can alley games, Skee-Ball, Basketball, pinball, prizes and so much more—all of the arcades at Jenkinson's will bring everyone in the family (or the family of friends) together for hours of fun.
                </p>
            </section>

            <!-- Arcade Listings -->
            <section class="arcades-list">
                <!-- Jenkinson's South Arcade -->
                <article class="arcade-block">
                    <div class="arcade-block-image">
                        <img src="../img/boardwalk/ac1.jpg" alt="Jenkinson's South Arcade interior">
                    </div>
                    <div class="arcade-block-content">
                        <h2 class="arcade-block-title">JENKINSON'S SOUTH ARCADE</h2>
                        <p class="arcade-block-desc">Experience the best of both worlds at the South Arcade!</p>
                        <p class="arcade-block-times"><strong>Opening Times:</strong> Daily 11:00 AM</p>
                        <p class="arcade-block-note">Hall Passes/Special Game Play tickets are valid at this location.</p>
                        <a href="#" class="arcade-btn">VIEW ON THE MAP</a>
                    </div>
                </article>

                <!-- Jenkinson's Pavilion Arcade -->
                <article class="arcade-block">
                    <div class="arcade-block-image">
                        <img src="../img/boardwalk/ac2.jpg" alt="Jenkinson's Pavilion Arcade - Games">
                    </div>
                    <div class="arcade-block-content">
                        <h2 class="arcade-block-title">JENKINSON'S PAVILION ARCADE</h2>
                        <p class="arcade-block-desc">Experience the best of both worlds at the Pavilion Arcade!</p>
                        <p class="arcade-block-times"><strong>Opening Times:</strong> Weekdays 11:00 AM - 10:00 PM; Weekends through Friday 11:00 AM - 12:00 AM</p>
                        <p class="arcade-block-note">Hall Passes/Special Game Play tickets are valid at this location.</p>
                        <a href="#" class="arcade-btn">VIEW ON THE MAP</a>
                    </div>
                </article>

                <!-- Frank's Fun Center -->
                <article class="arcade-block">
                    <div class="arcade-block-image">
                        <img src="../img/boardwalk/ac3.jpg" alt="Frank's Fun Center">
                    </div>
                    <div class="arcade-block-content">
                        <h2 class="arcade-block-title">FRANK'S FUN CENTER</h2>
                        <p class="arcade-block-desc">Experience the best of both worlds at the Fun Center!</p>
                        <p class="arcade-block-times"><strong>Opening Times:</strong> Weekdays 11:00 AM - 10:00 PM; Weekends through Friday 11:00 AM - 12:00 AM</p>
                        <p class="arcade-block-note">Hall Passes/Special Game Play tickets are valid at this location.</p>
                        <a href="#" class="arcade-btn">VIEW ON THE MAP</a>
                    </div>
                </article>

                <!-- South Beach Arcade -->
                <article class="arcade-block">
                    <div class="arcade-block-image">
                        <img src="../img/boardwalk/ac4.jpg" alt="South Beach Arcade">
                    </div>
                    <div class="arcade-block-content">
                        <h2 class="arcade-block-title">SOUTH BEACH ARCADE</h2>
                        <p class="arcade-block-desc">Experience the best of both worlds at the South Beach Arcade!</p>
                        <p class="arcade-block-times"><strong>Opening Times:</strong> Weekdays 11:00 AM - 10:00 PM; Weekends through Friday 11:00 AM - 12:00 AM</p>
                        <p class="arcade-block-note">Hall Passes/Special Game Play tickets are valid at this location.</p>
                        <a href="#" class="arcade-btn">VIEW ON THE MAP</a>
                    </div>
                </article>
            </section>

            <!-- Closing Times Note -->
            <div class="arcades-closing-note">
                <p class="arcades-closing-text">ALL CLOSING TIMES ARE SUBJECT TO CHANGE DUE TO CUSTOMER ATTENDANCE</p>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
