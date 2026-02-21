<?php
$currentSite = 'aquarium';
$currentPage = 'event-detail';
require_once __DIR__ . '/../includes/experience-data.php';

// Get event from query parameter
$eventSlug = $_GET['event'] ?? 'junior-keepers';

// Map event slug to experience slug for cart
$eventToExperienceSlug = [
    'junior-keepers' => 'junior-keepers',
    'yoga' => 'yoga-event',
];
$experienceSlug = $eventToExperienceSlug[$eventSlug] ?? null;

// Event data
$events = [
    'junior-keepers' => [
        'title' => 'JUNIOR KEEPERS (11-15 YEARS OLD)',
        'tagline' => 'Behind the Scenes Adventure',
        'location' => 'THE AQUARIUM',
        'date' => '02-13-2026',
        'time' => '8:30AM - 11:30AM',
        'description' => "This is a great program for those future marine biologists! Come experience the aquarium from an employee's point of view. Learn how to provide animal care including training, enrichment, and feeding for a variety of animals. You'll go behind the scenes, meet some of our animals, and talk with our care staff.",
        'requirements' => 'Pre-registration & sneakers are required.',
        'age' => 'Ages 11-15 years.',
        'cost' => '$100 per Child.',
        'register_link' => '#',
        'image' => '../img/body/junior.png',
        'deadline' => null,
        'theme' => 'adventure',
        'layout' => 'image-right'
    ],
    'yoga' => [
        'title' => 'YOGA',
        'tagline' => 'Find Your Calm by the Aquarium',
        'location' => 'THE AQUARIUM',
        'date' => '02-22-2026',
        'time' => '9:00AM - 10:00AM',
        'description' => "Enjoy an hour-long yoga class with This Is Yoga NJ surrounded by fascinating sea life, including our playful seals, Turbo and Noelani. A perfect way to blend relaxation with a unique aquatic experience! Includes admission for the day.",
        'requirements' => 'This program is planned as an All Levels Yoga class geared for adults, but ages 10+ are welcome accompanied by a participating adult.',
        'age' => '',
        'cost' => '$30 per participant.',
        'register_link' => '#',
        'image' => '../img/body/yoga.png',
        'deadline' => 'Registration will close February 20th at 4pm.',
        'theme' => 'wellness',
        'layout' => 'image-left'
    ],
    'world-whale-day' => [
        'title' => 'WORLD WHALE DAY',
        'tagline' => 'Celebrate & Conserve',
        'location' => 'THE AQUARIUM',
        'date' => '02-15-2026',
        'time' => '12:00PM - 4:00PM',
        'description' => "This day is celebrated to raise awareness about the challenges all whales face and to promote their conservation. Learn all about these amazing marine mammals through crafts, activities, chats, and more!",
        'requirements' => 'Included with general admission.',
        'age' => '',
        'cost' => '',
        'register_link' => '',
        'image' => '../img/body/l2.png',
        'deadline' => null,
        'theme' => 'conservation',
        'layout' => 'hero-image'
    ],
    'sensory-saturdays' => [
        'title' => 'SENSORY SATURDAY',
        'tagline' => 'Sensory Friendly Experience',
        'location' => 'THE AQUARIUM',
        'date' => '02-28-2026',
        'time' => '9:00AM - 10:00AM',
        'description' => "Guests with autism spectrum disorder, sensory processing or cognitive challenges, as well as guests requiring assistance for disabilities are invited to explore the aquarium before we open to the public. To create a sensory friendly environment there will be a decreased noise level, limited visual stimulation and less crowding.",
        'requirements' => 'General admission applies.',
        'age' => '',
        'cost' => '',
        'register_link' => '',
        'image' => '../img/body/sentory.png',
        'deadline' => null,
        'theme' => 'inclusive',
        'layout' => 'hero-image'
    ]
];

$event = $events[$eventSlug] ?? $events['junior-keepers'];
$theme = $event['theme'] ?? 'default';
$layout = $event['layout'] ?? 'image-right';
$tagline = $event['tagline'] ?? '';
include __DIR__ . '/../includes/header.php';
?>
    <main class="flex-grow-1">
        <?php if (!empty($_SESSION['cart_message'])): ?>
        <div class="container py-2">
            <div class="alert alert-<?php echo $_SESSION['cart_message_type'] ?? 'success'; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['cart_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        <?php unset($_SESSION['cart_message'], $_SESSION['cart_message_type']); endif; ?>
        <div class="event-detail-container event-theme-<?php echo htmlspecialchars($theme); ?> event-layout-<?php echo htmlspecialchars($layout); ?>">
            <div class="container py-5">
                <!-- Main Event Info -->
                <div class="event-detail-header">
                    <?php if (!empty($tagline)): ?>
                    <p class="event-tagline"><?php echo htmlspecialchars($tagline); ?></p>
                    <?php endif; ?>
                    <h1 class="event-detail-title"><?php echo htmlspecialchars($event['title']); ?></h1>
                    <div class="event-detail-meta">
                        <div class="event-meta-item">
                            <span class="meta-label">LOCATION:</span>
                            <span class="meta-value"><?php echo htmlspecialchars($event['location']); ?></span>
                        </div>
                        <div class="event-meta-item">
                            <span class="meta-label">DATE:</span>
                            <span class="meta-value"><?php echo htmlspecialchars($event['date']); ?></span>
                        </div>
                        <div class="event-meta-item">
                            <span class="meta-label">TIME:</span>
                            <span class="meta-value"><?php echo htmlspecialchars($event['time']); ?></span>
                        </div>
                    </div>
                </div>

                <div class="event-detail-content">
                    <?php if ($layout === 'hero-image'): ?>
                    <div class="event-image-hero-wrapper mb-4">
                        <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>" class="event-detail-image event-image-hero">
                    </div>
                    <?php endif; ?>
                    <div class="row <?php echo $layout === 'image-left' ? 'flex-row-reverse' : ''; ?>">
                        <div class="col-lg-8">
                            <div class="event-description">
                                <p><?php echo htmlspecialchars($event['description']); ?></p>
                            </div>
                            <div class="event-requirements">
                                <p class="requirements-text"><strong><?php echo htmlspecialchars($event['requirements']); ?></strong></p>
                                <?php if (!empty($event['age'])): ?>
                                <p><?php echo htmlspecialchars($event['age']); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($event['cost'])): ?>
                                <p><?php echo htmlspecialchars($event['cost']); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($event['deadline'])): ?>
                                <p class="event-deadline mt-2"><?php echo htmlspecialchars($event['deadline']); ?></p>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($event['register_link']) && $experienceSlug && getExperienceBySlug($experienceSlug)): ?>
                            <div class="event-register">
                                <a href="event-register.php?event=<?php echo urlencode($eventSlug); ?>" class="btn-register">
                                    To Register Click Here!
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php if ($layout !== 'hero-image'): ?>
                        <div class="col-lg-4">
                            <div class="event-image-wrapper">
                                <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>" class="event-detail-image">
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Related Events -->
                <div class="related-events-section">
                    <h2 class="related-events-title">RELATED EVENTS</h2>
                    <div class="row g-4">
                        <?php
                        $relatedList = [
                            'junior-keepers' => ['title' => 'JUNIOR KEEPERS (11-15 YEARS OLD)', 'date' => 'February 13 @ 8:30 am - 11:30 am', 'image' => '../img/body/junior.png', 'url' => 'event-detail.php?event=junior-keepers'],
                            'world-whale-day' => ['title' => 'WORLD WHALE DAY', 'date' => 'February 15 @ 12:00 pm - 4:00 pm', 'image' => '../img/body/l2.png', 'url' => 'event-detail.php?event=world-whale-day'],
                            'yoga' => ['title' => 'YOGA', 'date' => 'February 22 @ 9:00 am - 10:00 am', 'image' => '../img/body/yoga.png', 'url' => 'event-detail.php?event=yoga'],
                            'sensory-saturdays' => ['title' => 'SENSORY SATURDAY', 'date' => 'February 28 @ 9:00 am - 10:00 am', 'image' => '../img/body/sentory.png', 'url' => 'event-detail.php?event=sensory-saturdays']
                        ];
                        $showKeys = array_slice(array_keys(array_diff_key($relatedList, [$eventSlug => 1])), 0, 3);
                        foreach ($showKeys as $key):
                            $re = $relatedList[$key] ?? null;
                            if (!$re) continue;
                        ?>
                        <div class="col-md-4">
                            <a href="<?php echo htmlspecialchars($re['url']); ?>" class="event-card-link text-decoration-none">
                                <div class="related-event-card">
                                    <img src="<?php echo htmlspecialchars($re['image']); ?>" alt="<?php echo htmlspecialchars($re['title']); ?>" class="img-fluid">
                                    <div class="related-event-info">
                                        <h5><?php echo htmlspecialchars($re['title']); ?></h5>
                                        <p><?php echo htmlspecialchars($re['date']); ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
