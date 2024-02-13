<?php
require_once 'connect.php';

if (isset($_GET['cate_id'])) {
    $cateId = $_GET['cate_id'];

   
    $stmt = $conn->prepare("SELECT MAX(CAST(SUBSTRING_INDEX(item_serial, '-', -1) AS UNSIGNED)) AS max_serial 
                            FROM item 
                            WHERE item_serial LIKE :pattern");
    $pattern = $cateId . '-%';
    $stmt->bindParam(':pattern', $pattern, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $maxSerial = $row['max_serial'];

  
    echo ($maxSerial !== null) ? $maxSerial : '0000';
} else {
    
    echo 'Error: Missing cate_id parameter';
}
?>
