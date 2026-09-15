<?php
// api/contact.php - Contact Form & Lead Submission Handler for Hostinger
require_once __DIR__ . '/../includes/config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

// Support both JSON body and standard URL-encoded form data
$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if (!$data) {
    $data = $_POST;
}

$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$phone = trim($data['phone'] ?? '');
$service = trim($data['service_type'] ?? 'Web Systems');
$message = trim($data['message'] ?? '');

if (empty($name) || empty($email) || empty($message)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields (name, email, message).']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please provide a valid email address.']);
    exit;
}

// Log inquiry to file for persistence on Hostinger
$contactRecord = [
    'id' => time() . '_' . rand(1000, 9999),
    'name' => htmlspecialchars($name),
    'email' => htmlspecialchars($email),
    'phone' => htmlspecialchars($phone),
    'service' => htmlspecialchars($service),
    'message' => htmlspecialchars($message),
    'created_at' => date('Y-m-d H:i:s')
];

$contactsFile = DATA_DIR . '/contacts.json';
$current = file_exists($contactsFile) ? json_decode(file_get_contents($contactsFile), true) : [];
if (!is_array($current)) $current = [];
$current[] = $contactRecord;
file_put_contents($contactsFile, json_encode($current, JSON_PRETTY_PRINT));

echo json_encode([
    'success' => true,
    'message' => 'Thank you! Your message has been received. Our team will contact you shortly.',
    'lead' => $contactRecord
]);
