<!-- Projects Management -->
<div id="projectsContent" class="content-section">
    <div class="section-header">
        <h2 class="section-title">Projects Management</h2>
        <p class="section-subtitle">Manage your projects showcase content and images.</p>
    </div>

    <!-- Page Content -->
    <div class="form-section">
        <h3>Page Content</h3>
        <div class="form-row">
            <div class="form-group">
                <label>Page Title</label>
                <input id="projects-page-title" type="text" value="Projects">
            </div>
            <div class="form-group">
                <label>Page Description</label>
                <input id="projects-page-description" type="text" value="A showcase of my recent development work and creative projects.">
            </div>
        </div>
        <div class="action-buttons" style="margin-top: 16px;">
            <button id="projects-preview" class="btn btn-secondary">Preview</button>
            <button id="projects-save-page" class="btn btn-primary">Save Page Content</button>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="form-section">
        <h3>Hero Section</h3>
        <div class="form-row">
            <div class="form-group">
                <label>Hero Title</label>
                <input id="projects-hero-title" type="text" value="Hi, I'm Jerome.">
            </div>
            <div class="form-group">
                <label>Hero Subtitle</label>
                <input id="projects-hero-subtitle" type="text" value="Developer, Photographer & Cosplayer.">
            </div>
        </div>
        <div class="action-buttons" style="margin-top: 16px;">
            <button id="projects-save-hero" class="btn btn-primary">Save Hero Content</button>
        </div>
    </div>

    <!-- Projects Grid -->
    <div class="form-section">
        <h3>Projects Grid</h3>
        <div style="display: flex; gap: 8px; margin-bottom: 16px;">
            <button id="btnAddProject" class="btn btn-primary" onclick="openProjectModal('create', null); return false;">Add Project</button>
        </div>
        <div id="dashboard-projects" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;">
            <!-- Projects will be loaded here -->
        </div>
    </div>
</div>

<script>
// Auto-load projects when this section becomes visible
(function() {
    // Use MutationObserver to detect when section becomes visible
    const projectsSection = document.getElementById('projectsContent');
    const projectsContainer = document.getElementById('dashboard-projects');
    
    if (projectsSection && projectsContainer) {
        // Check if section is visible on load
        const observer = new MutationObserver(function(mutations) {
            const isVisible = projectsSection.style.display !== 'none' && 
                            window.getComputedStyle(projectsSection).display !== 'none';
            
            if (isVisible && (!projectsContainer.innerHTML || projectsContainer.innerHTML.trim() === '' || projectsContainer.innerHTML.includes('<!-- Projects will be loaded here -->'))) {
                if (typeof loadDashboardProjects === 'function') {
                    loadDashboardProjects();
                }
            }
        });
        
        // Observe changes to display style
        observer.observe(projectsSection, {
            attributes: true,
            attributeFilter: ['style']
        });
        
        // Also check on initial load
        if (window.getComputedStyle(projectsSection).display !== 'none') {
            setTimeout(function() {
                if (typeof loadDashboardProjects === 'function') {
                    loadDashboardProjects();
                }
            }, 300);
        }
    }
})();
</script>

