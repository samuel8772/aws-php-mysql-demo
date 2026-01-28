<?php
require_once __DIR__ . '/dbconnection.php';

header('Content-Type: application/json');

$id    = intval($_POST['id']);
$name  = trim($_POST['name']);
$email = trim($_POST['email']);

$stmt = $conn->prepare(
    "UPDATE enrollment SET fullname = ?, email = ? WHERE id = ?"
);
$stmt->bind_param("ssi", $name, $email, $id);
$stmt->execute();

echo json_encode(["success" => true]);
