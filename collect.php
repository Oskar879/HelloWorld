<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$conn = new mysqli("sqlXXX.epizy.com", "if0_42344312", "dnjUpkouhFS", "if0_42344312_visitors_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

$ip = $_SERVER['REMOTE_ADDR'];

$timezone = $data['timezone'] ?? '';
$language = $data['language'] ?? '';
$userAgent = $data['userAgent'] ?? '';
$visitTime = date("Y-m-d H:i:s");

$stmt = $conn->prepare("INSERT INTO visits (ip, timezone, language, user_agent, visit_time) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $ip, $timezone, $language, $userAgent, $visitTime);

$stmt->execute();

echo "OK";
?>