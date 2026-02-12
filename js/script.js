// Custom JavaScript

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Website loaded successfully!');
    
    // Hero Banner Slider Indicators
    const indicators = document.querySelectorAll('.slider-indicators .indicator');
    let currentSlide = 0;
    
    function updateIndicators() {
        indicators.forEach((indicator, index) => {
            if (index === currentSlide) {
                indicator.classList.add('active');
            } else {
                indicator.classList.remove('active');
            }
        });
    }
    
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', function() {
            currentSlide = index;
            updateIndicators();
        });
    });
    
    // Auto-rotate indicators (optional)
    setInterval(function() {
        currentSlide = (currentSlide + 1) % indicators.length;
        updateIndicators();
    }, 5000);

    // Featured Experiences Auto-Slider
    const experienceSlides = document.querySelectorAll('.experience-slide');
    const dots = document.querySelectorAll('.featured-experiences .dot');
    let currentExperienceSlide = 0;
    const totalSlides = experienceSlides.length;

    function showExperienceSlide(slideIndex) {
        // Hide all slides
        experienceSlides.forEach(slide => {
            slide.classList.remove('active');
        });

        // Show current slide
        if (experienceSlides[slideIndex]) {
            experienceSlides[slideIndex].classList.add('active');
        }

        // Update dots
        dots.forEach((dot, index) => {
            if (index === slideIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    // Initialize: show first slide
    if (experienceSlides.length > 0) {
        showExperienceSlide(0);

        // Auto-rotate experiences every 5 seconds
        setInterval(function() {
            currentExperienceSlide = (currentExperienceSlide + 1) % totalSlides;
            showExperienceSlide(currentExperienceSlide);
        }, 5000);

        // Allow manual dot clicking
        dots.forEach((dot, index) => {
            dot.addEventListener('click', function() {
                currentExperienceSlide = index;
                showExperienceSlide(currentExperienceSlide);
            });
        });
    }
});

// You can add more JavaScript functions here as your project grows
