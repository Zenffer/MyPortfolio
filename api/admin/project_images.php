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
$project_id = isset($_GET['project_id']) ? (int)$_GET['project_id'] : (isset($input['project_id']) ? (int)$input['project_id'] : 0);

try {
    if ($method === 'GET') {
        // List images for a project
        if ($project_id <= 0) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Project ID required']);
            exit;
        }
        
        $stmt = $pdo->prepare("SELECT id, project_id, image_path, alt_text, display_order, grid_size, created_at FROM project_images WHERE project_id = ? ORDER BY display_order ASC, id ASC");
        $stmt->execute([$project_id]);
        $rows = $stmt->fetchAll();
        echo json_encode(['ok' => true, 'data' => $rows]);
        exit;
    }

    if ($method === 'POST' && $action === 'upload') {
        $project_id = (int)($input['project_id'] ?? 0);
        $image_path = trim($input['image_path'] ?? '');
        $alt_text = trim($input['alt_text'] ?? '');
        $grid_size = trim($input['grid_size'] ?? 'medium');
        
        // Validate grid_size
        if (!in_array($grid_size, ['small', 'medium', 'large'])) {
            $grid_size = 'medium';
        }
        
        if ($project_id <= 0 || $image_path === '') {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Project ID and image path are required']);
            exit;
        }
        
        // Verify project exists
        $stmt = $pdo->prepare("SELECT id FROM projects WHERE id = ?");
        $stmt->execute([$project_id]);
        if (!$stmt->fetch()) {
            http_response_code(404);
            echo json_encode(['ok' => false, 'error' => 'Project not found']);
            exit;
        }
        
        // Compute next display order
        $next = (int)$pdo->query("SELECT COALESCE(MAX(display_order),0)+1 FROM project_images WHERE project_id = " . $project_id)->fetchColumn();
        $stmt = $pdo->prepare("INSERT INTO project_images (project_id, image_path, alt_text, display_order, grid_size) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$project_id, $image_path, $alt_text ?: null, $next, $grid_size]);
        echo json_encode(['ok' => true, 'id' => (int)$pdo->lastInsertId()]);
        exit;
    }

    if ($method === 'POST' && $action === 'update') {
        $id = (int)($input['id'] ?? 0);
        $alt_text = trim($input['alt_text'] ?? '');
        $grid_size = trim($input['grid_size'] ?? 'medium');
        
        // Validate grid_size
        if (!in_array($grid_size, ['small', 'medium', 'large'])) {
            $grid_size = 'medium';
        }
        
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Invalid id']);
            exit;
        }
        
        $stmt = $pdo->prepare("UPDATE project_images SET alt_text = ?, grid_size = ? WHERE id = ?");
        $stmt->execute([$alt_text ?: null, $grid_size, $id]);
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
        $stmt = $pdo->prepare("SELECT image_path FROM project_images WHERE id = ?");
        $stmt->execute([$id]);
        $image = $stmt->fetch();
        
        // Delete the image record
        $stmt = $pdo->prepare("DELETE FROM project_images WHERE id = ?");
        $stmt->execute([$id]);
        
        // Delete associated image file if it exists and is in our projects folder
        if ($image && !empty($image['image_path'])) {
            $imagePath = $image['image_path'];
            // Only delete if it's a local file (starts with assets/img/content/projects/)
            if (strpos($imagePath, 'assets/img/content/projects/') === 0) {
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
        $stmt = $pdo->prepare("UPDATE project_images SET display_order = ? WHERE id = ?");
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
    echo json_encode(['ok' => false, 'error' => 'Server error: ' . $e->getMessage()]);
}
?>

