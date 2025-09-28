<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kind Words / Testimonials">
    <title>Kind Words • My Portfolio</title>
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
                <a href="kind-words.php" class="active">KIND WORDS</a>
                <a href="about.php">ABOUT</a>
                <a href="contact.php">CONTACT</a>
                <a href="https://www.linkedin.com" target="_blank" rel="noopener" class="icon" aria-label="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
                <a href="https://www.instagram.com" target="_blank" rel="noopener" class="icon" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </nav>

        <section id="kind-words" class="kind-words-section">
            <div class="kw-header">
                <h1>What people say</h1>
                <p>Testimonials gathered from projects, collaborations, and commissions.</p>
            </div>

            <div class="kw-grid">
                <article class="kw-card">
                    <p class="kw-quote">“Jeroboam exceeded expectations. Fast, communicative, and the final work was stunning.”</p>
                    <div class="kw-meta">
                        <span class="kw-name">Alex Rivera</span>
                        <span class="kw-role">Product Manager, Northstar</span>
                    </div>
                </article>
                <article class="kw-card">
                    <p class="kw-quote">“A rare mix of technical skill and creative eye. Our shoot turned out incredible.”</p>
                    <div class="kw-meta">
                        <span class="kw-name">Mika Santos</span>
                        <span class="kw-role">Art Director</span>
                    </div>
                </article>
                <article class="kw-card">
                    <p class="kw-quote">“Collaborating with Jerome was effortless. Clear direction, great energy, beautiful results.”</p>
                    <div class="kw-meta">
                        <span class="kw-name">Kenji Tan</span>
                        <span class="kw-role">Cosplay Model</span>
                    </div>
                </article>
                <article class="kw-card">
                    <p class="kw-quote">“Delivers on time with polished work. Would happily work together again.”</p>
                    <div class="kw-meta">
                        <span class="kw-name">Lara Gomez</span>
                        <span class="kw-role">Photographer</span>
                    </div>
                </article>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Portfolio. All rights reserved.</p>
    </footer>
</body>
</html>


