// Document ready handlers and event listeners
$(document).ready(function(){
    // Initialize: Show content section by default, hide profile and contact
    showMainSection('content');
    
    // Load testimonials initially for content tab
    loadDashboardTestimonials();
    
    // Top hamburger menu - opens sidebar
    $('#nav-icon3-top, #nav-icon3-mobile').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        
        // Fade effect on click
        $(this).find('.menu-icon').fadeOut(100, function() {
            $(this).fadeIn(100);
        });
        
        // Open the sidebar
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        sidebar.classList.add('open');
        mainContent.classList.add('sidebar-open');
    });
    
    // Sidebar hamburger menu - closes sidebar
    $('#nav-icon3').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        
        // Fade effect on click
        $(this).find('.close-icon').fadeOut(100, function() {
            $(this).fadeIn(100);
        });
        
        // Close the sidebar
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        sidebar.classList.remove('open');
        mainContent.classList.remove('sidebar-open');
    });

    // Add click event listeners to content navigation
    $('.settings-nav-item').click(function(e) {
        e.preventDefault();
        const contentType = $(this).find('span').text().toLowerCase().replace(/\s+/g, '');
        showContent(contentType);
    });

    // Projects Management: Add Project button
    $('#contentArea').on('click', '#btnAddProject', function(e){
        e.preventDefault();
        console.log('Add Project button clicked');
        if (typeof openProjectModal === 'function') {
            openProjectModal('create', null);
        } else {
            console.error('openProjectModal function not found!');
            alert('Error: Project modal function not loaded. Please refresh the page.');
        }
    });

    // Projects Page Content: load on ready
    loadProjectsPageContent();

    // Save Projects Page Content
    $('#contentArea').on('click', '#projects-save-page', function(e){
        e.preventDefault();
        const title = $('#projects-page-title').val().trim();
        const desc = $('#projects-page-description').val().trim();
        Promise.all([
            savePageContent('index', 'projects_title', title),
            savePageContent('index', 'projects_description', desc)
        ]).then(results => {
            const ok = results.every(r => r && r.ok);
            if (ok) {
                alert('Saved');
            } else {
                alert('Failed to save');
            }
        }).catch(()=>alert('Failed to save'));
    });

    // Save Projects Hero Content
    $('#contentArea').on('click', '#projects-save-hero', function(e){
        e.preventDefault();
        const heroTitle = $('#projects-hero-title').val().trim();
        const heroSubtitle = $('#projects-hero-subtitle').val().trim();
        Promise.all([
            savePageContent('index', 'hero_title', heroTitle),
            savePageContent('index', 'hero_subtitle', heroSubtitle)
        ]).then(results => {
            const ok = results.every(r => r && r.ok);
            if (ok) {
                alert('Saved');
            } else {
                alert('Failed to save');
            }
        }).catch(()=>alert('Failed to save'));
    });

    // Preview (open public page in new tab)
    $('#contentArea').on('click', '#projects-preview', function(e){
        e.preventDefault();
        window.open('index.php', '_blank');
    });

    // Cosplay submenu toggle
    $('#cosplayMenu').click(function(e){
        e.preventDefault();
        $('#cosplaySubmenu').slideToggle(150);
        $(this).toggleClass('open');
    });

    // Add Testimonial button -> open modal
    $('#contentArea').on('click', '#btnAddTestimonial', function(e){
        e.preventDefault();
        openTestimonialModal('create');
    });

    // Kind Words Page Content: load on ready
    loadKindWordsPageContent();

    // Save Page Content
    $('#contentArea').on('click', '#kw-save', function(e){
        e.preventDefault();
        const title = $('#kw-page-title').val().trim();
        const desc = $('#kw-page-desc').val().trim();
        Promise.all([
            savePageContent('kind-words', 'page_title', title),
            savePageContent('kind-words', 'page_description', desc)
        ]).then(results => {
            const ok = results.every(r => r && r.ok);
            if (ok) {
                alert('Saved');
            } else {
                alert('Failed to save');
            }
        }).catch(()=>alert('Failed to save'));
    });

    // Preview (open public page in new tab)
    $('#contentArea').on('click', '#kw-preview', function(e){
        e.preventDefault();
        window.open('kind-words.php', '_blank');
    });

    // ================= PROFILE MANAGEMENT =================
    loadProfileSettings();

    // Contact messages controls
    $('#contactLayout').on('click', '#cmPrev', function(e){ 
        e.preventDefault(); 
        changeContactMessagesPage(-1); 
    });
    $('#contactLayout').on('click', '#cmNext', function(e){ 
        e.preventDefault(); 
        changeContactMessagesPage(1); 
    });
    $('#contactLayout').on('click', '.cm-delete', function(e){
        e.preventDefault();
        const id = Number(this.getAttribute('data-id'));
        if (!id) return;
        if (!confirm('Delete this message?')) return;
        fetch('api/admin/contact_messages.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'same-origin',
            body: JSON.stringify({ action: 'delete', id })
        }).then(r=>r.json()).then(resp=>{
            if (resp && resp.ok) {
                loadContactMessages(window.__cmPage || 1);
            } else {
                alert('Failed to delete message');
            }
        }).catch(()=>alert('Failed to delete message'));
    });

    // Upload new image
    $('#profileLayout').on('click', '#profileUploadBtn', function(e){
        e.preventDefault();
        uploadProfileImage();
    });

    // Show/hide available images
    $('#profileLayout').on('click', '#selectExistingBtn', function(e){
        e.preventDefault();
        const availableImages = document.getElementById('availableImages');
        if (availableImages.style.display === 'none') {
            loadAvailableImages();
            availableImages.style.display = 'block';
        } else {
            availableImages.style.display = 'none';
        }
    });

    // Profile save
    $('#profileLayout').on('click', '#profile-save', function(e){
        e.preventDefault();
        const q = sel => document.querySelector('#profileLayout ' + sel);
        const updates = {
            owner_name: (q('input[name="full_name"]')?.value || '').trim(),
            display_name: (q('input[name="display_name"]')?.value || '').trim(),
            owner_title: (q('input[name="title"]')?.value || '').trim(),
            location: (q('input[name="location"]')?.value || '').trim(),
            bio: (q('textarea[name="bio"]')?.value || '').trim(),
            bio_secondary: (q('textarea[name="bio_secondary"]')?.value || '').trim(),
            skills: (q('input[name="skills"]')?.value || '').trim(),
            tools: (q('input[name="tools"]')?.value || '').trim()
        };
        if (!updates.owner_name) { alert('Full Name is required'); return; }
        saveSettings(updates).then(ok => alert(ok ? 'Saved' : 'Failed to save'));
    });

    // Contact save
    $('#contactLayout').on('click', '#contact-save', function(e){
        e.preventDefault();
        const updates = {
            contact_email: document.getElementById('contact-email').value.trim(),
            contact_phone: document.getElementById('contact-phone').value.trim(),
            contact_location: document.getElementById('contact-location').value.trim(),
            contact_website: document.getElementById('contact-website').value.trim(),
            contact_linkedin: document.getElementById('contact-linkedin').value.trim(),
            contact_instagram: document.getElementById('contact-instagram').value.trim(),
            contact_twitter: document.getElementById('contact-twitter').value.trim(),
            contact_github: document.getElementById('contact-github').value.trim(),
            contact_behance: document.getElementById('contact-behance').value.trim(),
            contact_dribbble: document.getElementById('contact-dribbble').value.trim()
        };
        fetch('api/admin/settings.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'same-origin',
            body: JSON.stringify({ updates })
        }).then(r=>r.json()).then(resp=>{
            alert(resp && resp.ok ? 'Saved!' : 'Failed to save');
        }).catch(()=>alert('Failed to save'));
    });
});

