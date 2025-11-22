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

// Ensure upload dir exists
$uploadDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . 'projects';
if (!is_dir($uploadDir)) {
    if (!@mkdir($uploadDir, 0755, true)) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Failed to create upload directory']);
        exit;
    }
}

if (!isset($_FILES['file'])) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'No file uploaded']);
    exit;
}

$file = $_FILES['file'];
if ($file['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Upload error: ' . $file['error']]);
    exit;
}

// Check file size (max 10MB for project images)
if ($file['size'] > 10 * 1024 * 1024) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'File too large. Maximum size is 10MB.']);
    exit;
}

// Basic validation
$allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);
if (!isset($allowed[$mime])) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Unsupported file type. Please upload JPG, PNG, WebP, or GIF images.']);
    exit;
}

$ext = $allowed[$mime];
$basename = 'project_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
$destPath = $uploadDir . DIRECTORY_SEPARATOR . $basename;

if (!move_uploaded_file($file['tmp_name'], $destPath)) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Failed to move file']);
    exit;
}

// Public URL (relative path)
$publicUrl = 'assets/img/content/projects/' . $basename;

// Return success with the new URL
echo json_encode([
    'ok' => true, 
    'url' => $publicUrl,
    'message' => 'Project image uploaded successfully'
]);
?>

