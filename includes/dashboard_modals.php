    <!-- Testimonial Modal -->
    <div id="testimonialModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h2 id="tm-title">Add Testimonial</h2>
            <div class="form-group">
                <label for="tm-name">Name</label>
                <input type="text" id="tm-name" />
            </div>
            <div class="form-group">
                <label for="tm-role">Role (optional)</label>
                <input type="text" id="tm-role" />
            </div>
            <div class="form-group">
                <label for="tm-quote">Quote</label>
                <textarea id="tm-quote" rows="3"></textarea>
            </div>
            <div class="modal-buttons">
                <button id="tm-save" class="btn">Save</button>
                <button id="tm-cancel" class="btn ghost">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Project Modal -->
    <div id="projectModal" class="modal" style="display: none !important;">
        <div class="modal-content">
            <h2 id="pm-title">Add Project</h2>
            <form id="project-form" method="post" action="#">
                <div class="form-group">
                    <label for="pm-title-input">Project Title *</label>
                    <input type="text" id="pm-title-input" name="title" required />
                </div>
                <div class="form-group">
                    <label for="pm-description">Description</label>
                    <textarea id="pm-description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="pm-image-url">Image URL *</label>
                    <input type="text" id="pm-image-url" name="image_url" placeholder="https://images.unsplash.com/photo-..." required />
                    <p style="color: #A1A69C; font-size: 12px; margin-top: 4px;">Enter a full image URL or upload a file below</p>
                </div>
                <div class="form-group">
                    <label for="pm-image-file">Or Upload Image File</label>
                    <input type="file" id="pm-image-file" name="image_file" accept="image/*" />
                    <p style="color: #A1A69C; font-size: 12px; margin-top: 4px;">JPG, PNG, WebP, or GIF (Max 10MB)</p>
                    <div id="pm-image-upload-status" style="margin-top: 8px; display: none;">
                        <p style="color: #A1A69C; font-size: 14px;"><span id="pm-upload-message"></span></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="pm-alt-text">Alt Text (optional)</label>
                    <input type="text" id="pm-alt-text" name="alt_text" placeholder="Description of the image" />
                </div>
                <input type="hidden" id="pm-image-path" name="image_path" />
                <input type="hidden" id="pm-project-id" name="project_id" />
                <div class="modal-buttons">
                    <button type="submit" id="pm-save" class="btn btn-primary">Save</button>
                    <button type="button" id="pm-cancel" class="btn ghost">Cancel</button>
                </div>
            </form>
        </div>
    </div>

