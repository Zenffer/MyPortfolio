<?php
require_once 'db.php';
$config = $db_config;
$hero_title = getPageContent($config, 'index', 'hero_title', 'Hi, I\'m Jerome.');
$hero_subtitle = getPageContent($config, 'index', 'hero_subtitle', 'Developer, Photographer & Cosplayer.');
$projects_title = getPageContent($config, 'index', 'projects_title', 'Projects');
$projects_description = getPageContent($config, 'index', 'projects_description', 'A showcase of my recent development work and creative projects.');

// Fetch projects from database
$projects = [];
try {
    $pdo = getDatabaseConnection($config);
    $stmt = $pdo->prepare("SELECT id, title, description, image_path, alt_text, display_order FROM projects ORDER BY display_order ASC, id ASC");
    $stmt->execute();
    $projects = $stmt->fetchAll();
} catch (Exception $e) {
    error_log("Failed to load projects: " . $e->getMessage());
    $projects = [];
}
?>
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
      <h1 class="name"><?php echo htmlspecialchars($hero_title); ?></h1>
      
      <!-- Professional Title -->
      <h2 class="title"><?php echo htmlspecialchars($hero_subtitle); ?></h2>
      
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
                <h1><?php echo htmlspecialchars($projects_title); ?></h1>
                <p><?php echo htmlspecialchars($projects_description); ?></p>
            </div>

            <div class="photo-grid" id="projects-grid">
                <?php if (empty($projects)): ?>
                    <!-- No projects message -->
                    <div style="text-align: center; padding: 40px; color: #A1A69C; grid-column: 1 / -1;">
                        <i class="fas fa-folder-open" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                        <p>No projects available at the moment.</p>
                    </div>
                <?php else: ?>
                    <!-- Projects loaded from database -->
                    <?php foreach ($projects as $project): ?>
                        <figure class="photo-card">
                            <?php 
                            $image_path = htmlspecialchars($project['image_path'] ?? '');
                            $alt_text = htmlspecialchars($project['alt_text'] ?? $project['title'] ?? 'Project image');
                            $title = htmlspecialchars($project['title'] ?? 'Untitled Project');
                            $description = htmlspecialchars($project['description'] ?? '');
                            ?>
                            <img src="<?php echo $image_path; ?>" alt="<?php echo $alt_text; ?>" loading="lazy" />
                            <figcaption>
                                <h3><?php echo $title; ?></h3>
                                <?php if (!empty($description)): ?>
                                    <p><?php echo $description; ?></p>
                                <?php endif; ?>
                            </figcaption>
                        </figure>
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