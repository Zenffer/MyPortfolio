<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cosplay Portfolio">
    <title>Cosplay • My Portfolio</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src="assets/js/main.js"></script>
</head>
<body>
    <div class="cursor-circle" id="cursor-circle"></div>

    <!-- Hero Section with Animated Background -->
    <section class="intro">
      <canvas id="intro-particles"></canvas>
      <h1 class="name">Hi, I'm Zenffer</h1>
      <h2 class="title">Your friendly neighborhood cosplayer.</h2>
      <div class="scroll-indicator">
        <svg width="96" height="70" viewBox="0 0 60 40" fill="none">
          <polyline points="15,18 30,32 45,18" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </section>

    <main>
        <nav class="main-nav">
            <div class="logo">ZENFFER CRAFTISANO</div>
            <div class="nav-links">
                <a href="index.php">PROJECTS</a>
                <a href="photography.php">PHOTOGRAPHY</a>
                <a href="cosplay.php" class="active">COSPLAY</a>
                <a href="kind-words.php">KIND WORDS</a>
                <a href="about.php">ABOUT</a>
                <a href="contact.php">CONTACT</a>
                <a href="https://www.linkedin.com" target="_blank" rel="noopener" class="icon" aria-label="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
                <a href="https://www.instagram.com" target="_blank" rel="noopener" class="icon" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </nav>

        <!-- Reuse photography grid styles for cosplay as well -->
        <section id="cosplay" class="photo-section">
            <div class="photo-header">
                <h1>Cosplay</h1>
                <p>Selected costumes and characters from recent events and shoots.</p>
            </div>

            <div class="photo-grid">
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1542204165-65bf26472b9b?q=80&w=1400&auto=format&fit=crop" alt="Cosplayer in detailed armor">
                    <figcaption>
                        <h3>Content Title</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </figcaption>
                </figure>
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1517816743773-6e0fd518b4a6?q=80&w=1400&auto=format&fit=crop" alt="Anime character cosplay">
                    <figcaption>
                        <h3>Content Title</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </figcaption>
                </figure>
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1531259683007-016a7b628fc3?q=80&w=1400&auto=format&fit=crop" alt="Sci-fi themed costume portrait">
                    <figcaption>
                        <h3>Content Title</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </figcaption>
                </figure>
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1520975922329-72b3d3b6b455?q=80&w=1400&auto=format&fit=crop" alt="Convention hallway cosplay">
                    <figcaption>
                        <h3>Content Title</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </figcaption>
                </figure>
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1520975278047-6ccace1b4d5b?q=80&w=1400&auto=format&fit=crop" alt="Hero character in motion">
                    <figcaption>
                        <h3>Content Title</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </figcaption>
                </figure>
                <figure class="photo-card">
                    <img src="https://images.unsplash.com/photo-1542089363-5813837f825b?q=80&w=1400&auto=format&fit=crop" alt="Elegant fantasy costume">
                    <figcaption>
                        <h3>Content Title</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </figcaption>
                </figure>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Portfolio. All rights reserved.</p>
    </footer>
</body>
</html>


