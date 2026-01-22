<?php
require_once __DIR__ . '/dbconnection.php';

header('Content-Type: application/json');

if (!isset($_POST['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing ID"]);
    exit;
}

$id = intval($_POST['id']);

$stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

echo json_encode(["success" => true]);
