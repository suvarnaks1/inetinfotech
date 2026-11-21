<?php
require 'db.php';
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['title'])) {
    echo json_encode(["error" => "Title required"]); exit;
}

$stmt = $conn->prepare("INSERT INTO services (title, short_desc, icon, long_desc, features, best_for, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
$features = implode("\n", $data['features'] ?? []);
$stmt->bind_param("sssssss", $data['title'], $data['short_desc'], $data['icon'], $data['long_desc'], $features, $data['best_for'], $data['status']);

echo json_encode(["success" => $stmt->execute(), "id" => $conn->insert_id]);
?>