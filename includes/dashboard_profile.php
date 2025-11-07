<!-- Profile Management Layout -->
                <div id="profileLayout" class="settings-layout">
                    <div class="settings-content">
                        <div class="content-section">
                            <div class="section-header">
                                <h2 class="section-title">Personal Information</h2>
                                <p class="section-subtitle">Update your personal details and profile information.</p>
                            </div>

                            <!-- Profile Picture -->
                            <div class="form-section">
                                <h3>Profile Picture</h3>
                                <div class="profile-picture-upload">
                                    <div class="current-picture">
                                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200&auto=format&fit=crop" alt="Current Profile" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 2px solid #A1A69C;">
                                    </div>
                                    <div class="upload-controls">
                                        <input type="file" id="profileUpload" accept="image/*" style="display: none;">
                                        <button id="profileUploadBtn" class="btn btn-secondary">Upload New Picture</button>
                                        <button id="selectExistingBtn" class="btn btn-outline">Select Existing</button>
                                        <p style="color: #A1A69C; font-size: 12px; margin-top: 8px;">Recommended: 200x200px, JPG or PNG (Max 5MB)</p>
                                    </div>
                                </div>
                                
                                <!-- Available Images -->
                                <div id="availableImages" class="available-images" style="display: none; margin-top: 20px;">
                                    <h4>Available Profile Images</h4>
                                    <div id="imagesList" class="images-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px; margin-top: 10px;">
                                        <!-- Images will be loaded here -->
                                    </div>
                                </div>
                            </div>

                            <!-- Basic Information -->
                            <div class="form-section">
                                <h3>Basic Information</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" name="full_name" value="Jeroboam Oliveros">
                                    </div>
                                    <div class="form-group">
                                        <label>Display Name</label>
                                        <input type="text" name="display_name" value="Jerome">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Title/Profession</label>
                                        <input type="text" name="title" value="Developer • Photographer • Cosplayer">
                                    </div>
                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" name="location" value="Your City, Country">
                                    </div>
                                </div>
                            </div>

                            <!-- About Section -->
                            <div class="form-section">
                                <h3>About Me</h3>
                                <div class="form-group">
                                    <label>Bio/Description</label>
                                    <textarea rows="4" name="bio" placeholder="Tell people about yourself...">I craft clean, performant web experiences and tell stories through images and character work. With a background that blends software development, photography, and cosplay, I enjoy projects that balance technical depth with creative polish.</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Additional Info</label>
                                    <textarea rows="3" name="bio_secondary" placeholder="Additional details about yourself...">When I'm not shipping features, I'm experimenting with lighting setups, sewing details, or planning the next shoot.</textarea>
                                </div>
                            </div>
        
                            <!-- Skills & Tools -->
                            <div class="form-section">
                                <h3>Skills & Tools</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Skills (comma separated)</label>
                                        <input type="text" name="skills" value="HTML/CSS, JavaScript, PHP, jQuery, Responsive UI, Photography, Lighting, Cosplay Fabrication">
                                    </div>
                                    <div class="form-group">
                                        <label>Tools (comma separated)</label>
                                        <input type="text" name="tools" value="VS Code, Git, Figma, Lightroom, Photoshop">
                                    </div>
                                </div>
                            </div>
            
                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <button class="btn btn-secondary">Preview</button>
                                <button id="profile-save" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>

