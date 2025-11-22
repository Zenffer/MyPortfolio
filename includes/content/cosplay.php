<!-- Cosplay Management -->
<div id="cosplayContent" class="content-section" style="display: none;">
    <div class="section-header">
        <h2 class="section-title">Cosplay Management</h2>
        <p class="section-subtitle">Manage your cosplay showcase content and images.</p>
    </div>

    <!-- Page Content -->
    <div class="form-section">
        <h3>Page Content</h3>
        <div class="form-row">
            <div class="form-group">
                <label>Page Title</label>
                <input id="cosplay-page-title" type="text" value="Cosplay">
            </div>
            <div class="form-group">
                <label>Page Description</label>
                <input id="cosplay-page-description" type="text" value="Selected costumes and characters from recent events and shoots.">
            </div>
        </div>
        <div class="action-buttons" style="margin-top: 16px;">
            <button id="cosplay-preview" class="btn btn-secondary">Preview</button>
            <button id="cosplay-save-page" class="btn btn-primary">Save Page Content</button>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="form-section">
        <h3>Hero Section</h3>
        <div class="form-row">
            <div class="form-group">
                <label>Hero Title</label>
                <input id="cosplay-hero-title" type="text" value="Hi, I'm Zenffer">
            </div>
            <div class="form-group">
                <label>Hero Subtitle</label>
                <input id="cosplay-hero-subtitle" type="text" value="Your friendly neighborhood cosplayer.">
            </div>
        </div>
        <div class="action-buttons" style="margin-top: 16px;">
            <button id="cosplay-save-hero" class="btn btn-primary">Save Hero Content</button>
        </div>
    </div>

    <!-- Cosplay Grid -->
    <div class="form-section">
        <h3>Cosplay Grid</h3>
        <div style="display: flex; gap: 8px; margin-bottom: 16px;">
            <button id="btnAddCosplay" class="btn btn-primary" onclick="openCosplayModal('create', null); return false;">Add Cosplay</button>
        </div>
        <div id="dashboard-cosplay" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;">
            <!-- Cosplay will be loaded here -->
        </div>
    </div>
</div>

<script>
// Auto-load cosplay when this section becomes visible
(function() {
    // Use MutationObserver to detect when section becomes visible
    const cosplaySection = document.getElementById('cosplayContent');
    const cosplayContainer = document.getElementById('dashboard-cosplay');
    
    if (cosplaySection && cosplayContainer) {
        // Check if section is visible on load
        const observer = new MutationObserver(function(mutations) {
            const isVisible = cosplaySection.style.display !== 'none' && 
                            window.getComputedStyle(cosplaySection).display !== 'none';
            
            if (isVisible && (!cosplayContainer.innerHTML || cosplayContainer.innerHTML.trim() === '' || cosplayContainer.innerHTML.includes('<!-- Cosplay will be loaded here -->'))) {
                if (typeof loadDashboardCosplay === 'function') {
                    loadDashboardCosplay();
                }
            }
        });
        
        // Observe changes to display style
        observer.observe(cosplaySection, {
            attributes: true,
            attributeFilter: ['style']
        });
        
        // Also check on initial load
        if (window.getComputedStyle(cosplaySection).display !== 'none') {
            setTimeout(function() {
                if (typeof loadDashboardCosplay === 'function') {
                    loadDashboardCosplay();
                }
            }, 300);
        }
    }
})();
</script>
