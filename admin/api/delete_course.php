<?php
require 'db.php';
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM courses WHERE id=?");
$stmt->bind_param("i", $id);
echo json_encode(["success" => $stmt->execute()]);
?>