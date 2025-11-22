<?php
/**
 * Database Setup and Management
 * Handles database creation, table setup, and default account creation
 */

// Database configuration
$db_config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'portfolio_db',
    'charset' => 'utf8mb4'
];

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create database connection
function createConnection($config, $use_database = false) {
    $dsn = "mysql:host={$config['host']};charset={$config['charset']}";
    if ($use_database) {
        $dsn .= ";dbname={$config['database']}";
    }
    
    try {
        $pdo = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        throw new Exception("Database connection failed: " . $e->getMessage());
    }
}

// Check if database exists
function databaseExists($config) {
    try {
        $pdo = createConnection($config, false);
        $stmt = $pdo->prepare("SHOW DATABASES LIKE ?");
        $stmt->execute([$config['database']]);
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Database check failed: " . $e->getMessage());
        return false;
    }
}

// Create database
function createDatabase($config) {
    try {
        $pdo = createConnection($config, false);
        $sql = "CREATE DATABASE IF NOT EXISTS `{$config['database']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        $pdo->exec($sql);
        return true;
    } catch (PDOException $e) {
        error_log("Failed to create database: " . $e->getMessage());
        throw new Exception("Failed to create database: " . $e->getMessage());
    }
}

// Create tables
function createTables($config) {
    $pdo = createConnection($config, true);
    
    // Admin users table
    $admin_users_sql = "
        CREATE TABLE IF NOT EXISTS `admin_users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(50) NOT NULL UNIQUE,
            `password` varchar(255) NOT NULL,
            `email` varchar(100) DEFAULT NULL,
            `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";
    
    // Site settings table
    $site_settings_sql = "
        CREATE TABLE IF NOT EXISTS `site_settings` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `setting_key` varchar(100) NOT NULL UNIQUE,
            `setting_value` text,
            `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";
    
    // Page content table
    $page_content_sql = "
        CREATE TABLE IF NOT EXISTS `page_content` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `page_name` varchar(50) NOT NULL,
            `section` varchar(100) NOT NULL,
            `content` longtext,
            `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `page_section` (`page_name`, `section`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";
    
    // Gallery images table
    $gallery_images_sql = "
        CREATE TABLE IF NOT EXISTS `gallery_images` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `page_type` enum('photography','cosplay') NOT NULL,
            `image_path` varchar(255) NOT NULL,
            `title` varchar(200) DEFAULT NULL,
            `description` text,
            `alt_text` varchar(200) DEFAULT NULL,
            `display_order` int(11) DEFAULT 0,
            `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `page_type_order` (`page_type`, `display_order`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";
    
    // Testimonials table
    $testimonials_sql = "
        CREATE TABLE IF NOT EXISTS `testimonials` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) NOT NULL,
            `role` varchar(100) DEFAULT NULL,
            `quote` text NOT NULL,
            `display_order` int(11) DEFAULT 0,
            `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `display_order` (`display_order`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";
    
    // Contact messages table
    $contact_messages_sql = "
        CREATE TABLE IF NOT EXISTS `contact_messages` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(120) NOT NULL,
            `email` varchar(200) NOT NULL,
            `subject` varchar(200) DEFAULT NULL,
            `message` text NOT NULL,
            `ip_address` varchar(64) DEFAULT NULL,
            `user_agent` varchar(255) DEFAULT NULL,
            `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `created_at` (`created_at`),
            KEY `email_idx` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";
    
    // Projects table
    $projects_sql = "
        CREATE TABLE IF NOT EXISTS `projects` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(200) NOT NULL,
            `description` text,
            `image_path` varchar(255) NOT NULL,
            `alt_text` varchar(200) DEFAULT NULL,
            `display_order` int(11) DEFAULT 0,
            `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `display_order` (`display_order`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";

    // Insert dummy contact data after creating site_settings table
    $dummy_contact = [
        'contact_email' => 'jeoliveros@my.cspc.edu.ph',
        'contact_phone' => '+ 63 912 345 6789',
        'contact_location' => 'Region V, Philippines',
        'contact_website' => 'https://myportfolio.com',
        'contact_linkedin' => 'https://www.linkedin.com/in/dummyprofile',
        'contact_instagram' => 'https://www.instagram.com/dummyprofile',
        'contact_twitter' => 'https://twitter.com/dummyprofile',
        'contact_github' => 'https://github.com/dummyprofile',
        'contact_behance' => 'https://www.behance.net/dummyprofile',
        'contact_dribbble' => 'https://dribbble.com/dummyprofile'
    ];

    try {
        $pdo->exec($admin_users_sql);
        $pdo->exec($site_settings_sql);
        $pdo->exec($page_content_sql);
        $pdo->exec($gallery_images_sql);
        $pdo->exec($testimonials_sql);
        $pdo->exec($contact_messages_sql);
        $pdo->exec($projects_sql);

        // Insert dummy contact data
        foreach ($dummy_contact as $k => $v) {
            $stmt = $pdo->prepare("INSERT IGNORE INTO site_settings (setting_key, setting_value) VALUES (?, ?)");
            $stmt->execute([$k, $v]);
        }

        return true;
    } catch (PDOException $e) {
        error_log("Failed to create tables: " . $e->getMessage());
        throw new Exception("Failed to create tables: " . $e->getMessage());
    }
}

// Create default admin account
function createDefaultAdmin($config) {
    $pdo = createConnection($config, true);
    
    // Check if admin already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin_users WHERE username = ?");
    $stmt->execute(['artisan']);
    
    if ($stmt->fetchColumn() > 0) {
        return true; // Admin already exists
    }
    
    // Create default admin account
    $username = 'artisan';
    $password = 'myportfolio67';
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO admin_users (username, password, email) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hashed_password, 'admin@portfolio.com']);
        return true;
    } catch (PDOException $e) {
        error_log("Failed to create default admin: " . $e->getMessage());
        throw new Exception("Failed to create default admin: " . $e->getMessage());
    }
}

// Insert default site settings
function insertDefaultSettings($config) {
    $pdo = createConnection($config, true);
    
    $default_settings = [
        'site_name' => 'My Portfolio',
        'owner_name' => 'Jeroboam T. Oliveros',
        'owner_title' => 'Developer, Photographer & Cosplayer',
        'profile_image' => 'assets/img/content/profiles/profil1.jpg',
        'bio' => 'I craft clean, performant web experiences and tell stories through images and character work. With a background that blends software development, photography, and cosplay, I enjoy projects that balance technical depth with creative polish.',
        'bio_secondary' => 'When I\'m not shipping features, I\'m experimenting with lighting setups, sewing details, or planning the next shoot.',
        'email' => 'hello@example.com',
        'linkedin' => 'https://www.linkedin.com',
        'instagram' => 'https://www.instagram.com',
        'resume_url' => '#',
        // Sample profile data
        'skills' => 'HTML/CSS, JavaScript (ES6+), PHP, MySQL, jQuery, REST APIs, Responsive UI, Accessibility (a11y), SEO, Photography, Studio Lighting, Cosplay Fabrication',
        'tools' => 'VS Code, Git & GitHub, Docker, Postman, Figma, Adobe Photoshop, Adobe Lightroom'
    ];
    
    try {
        foreach ($default_settings as $key => $value) {
            $stmt = $pdo->prepare("INSERT IGNORE INTO site_settings (setting_key, setting_value) VALUES (?, ?)");
            $stmt->execute([$key, $value]);
        }
        return true;
    } catch (PDOException $e) {
        error_log("Failed to insert default settings: " . $e->getMessage());
        throw new Exception("Failed to insert default settings: " . $e->getMessage());
    }
}

// Insert default page content
function insertDefaultContent($config) {
    $pdo = createConnection($config, true);
    
    $default_content = [
        // Index page
        ['index', 'hero_title', 'Hi, I\'m Jerome.'],
        ['index', 'hero_subtitle', 'Developer, Photographer & Cosplayer.'],
        ['index', 'projects_title', 'Projects'],
        ['index', 'projects_description', 'A showcase of my recent development work and creative projects.'],
        
        // Photography page
        ['photography', 'hero_title', 'Hi, I\'m Jerome.'],
        ['photography', 'hero_subtitle', 'Developer, Photographer & Cosplayer.'],
        ['photography', 'page_title', 'Photography'],
        ['photography', 'page_description', 'A selection of my favorite shots. More coming soon.'],
        
        // Cosplay page
        ['cosplay', 'hero_title', 'Cosplay Showcase'],
        ['cosplay', 'hero_subtitle', 'Characters brought to life.'],
        ['cosplay', 'page_title', 'Cosplay'],
        ['cosplay', 'page_description', 'Selected costumes and characters from recent events and shoots.'],
        
        // Kind Words page
        ['kind-words', 'page_title', 'What people say'],
        ['kind-words', 'page_description', 'Testimonials gathered from projects, collaborations, and commissions.'],
        
        // About page
        ['about', 'bio_title', 'Hi, I\'m Jerome.'],
        ['about', 'skills_title', 'Skills'],
        ['about', 'tools_title', 'Tools'],
        
        // Contact page
        ['contact', 'page_title', 'Contact'],
        ['contact', 'page_description', 'Have a project in mind, need photos, or want to collaborate? Send a message and I\'ll get back to you.']
    ];
    
    try {
        foreach ($default_content as $content) {
            $stmt = $pdo->prepare("INSERT IGNORE INTO page_content (page_name, section, content) VALUES (?, ?, ?)");
            $stmt->execute($content);
        }
        return true;
    } catch (PDOException $e) {
        error_log("Failed to insert default content: " . $e->getMessage());
        throw new Exception("Failed to insert default content: " . $e->getMessage());
    }
}

// Insert default testimonials
function insertDefaultTestimonials($config) {
    $pdo = createConnection($config, true);
    
    // If table already has rows, skip seeding to avoid duplicates
    try {
        $count = (int)$pdo->query("SELECT COUNT(*) FROM testimonials")->fetchColumn();
        if ($count > 0) {
            return true;
        }
    } catch (PDOException $e) {
        error_log("Failed counting testimonials: " . $e->getMessage());
        // Continue to attempt inserts; if table missing it will be created by createTables
    }

    $default_testimonials = [
        ['Alex Rivera', 'Product Manager, Northstar', 'Jeroboam exceeded expectations. Fast, communicative, and the final work was stunning.', 1],
        ['Mika Santos', 'Art Director', 'A rare mix of technical skill and creative eye. Our shoot turned out incredible.', 2],
        ['Kenji Tan', 'Cosplay Model', 'Collaborating with Jerome was effortless. Clear direction, great energy, beautiful results.', 3],
        ['Lara Gomez', 'Photographer', 'Delivers on time with polished work. Would happily work together again.', 4]
    ];
    
    try {
        foreach ($default_testimonials as $testimonial) {
            $stmt = $pdo->prepare("INSERT IGNORE INTO testimonials (name, role, quote, display_order) VALUES (?, ?, ?, ?)");
            $stmt->execute($testimonial);
        }
        return true;
    } catch (PDOException $e) {
        error_log("Failed to insert default testimonials: " . $e->getMessage());
        throw new Exception("Failed to insert default testimonials: " . $e->getMessage());
    }
}

// Main initialization function
function initializeDatabase($config) {
    try {
        // Check if database exists
        if (!databaseExists($config)) {
            createDatabase($config);
        }
        
        // Create tables
        createTables($config);
        
        // Create default admin
        createDefaultAdmin($config);
        
        // Insert default settings
        insertDefaultSettings($config);
        
        // Insert default content
        insertDefaultContent($config);
        
        // Insert default testimonials
        insertDefaultTestimonials($config);
        
        return true;
    } catch (Exception $e) {
        error_log("Database initialization failed: " . $e->getMessage());
        throw $e;
    }
}

// Get database connection for use in other files
function getDatabaseConnection($config) {
    return createConnection($config, true);
}

// Utility function to get site setting
function getSiteSetting($config, $key, $default = null) {
    try {
        $pdo = getDatabaseConnection($config);
        $stmt = $pdo->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch();
        return $result ? $result['setting_value'] : $default;
    } catch (Exception $e) {
        error_log("Failed to get site setting: " . $e->getMessage());
        return $default;
    }
}

// Utility function to update site setting
function updateSiteSetting($config, $key, $value) {
    try {
        $pdo = getDatabaseConnection($config);
        $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
        $stmt->execute([$key, $value]);
        return true;
    } catch (Exception $e) {
        error_log("Failed to update site setting: " . $e->getMessage());
        return false;
    }
}

// Utility function to get page content
function getPageContent($config, $page_name, $section, $default = null) {
    try {
        $pdo = getDatabaseConnection($config);
        $stmt = $pdo->prepare("SELECT content FROM page_content WHERE page_name = ? AND section = ?");
        $stmt->execute([$page_name, $section]);
        $result = $stmt->fetch();
        return $result ? $result['content'] : $default;
    } catch (Exception $e) {
        error_log("Failed to get page content: " . $e->getMessage());
        return $default;
    }
}

// Utility function to update page content
function updatePageContent($config, $page_name, $section, $content) {
    try {
        $pdo = getDatabaseConnection($config);
        $stmt = $pdo->prepare("INSERT INTO page_content (page_name, section, content) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE content = VALUES(content)");
        $stmt->execute([$page_name, $section, $content]);
        return true;
    } catch (Exception $e) {
        error_log("Failed to update page content: " . $e->getMessage());
        return false;
    }
}

// Run initialization if this file is accessed directly
if (basename($_SERVER['PHP_SELF']) === 'db.php') {
    try {
        initializeDatabase($db_config);
        echo "Database initialized successfully!";
    } catch (Exception $e) {
        echo "Database initialization failed: " . $e->getMessage();
    }
}

?>