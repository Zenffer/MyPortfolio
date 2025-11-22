<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: public, max-age=300');

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'db.php';

$config = $db_config;

$project_id = isset($_GET['project_id']) ? (int)$_GET['project_id'] : 0;

if ($project_id <= 0) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Project ID required']);
    exit;
}

try {
    $pdo = getDatabaseConnection($config);
    $stmt = $pdo->prepare("SELECT id, project_id, image_path, alt_text, display_order, grid_size FROM project_images WHERE project_id = ? ORDER BY display_order ASC, id ASC");
    $stmt->execute([$project_id]);
    $rows = $stmt->fetchAll();
    echo json_encode(['ok' => true, 'data' => $rows]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Server error']);
}
?>

