<?php
require_once 'db.php';
$config = $db_config;

// Get project slug or ID from query string
$slug = $_GET['slug'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (empty($slug) && $id <= 0) {
    header('Location: index.php');
    exit;
}

// Fetch project from database
$project = null;
$project_images = [];

try {
    $pdo = getDatabaseConnection($config);
    
    if ($slug) {
        $stmt = $pdo->prepare("SELECT id, title, slug, description, image_path, alt_text, display_order, created_at, updated_at FROM projects WHERE slug = ?");
        $stmt->execute([$slug]);
    } else {
        $stmt = $pdo->prepare("SELECT id, title, slug, description, image_path, alt_text, display_order, created_at, updated_at FROM projects WHERE id = ?");
        $stmt->execute([$id]);
    }
    
    $project = $stmt->fetch();
    
    if (!$project) {
        header('Location: index.php');
        exit;
    }
    
    // Fetch project images
    $imgStmt = $pdo->prepare("SELECT id, image_path, alt_text, display_order, grid_size FROM project_images WHERE project_id = ? ORDER BY display_order ASC, id ASC");
    $imgStmt->execute([$project['id']]);
    $project_images = $imgStmt->fetchAll();
    
} catch (Exception $e) {
    error_log("Failed to load project: " . $e->getMessage());
    header('Location: index.php');
    exit;
}

$page_title = htmlspecialchars($project['title'] ?? 'Project');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($project['description'] ?? ''); ?>">
    <title><?php echo $page_title; ?> - My Portfolio</title>
    <link rel="stylesheet" href="assets/css/project.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root {
            --color-dark: #08090D;
            --color-mid: #292c3a;
            --color-light: #A1A69C;
        }
    </style>
</head>
<body>
    <div class="cursor-circle" id="cursor-circle"></div>
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

    <section id="project" class="project-section">
        <div class="project-detail">
            <div class="project-header">
                <a href="index.php" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Projects</span>
                </a>
                <h1><?php echo htmlspecialchars($project['title']); ?></h1>
                <?php if (!empty($project['image_path'])): ?>
                <div class="project-thumbnail">
                    <img src="<?php echo htmlspecialchars($project['image_path']); ?>" 
                         alt="<?php echo htmlspecialchars($project['alt_text'] ?? $project['title']); ?>" />
                </div>
            <?php endif; ?>

                <?php if (!empty($project['description'])): ?>
                    <div class="project-description">
                        <?php echo nl2br(htmlspecialchars($project['description'])); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            
            
            <?php if (!empty($project_images)): ?>
                <div class="project-images-grid" id="project-images-grid">
                    <?php foreach ($project_images as $img): ?>
                        <div class="project-image-item grid-<?php echo htmlspecialchars($img['grid_size'] ?? 'medium'); ?>" 
                             data-image="<?php echo htmlspecialchars($img['image_path']); ?>"
                             data-alt="<?php echo htmlspecialchars($img['alt_text'] ?? ''); ?>">
                            <img src="<?php echo htmlspecialchars($img['image_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($img['alt_text'] ?? ''); ?>" 
                                 loading="lazy" />
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    </main>



    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Portfolio. All rights reserved.</p>
    </footer>

    <!-- Lightbox -->
    <div id="lightbox" class="lightbox">
        <button id="lightbox-close" class="lightbox-close" aria-label="Close lightbox">
            <i class="fas fa-times"></i>
        </button>
        <button id="lightbox-prev" class="lightbox-nav lightbox-prev" aria-label="Previous image">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button id="lightbox-next" class="lightbox-nav lightbox-next" aria-label="Next image">
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="lightbox-content">
            <img id="lightbox-image" src="" alt="" />
        </div>
    </div>

    <script>
        // Lightbox functionality
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightbox-image');
        const lightboxClose = document.getElementById('lightbox-close');
        const lightboxPrev = document.getElementById('lightbox-prev');
        const lightboxNext = document.getElementById('lightbox-next');
        
        // Collect all images (thumbnail + gallery images)
        const images = [];
        let currentImageIndex = 0;
        
        // Add thumbnail if it exists
        <?php if (!empty($project['image_path'])): ?>
        const thumbnailImg = document.querySelector('.project-thumbnail img');
        if (thumbnailImg) {
            images.push({
                src: '<?php echo htmlspecialchars($project['image_path']); ?>',
                alt: '<?php echo htmlspecialchars($project['alt_text'] ?? $project['title']); ?>'
            });
            
            // Make thumbnail clickable
            document.querySelector('.project-thumbnail').style.cursor = 'pointer';
            document.querySelector('.project-thumbnail').addEventListener('click', () => {
                currentImageIndex = 0;
                openLightbox();
            });
        }
        <?php endif; ?>
        
        // Add gallery images
        const imageItems = document.querySelectorAll('.project-image-item');
        const thumbnailOffset = images.length;
        
        imageItems.forEach((item, index) => {
            images.push({
                src: item.dataset.image,
                alt: item.dataset.alt || ''
            });
            
            item.addEventListener('click', () => {
                currentImageIndex = thumbnailOffset + index;
                openLightbox();
            });
        });

        function openLightbox() {
            if (images.length === 0) return;
            lightbox.classList.add('active');
            updateLightboxImage();
            updateNavigationButtons();
        }

        function closeLightbox() {
            lightbox.classList.remove('active');
        }

        function updateLightboxImage() {
            if (images[currentImageIndex]) {
                lightboxImage.src = images[currentImageIndex].src;
                lightboxImage.alt = images[currentImageIndex].alt;
            }
        }

        function updateNavigationButtons() {
            // Hide navigation buttons if only one image
            if (images.length <= 1) {
                lightboxPrev.style.display = 'none';
                lightboxNext.style.display = 'none';
            } else {
                lightboxPrev.style.display = 'flex';
                lightboxNext.style.display = 'flex';
            }
        }

        function nextImage() {
            if (images.length <= 1) return;
            currentImageIndex = (currentImageIndex + 1) % images.length;
            updateLightboxImage();
        }

        function prevImage() {
            if (images.length <= 1) return;
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            updateLightboxImage();
        }

        // Initialize navigation buttons visibility
        updateNavigationButtons();

        lightboxClose.addEventListener('click', closeLightbox);
        lightboxNext.addEventListener('click', nextImage);
        lightboxPrev.addEventListener('click', prevImage);
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (!lightbox.classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="assets/js/main.js"></script>
</body>
</html>

