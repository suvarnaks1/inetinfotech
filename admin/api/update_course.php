<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'db.php';
$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['id']) || empty($data['title'])) { 
    echo json_encode(["error" => "ID and Title required"]); 
    exit; 
}

$id = $data['id'];
$title = $data['title'];
$category = $data['c'] ?? ''; 
$tag = $data['tag'] ?? '';
$icon = $data['icon'] ?? '';
$status = $data['status'] ?? 'published';
$image = $data['img'] ?? ''; 
$position = $data['pos'] ?? 'center';
$fit = $data['fit'] ?? 'cover';
$alt_text = $data['alt'] ?? '';
$description = $data['desc'] ?? ''; 
$meta = $data['meta'] ?? '';
$fee = $data['fee'] ?? '';
$feeNote = $data['feeNote'] ?? '';
$duration = $data['duration'] ?? '';
$level = $data['level'] ?? '';
$mode = $data['mode'] ?? '';
$batch = $data['batch'] ?? '';
$certification = $data['certification'] ?? '';
$eligibility = $data['eligibility'] ?? '';
$topics = json_encode($data['topics'] ?? []);
$outcomes = json_encode($data['outcomes'] ?? []);

$stmt = $conn->prepare("UPDATE courses SET 
    title=?, category=?, tag=?, icon=?, status=?, image=?, position=?, fit=?, alt_text=?, description=?, meta=?, fee=?, fee_note=?, duration=?, level=?, mode=?, batch=?, certification=?, eligibility=?, topics=?, outcomes=? 
    WHERE id=?");

if (!$stmt) {
    echo json_encode(["error" => "Prepare failed: " . $conn->error]);
    exit;
}

$stmt->bind_param("sssssssssssssssssssssi",
    $title, $category, $tag, $icon, $status,
    $image, $position, $fit, $alt_text, $description,
    $meta, $fee, $feeNote, $duration,
    $level, $mode, $batch, $certification,
    $eligibility, $topics, $outcomes, $id
);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Execute failed: " . $stmt->error]);
}
?>