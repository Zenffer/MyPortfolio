<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: public, max-age=300');

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'db.php';

$config = $db_config;

try {
    $pdo = getDatabaseConnection($config);
    $stmt = $pdo->prepare("SELECT id, title, description, image_path, alt_text, display_order FROM photography ORDER BY display_order ASC, id ASC");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    echo json_encode(['ok' => true, 'data' => $rows]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Server error']);
}
?>

