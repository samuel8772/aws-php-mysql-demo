<?php
require_once 'dbconnection.php';

$result = $conn->query("SELECT id, fullname, email, gender, phonenumber FROM enrollment ORDER BY id DESC");
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
