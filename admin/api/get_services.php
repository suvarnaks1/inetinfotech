<?php
require 'db.php';
$result = $conn->query("SELECT * FROM services WHERE status='published' ORDER BY id DESC");
$services = [];
while ($row = $result->fetch_assoc()) {
    $row['features'] = explode("\n", $row['features'] ?? '');
    $services[] = $row;
}
echo json_encode($services);
?>