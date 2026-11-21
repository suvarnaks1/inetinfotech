<?php
require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['title'])) {
    echo json_encode(["error" => "Title is required"]);
    exit;
}

// നിങ്ങളുടെ JS-ൽ നിന്നുള്ള കീ-കളുമായി (c, desc, img) ഡാറ്റാബേസ് കോളങ്ങൾ മാപ്പ് ചെയ്യുന്നു
$stmt = $conn->prepare("INSERT INTO courses 
    (title, category, tag, icon, status, image, position, fit, alt_text, description, meta, fee, fee_note, duration, level, mode, batch, certification, eligibility, topics, outcomes) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$topics = json_encode($data['topics'] ?? []);
$outcomes = json_encode($data['outcomes'] ?? []);
$category = $data['c'] ?? ''; // JS-ൽ 'c' എന്നാണ് ഉള്ളത്
$description = $data['desc'] ?? ''; // JS-ൽ 'desc' എന്നാണ് ഉള്ളത്
$image = $data['img'] ?? ''; // JS-ൽ 'img' എന്നാണ് ഉള്ളത്
$position = $data['pos'] ?? 'center';
$alt_text = $data['alt'] ?? '';

$stmt->bind_param("sssssssssssssssssssss",
    $data['title'], $category, $data['tag'], $data['icon'], $data['status'],
    $image, $position, $data['fit'], $alt_text, $description,
    $data['meta'], $data['fee'], $data['feeNote'], $data['duration'],
    $data['level'], $data['mode'], $data['batch'], $data['certification'],
    $data['eligibility'], $topics, $outcomes
);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "id" => $conn->insert_id]);
} else {
    echo json_encode(["error" => $stmt->error]);
}
?>