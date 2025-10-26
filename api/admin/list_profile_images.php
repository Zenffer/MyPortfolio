<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'db.php';

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'Unauthorized']);
    exit;
}

$config = $db_config;

// Get the profiles directory
$profilesDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . 'profiles';

try {
    $images = [];
    
    // Check if directory exists
    if (is_dir($profilesDir)) {
        // Get all image files
        $files = glob($profilesDir . DIRECTORY_SEPARATOR . '*.{jpg,jpeg,png,webp}', GLOB_BRACE);
        
        foreach ($files as $file) {
            $filename = basename($file);
            $images[] = [
                'filename' => $filename,
                'url' => 'assets/img/content/profiles/' . $filename,
                'size' => filesize($file),
                'modified' => filemtime($file),
                'is_default' => ($filename === 'profil1.jpg')
            ];
        }
        
        // Sort by modification time, newest first
        usort($images, function($a, $b) {
            return $b['modified'] - $a['modified'];
        });
    }
    
    echo json_encode([
        'ok' => true,
        'images' => $images,
        'count' => count($images)
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Failed to list images: ' . $e->getMessage()]);
}
?>
