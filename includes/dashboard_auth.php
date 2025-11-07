<?php
// Start session and include database configuration
session_start();
require_once __DIR__ . '/../db.php';

// Authentication check - redirect to login if not authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: login.php');
    exit();
}

// Database configuration settings
$db_config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'portfolio_db',
    'charset' => 'utf8mb4'
];

// Initialize database connection
initializeDatabase($db_config);
$pdo = getDatabaseConnection($db_config);
?>

