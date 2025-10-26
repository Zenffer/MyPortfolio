<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="My Portfolio">
    <title>My Portfolio</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="assets/js/main.js"></script>

</head>
<body>
    <div class="cursor-circle" id="cursor-circle"></div>
    
    
    <!-- Hero Section with Animated Background -->
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
                <a href="index.php" class="active">PROJECTS</a>
                <a href="photography.php">PHOTOGRAPHY</a>
                <a href="cosplay.php">COSPLAY</a>
                <a href="kind-words.php">KIND WORDS</a>
                <a href="about.php">ABOUT</a>
                <a href="contact.php">CONTACT</a>
                <a href="https://www.linkedin.com" target="_blank" rel="noopener" class="icon" aria-label="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
                <a href="https://www.instagram.com" target="_blank" rel="noopener" class="icon" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </nav>

        <section id="projects" class="photo-section">
            <div class="photo-header">
                <h1>Projects</h1>
                <p>A showcase of my recent development work and creative projects.</p>
            </div>

            <div class="photo-grid">
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=1400&auto=format&fit=crop" alt="Web development project dashboard">
                    <figcaption>
                        <h3>Content Title</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </figcaption>
                </figure>
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=1400&auto=format&fit=crop" alt="Data visualization dashboard">
                    <figcaption>
                        <h3>Content Title</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </figcaption>
                </figure>
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1551650975-87deedd944c3?q=80&w=1400&auto=format&fit=crop" alt="Mobile app interface">
                    <figcaption>
                        <h3>Content Title</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </figcaption>
                </figure>
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=1400&auto=format&fit=crop" alt="E-commerce website">
                    <figcaption>
                        <h3>Content Title</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </figcaption>
                </figure>
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?q=80&w=1400&auto=format&fit=crop" alt="API integration project">
                    <figcaption>
                        <h3>Content Title</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </figcaption>
                </figure>
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?q=80&w=1400&auto=format&fit=crop" alt="Database management system">
                    <figcaption>
                        <h3>Content Title</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </figcaption>
                </figure>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Portfolio. All rights reserved.</p>
    </footer>

    <!-- Scripts consolidated into assets/js/main.js -->
</body>
</html>