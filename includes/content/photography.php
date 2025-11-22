<!-- Photography Management -->
<div id="photographyContent" class="content-section" style="display: none;">
    <div class="section-header">
        <h2 class="section-title">Photography Management</h2>
        <p class="section-subtitle">Manage your photography gallery and content.</p>
    </div>

    <!-- Page Content -->
    <div class="form-section">
        <h3>Page Content</h3>
        <div class="form-row">
            <div class="form-group">
                <label>Page Title</label>
                <input id="photography-page-title" type="text" value="Photography">
            </div>
            <div class="form-group">
                <label>Page Description</label>
                <input id="photography-page-description" type="text" value="A selection of my favorite shots. More coming soon.">
            </div>
        </div>
        <div class="action-buttons" style="margin-top: 16px;">
            <button id="photography-preview" class="btn btn-secondary">Preview</button>
            <button id="photography-save-page" class="btn btn-primary">Save Page Content</button>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="form-section">
        <h3>Hero Section</h3>
        <div class="form-row">
            <div class="form-group">
                <label>Hero Title</label>
                <input id="photography-hero-title" type="text" value="Hi, I'm Jerome.">
            </div>
            <div class="form-group">
                <label>Hero Subtitle</label>
                <input id="photography-hero-subtitle" type="text" value="Developer, Photographer & Cosplayer.">
            </div>
        </div>
        <div class="action-buttons" style="margin-top: 16px;">
            <button id="photography-save-hero" class="btn btn-primary">Save Hero Content</button>
        </div>
    </div>

    <!-- Photography Gallery -->
    <div class="form-section">
        <h3>Photography Gallery</h3>
        <div style="display: flex; gap: 8px; margin-bottom: 16px;">
            <button id="btnAddPhotography" class="btn btn-primary">Add Photo</button>
        </div>
        <div id="dashboard-photography" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;"></div>
    </div>
</div>

