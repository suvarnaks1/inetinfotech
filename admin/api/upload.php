<?php
// അപ്‌ലോഡ് ചെയ്യുന്ന ഇമേജ് സേവ് ചെയ്യാനുള്ള ഫോൾഡർ
$targetDir = "../../assets/uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $fileName = time() . '_' . basename($_FILES['image']['name']);
    $targetFilePath = $targetDir . $fileName;
    
    // ഇമേജ് ഫോർമാറ്റ് ചെക്ക് ചെയ്യാൻ (Optional)
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowTypes = array('jpg', 'png', 'jpeg', 'webp', 'gif');
    
    if (in_array(strtolower($fileType), $allowTypes)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            // വെബ്സൈറ്റിൽ കാണിക്കാൻ വേണ്ടി റിലേറ്റീവ് പാത്ത് തിരികെ നൽകുന്നു
            echo json_encode(["success" => true, "path" => "assets/uploads/" . $fileName]);
        } else {
            echo json_encode(["error" => "Failed to upload image"]);
        }
    } else {
        echo json_encode(["error" => "Invalid file type"]);
    }
} else {
    echo json_encode(["error" => "No file uploaded"]);
}
?>