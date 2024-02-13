<?php
// 1. เชื่อมต่อกับฐานข้อมูล
require_once 'connect.php';

// 2. รับค่าจากฟอร์ม HTML
$item_statusname  = $_POST['item_statusname'];

// 4. เขียนคำสั่ง SQL INSERT
$sql = "INSERT INTO item_status (item_statusname) 
        VALUES (:item_statusname)";

// 5. ทำการ Execute คำสั่ง SQL
$stmt = $conn->prepare($sql);
$stmt->bindParam(':item_statusname', $item_statusname , PDO::PARAM_STR);

$result = $stmt->execute();

if ($result) {
    echo "เพิ่มข้อมูลสำเร็จ";
    header("Location: statusmember.php");
} else {
    echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . $stmt->errorInfo()[2];
}

// ปิดการเชื่อมต่อ
$conn = null;
?>


