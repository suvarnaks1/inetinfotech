<?php
require 'db.php';
$data = json_decode(file_get_contents("php://input"), true);
$stmt = $conn->prepare("DELETE FROM services WHERE id=?");
$stmt->bind_param("i", $data['id']);
echo json_encode(["success" => $stmt->execute()]);
?>