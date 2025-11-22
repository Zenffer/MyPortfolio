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
        // Get single photography by id
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id > 0) {
            $stmt = $pdo->prepare("SELECT id, title, description, image_path, alt_text, display_order, created_at, updated_at FROM photography WHERE id = ?");
            $stmt->execute([$id]);
            $photo = $stmt->fetch();
            if ($photo) {
                echo json_encode(['ok' => true, 'data' => $photo]);
            } else {
                http_response_code(404);
                echo json_encode(['ok' => false, 'error' => 'Photo not found']);
            }
            exit;
        }
        
        // List all photography
        $stmt = $pdo->prepare("SELECT id, title, description, image_path, alt_text, display_order, created_at, updated_at FROM photography ORDER BY display_order ASC, id ASC");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        echo json_encode(['ok' => true, 'data' => $rows]);
        exit;
    }

    if ($method === 'POST' && $action === 'create') {
        $title = trim($input['title'] ?? '');
        $description = trim($input['description'] ?? '');
        $image_path = trim($input['image_path'] ?? '');
        $alt_text = trim($input['alt_text'] ?? '');
        
        if ($title === '' || $image_path === '') {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Title and image path are required']);
            exit;
        }
        
        // Compute next display order
        $next = (int)$pdo->query("SELECT COALESCE(MAX(display_order),0)+1 FROM photography")->fetchColumn();
        $stmt = $pdo->prepare("INSERT INTO photography (title, description, image_path, alt_text, display_order) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description ?: null, $image_path, $alt_text ?: null, $next]);
        echo json_encode(['ok' => true, 'id' => (int)$pdo->lastInsertId()]);
        exit;
    }

    if ($method === 'POST' && $action === 'update') {
        $id = (int)($input['id'] ?? 0);
        $title = trim($input['title'] ?? '');
        $description = trim($input['description'] ?? '');
        $image_path = trim($input['image_path'] ?? '');
        $alt_text = trim($input['alt_text'] ?? '');
        
        if ($id <= 0 || $title === '' || $image_path === '') {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Invalid payload']);
            exit;
        }
        
        $stmt = $pdo->prepare("UPDATE photography SET title = ?, description = ?, image_path = ?, alt_text = ? WHERE id = ?");
        $stmt->execute([$title, $description ?: null, $image_path, $alt_text ?: null, $id]);
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
        
        // Get image path before deleting
        $stmt = $pdo->prepare("SELECT image_path FROM photography WHERE id = ?");
        $stmt->execute([$id]);
        $photo = $stmt->fetch();
        
        // Delete the photo
        $stmt = $pdo->prepare("DELETE FROM photography WHERE id = ?");
        $stmt->execute([$id]);
        
        // Delete associated image file if it exists and is in our photography folder
        if ($photo && !empty($photo['image_path'])) {
            $imagePath = $photo['image_path'];
            // Only delete if it's a local file (starts with assets/img/content/photography/)
            if (strpos($imagePath, 'assets/img/content/photography/') === 0) {
                $fullPath = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . $imagePath;
                if (file_exists($fullPath)) {
                    @unlink($fullPath);
                }
            }
        }
        
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
        $stmt = $pdo->prepare("UPDATE photography SET display_order = ? WHERE id = ?");
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

