<?php
require 'db.php';

$sql = "SELECT * FROM courses ORDER BY id DESC";
$result = $conn->query($sql);

$courses = [];
while ($row = $result->fetch_assoc()) {
    // JS-ന് വേണ്ടി കോളങ്ങളുടെ പേരുകൾ മാറ്റുന്നു
    $row['c'] = $row['category'];
    $row['desc'] = $row['description'];
    $row['img'] = $row['image'];
    $row['pos'] = $row['position'];
    $row['alt'] = $row['alt_text'];
    $row['feeNote'] = $row['fee_note'];
    
    $row['topics'] = json_decode($row['topics'] ?? '[]', true);
    $row['outcomes'] = json_decode($row['outcomes'] ?? '[]', true);
    $courses[] = $row;
}
echo json_encode($courses);
?>