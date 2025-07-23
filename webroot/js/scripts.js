/*!
 * Start Bootstrap - Business Frontpage v5.0.9 (https://startbootstrap.com/template/business-frontpage)
 * Copyright 2013-2023 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-business-frontpage/blob/master/LICENSE)
 */

document.addEventListener('DOMContentLoaded', function () {
    // Fade in the body to prevent FOUC
    document.body.classList.add('loaded');

    // Homepage navbar scroll behavior
    if (typeof IS_HOME !== 'undefined' && IS_HOME) {
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

    // Dropdown toggle behavior (desktop only)
    const dropdownToggles = document.querySelectorAll('.navbar-bottom .dropdown-toggle');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
            const navbar = document.querySelector('.navbar');
            navbar.classList.toggle('dropdown-open');
        });

        const dropdown = toggle.closest('.dropdown');
        if (dropdown) {
            dropdown.addEventListener('hidden.bs.dropdown', function () {
                const navbar = document.querySelector('.navbar');
                navbar.classList.remove('dropdown-open');
            });
        }
    });

    // Mobile full-screen menu toggle
    const toggleButton = document.querySelector('.menu-toggle');
    const menu = document.querySelector('.mobile-menu');

    if (toggleButton && menu) {
        const hamburgerIcon = toggleButton.querySelector('.hamburger-icon');
        const closeIcon = toggleButton.querySelector('.close-icon');

        toggleButton.addEventListener('click', function () {
            const isOpen = menu.classList.contains('open');

            if (isOpen) {
                // Close menu with animation
                menu.style.opacity = '0';
                setTimeout(() => {
                    menu.classList.remove('open');
                    menu.style.display = 'none';
                    hamburgerIcon.style.display = 'inline-block';
                    closeIcon.style.display = 'none';
                    document.body.classList.remove('menu-open');
                }, 300);
            } else {
                // Open menu with animation
                menu.classList.add('open');
                menu.style.display = 'block';
                hamburgerIcon.style.display = 'none';
                closeIcon.style.display = 'inline-block';
                document.body.classList.add('menu-open');
                
                // Trigger reflow to ensure animation works
                void menu.offsetWidth;
                
                // Fade in
                menu.style.opacity = '1';
            }
        });
        
        // Close menu when clicking on a link
        const menuLinks = menu.querySelectorAll('.nav-link, .nav-icon-login');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                menu.style.opacity = '0';
                setTimeout(() => {
                    menu.classList.remove('open');
                    menu.style.display = 'none';
                    hamburgerIcon.style.display = 'inline-block';
                    closeIcon.style.display = 'none';
                    document.body.classList.remove('menu-open');
                }, 300);
            });
        });
    }
});

$(document).ready(function() {
    // Search sidebar functions
    function openSearchSidebar() {
        $('#search-sidebar').addClass('active');
        $('#search-input').focus();
    }

    function closeSearchSidebar() {
        $('#search-sidebar').removeClass('active');
        $('#search-input').val('');
        $('#search-suggestions').empty();
        $('#search-results').empty();
    }

    // Toggle search sidebar (desktop and mobile)
    $('#search-toggle, #search-toggle-mobile').click(function(e) {
        e.preventDefault();
        openSearchSidebar();
    });

    $('#search-sidebar-close').click(function() {
        closeSearchSidebar();
    });

    // Autocomplete and search with debounce
    let debounceTimer;
    $('#search-input').on('input', function() {
        clearTimeout(debounceTimer);
        const query = $(this).val().trim();
        const searchResults = $('#search-results');
        const searchSuggestions = $('#search-suggestions');

        if (query.length < 2) {
            searchSuggestions.empty();
            searchResults.empty();
            return;
        }

        debounceTimer = setTimeout(() => {
            // Fetch autocomplete suggestions
            $.ajax({
                url: '/products/autocomplete',
                method: 'GET',
                data: { query: query },
                dataType: 'json',
                success: function(response) {
                    searchSuggestions.empty();
                    const suggestions = response.suggestions || [];
                    if (suggestions.length > 0) {
                        suggestions.forEach(suggestion => {
                            searchSuggestions.append(`<div class="suggestion-item">${suggestion}</div>`);
                        });
                    } else {
                        searchSuggestions.append('<div class="suggestion-item">No suggestions found</div>');
                    }
                },
                error: function(xhr) {
                    console.error('Autocomplete error: Status=' + xhr.status + ', Response=' + xhr.responseText);
                    searchSuggestions.html('<div class="suggestion-item">Error fetching suggestions</div>');
                }
            });

            // Fetch search results
            $.ajax({
                url: '/products/search',
                method: 'GET',
                data: { query: query },
                dataType: 'json',
                success: function(response) {
                    searchResults.empty();
                    console.log('Search response:', response);
                    if (response.products && response.products.length > 0) {
                        response.products.forEach(product => {
                            console.log('Fetching form for product:', product);
                            // Fetch the form via AJAX
                            $.ajax({
                                url: '/products/cart-form',
                                method: 'GET',
                                data: { product_id: product.id },
                                dataType: 'html',
                                success: function(formHtml) {
                                    const resultItem = `
                                        <div class="search-result">
                                            <div class="search-result-image">
                                                ${product.image ? `<img src="/img/${product.image}" alt="${product.name}">` : '<p>No image</p>'}
                                            </div>
                                            <div class="search-result-info">
                                                <h5>${product.name}</h5>
                                                <div class="price">$${parseFloat(product.price).toFixed(2)}</div>
                                                ${formHtml}
                                            </div>
                                        </div>`;
                                    searchResults.append(resultItem);
                                },
                                error: function(xhr) {
                                    console.error('Form fetch error for product ID ' + product.id + ': Status=' + xhr.status + ', Response=' + xhr.responseText);
                                    const resultItem = `
                                        <div class="search-result">
                                            <div class="search-result-image">
                                                ${product.image ? `<img src="/img/${product.image}" alt="${product.name}">` : '<p>No image</p>'}
                                            </div>
                                            <div class="search-result-info">
                                                <h5>${product.name}</h5>
                                                <div class="price">$${parseFloat(product.price).toFixed(2)}</div>
                                                <p>Unable to add to cart at this time (Error ${xhr.status}).</p>
                                            </div>
                                        </div>`;
                                    searchResults.append(resultItem);
                                }
                            });
                        });
                        openSearchSidebar();
                    } else {
                        searchResults.html('<p>No products found.</p>');
                        openSearchSidebar();
                    }
                },
                error: function(xhr) {
                    console.error('Search error: Status=' + xhr.status + ', Response=' + xhr.responseText);
                    searchResults.html('<p>Error fetching results. Please try again.</p>');
                    openSearchSidebar();
                }
            });
        }, 300);
    });

    // Handle suggestion click
    $(document).on('click', '.suggestion-item', function() {
        $('#search-input').val($(this).text());
        $('#search-input').trigger('input');
    });


});
