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

    // Newsletter Subscription Form - AJAX Submit
    const newsletterForm = document.getElementById('newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const emailInput = document.getElementById('subscribe-email');
            const submitBtn = document.getElementById('subscribe-btn');
            const messageContainer = document.getElementById('subscribe-message-container');
            const email = emailInput.value.trim();
            
            if (!email) {
                showSubscribeMessage('Please enter your email address.', 'danger');
                return;
            }
            
            // Disable button and show loading state
            const originalBtnText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Subscribing...';
            
            // Get form action URL
            const formAction = newsletterForm.getAttribute('action');
            
            // Create FormData
            const formData = new FormData();
            formData.append('email', email);
            
            // Send AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open('POST', formAction, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            xhr.onload = function() {
                submitBtn.disabled = false;
                submitBtn.textContent = originalBtnText;
                
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        
                        if (response.success) {
                            // Clear email input on success
                            emailInput.value = '';
                            showSubscribeMessage(response.message, response.message_type || 'success');
                        } else {
                            showSubscribeMessage(response.message, response.message_type || 'danger');
                        }
                    } catch (e) {
                        showSubscribeMessage('An error occurred. Please try again.', 'danger');
                    }
                } else {
                    showSubscribeMessage('An error occurred. Please try again.', 'danger');
                }
            };
            
            xhr.onerror = function() {
                submitBtn.disabled = false;
                submitBtn.textContent = originalBtnText;
                showSubscribeMessage('Network error. Please try again.', 'danger');
            };
            
            xhr.send(formData);
        });
    }
    
    // Function to show subscription message
    function showSubscribeMessage(message, type) {
        const messageContainer = document.getElementById('subscribe-message-container');
        if (!messageContainer) return;
        
        // Remove existing alert
        const existingAlert = messageContainer.querySelector('.alert');
        if (existingAlert) {
            existingAlert.remove();
        }
        
        // Create new alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show mb-2`;
        alertDiv.setAttribute('role', 'alert');
        alertDiv.style.fontSize = '0.875rem';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        messageContainer.appendChild(alertDiv);
        
        // Auto-hide success messages after 5 seconds
        if (type === 'success') {
            setTimeout(function() {
                if (alertDiv.parentNode) {
                    alertDiv.classList.remove('show');
                    setTimeout(function() {
                        if (alertDiv.parentNode) {
                            alertDiv.remove();
                        }
                    }, 150);
                }
            }, 5000);
        }
    }
});

// You can add more JavaScript functions here as your project grows
