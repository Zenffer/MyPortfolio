<?php
// Public API endpoint to fetch testimonials as JSON
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'db.php';

// Use the same config as db.php defaults
$config = $db_config;

try {
    // Connect to existing database; if it doesn't exist yet, create DB and tables (no seeding)
    try {
        $pdo = getDatabaseConnection($config);
    } catch (Throwable $connErr) {
        // Attempt minimal initialization without inserting seed rows
        if (!databaseExists($config)) {
            createDatabase($config);
        }
        createTables($config);
        $pdo = getDatabaseConnection($config);
    }

    $stmt = $pdo->prepare("SELECT id, name, role, quote, display_order, created_at, updated_at FROM testimonials ORDER BY display_order ASC, id ASC");
    $stmt->execute();
    $rows = $stmt->fetchAll();

    echo json_encode([
        'ok' => true,
        'count' => count($rows),
        'data' => $rows
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'error' => 'Failed to load testimonials.'
    ]);
}
?>


