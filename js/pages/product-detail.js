/**
 * Product Detail Page JavaScript
 * Handles quantity calculation and add to cart AJAX
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get base price from data attribute or global variable
    const priceElement = document.getElementById('product-base-price');
    const basePrice = priceElement ? parseFloat(priceElement.getAttribute('data-price')) : (typeof window.basePrice !== 'undefined' ? window.basePrice : 0);
    
    if (basePrice <= 0) {
        console.error('Base price not found');
        return;
    }
    
    // Update total function
    function updateTotal() {
        const quantity = parseInt(document.getElementById('quantity').value) || 1;
        const total = basePrice * quantity;
        const totalElement = document.getElementById('final-total');
        if (totalElement) {
            totalElement.textContent = '$' + total.toFixed(2);
        }
    }
    
    // Update total when quantity changes
    const quantityInput = document.getElementById('quantity');
    if (quantityInput) {
        quantityInput.addEventListener('input', updateTotal);
        quantityInput.addEventListener('change', updateTotal);
    }
    
    // Plus button - increase quantity
    const qtyPlus = document.querySelector('.qty-plus');
    if (qtyPlus) {
        qtyPlus.addEventListener('click', function() {
            const input = document.getElementById('quantity');
            let val = parseInt(input.value) || 1;
            val = Math.min(99, val + 1);
            input.value = val;
            updateTotal();
        });
    }
    
    // Minus button - decrease quantity
    const qtyMinus = document.querySelector('.qty-minus');
    if (qtyMinus) {
        qtyMinus.addEventListener('click', function() {
            const input = document.getElementById('quantity');
            let val = parseInt(input.value) || 1;
            val = Math.max(1, val - 1);
            input.value = val;
            updateTotal();
        });
    }
    
    // Handle form submission with AJAX
    const addToCartForm = document.getElementById('add-to-cart-form');
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const quantity = parseInt(document.getElementById('quantity').value) || 1;
            if (quantity < 1 || quantity > 99) {
                alert('Please enter a valid quantity between 1 and 99.');
                return false;
            }
            
            const formData = new FormData(this);
            const addToCartBtn = document.getElementById('add-to-cart-btn');
            const originalText = addToCartBtn.textContent;
            
            // Disable button and show loading state
            addToCartBtn.disabled = true;
            addToCartBtn.textContent = 'Adding...';
            
            // Send AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../product/add_to_cart.php', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            xhr.onload = function() {
                addToCartBtn.disabled = false;
                addToCartBtn.textContent = originalText;
                
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        
                        if (response.success) {
                            // Show success message
                            const successMessage = document.getElementById('cart-success-message');
                            const successText = document.getElementById('cart-success-text');
                            if (successMessage && successText) {
                                successText.textContent = response.message;
                                successMessage.classList.add('show');
                                successMessage.style.display = 'block';
                                
                                // Scroll to top to show message
                                window.scrollTo({ top: 0, behavior: 'smooth' });
                                
                                // Hide message after 5 seconds
                                setTimeout(function() {
                                    successMessage.classList.remove('show');
                                    setTimeout(function() {
                                        successMessage.style.display = 'none';
                                    }, 300);
                                }, 5000);
                            }
                            
                            // Update cart count in header
                            if (response.cart_count !== undefined) {
                                const cartCount = parseInt(response.cart_count) || 0;
                                
                                // Find cart link in top navigation
                                const cartLink = document.querySelector('a[href*="cart.php"].top-link');
                                if (cartLink) {
                                    let badge = cartLink.querySelector('.badge.bg-danger.rounded-pill');
                                    if (cartCount > 0) {
                                        if (!badge) {
                                            badge = document.createElement('span');
                                            badge.className = 'badge bg-danger rounded-pill';
                                            cartLink.appendChild(badge);
                                        }
                                        badge.textContent = cartCount;
                                        badge.style.display = 'inline-block';
                                    } else if (badge) {
                                        badge.style.display = 'none';
                                    }
                                }
                                
                                // Update item badge in dropdown menu
                                const itemBadge = document.querySelector('.item-badge');
                                if (itemBadge) {
                                    itemBadge.textContent = cartCount;
                                }
                            }
                        } else {
                            alert(response.message || 'Failed to add product to cart.');
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                        alert('An error occurred. Please try again.');
                    }
                } else {
                    alert('An error occurred. Please try again.');
                }
            };
            
            xhr.onerror = function() {
                addToCartBtn.disabled = false;
                addToCartBtn.textContent = originalText;
                alert('Network error. Please try again.');
            };
            
            xhr.send(formData);
        });
    }
});
