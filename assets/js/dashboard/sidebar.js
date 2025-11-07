// Function to toggle sidebar visibility
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const hamburger = document.getElementById('nav-icon3');
    
    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('sidebar-collapsed');
    hamburger.classList.toggle('open');
}

// Mobile sidebar toggle functionality
function toggleMobileSidebar() {
    const sidebar = document.getElementById('sidebar');
    const hamburger = document.getElementById('nav-icon3');
    sidebar.classList.toggle('open');
    hamburger.classList.toggle('open');
}

// Close mobile sidebar when clicking outside
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const hamburger = document.getElementById('nav-icon3');
    const isClickInsideSidebar = sidebar.contains(event.target);
    const isMobileMenuButton = event.target.closest('#nav-icon3');
    
    if (!isClickInsideSidebar && !isMobileMenuButton && window.innerWidth <= 768) {
        sidebar.classList.remove('open');
        hamburger.classList.remove('open');
    }
});

