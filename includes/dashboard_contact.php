                <!-- Contact Management Layout -->
                <div id="contactLayout" class="settings-layout" style="display: none;">
                    <div class="settings-content">
                        <div class="content-section">
                            <div class="section-header">
                                <h2 class="section-title">Contact Information</h2>
                                <p class="section-subtitle">Manage your contact details and social media links.</p>
                            </div>
            
                            <!-- Contact Details -->
                            <div class="form-section">
                                <h3>Contact Details</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" id="contact-email" name="contact_email" value="hello@example.com">
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="tel" id="contact-phone" name="contact_phone" value="+1 (555) 123-4567">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" id="contact-location" name="contact_location" value="Your City, Country">
                                    </div>
                                    <div class="form-group">
                                        <label>Website</label>
                                        <input type="url" id="contact-website" name="contact_website" value="https://yourwebsite.com">
                                    </div>
                                </div>
                            </div>

                            <!-- Social Media -->
                            <div class="form-section">
                                <h3>Social Media Links</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>LinkedIn</label>
                                        <input type="url" id="contact-linkedin" name="contact_linkedin" value="https://www.linkedin.com/in/yourprofile">
                                    </div>
                                    <div class="form-group">
                                        <label>Instagram</label>
                                        <input type="url" id="contact-instagram" name="contact_instagram" value="https://www.instagram.com/yourprofile">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Twitter/X</label>
                                        <input type="url" id="contact-twitter" name="contact_twitter" value="https://twitter.com/yourprofile">
                                    </div>
                                    <div class="form-group">
                                        <label>GitHub</label>
                                        <input type="url" id="contact-github" name="contact_github" value="https://github.com/yourprofile">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Behance</label>
                                        <input type="url" id="contact-behance" name="contact_behance" value="https://www.behance.net/yourprofile">
                                    </div>
                                    <div class="form-group">
                                        <label>Dribbble</label>
                                        <input type="url" id="contact-dribbble" name="contact_dribbble" value="https://dribbble.com/yourprofile">
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <button class="btn btn-secondary">Preview</button>
                                <button id="contact-save" class="btn btn-primary">Save Changes</button>
                            </div>

                            <!-- Contact Messages -->
                            <div class="form-section">
                                <h3>Contact Messages</h3>
                                <div id="contactMessagesContainer" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;"></div>
                                <div id="contactMessagesPagination" style="margin-top: 12px; display: flex; gap: 8px; align-items: center;">
                                    <button id="cmPrev" class="btn btn-secondary">Prev</button>
                                    <span id="cmPageInfo" style="color:#A1A69C; font-size: 14px;">Page 1</span>
                                    <button id="cmNext" class="btn btn-secondary">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

