<?php
require_once 'dbconnection.php';

$name  = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');

if (empty($name) || empty($email)) {
    die("Name and email are required");
}

// Prevent duplicates
$stmt = $conn->prepare("SELECT id FROM enrollment WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    header("Location: ../index.php?status=duplicate");
    exit();
}

try {
    $stmt = $conn->prepare("INSERT INTO enrollment (name, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $email);
    $stmt->execute();

    header("Location: ../index.php?status=success");
    exit();
} catch (Exception $e) {
    die("Insert failed: " . $e->getMessage());
}
?>
