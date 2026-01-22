<?php
require_once 'dbconnection.php';

$result = $conn->query("SELECT id, name, email FROM students ORDER BY id DESC");
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
