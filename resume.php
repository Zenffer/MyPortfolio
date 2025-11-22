<?php
require_once 'db.php';
$config = $db_config;

// Get resume data from site settings
$owner_name = getSiteSetting($config, 'owner_name', 'Jeroboam T. Oliveros');
$owner_title = getSiteSetting($config, 'owner_title', 'Developer, Photographer & Cosplayer');
$email = getSiteSetting($config, 'email', 'hello@example.com');
$phone = getSiteSetting($config, 'phone', '');
$location = getSiteSetting($config, 'location', '');
$linkedin = getSiteSetting($config, 'linkedin', 'https://www.linkedin.com');
$github = getSiteSetting($config, 'github', '');
$website = getSiteSetting($config, 'website', '');
$bio = getSiteSetting($config, 'bio', 'I craft clean, performant web experiences and tell stories through images and character work.');
$skills_csv = getSiteSetting($config, 'skills', 'HTML/CSS, JavaScript, PHP, MySQL, jQuery, REST APIs, Responsive UI');
$tools_csv = getSiteSetting($config, 'tools', 'VS Code, Git & GitHub, Docker, Postman, Figma, Adobe Photoshop');

// Resume-specific fields
$resume_summary = getSiteSetting($config, 'resume_summary', $bio);
$resume_education = getSiteSetting($config, 'resume_education', '');
$resume_experience = getSiteSetting($config, 'resume_experience', '');
$resume_projects = getSiteSetting($config, 'resume_projects', '');
$resume_certifications = getSiteSetting($config, 'resume_certifications', '');

function renderTagList($csv) {
    $items = array_filter(array_map('trim', explode(',', (string)$csv)));
    return $items;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Resume of <?php echo htmlspecialchars($owner_name); ?>">
    <title>Resume • <?php echo htmlspecialchars($owner_name); ?></title>
    <link rel="stylesheet" href="assets/css/project.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Print-friendly styles */
        @media print {
            body {
                background: white !important;
                color: black !important;
            }
            .resume-actions, .main-nav, footer, .cursor-circle, .back-link {
                display: none !important;
            }
            .resume-container {
                max-width: 100%;
                padding: 0;
                margin: 0;
            }
            /* Ensure all text is black */
            h1, h2, h3, h4, h5, h6, p, span, div, li, a, strong, em {
                color: black !important;
            }
            .resume-header h1,
            .resume-section h2,
            .resume-item h3 {
                color: black !important;
            }
            .resume-header .title,
            .resume-contact,
            .resume-contact a,
            .resume-contact span,
            .resume-item .meta,
            .resume-section p,
            .resume-item ul,
            .resume-item li {
                color: black !important;
            }
            .resume-skill-tag {
                background: #f0f0f0 !important;
                color: black !important;
                border: 1px solid #ddd !important;
            }
        }
        
        .resume-container {
            max-width: 1000px;
            margin: 2rem auto 3rem;
            padding: 0 24px;
        }
        
        .resume-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--color-light);
        }
        
        .resume-header h1 {
            font-size: 48px;
            font-weight: 800;
            margin: 0 0 10px 0;
            color: #fff;
        }
        
        .resume-header .title {
            font-size: 18px;
            color: var(--color-light);
            margin: 0 0 20px 0;
        }
        
        .resume-contact {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            font-size: 14px;
            color: var(--color-light);
        }
        
        .resume-contact a {
            color: var(--color-light);
            text-decoration: none;
        }
        
        .resume-contact a:hover {
            color: #fff;
        }
        
        .resume-section {
            margin-bottom: 30px;
        }
        
        .resume-section h2 {
            font-size: 24px;
            font-weight: 800;
            margin: 0 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--color-light);
            color: #fff;
        }
        
        .resume-section p {
            line-height: 1.6;
            color: #fff;
            font-size: 18px;
        }
        
        .resume-item {
            margin-bottom: 20px;
        }
        
        .resume-item h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 5px 0;
            color: #fff;
        }
        
        .resume-item .meta {
            font-size: 14px;
            color: var(--color-light);
            margin-bottom: 10px;
        }
        
        .resume-item ul {
            margin: 10px 0;
            padding-left: 20px;
            color: #fff;
        }
        
        .resume-item li {
            margin-bottom: 5px;
            line-height: 1.6;
        }
        
        .resume-skills {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .resume-skill-tag {
            background: var(--color-mid);
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 14px;
            color: #fff;
        }
        
        .resume-actions {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid var(--color-light);
        }
        
        .resume-actions .btn {
            margin: 0 10px;
        }
        
        /* Button styles */
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #000;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
        
        .btn:hover {
            background: #333;
        }
        
        .btn-primary {
            background: #000;
            color: #fff;
        }
        
        .btn-secondary {
            background: var(--color-mid);
            color: #fff;
        }
        
        .btn-secondary:hover {
            background: var(--color-light);
        }
        
        .btn.ghost {
            background: transparent;
            border: 1px solid var(--color-light);
            color: var(--color-light);
        }
        
        .btn.ghost:hover {
            background: var(--color-light);
            color: #fff;
        }
    </style>
    <script defer src="assets/js/main.js"></script>
    <?php if (isset($_GET['print']) && $_GET['print'] == '1'): ?>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
    <?php endif; ?>
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
                <a href="about.php">ABOUT</a>
                <a href="contact.php">CONTACT</a>
                <a href="https://www.linkedin.com" target="_blank" rel="noopener" class="icon" aria-label="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
                <a href="https://www.instagram.com" target="_blank" rel="noopener" class="icon" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </nav>

        <section id="resume" class="project-section">
            <div class="project-detail">
                <div class="project-header">
                    <a href="about.php" class="back-link">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to About</span>
                    </a>
                    <div class="resume-header">
                        <h1><?php echo htmlspecialchars($owner_name); ?></h1>
                        <p class="title"><?php echo htmlspecialchars($owner_title); ?></p>
                        <div class="resume-contact">
                    <?php if ($email): ?>
                        <a href="mailto:<?php echo htmlspecialchars($email); ?>">
                            <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($email); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($phone): ?>
                        <span><i class="fas fa-phone"></i> <?php echo htmlspecialchars($phone); ?></span>
                    <?php endif; ?>
                    <?php if ($location): ?>
                        <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($location); ?></span>
                    <?php endif; ?>
                    <?php if ($linkedin && $linkedin !== '#'): ?>
                        <a href="<?php echo htmlspecialchars($linkedin); ?>" target="_blank" rel="noopener">
                            <i class="fab fa-linkedin"></i> LinkedIn
                        </a>
                    <?php endif; ?>
                    <?php if ($github): ?>
                        <a href="<?php echo htmlspecialchars($github); ?>" target="_blank" rel="noopener">
                            <i class="fab fa-github"></i> GitHub
                        </a>
                    <?php endif; ?>
                    <?php if ($website): ?>
                        <a href="<?php echo htmlspecialchars($website); ?>" target="_blank" rel="noopener">
                            <i class="fas fa-globe"></i> Website
                        </a>
                    <?php endif; ?>
                    </div>
                </div>

                <?php if ($resume_summary): ?>
                <div class="resume-section">
                    <h2>Summary</h2>
                    <p><?php echo nl2br(htmlspecialchars($resume_summary)); ?></p>
                </div>
                <?php endif; ?>

                <?php if ($skills_csv): ?>
                <div class="resume-section">
                    <h2>Skills</h2>
                    <div class="resume-skills">
                        <?php foreach (renderTagList($skills_csv) as $skill): ?>
                            <span class="resume-skill-tag"><?php echo htmlspecialchars($skill); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($resume_experience): ?>
                <div class="resume-section">
                    <h2>Experience</h2>
                    <?php 
                    $experiences = json_decode($resume_experience, true);
                    if (is_array($experiences)) {
                        foreach ($experiences as $exp): ?>
                            <div class="resume-item">
                                <h3><?php echo htmlspecialchars($exp['title'] ?? ''); ?></h3>
                                <div class="meta">
                                    <?php if (!empty($exp['company'])): ?>
                                        <strong><?php echo htmlspecialchars($exp['company']); ?></strong>
                                    <?php endif; ?>
                                    <?php if (!empty($exp['period'])): ?>
                                        <span> • <?php echo htmlspecialchars($exp['period']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($exp['description'])): ?>
                                    <p><?php echo nl2br(htmlspecialchars($exp['description'])); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($exp['achievements']) && is_array($exp['achievements'])): ?>
                                    <ul>
                                        <?php foreach ($exp['achievements'] as $achievement): ?>
                                            <li><?php echo htmlspecialchars($achievement); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php endforeach;
                    } else {
                        // Fallback: treat as plain text
                        echo '<p>' . nl2br(htmlspecialchars($resume_experience)) . '</p>';
                    }
                    ?>
                </div>
                <?php endif; ?>

                <?php if ($resume_education): ?>
                <div class="resume-section">
                    <h2>Education</h2>
                    <?php 
                    $educations = json_decode($resume_education, true);
                    if (is_array($educations)) {
                        foreach ($educations as $edu): ?>
                            <div class="resume-item">
                                <h3><?php echo htmlspecialchars($edu['degree'] ?? ''); ?></h3>
                                <div class="meta">
                                    <?php if (!empty($edu['school'])): ?>
                                        <strong><?php echo htmlspecialchars($edu['school']); ?></strong>
                                    <?php endif; ?>
                                    <?php if (!empty($edu['year'])): ?>
                                        <span> • <?php echo htmlspecialchars($edu['year']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($edu['details'])): ?>
                                    <p><?php echo nl2br(htmlspecialchars($edu['details'])); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach;
                    } else {
                        // Fallback: treat as plain text
                        echo '<p>' . nl2br(htmlspecialchars($resume_education)) . '</p>';
                    }
                    ?>
                </div>
                <?php endif; ?>

                <?php if ($tools_csv): ?>
                <div class="resume-section">
                    <h2>Tools & Technologies</h2>
                    <div class="resume-skills">
                        <?php foreach (renderTagList($tools_csv) as $tool): ?>
                            <span class="resume-skill-tag"><?php echo htmlspecialchars($tool); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($resume_certifications): ?>
                <div class="resume-section">
                    <h2>Certifications</h2>
                    <?php 
                    $certs = json_decode($resume_certifications, true);
                    if (is_array($certs)) {
                        foreach ($certs as $cert): ?>
                            <div class="resume-item">
                                <h3><?php echo htmlspecialchars($cert['name'] ?? ''); ?></h3>
                                <div class="meta">
                                    <?php if (!empty($cert['issuer'])): ?>
                                        <strong><?php echo htmlspecialchars($cert['issuer']); ?></strong>
                                    <?php endif; ?>
                                    <?php if (!empty($cert['year'])): ?>
                                        <span> • <?php echo htmlspecialchars($cert['year']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach;
                    } else {
                        echo '<p>' . nl2br(htmlspecialchars($resume_certifications)) . '</p>';
                    }
                    ?>
                </div>
                <?php endif; ?>

                <div class="resume-actions">
                    <a href="resume-pdf.php" class="btn btn-primary" target="_blank">
                        <i class="fas fa-download"></i> Download as PDF
                    </a>
                    <button onclick="window.print()" class="btn btn-secondary">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Portfolio. All rights reserved.</p>
    </footer>
</body>
</html>

