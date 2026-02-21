<?php
$currentSite = 'boardwalk';
$currentPage = 'adventure-lookout';
include __DIR__ . '/../includes/header.php';
?>

<main class="flex-grow-1">
    <div class="adventure-lookout-container">
        <!-- Header Banner -->
        <section class="adventure-header-banner">
            <div class="adventure-header-image">
                <img src="../img/body2/b1.jpg" alt="Adventure Lookout Ropes Course">
                <div class="adventure-header-overlay"></div>
            </div>
            <div class="adventure-header-content">
                <h1 class="adventure-header-title">ADVENTURE LOOKOUT ROPES COURSE</h1>
            </div>
        </section>

        <div class="container">
            <!-- Seasonal Closure Notice -->
            <div class="adventure-closure-notice">
                <h2 class="closure-title">CLOSED FOR THE SEASON - SEE YOU IN 2026</h2>
                <p class="closure-subtitle">LAST DAY OF ROPES COURSE OPERATION WILL BE ON 10/17. FOLLOWING 10/17 – THE ROPES COURSE WILL BE CLOSED FOR THE REMAINDER OF THE YEAR.</p>
            </div>

            <!-- Image Gallery Strip -->
            <div class="adventure-gallery-strip">
                <div class="gallery-images">
                    <div class="gallery-item">
                        <img src="../img/body2/b1.jpg" alt="Ropes Course Activity 1">
                    </div>
                    <div class="gallery-item">
                        <img src="../img/body2/b2.jpg" alt="Ropes Course Activity 2">
                    </div>
                    <div class="gallery-item">
                        <img src="../img/body2/b3.jpg" alt="Ropes Course Activity 3">
                    </div>
                    <div class="gallery-item">
                        <img src="../img/body2/b4.jpg" alt="Ropes Course Activity 4">
                    </div>
                </div>
            </div>

            <!-- Your Adventure Awaits Section -->
            <section class="adventure-content-section">
                <h2 class="adventure-section-title">YOUR ADVENTURE AWAITS!</h2>
                <p class="adventure-intro-text">
                    Experience the thrill of adventure at Jenkinson's Boardwalk! Our Discovery SkyTrail and Adventure Lookout Ropes Course are part of our exciting Amusement Park attractions. Whether you're seeking high-flying challenges or family-friendly fun, we have the perfect adventure for you.
                </p>
            </section>

            <!-- Two Types of Adventures -->
            <section class="adventure-types-section">
                <h2 class="adventure-section-title">THERE ARE TWO DIFFERENT TYPES OF ADVENTURES:</h2>
                
                <div class="adventure-types-grid">
                    <div class="adventure-type-card">
                        <h3 class="adventure-type-title">Discovery SkyTrail</h3>
                        <p class="adventure-type-description">
                            Soar to new heights on our Discovery SkyTrail! This incredible ropes course stands 50 feet high and features 50 challenging elements, making it one of the largest ropes courses in the country. Test your balance, strength, and courage as you navigate through various obstacles high above the ground.
                        </p>
                        <div class="adventure-type-details">
                            <p><strong>Height:</strong> 50 feet</p>
                            <p><strong>Elements:</strong> 50</p>
                            <p><strong>Minimum Height Requirement:</strong> 48 inches (4 feet) to participate unassisted</p>
                        </div>
                    </div>

                    <div class="adventure-type-card">
                        <h3 class="adventure-type-title">Adventure Lookout Ropes Course</h3>
                        <p class="adventure-type-description">
                            Perfect for younger adventurers! Our Adventure Lookout Ropes Course offers an exciting 20-foot-high challenge with 20 fun elements. This course is designed specifically for families and provides a safe yet thrilling experience for children and adults alike.
                        </p>
                        <div class="adventure-type-details">
                            <p><strong>Height:</strong> 20 feet</p>
                            <p><strong>Elements:</strong> 20</p>
                            <p><strong>Minimum Height Requirement:</strong> 48 inches (4 feet) to participate unassisted</p>
                            <p><strong>Note:</strong> Parental supervision required for children under 48 inches</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Course Rules Section -->
            <section class="adventure-rules-section">
                <h2 class="adventure-section-title">COURSE RULES</h2>
                <div class="rules-container">
                    <ul class="rules-list">
                        <li>Maximum participant weight: 300 lbs.</li>
                        <li>Participants must wear appropriate attire. T-shirt and shorts/closed-toe shoes are mandatory.</li>
                        <li>No open-toed shoes, flip-flops, or sandals are permitted.</li>
                        <li>Pockets must be empty.</li>
                        <li>No food, gum, drinks, or smoking are permitted on the course.</li>
                        <li>Only one participant per element at a time.</li>
                        <li>No running, jumping, hanging, or horseplay.</li>
                        <li>Guests must sign a waiver.</li>
                        <li>Do not climb the ropes course while impaired.</li>
                        <li>Do not tamper with your harness or safety line.</li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
