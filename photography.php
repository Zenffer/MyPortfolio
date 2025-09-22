<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Photography Portfolio">
    <title>Photography • My Portfolio</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src="assets/js/main.js"></script>
</head>
<body>
    <div class="cursor-circle" id="cursor-circle"></div>
    
    <!-- Hero Section with Animated Background (copied from index.php) -->
    <section class="intro">
      <!-- Particle Animation Canvas -->
      <canvas id="intro-particles"></canvas>
      
      <!-- Main Name Display -->
      <h1 class="name">Hi, I'm Jerome.</h1>
      
      <!-- Professional Title -->
      <h2 class="title">Developer, Photographer & Cosplayer.</h2>
      
      <!-- Scroll Down Indicator -->
      <div class="scroll-indicator">
        <svg width="96" height="70" viewBox="0 0 60 40" fill="none">
          <polyline points="15,18 30,32 45,18" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </section>

    <main>
        <nav class="main-nav">
            <div class="logo">JEROBOAM OLIVEROS</div>
            <div class="nav-links">
                <a href="index.php">PROJECTS</a>
                <a href="photography.php" class="active">PHOTOGRAPHY</a>
                <a href="cosplay.php">COSPLAY</a>
                <a href="kind-words.php">KIND WORDS</a>
                <a href="about.php">ABOUT</a>
                <a href="contact.php">CONTACT</a>
                <a href="https://www.linkedin.com" target="_blank" rel="noopener" class="icon" aria-label="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
                <a href="https://www.instagram.com" target="_blank" rel="noopener" class="icon" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </nav>

        <section id="photography" class="photo-section">
            <div class="photo-header">
                <h1>Photography</h1>
                <p>A selection of my favorite shots. More coming soon.</p>
            </div>

            <div class="photo-grid">
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=1400&auto=format&fit=crop" alt="Mountain landscape at sunrise">
                </figure>
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=1400&auto=format&fit=crop" alt="Forest pathway with mist">
                </figure>
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1526336024174-e58f5cdd8e13?q=80&w=1400&auto=format&fit=crop" alt="City skyline at dusk">
                </figure>
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?q=80&w=1400&auto=format&fit=crop" alt="Desert dunes with shadows">
                </figure>
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?q=80&w=1400&auto=format&fit=crop" alt="Ocean waves">
                </figure>
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1491553895911-0055eca6402d?q=80&w=1400&auto=format&fit=crop" alt="Portrait in natural light">
                </figure>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Portfolio. All rights reserved.</p>
    </footer>

    <!-- Scripts consolidated into assets/js/main.js -->
</body>
</html>

