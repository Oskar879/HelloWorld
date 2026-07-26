<?php
header("Content-Type: application/json");

$conn = new mysqli("sql108.infinityfree.com", "if0_42344312", "salkhsa776ss", "if0_42344312_hwdb");

if ($conn->connect_error) {
    die("DB error");
}

// DEBUG (näyttää mitä frontend lähettää)
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

// fallback jos JSON ei toimi
if (!$data) {
    $data = $_POST;
}

$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

$timezone = $data['timezone'] ?? 'missing';
$language = $data['language'] ?? 'missing';
// DEBUG vastaus
// echo json_encode($data); exit;

$stmt = $conn->prepare("INSERT INTO visits (ip, timezone, language, user_agent) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $ip, $timezone, $language, $user_agent);
$stmt->execute();

echo json_encode([
    "status" => "ok",
    "received" => $data
]);
?>