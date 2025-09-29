<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="About Jeroboam Oliveros">
    <title>About • My Portfolio</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src="assets/js/main.js"></script>
</head>
<body>
    <div class="cursor-circle" id="cursor-circle"></div>

    <main>
        <nav class="main-nav">
            <div class="logo">JEROBOAM OLIVEROS</div>
            <div class="nav-links">
                <a href="index.php">PROJECTS</a>
                <a href="photography.php">PHOTOGRAPHY</a>
                <a href="cosplay.php">COSPLAY</a>
                <a href="kind-words.php">KIND WORDS</a>
                <a href="about.php" class="active">ABOUT</a>
                <a href="contact.php">CONTACT</a>
                <a href="https://www.linkedin.com" target="_blank" rel="noopener" class="icon" aria-label="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
                <a href="https://www.instagram.com" target="_blank" rel="noopener" class="icon" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </nav>

        <section id="about" class="about-section">
            <div class="about-grid">
                <div class="about-bio">
                    <div class="profile-section">
                        <div class="profile-picture">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200&auto=format&fit=crop" alt="Profile Picture" id="profile-img">
                        </div>
                        <div class="profile-info">
                            <h1>Hi, I'm Jerome.</h1>
                            <p>I craft clean, performant web experiences and tell stories through images and character work. With a background that blends software development, photography, and cosplay, I enjoy projects that balance technical depth with creative polish.</p>
                            <p>When I'm not shipping features, I'm experimenting with lighting setups, sewing details, or planning the next shoot.</p>
                        </div>
                    </div>
                    <div class="about-actions">
                        <a class="btn" href="contact.php">Get in touch</a>
                        <a class="btn ghost" href="#" onclick="alert('Resume coming soon!'); return false;">Download résumé</a>
                    </div>
                </div>
                <div class="about-aside">
                    <div class="about-card">
                        <h2>Skills</h2>
                        <ul class="tag-list">
                            <li>HTML/CSS</li><li>JavaScript</li><li>PHP</li><li>jQuery</li>
                            <li>Responsive UI</li><li>Photography</li><li>Lighting</li><li>Cosplay Fabrication</li>
                        </ul>
                    </div>
                    <div class="about-card">
                        <h2>Tools</h2>
                        <ul class="tag-list">
                            <li>VS Code</li><li>Git</li><li>Figma</li><li>Lightroom</li><li>Photoshop</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Edit Dashboard Icon - moved to top-right of portfolio section -->
            <div class="edit-dashboard">
                <button class="edit-btn" onclick="showOwnerPrompt()" title="Edit Portfolio">
                    <img src="assets/js/icons/editIcon.svg" alt="Edit" class="edit-icon">
                </button>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Portfolio. All rights reserved.</p>
    </footer>

    <!-- Owner Verification Modal -->
    <div id="ownerModal" class="modal">
        <div class="modal-content">
            <h2>Portfolio Owner Verification</h2>
            <p>Are you the owner of this portfolio?</p>
            <div class="modal-buttons">
                <button class="btn" onclick="proceedToLogin()">Yes, I'm the owner</button>
                <button class="btn ghost" onclick="closeModal()">No, just browsing</button>
            </div>
        </div>
    </div>

    <script>
        function showOwnerPrompt() {
            document.getElementById('ownerModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('ownerModal').style.display = 'none';
        }

        function proceedToLogin() {
            window.location.href = 'login.php';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('ownerModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>


