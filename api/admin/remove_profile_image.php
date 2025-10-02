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

// Get the request data
$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['filename']) || empty($input['filename'])) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'No filename provided']);
    exit;
}

$filename = $input['filename'];

// Security check - only allow profile_* files (not profil1.jpg)
if ($filename === 'profil1.jpg') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Cannot delete default profile image']);
    exit;
}

if (!preg_match('/^profile_\d+_[a-f0-9]+\.(jpg|jpeg|png|webp)$/', $filename)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Invalid filename format']);
    exit;
}

// Get the profiles directory
$profilesDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . 'profiles';
$filePath = $profilesDir . DIRECTORY_SEPARATOR . $filename;

// Check if file exists
if (!file_exists($filePath)) {
    http_response_code(404);
    echo json_encode(['ok' => false, 'error' => 'File not found']);
    exit;
}

// Check if this is the current profile image
try {
    $pdo = getDatabaseConnection($config);
    $stmt = $pdo->prepare("SELECT setting_value FROM site_settings WHERE setting_key = 'profile_image'");
    $stmt->execute();
    $result = $stmt->fetch();
    
    if ($result && $result['setting_value'] === 'assets/img/content/profiles/' . $filename) {
        // If this is the current profile image, reset to default
        $stmt = $pdo->prepare("UPDATE site_settings SET setting_value = 'assets/img/content/profiles/profil1.jpg' WHERE setting_key = 'profile_image'");
        $stmt->execute();
    }
} catch (Exception $e) {
    // Ignore database errors
}

// Delete the file
if (unlink($filePath)) {
    echo json_encode([
        'ok' => true,
        'message' => 'Image deleted successfully'
    ]);
} else {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Failed to delete file']);
}
?>
