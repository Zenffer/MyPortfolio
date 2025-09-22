<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contact Jeroboam Oliveros">
    <title>Contact • My Portfolio</title>
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
      <h1 class="name">Get In Touch</h1>
      <h2 class="title">Let's build something great.</h2>
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
                <a href="photography.php">PHOTOGRAPHY</a>
                <a href="cosplay.php">COSPLAY</a>
                <a href="kind-words.php">KIND WORDS</a>
                <a href="contact.php" class="active">CONTACT</a>
                <a href="https://www.linkedin.com" target="_blank" rel="noopener" class="icon" aria-label="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
                <a href="https://www.instagram.com" target="_blank" rel="noopener" class="icon" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </nav>

        <section id="contact" class="contact-section">
            <div class="contact-grid">
                <div class="contact-copy">
                    <h1>Contact</h1>
                    <p>Have a project in mind, need photos, or want to collaborate? Send a message and I’ll get back to you.</p>
                    <div class="contact-meta">
                        <p><i class="fa-solid fa-envelope"></i> <a href="mailto:hello@example.com">hello@example.com</a></p>
                        <p><i class="fa-brands fa-linkedin"></i> <a href="https://www.linkedin.com" target="_blank" rel="noopener">LinkedIn</a></p>
                        <p><i class="fa-brands fa-instagram"></i> <a href="https://www.instagram.com" target="_blank" rel="noopener">Instagram</a></p>
                    </div>
                </div>

                <form class="contact-form" method="post" action="#" onsubmit="alert('Thanks! This demo form isn\'t wired yet.'); return false;">
                    <div class="form-row">
                        <div class="form-field">
                            <label for="name">Name</label>
                            <input id="name" name="name" type="text" placeholder="Your name" required>
                        </div>
                        <div class="form-field">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" placeholder="you@example.com" required>
                        </div>
                    </div>
                    <div class="form-field">
                        <label for="subject">Subject</label>
                        <input id="subject" name="subject" type="text" placeholder="How can I help?">
                    </div>
                    <div class="form-field">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="6" placeholder="Tell me a little about your project..." required></textarea>
                    </div>
                    <button class="btn" type="submit">Send message</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Portfolio. All rights reserved.</p>
    </footer>
</body>
</html>


