<?php

require_once 'connect.php';

$item_name = $_POST['item_name'];
$item_detail = $_POST['item_detail'];
$item_category = $_POST['item_category'];
$item_serial = $_POST['item_serial'];
$item_owner = $_POST['item_owner'];
$item_status = $_POST['item_status'];  

$sql = "INSERT INTO item (item_name, item_detail, item_category, item_serial, item_owner, item_status) 
        VALUES (:item_name, :item_detail, :item_category, :item_serial, :item_owner, :item_status)";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':item_name', $item_name, PDO::PARAM_STR);
$stmt->bindParam(':item_detail', $item_detail, PDO::PARAM_STR);
$stmt->bindParam(':item_category', $item_category, PDO::PARAM_STR);
$stmt->bindParam(':item_serial', $item_serial, PDO::PARAM_STR);
$stmt->bindParam(':item_owner', $item_owner, PDO::PARAM_STR);
$stmt->bindParam(':item_status', $item_status, PDO::PARAM_STR);

try {
    $result = $stmt->execute();

    // ตรวจสอบผลลัพธ์
    if ($result) {
        echo "เพิ่มข้อมูลสำเร็จ";
        header("Location: product.php");
    } else {
        echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล";
        print_r($stmt->errorInfo());
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// ปิดการเชื่อมต่อ
$conn = null;
?>

