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

