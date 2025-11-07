        <!-- Sidebar navigation -->
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

