<?php
$currentSite = 'aquarium';
include 'includes/header.php';
?>

<!-- Hero Banner Section -->
<section class="hero-banner-section">
    <div class="hero-banner-image">
        <img src="img/mainmain.jpg" alt="Jenkinson's Aquarium">
        <div class="hero-banner-overlay"></div>
    </div>
    <div class="container">
        <div class="hero-banner-content">
            <div class="hero-banner-subtitle">
                <span class="subtitle-text">THE BEST AQUARIUM EXPERIENCE</span>
                <div class="subtitle-underline"></div>
            </div>
            <h1 class="hero-banner-title">WELCOME TO<br>JENKINSON'S <span class="aquarium-text">AQUARIUM</span></h1>
            <a href="componets/ourmission.php" class="btn-hero-banner" id="ctaButton">
                Discover More
            </a>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section class="about-us-section">
    <div class="container">
        <div class="row align-items-start g-4">
            <!-- Left Column - Images -->
            <div class="col-lg-5">
                <div class="about-images">
                    <div class="about-image-top mb-3">
                        <img src="img/mainpic.jpg" alt="Ocean Wave" class="img-fluid rounded">
                    </div>
                    <div class="about-image-bottom">
                        <div class="about-image-bottom-wrapper rounded">
                            <img src="img/pic2.jpg" alt="Marine Life" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Content -->
            <div class="col-lg-7">
                <div class="about-content">
                    <p class="about-subtitle">ABOUT AQUARIUM</p>
                    <h2 class="about-title">WE'RE LEADER IN MARINE EDUCATION</h2>
                    <div class="about-underline"></div>
                    
                    <p class="about-text">
                        Jenkinson's Aquarium is a privately owned facility located on the boardwalk in Point Pleasant Beach, NJ. 
                        We are dedicated to educating the public on marine life and conservation.
                    </p>
                    <p class="about-text about-text-lead">
                        We offer engaging exhibits, educational programs, and hands-on experiences with marine animals for visitors of all ages.
                    </p>
                    <div class="about-features">
                        <div class="feature-item">
                            <i class="fa-solid fa-fish feature-icon"></i>
                            <span>Marine Life Exhibits</span>
                        </div>
                        <span class="feature-line-break" aria-hidden="true"></span>
                        <div class="feature-item">
                            <i class="fa-solid fa-water feature-icon"></i>
                            <span>Educational Programs</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="upcoming-events py-5">
        <div class="container">
            <h2 class="section-title mb-4">UPCOMING EVENTS</h2>
            <div class="events-slider position-relative">
                <button class="slider-btn prev-btn" aria-label="Previous events">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="event-card">
                            <img src="img/body2/b1.jpg" alt="Penguins & Pancakes" class="img-fluid">
                            <div class="event-info">
                                <h5>PENGUINS & PANCAKES</h5>
                                <p>Penguins & Pancakes</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="event-card">
                            <img src="img/body2/b2.jpg" alt="Junior Keepers" class="img-fluid">
                            <div class="event-info">
                                <h5>JUNIOR KEEPERS</h5>
                                <p>Junior Keepers 10-15 years olds</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="event-card">
                            <img src="img/body2/b3.jpg" alt="World Whale Day" class="img-fluid">
                            <div class="event-info">
                                <h5>WORLD WHALE DAY</h5>
                                <p>World Whale Day</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="event-card">
                            <img src="img/body2/b4.jpg" alt="Junior Divers" class="img-fluid">
                            <div class="event-info">
                                <h5>JUNIOR DIVERS</h5>
                                <p>Junior Divers 8-17 years old</p>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="slider-btn next-btn" aria-label="Next events">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Featured Experiences Section -->
    <section class="featured-experiences py-5">
        <div class="container">
            <h2 class="section-title mb-4">FEATURED EXPERIENCES</h2>
            <div class="experiences-slider-wrapper">
                <!-- Slide 0: First 4 cards -->
                <div class="row g-4 experience-slide active" data-slide="0">
                    <div class="col-md-3">
                        <div class="experience-card">
                            <img src="img/body2/b5.jpg" alt="Penguin Encounter" class="img-fluid rounded">
                            <div class="card-body">
                                <p class="experience-subtitle">ANIMAL MEET & GREETS</p>
                                <h5>Penguin Encounter</h5>
                                <button class="btn btn-primary">Book Now</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="experience-card">
                            <img src="img/body2/b6.jpg" alt="Yoga" class="img-fluid rounded">
                            <div class="card-body">
                                <p class="experience-subtitle">FITNESS</p>
                                <h5>All-Level Yoga</h5>
                                <button class="btn btn-primary">Book Now</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="experience-card">
                            <img src="img/body2/b7.jpg" alt="Penguins & Pancakes" class="img-fluid rounded">
                            <div class="card-body">
                                <p class="experience-subtitle">ANIMAL MEET & GREETS</p>
                                <h5>Penguins & Pancakes</h5>
                                <button class="btn btn-primary">Book Now</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="experience-card">
                            <img src="img/body2/b8.jpg" alt="Otter Encounter" class="img-fluid rounded">
                            <div class="card-body">
                                <p class="experience-subtitle">ANIMAL MEET & GREETS</p>
                                <h5>Otter encounter</h5>
                                <button class="btn btn-primary">Book Now</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slide 1: Next 4 cards -->
                <div class="row g-4 experience-slide" data-slide="1">
                    <div class="col-md-3">
                        <div class="experience-card">
                            <img src="img/body2/b9.jpg" alt="Marine Life Tour" class="img-fluid rounded">
                            <div class="card-body">
                                <p class="experience-subtitle">EDUCATIONAL TOURS</p>
                                <h5>Marine Life Tour</h5>
                                <button class="btn btn-primary">Book Now</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="experience-card">
                            <img src="img/body2/b10.jpg" alt="Aquarium Behind Scenes" class="img-fluid rounded">
                            <div class="card-body">
                                <p class="experience-subtitle">BEHIND THE SCENES</p>
                                <h5>Aquarium Behind Scenes</h5>
                                <button class="btn btn-primary">Book Now</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="experience-card">
                            <img src="img/body2/b11.jpg" alt="Shark Encounter" class="img-fluid rounded">
                            <div class="card-body">
                                <p class="experience-subtitle">ANIMAL MEET & GREETS</p>
                                <h5>Shark Encounter</h5>
                                <button class="btn btn-primary">Book Now</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="experience-card">
                            <img src="img/body2/b1.jpg" alt="Family Fun Day" class="img-fluid rounded">
                            <div class="card-body">
                                <p class="experience-subtitle">FAMILY EVENTS</p>
                                <h5>Family Fun Day</h5>
                                <button class="btn btn-primary">Book Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pagination-dots text-center mt-4">
                <span class="dot active" data-dot="0"></span>
                <span class="dot" data-dot="1"></span>
            </div>
        </div>
    </section>

    <!-- Attractions Section -->
    <section class="attractions bg-dark text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="attraction-logo mb-4">
                        <img src="img/logo-main.png" alt="Jenkinson's Boardwalk" class="img-fluid mb-3">
                        <img src="img/sweetshop.png" alt="Jenkinson's Aquarium" class="img-fluid mb-3">
                        <img src="img/boardwalk.png" alt="Sweet Shop" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="attraction-image position-relative">
                        <img src="img/topfloor.jpg" alt="Top Floor Open" class="img-fluid rounded">
                        <div class="attraction-overlay">
                            <h3>TOP FLOOR OPEN</h3>
                            <p>Come see our newly designed top floor. Perfect place to enjoy our world class shows.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



<?php include 'includes/footer.php'; ?>
