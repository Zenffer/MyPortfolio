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
                <div class="logo">PORTFOLIO</div>
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="user-details">
                        <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
                        <p>Portfolio Owner</p>
                    </div>
                </div>
                <button class="toggle-sidebar" onclick="toggleSidebar()">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <a href="#" class="nav-item">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-images"></i>
                    <span>Gallery</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-edit"></i>
                    <span>Content</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-quote-left"></i>
                    <span>Testimonials</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-envelope"></i>
                    <span>Contact</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-chart-bar"></i>
                    <span>Analytics</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-comments"></i>
                    <span>Messages</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-video"></i>
                    <span>Video Room</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-cog"></i>
                    <span>Services</span>
                </a>
                <a href="#" class="nav-item active">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-question-circle"></i>
                    <span>Help</span>
                </a>
                <a href="logout.php" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search">
                </div>
                <div class="top-bar-actions">
                    <button class="action-btn">
                        <i class="fas fa-file-alt"></i>
                    </button>
                    <button class="action-btn">
                        <i class="fas fa-bell"></i>
                    </button>
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
                <div class="page-header">
                    <h1 class="page-title">Portfolio Settings</h1>
                    <p class="page-subtitle">Manage your portfolio content, profile, and site settings.</p>
                </div>

                <div class="settings-layout">
                    <!-- Settings Navigation -->
                    <div class="settings-nav">
                        <a href="#" class="settings-nav-item active">
                            <i class="fas fa-user"></i>
                            <span>Profile Settings</span>
                        </a>
                        <a href="#" class="settings-nav-item">
                            <i class="fas fa-edit"></i>
                            <span>Content Management</span>
                        </a>
                        <a href="#" class="settings-nav-item">
                            <i class="fas fa-images"></i>
                            <span>Gallery</span>
                        </a>
                        <a href="#" class="settings-nav-item">
                            <i class="fas fa-quote-left"></i>
                            <span>Testimonials</span>
                        </a>
                        <a href="#" class="settings-nav-item">
                            <i class="fas fa-envelope"></i>
                            <span>Contact Info</span>
                        </a>
                        <a href="#" class="settings-nav-item">
                            <i class="fas fa-cog"></i>
                            <span>Site Settings</span>
                        </a>
                        <a href="#" class="settings-nav-item">
                            <i class="fas fa-lock"></i>
                            <span>Security</span>
                        </a>
                    </div>

                    <!-- Settings Content -->
                    <div class="settings-content">
                        <div class="section-header">
                            <h2 class="section-title">Profile Settings</h2>
                            <p class="section-subtitle">Update your personal information and profile details.</p>
                        </div>

                        <!-- Profile Picture Upload -->
                        <div class="form-section">
                            <h3>Profile picture upload</h3>
                            <div class="profile-upload">
                                <div class="profile-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="profile-info">
                                    <h4>Jerome</h4>
                                    <p>Developer, Photographer & Cosplayer</p>
                                    <p>Portfolio Owner</p>
                                    <div style="display: flex; gap: 8px; margin-top: 8px;">
                                        <button class="btn btn-primary">Upload New Photo</button>
                                        <button class="btn btn-danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="form-section">
                            <h3>Personal Information</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" value="Jeroboam Oliveros">
                                </div>
                                <div class="form-group">
                                    <label>Professional Title</label>
                                    <input type="text" value="Developer, Photographer & Cosplayer">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" value="hello@example.com">
                                </div>
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" value="Your City, Country">
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="form-section">
                            <h3>Social Media & Links</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>LinkedIn URL</label>
                                    <input type="url" value="https://www.linkedin.com">
                                </div>
                                <div class="form-group">
                                    <label>Instagram URL</label>
                                    <input type="url" value="https://www.instagram.com">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Portfolio Website</label>
                                    <input type="url" value="https://yourportfolio.com">
                                </div>
                                <div class="form-group">
                                    <label>Resume URL</label>
                                    <input type="url" value="#">
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button class="btn btn-secondary">Cancel</button>
                            <button class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('sidebar-collapsed');
        }

        // Mobile sidebar toggle
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        // Close mobile sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isMobileMenuButton = event.target.closest('.mobile-menu-button');
            
            if (!isClickInsideSidebar && !isMobileMenuButton && window.innerWidth <= 768) {
                sidebar.classList.remove('open');
            }
        });
    </script>
</body>
</html>
