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

    <!-- Photography Modal -->
    <div id="photographyModal" class="modal" style="display: none !important;">
        <div class="modal-content" style="max-width: 700px; max-height: 90vh; overflow-y: auto;">
            <h2 id="phm-title">Add Photo</h2>
            <form id="photography-form" method="post" action="#">
                <div class="form-group">
                    <label for="phm-title-input">Photo Title *</label>
                    <input type="text" id="phm-title-input" name="title" required />
                </div>
                <div class="form-group">
                    <label for="phm-description">Description</label>
                    <textarea id="phm-description" name="description" rows="3"></textarea>
                </div>
                
                <!-- Thumbnail Image Section -->
                <div class="form-section" style="margin-bottom: 24px; padding: 16px; background: #08090D; border: 1px solid #A1A69C; border-radius: 8px;">
                    <h3 style="margin-top: 0; color: #fff; font-size: 16px; margin-bottom: 12px;">Thumbnail Image *</h3>
                    <p style="color: #A1A69C; font-size: 12px; margin-bottom: 12px;">This is the main image displayed on the photography listing page</p>
                    <div class="form-group">
                        <label for="phm-image-url">Image URL</label>
                        <input type="text" id="phm-image-url" name="image_url" placeholder="https://images.unsplash.com/photo-..." />
                        <p style="color: #A1A69C; font-size: 12px; margin-top: 4px;">Enter a full image URL or upload a file below</p>
                    </div>
                    <div class="form-group">
                        <label for="phm-image-file">Or Upload Image File</label>
                        <input type="file" id="phm-image-file" name="image_file" accept="image/*" />
                        <p style="color: #A1A69C; font-size: 12px; margin-top: 4px;">JPG, PNG, WebP, or GIF (Max 10MB)</p>
                        <div id="phm-image-upload-status" style="margin-top: 8px; display: none;">
                            <p style="color: #A1A69C; font-size: 14px;"><span id="phm-upload-message"></span></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phm-alt-text">Alt Text (optional)</label>
                        <input type="text" id="phm-alt-text" name="alt_text" placeholder="Description of the thumbnail image" />
                    </div>
                    <div id="phm-thumbnail-preview" style="margin-top: 12px; display: none;">
                        <img id="phm-thumbnail-preview-img" src="" alt="Thumbnail preview" style="max-width: 100%; max-height: 200px; border-radius: 4px; border: 1px solid #A1A69C;" />
                    </div>
                </div>
                
                <!-- Grid Images Section -->
                <div class="form-section" style="margin-bottom: 24px; padding: 16px; background: #08090D; border: 1px solid #A1A69C; border-radius: 8px;">
                    <h3 style="margin-top: 0; color: #fff; font-size: 16px; margin-bottom: 12px;">Photo Gallery Images (Optional)</h3>
                    <p style="color: #A1A69C; font-size: 12px; margin-bottom: 16px;">These images will be displayed on the photo detail page in a hierarchical grid. Images are uploaded immediately when selected.</p>
                    
                    <!-- Google Forms Style Upload Area -->
                    <div id="phm-grid-upload-area" style="border: 2px dashed #A1A69C; border-radius: 8px; padding: 40px 20px; text-align: center; background: #292c3a; cursor: pointer; transition: all 0.3s; margin-bottom: 16px;" onmouseover="this.style.borderColor='#fff'; this.style.background='#1a1d24';" onmouseout="this.style.borderColor='#A1A69C'; this.style.background='#292c3a';">
                        <input type="file" id="phm-grid-images" name="grid_images" accept="image/*" multiple style="display: none;" />
                        <div id="phm-grid-upload-content">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #A1A69C; margin-bottom: 16px; display: block;"></i>
                            <p style="color: #fff; font-size: 16px; margin: 0 0 8px 0; font-weight: 600;">Click to upload or drag and drop</p>
                            <p style="color: #A1A69C; font-size: 12px; margin: 0;">JPG, PNG, WebP, or GIF (Max 10MB each)</p>
                            <p style="color: #A1A69C; font-size: 12px; margin: 8px 0 0 0;">You can select multiple files</p>
                        </div>
                        <div id="phm-grid-upload-progress" style="display: none;">
                            <i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #A1A69C; margin-bottom: 12px;"></i>
                            <p style="color: #A1A69C; font-size: 14px; margin: 0;">Uploading images...</p>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="phm-grid-size">Default Grid Size</label>
                        <select id="phm-grid-size" style="width: 100%; padding: 8px; background: #292c3a; border: 1px solid #A1A69C; border-radius: 4px; color: #fff;">
                            <option value="small">Small (3 columns)</option>
                            <option value="medium" selected>Medium (4 columns)</option>
                            <option value="large">Large (6 columns)</option>
                        </select>
                        <p style="color: #A1A69C; font-size: 12px; margin-top: 4px;">Applied to newly uploaded images</p>
                    </div>
                    
                    <!-- Uploaded Images Grid -->
                    <div id="phm-uploaded-images-section" style="margin-top: 20px; display: none;">
                        <h4 style="color: #fff; font-size: 14px; margin-bottom: 12px;">Uploaded Images (<span id="phm-uploaded-count">0</span>)</h4>
                        <div id="phm-uploaded-images-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 12px; max-height: 300px; overflow-y: auto; padding: 8px; background: #292c3a; border-radius: 4px;">
                            <!-- Uploaded images will appear here -->
                        </div>
                    </div>
                    
                    <div id="phm-grid-upload-status" style="margin-top: 12px; display: none;">
                        <p style="color: #A1A69C; font-size: 14px;"><span id="phm-grid-upload-message"></span></p>
                    </div>
                </div>
                
                <input type="hidden" id="phm-image-path" name="image_path" />
                <input type="hidden" id="phm-photo-id" name="photo_id" />
                <div class="modal-buttons">
                    <button type="submit" id="phm-save" class="btn btn-primary">Save Photo</button>
                    <button type="button" id="phm-cancel" class="btn ghost">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cosplay Modal -->
    <div id="cosplayModal" class="modal" style="display: none !important;">
        <div class="modal-content" style="max-width: 700px; max-height: 90vh; overflow-y: auto;">
            <h2 id="cm-title">Add Cosplay</h2>
            <form id="cosplay-form" method="post" action="#">
                <div class="form-group">
                    <label for="cm-title-input">Cosplay Title *</label>
                    <input type="text" id="cm-title-input" name="title" required />
                </div>
                <div class="form-group">
                    <label for="cm-description">Description</label>
                    <textarea id="cm-description" name="description" rows="3"></textarea>
                </div>
                
                <!-- Thumbnail Image Section -->
                <div class="form-section" style="margin-bottom: 24px; padding: 16px; background: #08090D; border: 1px solid #A1A69C; border-radius: 8px;">
                    <h3 style="margin-top: 0; color: #fff; font-size: 16px; margin-bottom: 12px;">Thumbnail Image *</h3>
                    <p style="color: #A1A69C; font-size: 12px; margin-bottom: 12px;">This is the main image displayed on the cosplay listing page</p>
                    <div class="form-group">
                        <label for="cm-image-url">Image URL</label>
                        <input type="text" id="cm-image-url" name="image_url" placeholder="https://images.unsplash.com/photo-..." />
                        <p style="color: #A1A69C; font-size: 12px; margin-top: 4px;">Enter a full image URL or upload a file below</p>
                    </div>
                    <div class="form-group">
                        <label for="cm-image-file">Or Upload Image File</label>
                        <input type="file" id="cm-image-file" name="image_file" accept="image/*" />
                        <p style="color: #A1A69C; font-size: 12px; margin-top: 4px;">JPG, PNG, WebP, or GIF (Max 10MB)</p>
                        <div id="cm-image-upload-status" style="margin-top: 8px; display: none;">
                            <p style="color: #A1A69C; font-size: 14px;"><span id="cm-upload-message"></span></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cm-alt-text">Alt Text (optional)</label>
                        <input type="text" id="cm-alt-text" name="alt_text" placeholder="Description of the thumbnail image" />
                    </div>
                    <div id="cm-thumbnail-preview" style="margin-top: 12px; display: none;">
                        <img id="cm-thumbnail-preview-img" src="" alt="Thumbnail preview" style="max-width: 100%; max-height: 200px; border-radius: 4px; border: 1px solid #A1A69C;" />
                    </div>
                </div>
                
                <!-- Grid Images Section -->
                <div class="form-section" style="margin-bottom: 24px; padding: 16px; background: #08090D; border: 1px solid #A1A69C; border-radius: 8px;">
                    <h3 style="margin-top: 0; color: #fff; font-size: 16px; margin-bottom: 12px;">Cosplay Gallery Images (Optional)</h3>
                    <p style="color: #A1A69C; font-size: 12px; margin-bottom: 16px;">These images will be displayed on the cosplay detail page in a hierarchical grid. Images are uploaded immediately when selected.</p>
                    
                    <!-- Google Forms Style Upload Area -->
                    <div id="cm-grid-upload-area" style="border: 2px dashed #A1A69C; border-radius: 8px; padding: 40px 20px; text-align: center; background: #292c3a; cursor: pointer; transition: all 0.3s; margin-bottom: 16px;" onmouseover="this.style.borderColor='#fff'; this.style.background='#1a1d24';" onmouseout="this.style.borderColor='#A1A69C'; this.style.background='#292c3a';">
                        <input type="file" id="cm-grid-images" name="grid_images" accept="image/*" multiple style="display: none;" />
                        <div id="cm-grid-upload-content">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #A1A69C; margin-bottom: 16px; display: block;"></i>
                            <p style="color: #fff; font-size: 16px; margin: 0 0 8px 0; font-weight: 600;">Click to upload or drag and drop</p>
                            <p style="color: #A1A69C; font-size: 12px; margin: 0;">JPG, PNG, WebP, or GIF (Max 10MB each)</p>
                            <p style="color: #A1A69C; font-size: 12px; margin: 8px 0 0 0;">You can select multiple files</p>
                        </div>
                        <div id="cm-grid-upload-progress" style="display: none;">
                            <i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #A1A69C; margin-bottom: 12px;"></i>
                            <p style="color: #A1A69C; font-size: 14px; margin: 0;">Uploading images...</p>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="cm-grid-size">Default Grid Size</label>
                        <select id="cm-grid-size" style="width: 100%; padding: 8px; background: #292c3a; border: 1px solid #A1A69C; border-radius: 4px; color: #fff;">
                            <option value="small">Small (3 columns)</option>
                            <option value="medium" selected>Medium (4 columns)</option>
                            <option value="large">Large (6 columns)</option>
                        </select>
                        <p style="color: #A1A69C; font-size: 12px; margin-top: 4px;">Applied to newly uploaded images</p>
                    </div>
                    
                    <!-- Uploaded Images Grid -->
                    <div id="cm-uploaded-images-section" style="margin-top: 20px; display: none;">
                        <h4 style="color: #fff; font-size: 14px; margin-bottom: 12px;">Uploaded Images (<span id="cm-uploaded-count">0</span>)</h4>
                        <div id="cm-uploaded-images-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 12px; max-height: 300px; overflow-y: auto; padding: 8px; background: #292c3a; border-radius: 4px;">
                            <!-- Uploaded images will appear here -->
                        </div>
                    </div>
                    
                    <div id="cm-grid-upload-status" style="margin-top: 12px; display: none;">
                        <p style="color: #A1A69C; font-size: 14px;"><span id="cm-grid-upload-message"></span></p>
                    </div>
                </div>
                
                <input type="hidden" id="cm-image-path" name="image_path" />
                <input type="hidden" id="cm-cosplay-id" name="cosplay_id" />
                <div class="modal-buttons">
                    <button type="submit" id="cm-save" class="btn btn-primary">Save Cosplay</button>
                    <button type="button" id="cm-cancel" class="btn ghost">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Project Modal -->
    <div id="projectModal" class="modal" style="display: none !important;">
        <div class="modal-content" style="max-width: 700px; max-height: 90vh; overflow-y: auto;">
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
                
                <!-- Thumbnail Image Section -->
                <div class="form-section" style="margin-bottom: 24px; padding: 16px; background: #08090D; border: 1px solid #A1A69C; border-radius: 8px;">
                    <h3 style="margin-top: 0; color: #fff; font-size: 16px; margin-bottom: 12px;">Thumbnail Image *</h3>
                    <p style="color: #A1A69C; font-size: 12px; margin-bottom: 12px;">This is the main image displayed on the projects listing page</p>
                    <div class="form-group">
                        <label for="pm-image-url">Image URL</label>
                        <input type="text" id="pm-image-url" name="image_url" placeholder="https://images.unsplash.com/photo-..." />
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
                        <input type="text" id="pm-alt-text" name="alt_text" placeholder="Description of the thumbnail image" />
                    </div>
                    <div id="pm-thumbnail-preview" style="margin-top: 12px; display: none;">
                        <img id="pm-thumbnail-preview-img" src="" alt="Thumbnail preview" style="max-width: 100%; max-height: 200px; border-radius: 4px; border: 1px solid #A1A69C;" />
                    </div>
                </div>
                
                <!-- Grid Images Section -->
                <div class="form-section" style="margin-bottom: 24px; padding: 16px; background: #08090D; border: 1px solid #A1A69C; border-radius: 8px;">
                    <h3 style="margin-top: 0; color: #fff; font-size: 16px; margin-bottom: 12px;">Project Gallery Images (Optional)</h3>
                    <p style="color: #A1A69C; font-size: 12px; margin-bottom: 16px;">These images will be displayed on the project detail page in a hierarchical grid. Images are uploaded immediately when selected.</p>
                    
                    <!-- Google Forms Style Upload Area -->
                    <div id="pm-grid-upload-area" style="border: 2px dashed #A1A69C; border-radius: 8px; padding: 40px 20px; text-align: center; background: #292c3a; cursor: pointer; transition: all 0.3s; margin-bottom: 16px;" onmouseover="this.style.borderColor='#fff'; this.style.background='#1a1d24';" onmouseout="this.style.borderColor='#A1A69C'; this.style.background='#292c3a';">
                        <input type="file" id="pm-grid-images" name="grid_images" accept="image/*" multiple style="display: none;" />
                        <div id="pm-grid-upload-content">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #A1A69C; margin-bottom: 16px; display: block;"></i>
                            <p style="color: #fff; font-size: 16px; margin: 0 0 8px 0; font-weight: 600;">Click to upload or drag and drop</p>
                            <p style="color: #A1A69C; font-size: 12px; margin: 0;">JPG, PNG, WebP, or GIF (Max 10MB each)</p>
                            <p style="color: #A1A69C; font-size: 12px; margin: 8px 0 0 0;">You can select multiple files</p>
                        </div>
                        <div id="pm-grid-upload-progress" style="display: none;">
                            <i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #A1A69C; margin-bottom: 12px;"></i>
                            <p style="color: #A1A69C; font-size: 14px; margin: 0;">Uploading images...</p>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="pm-grid-size">Default Grid Size</label>
                        <select id="pm-grid-size" style="width: 100%; padding: 8px; background: #292c3a; border: 1px solid #A1A69C; border-radius: 4px; color: #fff;">
                            <option value="small">Small (3 columns)</option>
                            <option value="medium" selected>Medium (4 columns)</option>
                            <option value="large">Large (6 columns)</option>
                        </select>
                        <p style="color: #A1A69C; font-size: 12px; margin-top: 4px;">Applied to newly uploaded images</p>
                    </div>
                    
                    <!-- Uploaded Images Grid -->
                    <div id="pm-uploaded-images-section" style="margin-top: 20px; display: none;">
                        <h4 style="color: #fff; font-size: 14px; margin-bottom: 12px;">Uploaded Images (<span id="pm-uploaded-count">0</span>)</h4>
                        <div id="pm-uploaded-images-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 12px; max-height: 300px; overflow-y: auto; padding: 8px; background: #292c3a; border-radius: 4px;">
                            <!-- Uploaded images will appear here -->
                        </div>
                    </div>
                    
                    <div id="pm-grid-upload-status" style="margin-top: 12px; display: none;">
                        <p style="color: #A1A69C; font-size: 14px;"><span id="pm-grid-upload-message"></span></p>
                    </div>
                </div>
                
                <input type="hidden" id="pm-image-path" name="image_path" />
                <input type="hidden" id="pm-project-id" name="project_id" />
                <div class="modal-buttons">
                    <button type="submit" id="pm-save" class="btn btn-primary">Save Project</button>
                    <button type="button" id="pm-cancel" class="btn ghost">Cancel</button>
                </div>
            </form>
        </div>
    </div>

