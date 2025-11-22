<!-- Kind Words Management -->
<div id="kindwordsContent" class="content-section" style="display: none;">
    <div class="section-header">
        <h2 class="section-title">Kind Words Management</h2>
        <p class="section-subtitle">Manage testimonials and feedback from clients or friends.</p>
    </div>

    <!-- Page Content -->
    <div class="form-section" id="kw-page-content">
        <h3>Page Content</h3>
        <div class="form-row">
            <div class="form-group">
                <label>Page Title</label>
                <input id="kw-page-title" type="text" value="Kind Words">
            </div>
            <div class="form-group">
                <label>Page Description</label>
                <input id="kw-page-desc" type="text" value="Some lovely words from people I've worked with.">
            </div>
        </div>
        <div class="action-buttons" style="margin-top: 8px;">
            <button id="kw-preview" class="btn btn-secondary">Preview</button>
            <button id="kw-save" class="btn btn-primary">Save Changes</button>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="form-section">
        <h3>Testimonials</h3>
        <div style="display:flex; gap:8px; margin-bottom:12px;">
            <button id="btnAddTestimonial" class="btn btn-primary">Add Testimonial</button>
        </div>
        <div id="dashboard-testimonials" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 16px; margin-bottom: 16px;"></div>
    </div>
</div>

