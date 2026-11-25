<?php
// എറർ കാണിക്കാൻ വേണ്ടി (പ്രോഡക്ഷനിൽ ഇത് ഒഴിവാക്കണം)
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['title'])) {
    echo json_encode(["error" => "Title is required"]);
    exit;
}

// JS-ൽ നിന്നുള്ള ഡാറ്റ സുരക്ഷിതമായി എടുക്കുക (ഇല്ലെങ്കിൽ ഡിഫോൾട്ട് വാല്യൂ നൽകുക)
$title = $data['title'] ?? '';
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

// topics, outcomes എന്നിവ JSON ആക്കി മാറ്റുന്നു
$topics = json_encode($data['topics'] ?? []);
$outcomes = json_encode($data['outcomes'] ?? []);

$stmt = $conn->prepare("INSERT INTO courses 
    (title, category, tag, icon, status, image, position, fit, alt_text, description, meta, fee, fee_note, duration, level, mode, batch, certification, eligibility, topics, outcomes) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    echo json_encode(["error" => "Prepare failed: " . $conn->error]);
    exit;
}

// 21 കോളങ്ങൾക്ക് അനുസരിച്ച് 21 's' (strings) വേണം
$stmt->bind_param("sssssssssssssssssssss",
    $title, $category, $tag, $icon, $status,
    $image, $position, $fit, $alt_text, $description,
    $meta, $fee, $feeNote, $duration,
    $level, $mode, $batch, $certification,
    $eligibility, $topics, $outcomes
);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "id" => $conn->insert_id]);
} else {
    echo json_encode(["error" => "Execute failed: " . $stmt->error]);
}
?>