/**
 * Quick View functionality for products
 */

// Function to open the quick view modal
function openQuickView(productId) {
    fetch(`/products/quickView/${productId}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        // Create modal container if it doesn't exist
        let modalContainer = document.querySelector('.quick-view-modal-container');
        if (!modalContainer) {
            modalContainer = document.createElement('div');
            modalContainer.className = 'quick-view-modal-container';
            document.body.appendChild(modalContainer);
        }
        
        // Set the modal content
        modalContainer.innerHTML = html;
        
        // Show the modal
        const modal = document.querySelector('.quick-view-modal');
        if (modal) {
            modal.classList.add('active');
        }
        
        // Add event listener to close button
        const closeButton = document.querySelector('.quick-view-close');
        if (closeButton) {
            closeButton.addEventListener('click', closeQuickView);
        }
        
        // Add event listener to add to cart form
        const addToCartForm = document.querySelector('#add-to-cart-form');
        if (addToCartForm) {
            addToCartForm.addEventListener('submit', handleAddToCart);
        }
        
        // Add event listeners for quantity buttons
        const decreaseButton = document.querySelector('.decrease-quantity-btn');
        if (decreaseButton) {
            decreaseButton.addEventListener('click', function() {
                const quantityInput = document.querySelector('#product_quantity');
                if (quantityInput && parseInt(quantityInput.value) > 1) {
                    quantityInput.value = parseInt(quantityInput.value) - 1;
                }
            });
        }
        
        const increaseButton = document.querySelector('.increase-quantity-btn');
        if (increaseButton) {
            increaseButton.addEventListener('click', function() {
                const quantityInput = document.querySelector('#product_quantity');
                const maxStock = parseInt(quantityInput.getAttribute('max'));
                if (quantityInput && parseInt(quantityInput.value) < maxStock) {
                    quantityInput.value = parseInt(quantityInput.value) + 1;
                }
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('An error occurred while loading the product details.', 'error');
    });
}

// Function to close the quick view modal
function closeQuickView() {
    const modal = document.querySelector('.quick-view-modal');
    if (modal) {
        modal.classList.remove('active');
        
        // Remove the modal after animation completes
        setTimeout(() => {
            const modalContainer = document.querySelector('.quick-view-modal-container');
            if (modalContainer) {
                modalContainer.remove();
            }
        }, 300);
    }
}

// Function to handle add to cart form submission
function handleAddToCart(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const data = {
        product_id: formData.get('product_id'),
        product_quantity: parseInt(formData.get('product_quantity'))
    };
    
    fetch('/cart-items/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.cartCount !== undefined) {
                updateCartCount(data.cartCount);
            }
            showAlert(data.message, 'success');
            closeQuickView();
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('An error occurred while adding the item to your cart.', 'error');
    });
}

// Initialize quick view functionality when the DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to quick view buttons
    const quickViewButtons = document.querySelectorAll('.quick-view-btn');
    quickViewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            openQuickView(productId);
        });
    });
}); 