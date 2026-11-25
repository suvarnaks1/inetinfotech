<?php
// എറർ കാണിക്കാൻ
ini_set('display_errors', 1);
error_reporting(E_ALL);

$targetDir = "../../assets/uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $fileName = time() . '_' . basename($_FILES['image']['name']);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowTypes = array('jpg', 'png', 'jpeg', 'webp', 'gif');
    
    if (in_array(strtolower($fileType), $allowTypes)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            echo json_encode(["success" => true, "path" => "assets/uploads/" . $fileName]);
        } else {
            echo json_encode(["error" => "Failed to upload image. Check folder permissions."]);
        }
    } else {
        echo json_encode(["error" => "Invalid file type. Only JPG, PNG, WEBP, GIF allowed."]);
    }
} else {
    echo json_encode(["error" => "No file uploaded or file too large."]);
}
?>