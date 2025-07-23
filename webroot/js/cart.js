/**
 * Cart functionality for handling cart operations and updating the cart count
 */

// Function to update the cart count display
function updateCartCount(count) {
    console.log('Updating cart count to:', count); // Debug
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(element => {
        element.textContent = count;
    });
}

// Function to decrease quantity
function decreaseQuantity(inputId) {
    console.log('Decreasing quantity for input:', inputId); // Debug
    const input = document.getElementById(inputId);
    if (!input) {
        console.error('Quantity input not found:', inputId);
        return;
    }
    console.log('Input found:', input, 'Current value:', input.value); // Debug
    const currentValue = parseInt(input.value) || 1;
    const min = parseInt(input.getAttribute('min')) || 1;
    if (currentValue > min) {
        input.value = currentValue - 1;
    }
}

// Function to increase quantity
function increaseQuantity(inputId) {
    console.log('Increasing quantity for input:', inputId); // Debug
    const input = document.getElementById(inputId);
    if (!input) {
        console.error('Quantity input not found:', inputId);
        return;
    }
    console.log('Input found:', input, 'Current value:', input.value); // Debug
    const currentValue = parseInt(input.value) || 1;
    const max = parseInt(input.getAttribute('max')) || Infinity;
    if (currentValue < max) {
        input.value = currentValue + 1;
    }
}

// Function to handle adding items to cart
function addToCart(formElement) {
    console.log('Add to cart triggered for form:', formElement); // Debug
    const formData = new FormData(formElement);

    fetch('/cart-items/add', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-Token': document.querySelector('meta[name="csrfToken"]')?.content || ''
        }
    })
        .then(response => {
            console.log('Add to cart response status:', response.status); // Debug
            return response.json();
        })
        .then(data => {
            console.log('Add to cart response data:', data); // Debug
            if (data.success) {
                if (data.cartCount !== undefined) {
                    updateCartCount(data.cartCount);
                }
                showAlert(data.message, 'success');
                // Redirect to /products/page if the form has class 'add-to-cart' (view.php)
                if (formElement.classList.contains('add-to-cart')) {
                    console.log('Redirecting to /products/page after adding to cart'); // Debug
                    window.location.href = '/products/page';
                }
            } else {
                showAlert(data.message || 'Failed to add item to cart.', 'error');
            }
        })
        .catch(error => {
            console.error('Add to cart error:', error); // Debug
            showAlert('An error occurred while adding the item to the cart.', 'error');
        });
}

// Function to handle quantity decrease for cart items
function decreaseCartQuantity(cartItemId) {
    console.log('Decreasing cart quantity for cart item:', cartItemId); // Debug
    fetch(`/cart-items/decreaseQuantity/${cartItemId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-Token': document.querySelector('meta[name="csrfToken"]')?.content || ''
        }
    })
        .then(response => response.json())
        .then(data => {
            console.log('Decrease cart quantity response:', data); // Debug
            if (data.success) {
                if (data.cartCount !== undefined) {
                    updateCartCount(data.cartCount);
                }
                showAlert(data.message, 'success');
                // Update quantity display or remove item if deleted
                const quantityElement = document.querySelector(`[data-cart-item-id="${cartItemId}"] .quantity`);
                if (quantityElement && data.cartCount >= 0) {
                    quantityElement.textContent = data.cartCount;
                } else {
                    const cartItemElement = document.querySelector(`[data-cart-item-id="${cartItemId}"]`);
                    if (cartItemElement) {
                        cartItemElement.remove();
                    }
                }
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Decrease cart quantity error:', error); // Debug
            showAlert('An error occurred while updating the quantity.', 'error');
        });
}

// Function to handle quantity increase for cart items
function increaseCartQuantity(cartItemId) {
    console.log('Increasing cart quantity for cart item:', cartItemId); // Debug
    fetch(`/cart-items/increaseQuantity/${cartItemId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-Token': document.querySelector('meta[name="csrfToken"]')?.content || ''
        }
    })
        .then(response => response.json())
        .then(data => {
            console.log('Increase cart quantity response:', data); // Debug
            if (data.success) {
                if (data.cartCount !== undefined) {
                    updateCartCount(data.cartCount);
                }
                showAlert(data.message, 'success');
                // Update quantity display
                const quantityElement = document.querySelector(`[data-cart-item-id="${cartItemId}"] .quantity`);
                if (quantityElement) {
                    quantityElement.textContent = data.cartCount;
                }
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Increase cart quantity error:', error); // Debug
            showAlert('An error occurred while updating the quantity.', 'error');
        });
}

// Function to handle cart item deletion
function deleteCartItem(cartItemId) {
    console.log('Deleting cart item:', cartItemId); // Debug
    if (confirm('Are you sure you want to remove this item from your cart?')) {
        fetch(`/cart-items/delete/${cartItemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-Token': document.querySelector('meta[name="csrfToken"]')?.content || ''
            }
        })
            .then(response => response.json())
            .then(data => {
                console.log('Delete cart item response:', data); // Debug
                if (data.success) {
                    if (data.cartCount !== undefined) {
                        updateCartCount(data.cartCount);
                    }
                    // Remove the cart item element from the DOM
                    const cartItemElement = document.querySelector(`[data-cart-item-id="${cartItemId}"]`);
                    if (cartItemElement) {
                        cartItemElement.remove();
                    }
                    showAlert(data.message, 'success');
                } else {
                    showAlert(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Delete cart item error:', error); // Debug
                showAlert('An error occurred while removing the item from your cart.', 'error');
            });
    }
}

// Function to show alerts
function showAlert(message, type = 'info') {
    console.log(`Showing alert: ${message} (${type})`); // Debug
    // Check if there's an existing alert container
    let alertContainer = document.querySelector('.alert-container');

    // If not, create one
    if (!alertContainer) {
        alertContainer = document.createElement('div');
        alertContainer.className = 'alert-container';
        document.body.appendChild(alertContainer);
    }

    // Create the alert element
    const alertElement = document.createElement('div');
    alertElement.className = `alert alert-${type}`;
    alertElement.textContent = message;

    // Add the alert to the container
    alertContainer.appendChild(alertElement);

    // Remove the alert after 3 seconds
    setTimeout(() => {
        alertElement.classList.add('fade-out');
        setTimeout(() => {
            alertElement.remove();
        }, 300);
    }, 3000);
}

// Function to bind cart events (for forms and non-delegated events)
function bindCartEvents() {
    console.log('Binding cart events'); // Debug

    // Add event listeners for add to cart forms
    const addToCartForms = document.querySelectorAll('form.add-to-cart, form.add-to-cart-form, form[id^="quick-view-add-to-cart-form-"]');
    console.log('Found add-to-cart forms:', addToCartForms.length); // Debug
    addToCartForms.forEach(form => {
        // Remove existing listeners to prevent duplicates
        form.removeEventListener('submit', handleFormSubmit);
        form.addEventListener('submit', handleFormSubmit);
    });

    // Add event listeners for cart quantity buttons
    const decreaseButtons = document.querySelectorAll('.decrease-quantity');
    console.log('Found decrease cart buttons:', decreaseButtons.length); // Debug
    decreaseButtons.forEach(button => {
        button.removeEventListener('click', handleDecreaseCart);
        button.addEventListener('click', handleDecreaseCart);
    });

    const increaseButtons = document.querySelectorAll('.increase-quantity');
    console.log('Found increase cart buttons:', increaseButtons.length); // Debug
    increaseButtons.forEach(button => {
        button.removeEventListener('click', handleIncreaseCart);
        button.addEventListener('click', handleIncreaseCart);
    });

    // Add event listeners for delete buttons
    const deleteButtons = document.querySelectorAll('.delete-cart-item');
    console.log('Found delete buttons:', deleteButtons.length); // Debug
    deleteButtons.forEach(button => {
        button.removeEventListener('click', handleDeleteCart);
        button.addEventListener('click', handleDeleteCart);
    });
}

// Event handler functions
function handleFormSubmit(e) {
    e.preventDefault();
    console.log('Form submitted:', this); // Debug
    addToCart(this);
}

function handleDecreaseCart() {
    const cartItemId = this.getAttribute('data-cart-item-id');
    decreaseCartQuantity(cartItemId);
}

function handleIncreaseCart() {
    const cartItemId = this.getAttribute('data-cart-item-id');
    increaseCartQuantity(cartItemId);
}

function handleDeleteCart() {
    const cartItemId = this.getAttribute('data-cart-item-id');
    deleteCartItem(cartItemId);
}

// Initialize cart functionality when the DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing cart functionality'); // Debug
    bindCartEvents();

    // Use event delegation for quantity buttons
    document.addEventListener('click', function(e) {
        if (e.target.matches('.quantity-btn')) {
            console.log('Quantity button clicked:', e.target, 'data-input-id:', e.target.getAttribute('data-input-id')); // Debug
            const inputId = e.target.getAttribute('data-input-id');
            const action = e.target.textContent.trim() === '-' ? 'decrease' : 'increase';
            console.log(`Action: ${action} for input ${inputId}`); // Debug
            if (inputId) {
                if (action === 'decrease') {
                    decreaseQuantity(inputId);
                } else {
                    increaseQuantity(inputId);
                }
            } else {
                console.error('No data-input-id found on quantity button:', e.target); // Debug
            }
        }
    });
});

// Export bindCartEvents for external use (e.g., after modal open)
window.bindCartEvents = bindCartEvents;
