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
        // Optional comma-separated keys: ?keys=owner_name,owner_title
        $keysParam = isset($_GET['keys']) ? trim($_GET['keys']) : '';
        if ($keysParam !== '') {
            $keys = array_values(array_filter(array_map('trim', explode(',', $keysParam))));
            if (empty($keys)) {
                echo json_encode(['ok' => true, 'data' => new stdClass()]);
                exit;
            }
            $placeholders = implode(',', array_fill(0, count($keys), '?'));
            $stmt = $pdo->prepare("SELECT setting_key, setting_value FROM site_settings WHERE setting_key IN ($placeholders)");
            $stmt->execute($keys);
        } else {
            $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
        }
        $rows = $stmt->fetchAll();
        $data = [];
        foreach ($rows as $row) {
            $data[$row['setting_key']] = $row['setting_value'];
        }
        echo json_encode(['ok' => true, 'data' => $data]);
        exit;
    }

    if ($method === 'POST') {
        // Expect { updates: { key: value, ... } }
        $updates = isset($input['updates']) && is_array($input['updates']) ? $input['updates'] : [];
        if (empty($updates)) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'No updates provided']);
            exit;
        }
        $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
        foreach ($updates as $k => $v) {
            $key = trim((string)$k);
            $val = (string)$v;
            if ($key === '') continue;
            $stmt->execute([$key, $val]);
        }
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


