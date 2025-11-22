<?php
require_once 'db.php';
$config = $db_config;
$photography_title = getPageContent($config, 'photography', 'page_title', 'Photography');
$photography_description = getPageContent($config, 'photography', 'page_description', 'A selection of my favorite shots. More coming soon.');

// Fetch photography from database
$photography = [];
try {
    $pdo = getDatabaseConnection($config);
    $stmt = $pdo->prepare("SELECT id, title, description, image_path, alt_text, display_order FROM photography ORDER BY display_order ASC, id ASC");
    $stmt->execute();
    $photography = $stmt->fetchAll();
} catch (Exception $e) {
    error_log("Failed to load photography: " . $e->getMessage());
    $photography = [];
}
?>
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
      <h1 class="name"><?php echo htmlspecialchars(getPageContent($config, 'photography', 'hero_title', 'Hi, I\'m Jerome.')); ?></h1>
      
      <!-- Professional Title -->
      <h2 class="title"><?php echo htmlspecialchars(getPageContent($config, 'photography', 'hero_subtitle', 'Developer, Photographer & Cosplayer.')); ?></h2>
      
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
                <h1><?php echo htmlspecialchars($photography_title); ?></h1>
                <p><?php echo htmlspecialchars($photography_description); ?></p>
            </div>

            <div class="photo-grid" id="photography-grid">
                <?php if (empty($photography)): ?>
                    <!-- No photography message -->
                    <div style="text-align: center; padding: 40px; color: #A1A69C; grid-column: 1 / -1;">
                        <i class="fas fa-folder-open" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                        <p>No photography available at the moment.</p>
                    </div>
                <?php else: ?>
                    <!-- Photography loaded from database -->
                    <?php foreach ($photography as $photo): ?>
                        <?php 
                        $image_path = !empty($photo['image_path']) ? htmlspecialchars($photo['image_path']) : 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="400" height="300"%3E%3Crect fill="%23292c3a" width="400" height="300"/%3E%3Ctext fill="%23A1A69C" font-family="Arial" font-size="18" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3ENo Image%3C/text%3E%3C/svg%3E';
                        $alt_text = htmlspecialchars($photo['alt_text'] ?? $photo['title'] ?? 'Photo image');
                        $title = htmlspecialchars($photo['title'] ?? 'Untitled Photo');
                        $description = htmlspecialchars($photo['description'] ?? '');
                        $photo_url = 'photo.php?id=' . (int)$photo['id'];
                        ?>
                        <a href="<?php echo $photo_url; ?>" class="photo-card-link">
                            <figure class="photo-card">
                                <img src="<?php echo $image_path; ?>" alt="<?php echo $alt_text; ?>" loading="lazy" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'300\'%3E%3Crect fill=\'%23292c3a\' width=\'400\' height=\'300\'/%3E%3Ctext fill=\'%23A1A69C\' font-family=\'Arial\' font-size=\'18\' x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\'%3ENo Image%3C/text%3E%3C/svg%3E';" />
                                <figcaption>
                                    <h3><?php echo $title; ?></h3>
                                    <?php if (!empty($description)): ?>
                                        <p><?php echo $description; ?></p>
                                    <?php endif; ?>
                                </figcaption>
                            </figure>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
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

