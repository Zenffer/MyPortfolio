<!-- Cosplay Management -->
<div id="cosplayContent" class="content-section" style="display: none;">
    <div class="section-header">
        <h2 class="section-title">Cosplay Management</h2>
        <p class="section-subtitle">Manage your cosplay gallery and content.</p>
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
                <input id="cosplay-page-description" type="text" value="A selection of my favorite cosplays. More coming soon.">
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
                <input id="cosplay-hero-title" type="text" value="Hi, I'm Jerome.">
            </div>
            <div class="form-group">
                <label>Hero Subtitle</label>
                <input id="cosplay-hero-subtitle" type="text" value="Developer, Photographer & Cosplayer.">
            </div>
        </div>
        <div class="action-buttons" style="margin-top: 16px;">
            <button id="cosplay-save-hero" class="btn btn-primary">Save Hero Content</button>
        </div>
    </div>
    
    <!-- Cosplay Gallery -->
    <div class="form-section">
        <h3>Cosplay Gallery</h3>
        <div style="display: flex; gap: 8px; margin-bottom: 16px;">
            <button id="btnAddCosplay" class="btn btn-primary">Add Cosplay</button>
        </div>
        <div id="dashboard-cosplay" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;"></div>
    </div>
</div>

