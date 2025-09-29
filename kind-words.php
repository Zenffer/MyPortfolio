<?php
require_once 'db.php';

// Use shared DB config
$config = $db_config;

// Fetch page content
$kw_title = getPageContent($config, 'kind-words', 'page_title', 'What people say');
$kw_desc  = getPageContent($config, 'kind-words', 'page_description', 'Testimonials gathered from projects, collaborations, and commissions.');
?>
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
                <h1><?php echo htmlspecialchars($kw_title); ?></h1>
                <p><?php echo htmlspecialchars($kw_desc); ?></p>
            </div>

            <div id="kw-grid" class="kw-grid" aria-live="polite">
                <article class="kw-card" id="kw-loading">
                    <p class="kw-quote">Loading testimonials…</p>
                    <div class="kw-meta">
                        <span class="kw-name">Please wait</span>
                        <span class="kw-role"></span>
                    </div>
                </article>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Portfolio. All rights reserved.</p>
    </footer>
    <script>
    (function(){
        const grid = document.getElementById('kw-grid');
        if (!grid) return;

        fetch('api/testimonials.php', { credentials: 'same-origin' })
          .then(r => r.json())
          .then(json => {
            grid.innerHTML = '';
            if (!json || !json.ok || !Array.isArray(json.data) || json.data.length === 0) {
              grid.innerHTML = '<article class="kw-card"><p class="kw-quote">No testimonials yet.</p><div class="kw-meta"><span class="kw-name"></span><span class="kw-role"></span></div></article>';
              return;
            }
            json.data.forEach(item => {
              const card = document.createElement('article');
              card.className = 'kw-card';
              card.innerHTML = `
                <p class="kw-quote">${escapeHtml(item.quote)}</p>
                <div class="kw-meta">
                    <span class="kw-name">${escapeHtml(item.name)}</span>
                    <span class="kw-role">${escapeHtml(item.role || '')}</span>
                </div>
              `;
              grid.appendChild(card);
            });
          })
          .catch(() => {
            grid.innerHTML = '<article class="kw-card"><p class="kw-quote">Failed to load testimonials.</p><div class="kw-meta"><span class="kw-name"></span><span class="kw-role"></span></div></article>';
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
    })();
    </script>
</body>
</html>


