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
$pdo = getDatabaseConnection($config);

$method = $_SERVER['REQUEST_METHOD'];
$raw = file_get_contents('php://input');
$input = $raw ? json_decode($raw, true) : [];

try {
    if ($method === 'GET') {
        $page = $_GET['page'] ?? '';
        $section = $_GET['section'] ?? '';
        if ($page === '' || $section === '') {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Missing params']);
            exit;
        }
        $stmt = $pdo->prepare('SELECT content FROM page_content WHERE page_name = ? AND section = ?');
        $stmt->execute([$page, $section]);
        $row = $stmt->fetch();
        echo json_encode(['ok' => true, 'content' => $row ? $row['content'] : null]);
        exit;
    }

    if ($method === 'POST') {
        $page = trim($input['page'] ?? '');
        $section = trim($input['section'] ?? '');
        $content = (string)($input['content'] ?? '');
        if ($page === '' || $section === '') {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Invalid payload']);
            exit;
        }
        $stmt = $pdo->prepare('INSERT INTO page_content (page_name, section, content) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE content = VALUES(content)');
        $stmt->execute([$page, $section, $content]);
        echo json_encode(['ok' => true]);
        exit;
    }

    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Server error']);
}
?>


