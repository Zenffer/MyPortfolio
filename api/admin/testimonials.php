<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'db.php';

// Require authenticated admin
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'Unauthorized']);
    exit;
}

$config = $db_config;

try {
    $pdo = getDatabaseConnection($config);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'DB connection failed']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

// Read JSON body if present
$input = [];
if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
    $raw = file_get_contents('php://input');
    if ($raw) {
        $parsed = json_decode($raw, true);
        if (is_array($parsed)) {
            $input = $parsed;
        }
    }
}

// Action routing
$action = $_GET['action'] ?? $input['action'] ?? null;

try {
    if ($method === 'GET') {
        // List
        $stmt = $pdo->prepare("SELECT id, name, role, quote, display_order, created_at, updated_at FROM testimonials ORDER BY display_order ASC, id ASC");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        echo json_encode(['ok' => true, 'data' => $rows]);
        exit;
    }

    if ($method === 'POST' && $action === 'create') {
        $name = trim($input['name'] ?? '');
        $role = trim($input['role'] ?? '');
        $quote = trim($input['quote'] ?? '');
        if ($name === '' || $quote === '') {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Name and quote are required']);
            exit;
        }
        // Compute next display order
        $next = (int)$pdo->query("SELECT COALESCE(MAX(display_order),0)+1 FROM testimonials")->fetchColumn();
        $stmt = $pdo->prepare("INSERT INTO testimonials (name, role, quote, display_order) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $role ?: null, $quote, $next]);
        echo json_encode(['ok' => true, 'id' => (int)$pdo->lastInsertId() ]);
        exit;
    }

    if ($method === 'POST' && $action === 'update') {
        $id = (int)($input['id'] ?? 0);
        $name = trim($input['name'] ?? '');
        $role = trim($input['role'] ?? '');
        $quote = trim($input['quote'] ?? '');
        if ($id <= 0 || $name === '' || $quote === '') {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Invalid payload']);
            exit;
        }
        $stmt = $pdo->prepare("UPDATE testimonials SET name = ?, role = ?, quote = ? WHERE id = ?");
        $stmt->execute([$name, $role ?: null, $quote, $id]);
        echo json_encode(['ok' => true]);
        exit;
    }

    if ($method === 'POST' && $action === 'delete') {
        $id = (int)($input['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Invalid id']);
            exit;
        }
        $stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['ok' => true]);
        exit;
    }

    if ($method === 'POST' && $action === 'reorder') {
        // Expect an array of {id, display_order}
        $items = $input['items'] ?? [];
        if (!is_array($items)) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Invalid items']);
            exit;
        }
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("UPDATE testimonials SET display_order = ? WHERE id = ?");
        foreach ($items as $it) {
            $id = (int)($it['id'] ?? 0);
            $order = (int)($it['display_order'] ?? 0);
            if ($id > 0) {
                $stmt->execute([$order, $id]);
            }
        }
        $pdo->commit();
        echo json_encode(['ok' => true]);
        exit;
    }

    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Unsupported operation']);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Server error']);
}
?>


