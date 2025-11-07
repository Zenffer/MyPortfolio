                <!-- Content Management Header -->
                <div id="contentHeader" class="page-header">
                    <h1 class="page-title">Content Management</h1>
                    <p class="page-subtitle">Manage your portfolio pages and content.</p>
                </div>

                <!-- Profile Management Header -->
                <div id="profileHeader" class="page-header" style="display: none;">
                    <h1 class="page-title">Profile Management</h1>
                    <p class="page-subtitle">Manage your personal information and profile settings.</p>
                </div>

                <!-- Contact Management Header -->
                <div id="contactHeader" class="page-header" style="display: none;">
                    <h1 class="page-title">Contact Management</h1>
                    <p class="page-subtitle">Manage your contact information and social links.</p>
                </div>

                <!-- Content Management Layout -->
                <div id="contentLayout" class="settings-layout">
                    <!-- Content Navigation -->
                    <div class="settings-nav">
                        <a href="#" class="settings-nav-item active">
                            <i class="fas fa-th-large"></i>
                            <span>Projects</span>
                        </a>
                        <a href="#" class="settings-nav-item">
                            <i class="fas fa-camera"></i>
                            <span>Photography</span>
                        </a>
                        <a href="#" class="settings-nav-item" id="cosplayMenu">
                            <i class="fas fa-mask"></i>
                            <span>Cosplay</span>
                        </a>
                        <a href="#" class="settings-nav-item">
                            <i class="fas fa-quote-left"></i>
                            <span>Kind Words</span>
                        </a>
                    </div>

                    <!-- Content Management Area -->
                    <div class="settings-content" id="contentArea">
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
                                        <input type="text" value="Projects">
                                    </div>
                                    <div class="form-group">
                                        <label>Page Description</label>
                                        <input type="text" value="A showcase of my recent development work and creative projects.">
                                    </div>
                                </div>
                            </div>

                            <!-- Hero Section -->
                            <div class="form-section">
                                <h3>Hero Section</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Hero Title</label>
                                        <input type="text" value="Hi, I'm Jerome.">
                                    </div>
                                    <div class="form-group">
                                        <label>Hero Subtitle</label>
                                        <input type="text" value="Developer, Photographer & Cosplayer.">
                                    </div>
                                </div>
                            </div>

                            <!-- Projects Grid -->
                            <div class="form-section">
                                <h3>Projects Grid</h3>
                                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;">
                                    <div style="background: #08090D; border: 1px solid #A1A69C; border-radius: 8px; padding: 16px; text-align: center;">
                                        <div style="width: 100%; height: 120px; background: #292c3a; border-radius: 4px; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; color: #A1A69C;">
                                            <i class="fas fa-image" style="font-size: 24px;"></i>
                                        </div>
                                        <h4 style="color: #fff; margin-bottom: 4px;">Project 1</h4>
                                        <p style="color: #A1A69C; font-size: 12px;">Description</p>
                                        <div style="margin-top: 8px;">
                                            <button class="btn btn-primary" style="padding: 4px 8px; font-size: 12px;">Edit</button>
                                        </div>
                                    </div>
                                    <div style="background: #08090D; border: 1px solid #A1A69C; border-radius: 8px; padding: 16px; text-align: center;">
                                        <div style="width: 100%; height: 120px; background: #292c3a; border-radius: 4px; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; color: #A1A69C;">
                                            <i class="fas fa-image" style="font-size: 24px;"></i>
                                        </div>
                                        <h4 style="color: #fff; margin-bottom: 4px;">Project 2</h4>
                                        <p style="color: #A1A69C; font-size: 12px;">Description</p>
                                        <div style="margin-top: 8px;">
                                            <button class="btn btn-primary" style="padding: 4px 8px; font-size: 12px;">Edit</button>
                                        </div>
                                    </div>
                                    <div style="background: #08090D; border: 1px solid #A1A69C; border-radius: 8px; padding: 16px; text-align: center;">
                                        <div style="width: 100%; height: 120px; background: #292c3a; border-radius: 4px; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; color: #A1A69C;">
                                            <i class="fas fa-plus" style="font-size: 24px;"></i>
                                        </div>
                                        <h4 style="color: #fff; margin-bottom: 4px;">Add Project</h4>
                                        <p style="color: #A1A69C; font-size: 12px;">Click to add new</p>
                                        <div style="margin-top: 8px;">
                                            <button class="btn btn-primary" style="padding: 4px 8px; font-size: 12px;">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <button class="btn btn-secondary">Preview</button>
                                <button class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>

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
                                        <input type="text" value="Photography">
                                    </div>
                                    <div class="form-group">
                                        <label>Page Description</label>
                                        <input type="text" value="A selection of my favorite shots. More coming soon.">
                                    </div>
                                </div>
                            </div>

                            <!-- Hero Section -->
                            <div class="form-section">
                                <h3>Hero Section</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Hero Title</label>
                                        <input type="text" value="Hi, I'm Jerome.">
                                    </div>
                                    <div class="form-group">
                                        <label>Hero Subtitle</label>
                                        <input type="text" value="Developer, Photographer & Cosplayer.">
                                    </div>
                                </div>
                            </div>

                            <!-- Photography Gallery -->
                            <div class="form-section">
                                <h3>Photography Gallery</h3>
                                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;">
                                    <div style="background: #08090D; border: 1px solid #A1A69C; border-radius: 8px; padding: 16px; text-align: center;">
                                        <div style="width: 100%; height: 120px; background: #292c3a; border-radius: 4px; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; color: #A1A69C; background-image: url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=200&auto=format&fit=crop'); background-size: cover; background-position: center;">
                                        </div>
                                        <h4 style="color: #fff; margin-bottom: 4px;">Mountain Sunrise</h4>
                                        <p style="color: #A1A69C; font-size: 12px;">Captured during golden hour</p>
                                        <div style="margin-top: 8px;">
                                            <button class="btn btn-primary" style="padding: 4px 8px; font-size: 12px;">Edit</button>
                                        </div>
                                    </div>
                                    <div style="background: #08090D; border: 1px solid #A1A69C; border-radius: 8px; padding: 16px; text-align: center;">
                                        <div style="width: 100%; height: 120px; background: #292c3a; border-radius: 4px; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; color: #A1A69C; background-image: url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=200&auto=format&fit=crop'); background-size: cover; background-position: center;">
                                        </div>
                                        <h4 style="color: #fff; margin-bottom: 4px;">Misty Forest</h4>
                                        <p style="color: #A1A69C; font-size: 12px;">Early morning fog</p>
                                        <div style="margin-top: 8px;">
                                            <button class="btn btn-primary" style="padding: 4px 8px; font-size: 12px;">Edit</button>
                                        </div>
                                    </div>
                                    <div style="background: #08090D; border: 1px solid #A1A69C; border-radius: 8px; padding: 16px; text-align: center;">
                                        <div style="width: 100%; height: 120px; background: #292c3a; border-radius: 4px; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; color: #A1A69C; background-image: url('https://images.unsplash.com/photo-1526336024174-e58f5cdd8e13?q=80&w=200&auto=format&fit=crop'); background-size: cover; background-position: center;">
                                        </div>
                                        <h4 style="color: #fff; margin-bottom: 4px;">Urban Twilight</h4>
                                        <p style="color: #A1A69C; font-size: 12px;">City lights at dusk</p>
                                        <div style="margin-top: 8px;">
                                            <button class="btn btn-primary" style="padding: 4px 8px; font-size: 12px;">Edit</button>
                                        </div>
                                    </div>
                                    <div style="background: #08090D; border: 1px solid #A1A69C; border-radius: 8px; padding: 16px; text-align: center;">
                                        <div style="width: 100%; height: 120px; background: #292c3a; border-radius: 4px; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; color: #A1A69C;">
                                            <i class="fas fa-plus" style="font-size: 24px;"></i>
                                        </div>
                                        <h4 style="color: #fff; margin-bottom: 4px;">Add Photo</h4>
                                        <p style="color: #A1A69C; font-size: 12px;">Upload new image</p>
                                        <div style="margin-top: 8px;">
                                            <button class="btn btn-primary" style="padding: 4px 8px; font-size: 12px;">Upload</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <button class="btn btn-secondary">Preview</button>
                                <button class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>

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
                                        <input type="text" value="Cosplay">
                                    </div>
                                    <div class="form-group">
                                        <label>Page Description</label>
                                        <input type="text" value="A selection of my favorite cosplays. More coming soon.">
                                    </div>
                                </div>
                            </div>

                            <!-- Hero Section -->
                            <div class="form-section">
                                <h3>Hero Section</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Hero Title</label>
                                        <input type="text" value="Hi, I'm Jerome.">
                                    </div>
                                    <div class="form-group">
                                        <label>Hero Subtitle</label>
                                        <input type="text" value="Developer, Photographer & Cosplayer.">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Cosplay Gallery -->
                            <div class="form-section">
                                <h3>Cosplay Gallery</h3>
                                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;">
                                    <div style="background: #08090D; border: 1px solid #A1A69C; border-radius: 8px; padding: 16px; text-align: center;">
                                        <div style="width: 100%; height: 120px; background: #292c3a; border-radius: 4px; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; color: #A1A69C; background-image: url('https://images.unsplash.com/photo-1519125323398-675f0ddb6308?q=80&w=200&auto=format&fit=crop'); background-size: cover; background-position: center;">
                                        </div>
                                        <h4 style="color: #fff; margin-bottom: 4px;">Cosplay 1</h4>
                                        <p style="color: #A1A69C; font-size: 12px;">Description</p>
                                        <div style="margin-top: 8px;">
                                            <button class="btn btn-primary" style="padding: 4px 8px; font-size: 12px;">Edit</button>
                                        </div>
                                    </div>
                                    <div style="background: #08090D; border: 1px solid #A1A69C; border-radius: 8px; padding: 16px; text-align: center;">
                                        <div style="width: 100%; height: 120px; background: #292c3a; border-radius: 4px; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; color: #A1A69C; background-image: url('https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?q=80&w=200&auto=format&fit=crop'); background-size: cover; background-position: center;">
                                        </div>
                                        <h4 style="color: #fff; margin-bottom: 4px;">Cosplay 2</h4>
                                        <p style="color: #A1A69C; font-size: 12px;">Description</p>
                                        <div style="margin-top: 8px;">
                                            <button class="btn btn-primary" style="padding: 4px 8px; font-size: 12px;">Edit</button>
                                        </div>
                                    </div>
                                    <div style="background: #08090D; border: 1px solid #A1A69C; border-radius: 8px; padding: 16px; text-align: center;">
                                        <div style="width: 100%; height: 120px; background: #292c3a; border-radius: 4px; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; color: #A1A69C;">
                                            <i class="fas fa-plus" style="font-size: 24px;"></i>
                                        </div>
                                        <h4 style="color: #fff; margin-bottom: 4px;">Add Cosplay</h4>
                                        <p style="color: #A1A69C; font-size: 12px;">Upload new cosplay</p>
                                        <div style="margin-top: 8px;">
                                            <button class="btn btn-primary" style="padding: 4px 8px; font-size: 12px;">Upload</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <button class="btn btn-secondary">Preview</button>
                                <button class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                        
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
            
                            <!-- Action Buttons moved to Page Content above -->
                        </div>
                    </div>
                </div>

