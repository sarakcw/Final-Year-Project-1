/**
 * Quick View functionality for products
 */
document.addEventListener('DOMContentLoaded', function() {
    // Get modal elements
    const modal = document.getElementById('quickViewModal');
    const closeBtn = modal.querySelector('.quick-view-close');
    const form = document.getElementById('quickViewForm');
    const alertDiv = document.getElementById('quickViewAlert');
    
    // Close modal when clicking the close button
    closeBtn.addEventListener('click', function() {
        closeModal();
    });
    
    // Close modal when clicking outside the content
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });
    
    // Close modal when pressing Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && modal.style.display === 'block') {
            closeModal();
        }
    });
    
    // Handle form submission
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const productId = document.getElementById('quickViewProductId').value;
        const quantity = document.getElementById('quickViewQuantity').value;
        
        // Send AJAX request to add to cart
        fetch('/add-to-cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('Product added to cart successfully!', 'success');
                // Update cart count if needed
                if (data.cartCount) {
                    updateCartCount(data.cartCount);
                }
            } else {
                showAlert(data.message || 'Failed to add product to cart.', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('An error occurred. Please try again.', 'danger');
        });
    });
    
    // Function to open the modal with product data
    window.openQuickView = function(productId) {
        // Show loading state
        modal.querySelector('.quick-view-body').style.opacity = '0.5';
        modal.style.display = 'block';
        
        // Fetch product data
        fetch(`/get-product-details.php?id=${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateModal(data.product);
                } else {
                    showAlert('Failed to load product details.', 'danger');
                    closeModal();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred while loading product details.', 'danger');
                closeModal();
            })
            .finally(() => {
                modal.querySelector('.quick-view-body').style.opacity = '1';
            });
    };
    
    // Function to populate modal with product data
    function populateModal(product) {
        document.getElementById('quickViewProductId').value = product.id;
        document.getElementById('quickViewImage').src = product.image_url;
        document.getElementById('quickViewTitle').textContent = product.name;
        document.getElementById('quickViewPrice').textContent = formatPrice(product.price);
        document.getElementById('quickViewDescription').textContent = product.description;
        document.getElementById('quickViewCategory').textContent = product.category;
        document.getElementById('quickViewStock').textContent = product.stock;
        document.getElementById('quickViewSku').textContent = product.sku;
        
        // Reset form
        document.getElementById('quickViewQuantity').value = 1;
        alertDiv.style.display = 'none';
    }
    
    // Function to close the modal
    function closeModal() {
        modal.style.display = 'none';
    }
    
    // Function to show alert messages
    function showAlert(message, type) {
        alertDiv.textContent = message;
        alertDiv.className = `alert alert-${type}`;
        alertDiv.style.display = 'block';
        
        // Auto-hide success alerts after 3 seconds
        if (type === 'success') {
            setTimeout(() => {
                alertDiv.style.display = 'none';
            }, 3000);
        }
    }
    
    // Function to format price
    function formatPrice(price) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(price);
    }
    
    // Function to update cart count in the header
    function updateCartCount(count) {
        const cartCountElement = document.querySelector('.cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = count;
        }
    }
}); 