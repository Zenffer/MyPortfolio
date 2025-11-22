<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// Require authenticated admin
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'Unauthorized']);
    exit;
}

$photography_id = isset($_POST['photography_id']) ? (int)$_POST['photography_id'] : 0;
$grid_size = isset($_POST['grid_size']) ? trim($_POST['grid_size']) : 'medium';

if ($photography_id <= 0) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Photography ID required']);
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
    
    // Verify photography exists
    $stmt = $pdo->prepare("SELECT id FROM photography WHERE id = ?");
    $stmt->execute([$photography_id]);
    if (!$stmt->fetch()) {
        http_response_code(404);
        echo json_encode(['ok' => false, 'error' => 'Photography not found']);
        exit;
    }
    
    $uploadDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . 'photography' . DIRECTORY_SEPARATOR;
    
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
    $maxOrder = (int)$pdo->query("SELECT COALESCE(MAX(display_order),0) FROM photography_images WHERE photography_id = " . $photography_id)->fetchColumn();
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
        $filename = 'photo_' . $photography_id . '_' . time() . '_' . $i . '.' . $extension;
        $filepath = $uploadDir . $filename;
        
        if (move_uploaded_file($files['tmp_name'][$i], $filepath)) {
            $relativePath = 'assets/img/content/photography/' . $filename;
            
            // Insert into database
            $stmt = $pdo->prepare("INSERT INTO photography_images (photography_id, image_path, display_order, grid_size) VALUES (?, ?, ?, ?)");
            $stmt->execute([$photography_id, $relativePath, $currentOrder, $grid_size]);
            
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

