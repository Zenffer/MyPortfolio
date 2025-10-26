<?php
session_start();
require_once 'db.php';

// Database configuration
$db_config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'portfolio_db',
    'charset' => 'utf8mb4'
];

// Initialize database if needed
initializeDatabase($db_config);

// Get database connection
$pdo = getDatabaseConnection($db_config);

// Authenticate user
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    try {
        // Get user from database
        $stmt = $pdo->prepare("SELECT id, username, password FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['authenticated'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: dashboard.php');
            exit();
        } else {
            header('Location: login.php?error=1');
            exit();
        }
    } catch (PDOException $e) {
        error_log("Authentication error: " . $e->getMessage());
        header('Location: login.php?error=1');
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}
?>