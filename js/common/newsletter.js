/**
 * Newsletter Subscription JavaScript
 * Handles AJAX form submission for newsletter subscription
 */

document.addEventListener('DOMContentLoaded', function() {
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
