// Main section switching logic
function showMainSection(sectionType) {
    // Hide all headers
    document.getElementById('contentHeader').style.display = 'none';
    document.getElementById('profileHeader').style.display = 'none';
    document.getElementById('contactHeader').style.display = 'none';

    // Hide all layouts
    document.getElementById('contentLayout').style.display = 'none';
    document.getElementById('profileLayout').style.display = 'none';
    document.getElementById('contactLayout').style.display = 'none';

    // Remove active class from all nav items
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.classList.remove('active');
    });

    // Show selected section
    switch(sectionType) {
        case 'content':
            document.getElementById('contentHeader').style.display = 'block';
            document.getElementById('contentLayout').style.display = 'block';
            break;
        case 'profile':
            document.getElementById('profileHeader').style.display = 'block';
            document.getElementById('profileLayout').style.display = 'block';
            break;
        case 'contact':
            document.getElementById('contactHeader').style.display = 'block';
            document.getElementById('contactLayout').style.display = 'block';
            loadContactSettings();
            break;
    }

    // Add active class to clicked nav item
    if (event && event.target) {
        const navItem = event.target.closest('.nav-item');
        if (navItem) {
            navItem.classList.add('active');
        }
    }

    // If content section is shown, also ensure testimonials are loaded
    if (sectionType === 'content') {
        loadDashboardTestimonials();
    }
    if (sectionType === 'contact') {
        loadContactMessages(1);
    }
}

// Content type switching functionality
function showContent(contentType) {
    // Hide all content sections
    const contentSections = document.querySelectorAll('.content-section');
    contentSections.forEach(section => {
        section.style.display = 'none';
    });

    // Remove active class from all nav items
    const navItems = document.querySelectorAll('.settings-nav-item');
    navItems.forEach(item => {
        item.classList.remove('active');
    });

    // Show selected content
    const selectedContent = document.getElementById(contentType + 'Content');
    if (selectedContent) {
        selectedContent.style.display = 'block';
    }

    // Add active class to clicked nav item
    if (event && event.target) {
        const navItem = event.target.closest('.settings-nav-item');
        if (navItem) {
            navItem.classList.add('active');
        }
    }
}

