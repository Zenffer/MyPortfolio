<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: public, max-age=300');

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'db.php';

$config = $db_config;

$cosplay_id = isset($_GET['cosplay_id']) ? (int)$_GET['cosplay_id'] : 0;

if ($cosplay_id <= 0) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Cosplay ID required']);
    exit;
}

try {
    $pdo = getDatabaseConnection($config);
    $stmt = $pdo->prepare("SELECT id, cosplay_id, image_path, alt_text, display_order, grid_size FROM cosplay_images WHERE cosplay_id = ? ORDER BY display_order ASC, id ASC");
    $stmt->execute([$cosplay_id]);
    $rows = $stmt->fetchAll();
    echo json_encode(['ok' => true, 'data' => $rows]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Server error']);
}
?>

