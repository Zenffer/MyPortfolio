<?php
session_start();
require_once 'db.php';

// Check if user is authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: login.php');
    exit();
}

// Database configuration
$db_config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'portfolio_db',
    'charset' => 'utf8mb4'
];

// Initialize database if needed
initializeDatabase($db_config);
$pdo = getDatabaseConnection($db_config);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portfolio Dashboard">
    <title>Dashboard • My Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard-layout">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="user-details">
                        <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
                        <p>Portfolio Owner</p>
                    </div>
                </div>
                <div id="nav-icon3" class="toggle-sidebar">
                    <img src="assets/js/icons/closeIcon.svg" alt="Close" class="close-icon">
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <a href="#" class="nav-item active" onclick="showMainSection('content')">
                    <i class="fas fa-edit"></i>
                    <span>Content Management</span>
                </a>
                <a href="#" class="nav-item" onclick="showMainSection('profile')">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="#" class="nav-item" onclick="showMainSection('contact')">
                    <i class="fas fa-envelope"></i>
                    <span>Contact</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <a href="logout.php" class="nav-item logout-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="top-bar-left">
                    <div id="nav-icon3-top" class="top-hamburger">
                        <img src="assets/js/icons/menuIcon.svg" alt="Menu" class="menu-icon">
                    </div>
                    <div id="nav-icon3-mobile" class="mobile-hamburger">
                        <img src="assets/js/icons/menuIcon.svg" alt="Menu" class="menu-icon">
                    </div>
                </div>
                <div class="top-bar-actions">
                    <div class="user-menu">
                        <div class="user-menu-avatar">
                            <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                        </div>
                        <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="content-area">
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
                            <i class="fas fa-chevron-down" style="margin-left: 8px;"></i>
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

                <!-- Profile Management Layout -->
                <div id="profileLayout" class="settings-layout" style="display: none;">
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
            </div>
        </div>
    </div>

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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const hamburger = document.getElementById('nav-icon3');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('sidebar-collapsed');
            hamburger.classList.toggle('open');
        }

        // Modal helpers for Add/Edit testimonial
        function openTestimonialModal(mode, data){
            const modal = document.getElementById('testimonialModal');
            const title = document.getElementById('tm-title');
            const nameEl = document.getElementById('tm-name');
            const roleEl = document.getElementById('tm-role');
            const quoteEl = document.getElementById('tm-quote');
            const saveBtn = document.getElementById('tm-save');
            const cancelBtn = document.getElementById('tm-cancel');

            title.textContent = mode === 'edit' ? 'Edit Testimonial' : 'Add Testimonial';
            nameEl.value = (data && data.name) ? data.name : '';
            roleEl.value = (data && data.role) ? data.role : '';
            quoteEl.value = (data && data.quote) ? data.quote : '';

            modal.style.display = 'flex';

            const onCancel = () => { modal.style.display = 'none'; cleanup(); };
            const onSave = () => {
                const payload = {
                    action: mode === 'edit' ? 'update' : 'create',
                    id: data ? data.id : undefined,
                    name: nameEl.value.trim(),
                    role: roleEl.value.trim(),
                    quote: quoteEl.value.trim()
                };
                if (!payload.name || !payload.quote) { alert('Name and quote are required'); return; }
                fetch('api/admin/testimonials.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    credentials: 'same-origin',
                    body: JSON.stringify(payload)
                }).then(r=>r.json()).then(resp=>{
                    if (resp && resp.ok) {
                        modal.style.display = 'none';
                        cleanup();
                        loadDashboardTestimonials();
                    } else {
                        alert('Failed to save testimonial');
                    }
                }).catch(()=>alert('Failed to save testimonial'));
            };

            cancelBtn.addEventListener('click', onCancel);
            saveBtn.addEventListener('click', onSave);
            modal.addEventListener('click', function(e){ if (e.target === modal) onCancel(); });

            function cleanup(){
                cancelBtn.removeEventListener('click', onCancel);
                saveBtn.removeEventListener('click', onSave);
            }
        }

        // Mobile sidebar toggle
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const hamburger = document.getElementById('nav-icon3');
            sidebar.classList.toggle('open');
            hamburger.classList.toggle('open');
        }

        // Close mobile sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const hamburger = document.getElementById('nav-icon3');
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isMobileMenuButton = event.target.closest('#nav-icon3');
            
            if (!isClickInsideSidebar && !isMobileMenuButton && window.innerWidth <= 768) {
                sidebar.classList.remove('open');
                hamburger.classList.remove('open');
            }
        });

        // Main section switching functionality
        function showMainSection(sectionType) {
            // Hide all headers
            document.getElementById('contentHeader').style.display = 'none';
            document.getElementById('profileHeader').style.display = 'none';
            document.getElementById('contactHeader').style.display = 'none';

            // Hide all layouts
            document.getElementById('contentLayout').style.display = 'none';
            document.getElementById('profileLayout').style.display = 'none';
            document.getElementById('contactLayout').style.display = 'none';

            // Remove active class from all nav items
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.classList.remove('active');
            });

            // Show selected section
            switch(sectionType) {
                case 'content':
                    document.getElementById('contentHeader').style.display = 'block';
                    document.getElementById('contentLayout').style.display = 'block';
                    break;
                case 'profile':
                    document.getElementById('profileHeader').style.display = 'block';
                    document.getElementById('profileLayout').style.display = 'block';
                    break;
                case 'contact':
                    document.getElementById('contactHeader').style.display = 'block';
                    document.getElementById('contactLayout').style.display = 'block';
                    loadContactSettings(); // <-- Add this line
                    break;
            }

            // Add active class to clicked nav item
            event.target.closest('.nav-item').classList.add('active');

            // If content section is shown, also ensure testimonials are loaded
            if (sectionType === 'content') {
                loadDashboardTestimonials();
            }
            if (sectionType === 'contact') {
                loadContactMessages(1);
            }
        }

        // Content switching functionality
        function showContent(contentType) {
            // Hide all content sections
            const contentSections = document.querySelectorAll('.content-section');
            contentSections.forEach(section => {
                section.style.display = 'none';
            });

            // Remove active class from all nav items
            const navItems = document.querySelectorAll('.settings-nav-item');
            navItems.forEach(item => {
                item.classList.remove('active');
            });

            // Show selected content
            const selectedContent = document.getElementById(contentType + 'Content');
            if (selectedContent) {
                selectedContent.style.display = 'block';
            }

            // Add active class to clicked nav item
            event.target.closest('.settings-nav-item').classList.add('active');
        }

        // jQuery for hamburger menu - this will handle the click
        $(document).ready(function(){
            // Load testimonials initially for content tab
            loadDashboardTestimonials();
            // Top hamburger menu - opens sidebar
            $('#nav-icon3-top, #nav-icon3-mobile').click(function(e){
                e.preventDefault();
                e.stopPropagation();
                
                // Fade effect on click
                $(this).find('.menu-icon').fadeOut(100, function() {
                    $(this).fadeIn(100);
                });
                
                // Open the sidebar
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('mainContent');
                
                sidebar.classList.add('open');
                mainContent.classList.add('sidebar-open');
            });
            
            // Sidebar hamburger menu - closes sidebar
            $('#nav-icon3').click(function(e){
                e.preventDefault();
                e.stopPropagation();
                
                // Fade effect on click
                $(this).find('.close-icon').fadeOut(100, function() {
                    $(this).fadeIn(100);
                });
                
                // Close the sidebar
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('mainContent');
                
                sidebar.classList.remove('open');
                mainContent.classList.remove('sidebar-open');
            });

            // Add click event listeners to content navigation
            $('.settings-nav-item').click(function(e) {
                e.preventDefault();
                const contentType = $(this).find('span').text().toLowerCase().replace(' ', '');
                showContent(contentType);
            });

            // Cosplay submenu toggle
            $('#cosplayMenu').click(function(e){
                e.preventDefault();
                $('#cosplaySubmenu').slideToggle(150);
                $(this).toggleClass('open');
            });

            // Add Testimonial button -> open modal
            $('#contentArea').on('click', '#btnAddTestimonial', function(e){
                e.preventDefault();
                openTestimonialModal('create');
            });

            // Kind Words Page Content: load on ready
            loadKindWordsPageContent();

            // Save Page Content
            $('#contentArea').on('click', '#kw-save', function(e){
                e.preventDefault();
                const title = $('#kw-page-title').val().trim();
                const desc = $('#kw-page-desc').val().trim();
                Promise.all([
                    savePageContent('kind-words', 'page_title', title),
                    savePageContent('kind-words', 'page_description', desc)
                ]).then(results => {
                    const ok = results.every(r => r && r.ok);
                    if (ok) {
                        alert('Saved');
                    } else {
                        alert('Failed to save');
                    }
                }).catch(()=>alert('Failed to save'));
            });

            // Preview (open public page in new tab)
            $('#contentArea').on('click', '#kw-preview', function(e){
                e.preventDefault();
                window.open('kind-words.php', '_blank');
            });

            // ================= PROFILE MANAGEMENT =================
            loadProfileSettings();

            // Contact messages controls
            $('#contactLayout').on('click', '#cmPrev', function(e){ e.preventDefault(); changeContactMessagesPage(-1); });
            $('#contactLayout').on('click', '#cmNext', function(e){ e.preventDefault(); changeContactMessagesPage(1); });
            $('#contactLayout').on('click', '.cm-delete', function(e){
                e.preventDefault();
                const id = Number(this.getAttribute('data-id'));
                if (!id) return;
                if (!confirm('Delete this message?')) return;
                fetch('api/admin/contact_messages.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    credentials: 'same-origin',
                    body: JSON.stringify({ action: 'delete', id })
                }).then(r=>r.json()).then(resp=>{
                    if (resp && resp.ok) {
                        loadContactMessages(window.__cmPage || 1);
                    } else {
                        alert('Failed to delete message');
                    }
                }).catch(()=>alert('Failed to delete message'));
            });

            // Upload new image (using test function)
            $('#profileLayout').on('click', '#profileUploadBtn', function(e){
                e.preventDefault();
                console.log('Upload button clicked - using test function');
                testUploadFunction();
            });

            // Show/hide available images
            $('#profileLayout').on('click', '#selectExistingBtn', function(e){
                e.preventDefault();
                const availableImages = document.getElementById('availableImages');
                if (availableImages.style.display === 'none') {
                    loadAvailableImages();
                    availableImages.style.display = 'block';
                } else {
                    availableImages.style.display = 'none';
                }
            });


            $('#profileLayout').on('click', '#profile-save', function(e){
                e.preventDefault();
                const q = sel => document.querySelector('#profileLayout ' + sel);
                const updates = {
                    owner_name: (q('input[name="full_name"]')?.value || '').trim(),
                    display_name: (q('input[name="display_name"]')?.value || '').trim(),
                    owner_title: (q('input[name="title"]')?.value || '').trim(),
                    location: (q('input[name="location"]')?.value || '').trim(),
                    bio: (q('textarea[name="bio"]')?.value || '').trim(),
                    bio_secondary: (q('textarea[name="bio_secondary"]')?.value || '').trim(),
                    skills: (q('input[name="skills"]')?.value || '').trim(),
                    tools: (q('input[name="tools"]')?.value || '').trim()
                };
                if (!updates.owner_name) { alert('Full Name is required'); return; }
                saveSettings(updates).then(ok => alert(ok ? 'Saved' : 'Failed to save'));
            });
        });

        // Fetch testimonials into dashboard cards
        function loadDashboardTestimonials(){
            const container = document.getElementById('dashboard-testimonials');
            if (!container) return;
            container.innerHTML = '<div style="background: #08090D; border: 1px solid #A1A69C; border-radius: 8px; padding: 16px;"><p style="color:#A1A69C; font-size:14px;">Loading testimonials…</p></div>';

            fetch('api/testimonials.php', { credentials: 'same-origin' })
              .then(r => r.json())
              .then(json => {
                  container.innerHTML = '';
                  if (!json || !json.ok || !Array.isArray(json.data) || json.data.length === 0) {
                      container.innerHTML = '<div style="background:#08090D; border:1px solid #A1A69C; border-radius:8px; padding:16px;"><p style="color:#A1A69C; font-size:14px;">No testimonials yet.</p></div>';
                      return;
                  }
                  json.data.forEach(item => {
                      const card = document.createElement('div');
                      card.className = 'dashboard-testimonial-card';
                      card.style.background = '#08090D';
                      card.style.border = '1px solid #A1A69C';
                      card.style.borderRadius = '8px';
                      card.style.padding = '16px';
                      card.innerHTML = `
                        <p style="color:#A1A69C; font-size:14px; margin-bottom:8px;">${escapeHtml(item.quote)}</p>
                        <div style="display:flex; align-items:center;">
                            <div style="width:32px; height:32px; background:#292c3a; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#A1A69C; margin-right:8px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <span style="color:#fff; font-size:13px;">${escapeHtml(item.name)}${item.role ? ' • ' + escapeHtml(item.role) : ''}</span>
                        </div>
                        <div style="margin-top:8px; display:flex; gap:8px;">
                            <button class="btn btn-primary btn-edit-testimonial" style="padding: 4px 8px; font-size: 12px;" data-id="${item.id}">Edit</button>
                            <button class="btn btn-secondary btn-delete-testimonial" style="padding: 4px 8px; font-size: 12px;" data-id="${item.id}">Delete</button>
                        </div>
                      `;
                      container.appendChild(card);
                  });

                  // Bind edit/delete actions
                  container.querySelectorAll('.btn-edit-testimonial').forEach(btn => {
                      btn.addEventListener('click', function(){
                          const id = Number(this.getAttribute('data-id'));
                          const card = this.closest('.dashboard-testimonial-card');
                          if (!card) return;
                          const quoteEl = card.querySelector('p');
                          const nameSpan = card.querySelector('span');
                          const currentText = quoteEl ? quoteEl.textContent : '';
                          const nameRoleText = nameSpan ? nameSpan.textContent : '';
                          const parts = nameRoleText.split(' • ');
                          const currentName = parts[0] || '';
                          const currentRole = parts[1] || '';
                          openTestimonialModal('edit', { id, name: currentName, role: currentRole, quote: currentText });
                      });
                  });

                  container.querySelectorAll('.btn-delete-testimonial').forEach(btn => {
                      btn.addEventListener('click', function(){
                          const id = Number(this.getAttribute('data-id'));
                          if (!confirm('Delete this testimonial?')) return;
                          fetch('api/admin/testimonials.php', {
                              method: 'POST',
                              headers: { 'Content-Type': 'application/json' },
                              credentials: 'same-origin',
                              body: JSON.stringify({ action: 'delete', id })
                          }).then(r=>r.json()).then(resp=>{
                              if (resp && resp.ok) {
                                  loadDashboardTestimonials();
                              } else {
                                  alert('Failed to delete testimonial');
                              }
                          }).catch(()=>alert('Failed to delete testimonial'));
                      });
                  });
              })
              .catch(() => {
                  container.innerHTML = '<div style="background:#08090D; border:1px solid #A1A69C; border-radius:8px; padding:16px;"><p style="color:#A1A69C; font-size:14px;">Failed to load testimonials.</p></div>';
              });

            function escapeHtml(str){
              if (str == null) return '';
              return String(str)
                .replace(/&/g,'&amp;')
                .replace(/</g,'&lt;')
                .replace(/>/g,'&gt;')
                .replace(/"/g,'&quot;')
                .replace(/'/g,'&#039;');
            }
        }

        // Load Kind Words page content values
        function loadKindWordsPageContent(){
            fetch('api/admin/page_content.php?page=kind-words&section=page_title', { credentials: 'same-origin' })
              .then(r=>r.json()).then(j=>{ if (j && j.ok && j.content != null) { const el=document.getElementById('kw-page-title'); if (el) el.value = j.content; } });
            fetch('api/admin/page_content.php?page=kind-words&section=page_description', { credentials: 'same-origin' })
              .then(r=>r.json()).then(j=>{ if (j && j.ok && j.content != null) { const el=document.getElementById('kw-page-desc'); if (el) el.value = j.content; } });
        }

        // Save page content helper
        function savePageContent(page, section, content){
            return fetch('api/admin/page_content.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ page, section, content })
            }).then(r=>r.json()).catch(()=>({ ok:false }));
        }

        // ===== Profile helpers =====
        function loadProfileSettings(){
            fetch('api/admin/settings.php?keys=owner_name,display_name,owner_title,location,bio,bio_secondary,skills,tools,profile_image', { credentials: 'same-origin' })
              .then(r=>r.json()).then(resp=>{
                  if (!resp || !resp.ok) return;
                  const d = resp.data || {};
                  const q = sel => document.querySelector('#profileLayout ' + sel);
                  if (q('input[name="full_name"]')) q('input[name="full_name"]').value = d.owner_name || '';
                  if (q('input[name="display_name"]')) q('input[name="display_name"]').value = (d.display_name || d.owner_name || '');
                  if (q('input[name="title"]')) q('input[name="title"]').value = d.owner_title || '';
                  if (q('input[name="location"]')) q('input[name="location"]').value = d.location || '';
                  if (q('textarea[name="bio"]')) q('textarea[name="bio"]').value = d.bio || '';
                  if (q('textarea[name="bio_secondary"]')) q('textarea[name="bio_secondary"]').value = d.bio_secondary || '';
                  if (q('input[name="skills"]')) q('input[name="skills"]').value = d.skills || '';
                  if (q('input[name="tools"]')) q('input[name="tools"]').value = d.tools || '';
                  const img = document.querySelector('#profileLayout .current-picture img');
                  if (img && d.profile_image) img.src = d.profile_image;
              });
        }

        function saveSettings(updates){
            return fetch('api/admin/settings.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ updates })
            }).then(r=>r.json()).then(resp=>!!(resp && resp.ok)).catch(()=>false);
        }

        // Escape helper used in multiple renderers
        function escapeHtml(str){
          if (str == null) return '';
          return String(str)
            .replace(/&/g,'&amp;')
            .replace(/</g,'&lt;')
            .replace(/>/g,'&gt;')
            .replace(/"/g,'&quot;')
            .replace(/'/g,'&#039;');
        }

        // ===== Contact Management: Load and Save =====
        function loadContactSettings() {
    fetch('api/admin/settings.php?keys=contact_email,contact_phone,contact_location,contact_website,contact_linkedin,contact_instagram,contact_twitter,contact_github,contact_behance,contact_dribbble', { credentials: 'same-origin' })
      .then(r=>r.json()).then(resp=>{
        if (!resp || !resp.ok) return;
        const d = resp.data || {};
        document.getElementById('contact-email').value = d.contact_email || '';
        document.getElementById('contact-phone').value = d.contact_phone || '';
        document.getElementById('contact-location').value = d.contact_location || '';
        document.getElementById('contact-website').value = d.contact_website || '';
        document.getElementById('contact-linkedin').value = d.contact_linkedin || '';
        document.getElementById('contact-instagram').value = d.contact_instagram || '';
        document.getElementById('contact-twitter').value = d.contact_twitter || '';
        document.getElementById('contact-github').value = d.contact_github || '';
        document.getElementById('contact-behance').value = d.contact_behance || '';
        document.getElementById('contact-dribbble').value = d.contact_dribbble || '';
      });
}

$('#contactLayout').on('click', '#contact-save', function(e){
    e.preventDefault();
    const updates = {
        contact_email: document.getElementById('contact-email').value.trim(),
        contact_phone: document.getElementById('contact-phone').value.trim(),
        contact_location: document.getElementById('contact-location').value.trim(),
        contact_website: document.getElementById('contact-website').value.trim(),
        contact_linkedin: document.getElementById('contact-linkedin').value.trim(),
        contact_instagram: document.getElementById('contact-instagram').value.trim(),
        contact_twitter: document.getElementById('contact-twitter').value.trim(),
        contact_github: document.getElementById('contact-github').value.trim(),
        contact_behance: document.getElementById('contact-behance').value.trim(),
        contact_dribbble: document.getElementById('contact-dribbble').value.trim()
    };
    fetch('api/admin/settings.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ updates })
    }).then(r=>r.json()).then(resp=>{
        alert(resp && resp.ok ? 'Saved!' : 'Failed to save');
    }).catch(()=>alert('Failed to save'));
});

            // Load contact settings when Contact Management is shown
            function showMainSection(sectionType) {
    // Hide all headers
    document.getElementById('contentHeader').style.display = 'none';
    document.getElementById('profileHeader').style.display = 'none';
    document.getElementById('contactHeader').style.display = 'none';

    // Hide all layouts
    document.getElementById('contentLayout').style.display = 'none';
    document.getElementById('profileLayout').style.display = 'none';
    document.getElementById('contactLayout').style.display = 'none';

    // Remove active class from all nav items
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.classList.remove('active');
    });

    // Show selected section
    switch(sectionType) {
        case 'content':
            document.getElementById('contentHeader').style.display = 'block';
            document.getElementById('contentLayout').style.display = 'block';
            break;
        case 'profile':
            document.getElementById('profileHeader').style.display = 'block';
            document.getElementById('profileLayout').style.display = 'block';
            break;
        case 'contact':
            document.getElementById('contactHeader').style.display = 'block';
            document.getElementById('contactLayout').style.display = 'block';
            loadContactSettings(); // <-- Add this line
            break;
    }

    // Add active class to clicked nav item
    event.target.closest('.nav-item').classList.add('active');

    // If content section is shown, also ensure testimonials are loaded
    if (sectionType === 'content') {
        loadDashboardTestimonials();
    }
    if (sectionType === 'contact') {
        loadContactMessages(1);
    }
}
        </script>
</body>
</html>
