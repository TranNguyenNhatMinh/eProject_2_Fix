<?php
$currentSite = 'aquarium';
$currentPage = 'event-register';
require_once __DIR__ . '/../includes/experience-data.php';

$eventSlug = $_GET['event'] ?? 'junior-keepers';

$eventToExperienceSlug = [
    'junior-keepers' => 'junior-keepers',
    'yoga' => 'yoga-event',
];
$experienceSlug = $eventToExperienceSlug[$eventSlug] ?? null;

$events = [
    'junior-keepers' => [
        'title' => 'JUNIOR KEEPERS (11-15 YEARS OLD)',
        'tagline' => 'Behind the Scenes Adventure',
        'location' => 'THE AQUARIUM',
        'date' => '02-13-2026',
        'time' => '8:30AM - 11:30AM',
        'cost' => '$100 per Child.',
        'image' => '../img/body/junior.png',
        'theme' => 'adventure',
    ],
    'yoga' => [
        'title' => 'YOGA',
        'tagline' => 'Find Your Calm by the Aquarium',
        'location' => 'THE AQUARIUM',
        'date' => '02-22-2026',
        'time' => '9:00AM - 10:00AM',
        'cost' => '$30 per participant.',
        'image' => '../img/body/yoga.png',
        'theme' => 'wellness',
    ],
];

$event = $events[$eventSlug] ?? null;
$registerTheme = $event['theme'] ?? 'default';

// Redirect if event not registerable
if (!$event || !$experienceSlug || !getExperienceBySlug($experienceSlug)) {
    header('Location: event-detail.php?event=junior-keepers');
    exit;
}

include __DIR__ . '/../includes/header.php';
?>
    <main class="flex-grow-1">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumb event-register-breadcrumb mb-4">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="event-detail.php?event=<?php echo urlencode($eventSlug); ?>"><?php echo htmlspecialchars($event['title']); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Register</li>
                </ol>
            </nav>

            <div class="row justify-content-center">
                <div class="col-lg-7 col-xl-6">
                    <div class="card event-register-card <?php echo htmlspecialchars($registerTheme); ?>">
                        <div class="event-register-header <?php echo htmlspecialchars($registerTheme); ?>">
                            <h2 class="event-register-title"><?php echo htmlspecialchars($event['title']); ?></h2>
                            <p class="event-register-meta mb-0"><?php echo htmlspecialchars($event['cost']); ?> — <?php echo htmlspecialchars($event['date']); ?> <?php echo htmlspecialchars($event['time']); ?></p>
                        </div>
                        <div class="event-register-body">
                            <form method="post" action="add_experience_to_cart.php" class="event-register-form">
                                <input type="hidden" name="experience_slug" value="<?php echo htmlspecialchars($experienceSlug); ?>">
                                <input type="hidden" name="event_slug" value="<?php echo htmlspecialchars($eventSlug); ?>">
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="redirect" value="event-detail.php?event=<?php echo urlencode($eventSlug); ?>">

                                <?php if ($eventSlug === 'junior-keepers'): ?>
                                <div class="mb-3">
                                    <label for="child_name" class="form-label">Child's Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="child_name" name="certificate_name" required placeholder="Full name of participant (ages 11-15)">
                                </div>
                                <?php else: ?>
                                <div class="mb-3">
                                    <label for="participant_name" class="form-label">Participant Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="participant_name" name="certificate_name" required placeholder="Full name of participant">
                                </div>
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label for="guardian_email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="guardian_email" name="guardian_email" required placeholder="Guardian/parent email">
                                </div>

                                <div class="mb-4">
                                    <label for="guardian_phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="guardian_phone" name="guardian_phone" placeholder="Contact phone number">
                                </div>

                                <div class="event-register-actions">
                                    <a href="event-detail.php?event=<?php echo urlencode($eventSlug); ?>" class="event-register-btn-cancel">Cancel</a>
                                    <button type="submit" class="event-register-btn-submit btn">Add to Cart &amp; Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
