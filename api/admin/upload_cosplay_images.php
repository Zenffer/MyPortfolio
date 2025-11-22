<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// Require authenticated admin
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'Unauthorized']);
    exit;
}

$cosplay_id = isset($_POST['cosplay_id']) ? (int)$_POST['cosplay_id'] : 0;
$grid_size = isset($_POST['grid_size']) ? trim($_POST['grid_size']) : 'medium';

if ($cosplay_id <= 0) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Cosplay ID required']);
    exit;
}

// Validate grid_size
if (!in_array($grid_size, ['small', 'medium', 'large'])) {
    $grid_size = 'medium';
}

if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'No files uploaded']);
    exit;
}

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'db.php';

$config = $db_config;

try {
    $pdo = getDatabaseConnection($config);
    
    // Verify cosplay exists
    $stmt = $pdo->prepare("SELECT id FROM cosplay WHERE id = ?");
    $stmt->execute([$cosplay_id]);
    if (!$stmt->fetch()) {
        http_response_code(404);
        echo json_encode(['ok' => false, 'error' => 'Cosplay not found']);
        exit;
    }
    
    $uploadDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . 'cosplay' . DIRECTORY_SEPARATOR;
    
    // Create directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'];
    $maxSize = 10 * 1024 * 1024; // 10MB
    $uploadedImages = [];
    $errors = [];
    
    $files = $_FILES['images'];
    $fileCount = count($files['name']);
    
    // Get current max display_order
    $maxOrder = (int)$pdo->query("SELECT COALESCE(MAX(display_order),0) FROM cosplay_images WHERE cosplay_id = " . $cosplay_id)->fetchColumn();
    $currentOrder = $maxOrder + 1;
    
    for ($i = 0; $i < $fileCount; $i++) {
        if ($files['error'][$i] !== UPLOAD_ERR_OK) {
            $errors[] = "File " . ($i + 1) . ": Upload error";
            continue;
        }
        
        if ($files['size'][$i] > $maxSize) {
            $errors[] = "File " . ($i + 1) . ": File too large (max 10MB)";
            continue;
        }
        
        $fileType = mime_content_type($files['tmp_name'][$i]);
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "File " . ($i + 1) . ": Invalid file type";
            continue;
        }
        
        // Generate unique filename
        $extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
        $filename = 'cosplay_' . $cosplay_id . '_' . time() . '_' . $i . '.' . $extension;
        $filepath = $uploadDir . $filename;
        
        if (move_uploaded_file($files['tmp_name'][$i], $filepath)) {
            $relativePath = 'assets/img/content/cosplay/' . $filename;
            
            // Insert into database
            $stmt = $pdo->prepare("INSERT INTO cosplay_images (cosplay_id, image_path, display_order, grid_size) VALUES (?, ?, ?, ?)");
            $stmt->execute([$cosplay_id, $relativePath, $currentOrder, $grid_size]);
            
            $uploadedImages[] = [
                'id' => (int)$pdo->lastInsertId(),
                'image_path' => $relativePath,
                'display_order' => $currentOrder,
                'grid_size' => $grid_size
            ];
            
            $currentOrder++;
        } else {
            $errors[] = "File " . ($i + 1) . ": Failed to save file";
        }
    }
    
    if (empty($uploadedImages) && !empty($errors)) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => implode(', ', $errors)]);
        exit;
    }
    
    echo json_encode([
        'ok' => true,
        'uploaded' => $uploadedImages,
        'errors' => $errors
    ]);
    
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Server error: ' . $e->getMessage()]);
}
?>

