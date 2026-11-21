<?php
require 'db.php';
$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['id'])) { echo json_encode(["error" => "ID required"]); exit; }

$stmt = $conn->prepare("UPDATE services SET title=?, short_desc=?, icon=?, long_desc=?, features=?, best_for=?, status=? WHERE id=?");
$features = implode("\n", $data['features'] ?? []);
$stmt->bind_param("sssssssi", $data['title'], $data['short_desc'], $data['icon'], $data['long_desc'], $features, $data['best_for'], $data['status'], $data['id']);

echo json_encode(["success" => $stmt->execute()]);
?>