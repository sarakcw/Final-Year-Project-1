document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.admin-sidebar');
    const toggleButton = document.getElementById('toggleSidebar');
    const mainContent = document.querySelector('.admin-main');

    // Toggle sidebar on button click
    toggleButton.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
    });

    // Handle responsive design
    function handleResponsive() {
        if (window.innerWidth <= 768) {
            sidebar.classList.add('collapsed');
        } else {
            sidebar.classList.remove('collapsed');
        }
    }

    // Initial check
    handleResponsive();

    // Add event listener for window resize
    window.addEventListener('resize', handleResponsive);

    // Add active class to current menu item
    const currentPath = window.location.pathname;
    const menuItems = document.querySelectorAll('.sidebar-menu a');

    menuItems.forEach(item => {
        const href = item.getAttribute('href');
        if (currentPath.includes(href)) {
            item.classList.add('active');
        }
    });
}); 