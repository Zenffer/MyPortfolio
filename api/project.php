<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: public, max-age=300');

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'db.php';

$config = $db_config;

$slug = $_GET['slug'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (empty($slug) && $id <= 0) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Slug or ID required']);
    exit;
}

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
        http_response_code(404);
        echo json_encode(['ok' => false, 'error' => 'Project not found']);
        exit;
    }
    
    // Get project images
    $imgStmt = $pdo->prepare("SELECT id, image_path, alt_text, display_order, grid_size FROM project_images WHERE project_id = ? ORDER BY display_order ASC, id ASC");
    $imgStmt->execute([$project['id']]);
    $project['images'] = $imgStmt->fetchAll();
    
    echo json_encode(['ok' => true, 'data' => $project]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Server error']);
}
?>

