<?php
// Public API endpoint to accept contact form submissions
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'db.php';

$config = $db_config;

// Allow only POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

// Parse JSON body
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data)) {
    // Fallback to form-encoded
    $data = $_POST;
}

// Basic honeypot check
$honeypot = isset($data['website']) ? trim((string)$data['website']) : '';
if ($honeypot !== '') {
    // Pretend success
    echo json_encode(['ok' => true, 'message' => 'Thanks!']);
    exit;
}

$name = isset($data['name']) ? trim((string)$data['name']) : '';
$email = isset($data['email']) ? trim((string)$data['email']) : '';
$subject = isset($data['subject']) ? trim((string)$data['subject']) : '';
$message = isset($data['message']) ? trim((string)$data['message']) : '';

// Validate
if ($name === '' || $email === '' || $message === '') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Please fill in name, email, and message.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Invalid email address.']);
    exit;
}

// Rate limiting (simple): limit per IP per minute
function getClientIp() {
    $keys = ['HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','REMOTE_ADDR'];
    foreach ($keys as $k) {
        if (!empty($_SERVER[$k])) {
            $ip = $_SERVER[$k];
            if ($k === 'HTTP_X_FORWARDED_FOR') {
                $parts = explode(',', $ip);
                $ip = trim($parts[0]);
            }
            return $ip;
        }
    }
    return '0.0.0.0';
}

try {
    // Ensure DB and tables exist
    try {
        $pdo = getDatabaseConnection($config);
    } catch (Throwable $connErr) {
        if (!databaseExists($config)) { createDatabase($config); }
        createTables($config);
        $pdo = getDatabaseConnection($config);
    }

    $ip = substr(getClientIp(), 0, 64);
    $ua = isset($_SERVER['HTTP_USER_AGENT']) ? substr((string)$_SERVER['HTTP_USER_AGENT'], 0, 255) : null;

    // Optional: naive rate limit using last minute window
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM contact_messages WHERE ip_address = ? AND created_at >= (NOW() - INTERVAL 1 MINUTE)");
    $stmt->execute([$ip]);
    $recent = (int)$stmt->fetchColumn();
    if ($recent > 4) { // max 5 per minute
        http_response_code(429);
        echo json_encode(['ok' => false, 'error' => 'Too many requests. Please try again later.']);
        exit;
    }

    // Insert
    $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message, ip_address, user_agent) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $subject, $message, $ip, $ua]);

    return ['ok' => true, 'message' => 'Thanks! Your message has been sent.'];
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Failed to send message.']);
}
?>


