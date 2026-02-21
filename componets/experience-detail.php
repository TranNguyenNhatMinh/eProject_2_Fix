<?php
$currentSite = 'aquarium';
$currentPage = 'experience-detail';

// Get experience from query parameter
$experienceSlug = $_GET['experience'] ?? 'penguin-encounter';

// Load base experience data
require_once __DIR__ . '/../includes/experience-data.php';

// Extended experience data for detail page (includes full description, etc.)
$experiences = [
    'penguin-encounter' => [
        'title' => 'Penguin Encounter',
        'category' => 'ANIMAL MEET & GREETS',
        'price' => 90.00,
        'image' => '../img/body/cardp1.jpg',
        'inclusions' => [
            'Personalized certificate',
            '5x7 color photo of your penguin',
            'Personality card on your penguin',
            'Information packet',
            '8x10 penguin foot painting',
            'Two complimentary passes to the aquarium',
            'Discount coupon for an animal encounter'
        ],
        'description' => [
            'title' => 'Description',
            'subtitle' => 'Duration - 30 minutes',
            'details' => [
                'Experience Level - Beginner friendly, all ages welcome',
                'Group Size - Maximum 6 participants per session',
                'What to Expect - Get up close and personal with our African Penguins! You\'ll have the opportunity to interact with these amazing birds, learn about their behavior, and even help with feeding. Our experienced keepers will guide you through this unforgettable experience.',
                'Safety Requirements - Closed-toe shoes required. No flash photography allowed.',
                'Best For - Families, animal lovers, and anyone looking for a unique aquarium experience.'
            ]
        ],
        'related' => ['yoga', 'penguins-pancakes', 'otter-encounter']
    ],
    'yoga' => [
        'title' => 'All-Level Yoga',
        'category' => 'FITNESS',
        'price' => 25.00,
        'image' => '../img/body/cardp2.png',
        'inclusions' => [
            'Yoga mat rental',
            'Access to aquarium exhibits before/after class',
            'Complimentary water',
            'Experienced instructor'
        ],
        'description' => [
            'title' => 'Description',
            'subtitle' => 'Duration - 60 minutes',
            'details' => [
                'Experience Level - All levels welcome',
                'Group Size - Maximum 20 participants',
                'What to Expect - Practice yoga surrounded by the peaceful ambiance of our aquarium. This unique experience combines mindfulness with marine life observation.',
                'What to Bring - Comfortable clothing, water bottle (optional)',
                'Best For - Yoga enthusiasts, stress relief seekers, and those looking for a unique fitness experience.'
            ]
        ],
        'related' => ['penguin-encounter', 'penguins-pancakes', 'otter-encounter']
    ],
    'penguins-pancakes' => [
        'title' => 'Penguins & Pancakes',
        'category' => 'ANIMAL MEET & GREETS',
        'price' => 45.00,
        'image' => '../img/body/cardp3.png',
        'inclusions' => [
            'Breakfast buffet',
            'Penguin encounter experience',
            'Educational presentation',
            'Take-home certificate',
            'Aquarium admission for the day'
        ],
        'description' => [
            'title' => 'Description',
            'subtitle' => 'Duration - 90 minutes',
            'details' => [
                'Experience Level - Family-friendly, all ages',
                'Group Size - Maximum 30 participants',
                'What to Expect - Start your day with a delicious breakfast while watching our penguins enjoy their morning meal. Includes an interactive presentation and the chance to meet the penguins up close.',
                'Schedule - Check schedule for available dates',
                'Best For - Families with children, early risers, and breakfast enthusiasts.'
            ]
        ],
        'related' => ['penguin-encounter', 'yoga', 'otter-encounter']
    ],
    'otter-encounter' => [
        'title' => 'Otter Encounter',
        'category' => 'ANIMAL MEET & GREETS',
        'price' => 85.00,
        'image' => '../img/body/cardp4.jpg',
        'inclusions' => [
            'Personalized certificate',
            '5x7 color photo',
            'Otter information packet',
            'Behind-the-scenes access',
            'Aquarium admission for the day'
        ],
        'description' => [
            'title' => 'Description',
            'subtitle' => 'Duration - 45 minutes',
            'details' => [
                'Experience Level - Beginner friendly, ages 8+',
                'Group Size - Maximum 4 participants per session',
                'What to Expect - Meet our playful river otters! Learn about their behavior, help with enrichment activities, and watch them play. Our keepers will share fascinating facts about these intelligent animals.',
                'Safety Requirements - Must be able to follow keeper instructions. No jewelry or loose items.',
                'Best For - Animal lovers, families with older children, and those seeking an intimate animal encounter.'
            ]
        ],
        'related' => ['penguin-encounter', 'penguins-pancakes', 'shark-encounter']
    ],
    'marine-life-tour' => [
        'title' => 'Marine Life Tour',
        'category' => 'EDUCATIONAL TOURS',
        'price' => 35.00,
        'image' => '../img/body/cardp5.jpg',
        'inclusions' => [
            'Guided tour with marine biologist',
            'Educational materials',
            'Q&A session',
            'Aquarium admission for the day'
        ],
        'description' => [
            'title' => 'Description',
            'subtitle' => 'Duration - 75 minutes',
            'details' => [
                'Experience Level - Educational, all ages',
                'Group Size - Maximum 15 participants',
                'What to Expect - Explore the aquarium with an expert guide who will share insights about marine life, conservation efforts, and the fascinating creatures that call our aquarium home.',
                'Best For - Students, educators, and anyone interested in marine biology and conservation.'
            ]
        ],
        'related' => ['aquarium-behind-scenes', 'penguin-encounter', 'yoga']
    ],
    'aquarium-behind-scenes' => [
        'title' => 'Aquarium Behind Scenes',
        'category' => 'BEHIND THE SCENES',
        'price' => 55.00,
        'image' => '../img/body/cardp6.jpg',
        'inclusions' => [
            'Exclusive behind-the-scenes access',
            'Meet the keepers',
            'See food preparation areas',
            'Learn about animal care',
            'Aquarium admission for the day'
        ],
        'description' => [
            'title' => 'Description',
            'subtitle' => 'Duration - 60 minutes',
            'details' => [
                'Experience Level - Educational, ages 10+',
                'Group Size - Maximum 12 participants',
                'What to Expect - Go behind the scenes to see how we care for our animals. Visit food preparation areas, learn about enrichment programs, and meet the dedicated team that keeps our aquarium running.',
                'Best For - Future marine biologists, aquarium enthusiasts, and those curious about animal care.'
            ]
        ],
        'related' => ['marine-life-tour', 'penguin-encounter', 'otter-encounter']
    ],
    'shark-encounter' => [
        'title' => 'Shark Encounter',
        'category' => 'ANIMAL MEET & GREETS',
        'price' => 95.00,
        'image' => '../img/body/cardp7.jpg',
        'inclusions' => [
            'Shark feeding experience',
            'Educational presentation',
            'Take-home certificate',
            'Safety equipment provided',
            'Aquarium admission for the day'
        ],
        'description' => [
            'title' => 'Description',
            'subtitle' => 'Duration - 50 minutes',
            'details' => [
                'Experience Level - Intermediate, ages 12+',
                'Group Size - Maximum 6 participants per session',
                'What to Expect - Experience the thrill of feeding our sharks under the guidance of our expert keepers. Learn about shark behavior, conservation, and the important role sharks play in marine ecosystems.',
                'Safety Requirements - Must be comfortable in water. All safety equipment provided.',
                'Best For - Thrill-seekers, shark enthusiasts, and those looking for an unforgettable experience.'
            ]
        ],
        'related' => ['penguin-encounter', 'otter-encounter', 'aquarium-behind-scenes']
    ],
    'family-fun-day' => [
        'title' => 'Family Fun Day',
        'category' => 'FAMILY EVENTS',
        'price' => 60.00,
        'image' => '../img/body/cardp8.jpg',
        'inclusions' => [
            'Full day aquarium access',
            'Interactive activities',
            'Educational workshops',
            'Family photo opportunity',
            'Complimentary snacks'
        ],
        'description' => [
            'title' => 'Description',
            'subtitle' => 'Duration - Full day',
            'details' => [
                'Experience Level - Family-friendly, all ages',
                'Group Size - Unlimited',
                'What to Expect - A full day of fun for the whole family! Includes interactive activities, educational workshops, animal encounters, and plenty of time to explore all our exhibits.',
                'Schedule - Check schedule for available dates',
                'Best For - Families looking for a complete aquarium experience with activities for all ages.'
            ]
        ],
        'related' => ['penguins-pancakes', 'penguin-encounter', 'yoga']
    ]
];

$experience = $experiences[$experienceSlug] ?? $experiences['penguin-encounter'];
include __DIR__ . '/../includes/header.php';
?>
    <main class="flex-grow-1">
        <div class="experience-detail-container">
            <div class="container py-5">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="experience-breadcrumb mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="../index.php#featured-experiences">Experiences</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($experience['title']); ?></li>
                    </ol>
                </nav>

                <!-- Success Message -->
                <?php if (isset($_SESSION['cart_message'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['cart_message_type'] ?? 'success'; ?> alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($_SESSION['cart_message']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php 
                    unset($_SESSION['cart_message']);
                    unset($_SESSION['cart_message_type']);
                    ?>
                <?php endif; ?>

                <!-- Main Content -->
                <div class="row g-4 mb-5">
                    <!-- Left Column - Image -->
                    <div class="col-lg-6">
                        <div class="experience-image-wrapper">
                            <?php 
                            // Ensure correct image path
                            $imagePath = $experience['image'];
                            if (strpos($imagePath, '../') !== 0 && strpos($imagePath, 'http') !== 0) {
                                $imagePath = '../' . $imagePath;
                            }
                            ?>
                            <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                                 alt="<?php echo htmlspecialchars($experience['title']); ?>" 
                                 class="experience-main-image">
                            <div class="image-zoom-icon">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Details -->
                    <div class="col-lg-6">
                        <div class="experience-details">
                            <p class="experience-category"><?php echo htmlspecialchars($experience['category']); ?></p>
                            <h1 class="experience-title"><?php echo htmlspecialchars($experience['title']); ?></h1>
                            <div class="experience-price">$<?php echo number_format($experience['price'], 2); ?></div>

                            <div class="experience-inclusions">
                                <h3 class="inclusions-title">Each Experience Includes:</h3>
                                <ul class="inclusions-list">
                                    <?php foreach ($experience['inclusions'] as $inclusion): ?>
                                        <li><?php echo htmlspecialchars($inclusion); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <div class="experience-personalization">
                                <label for="certificate-name" class="personalization-label">
                                    Name you would like on the certificate:
                                </label>
                                <input type="text" 
                                       id="certificate-name" 
                                       name="certificate_name"
                                       class="form-control personalization-input" 
                                       placeholder="Enter your name">
                            </div>

                            <form method="POST" action="add_experience_to_cart.php" id="book-experience-form">
                                <input type="hidden" name="experience_slug" value="<?php echo htmlspecialchars($experienceSlug); ?>">
                                <input type="hidden" name="redirect" value="experience-detail.php?experience=<?php echo urlencode($experienceSlug); ?>">
                                
                                <div class="experience-total">
                                    <div class="total-label">Final Total:</div>
                                    <div class="total-amount" id="final-total">$<?php echo number_format($experience['price'], 2); ?></div>
                                </div>

                                <div class="experience-actions">
                                    <div class="quantity-selector">
                                        <label for="quantity" class="visually-hidden">Quantity</label>
                                        <input type="number" 
                                               id="quantity" 
                                               name="quantity"
                                               class="form-control quantity-input" 
                                               value="1" 
                                               min="1" 
                                               max="10"
                                               onchange="updateTotal()">
                                    </div>
                                    <button type="submit" class="btn-book-now">
                                        Book Now
                                    </button>
                                </div>
                            </form>

                            <div class="experience-categories">
                                <span class="categories-label">Categories: </span>
                                <a href="../index.php#featured-experiences" class="category-link">Experiences</a>,
                                <a href="../index.php#featured-experiences" class="category-link"><?php echo htmlspecialchars($experience['category']); ?></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="experience-description-section">
                    <ul class="nav nav-tabs description-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                                Description
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <h2 class="description-title"><?php echo htmlspecialchars($experience['description']['title']); ?></h2>
                            <p class="description-subtitle"><?php echo htmlspecialchars($experience['description']['subtitle']); ?></p>
                            <ul class="description-details">
                                <?php foreach ($experience['description']['details'] as $detail): ?>
                                    <li><?php echo htmlspecialchars($detail); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Related Experiences -->
                <div class="related-experiences-section">
                    <h2 class="related-experiences-title">Related Experiences</h2>
                    <div class="row g-4">
                        <?php 
                        $relatedSlugs = $experience['related'] ?? ['penguin-encounter', 'yoga', 'penguins-pancakes'];
                        foreach (array_slice($relatedSlugs, 0, 3) as $relatedSlug):
                            if (isset($experiences[$relatedSlug])):
                                $related = $experiences[$relatedSlug];
                        ?>
                        <div class="col-md-4">
                            <div class="related-experience-card">
                                <a href="experience-detail.php?experience=<?php echo urlencode($relatedSlug); ?>" class="related-experience-link">
                                    <?php 
                                    // Ensure correct image path for related experiences
                                    $relatedImagePath = $related['image'];
                                    if (strpos($relatedImagePath, '../') !== 0 && strpos($relatedImagePath, 'http') !== 0) {
                                        $relatedImagePath = '../' . $relatedImagePath;
                                    }
                                    ?>
                                    <img src="<?php echo htmlspecialchars($relatedImagePath); ?>" 
                                         alt="<?php echo htmlspecialchars($related['title']); ?>" 
                                         class="related-experience-image">
                                    <div class="related-experience-info">
                                        <h5><?php echo htmlspecialchars($related['title']); ?></h5>
                                        <div class="related-experience-price">$<?php echo number_format($related['price'], 2); ?></div>
                                        <button class="btn-related-book">Book Now</button>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const basePrice = <?php echo $experience['price']; ?>;
        
        function updateTotal() {
            const quantity = parseInt(document.getElementById('quantity').value) || 1;
            const total = basePrice * quantity;
            document.getElementById('final-total').textContent = '$' + total.toFixed(2);
        }
        
        // Update total when quantity changes
        document.getElementById('quantity').addEventListener('input', updateTotal);
        
        // Handle form submission
        document.getElementById('book-experience-form').addEventListener('submit', function(e) {
            const quantity = parseInt(document.getElementById('quantity').value) || 1;
            if (quantity < 1 || quantity > 10) {
                e.preventDefault();
                alert('Please enter a valid quantity between 1 and 10.');
                return false;
            }
            // Form will submit normally to add_experience_to_cart.php
        });
    </script>
</body>
</html>
