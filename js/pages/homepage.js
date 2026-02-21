/**
 * Homepage JavaScript
 * Handles hero banner slider and featured experiences slider
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Homepage scripts loaded');
    
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
    if (indicators.length > 0) {
        setInterval(function() {
            currentSlide = (currentSlide + 1) % indicators.length;
            updateIndicators();
        }, 5000);
    }

    // Featured Experiences - Prev/Next nav buttons
    const experienceSlides = document.querySelectorAll('.exp-slides .experience-slide');
    const prevBtn = document.querySelector('.exp-prev-btn');
    const nextBtn = document.querySelector('.exp-next-btn');
    let currentExperienceSlide = 0;
    const totalSlides = experienceSlides.length;

    function showExperienceSlide(slideIndex) {
        experienceSlides.forEach(slide => slide.classList.remove('active'));
        if (experienceSlides[slideIndex]) {
            experienceSlides[slideIndex].classList.add('active');
        }
        currentExperienceSlide = slideIndex;
    }

    if (experienceSlides.length > 0) {
        showExperienceSlide(0);

        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                const next = (currentExperienceSlide - 1 + totalSlides) % totalSlides;
                showExperienceSlide(next);
            });
        }
        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                const next = (currentExperienceSlide + 1) % totalSlides;
                showExperienceSlide(next);
            });
        }
    }
});
