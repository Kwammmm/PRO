<?php
// 1. เชื่อมต่อกับฐานข้อมูล
require_once 'connect.php';

// 2. รับค่าจากฟอร์ม HTML
$Cate_id      = $_POST['Cate_id'];
$Cate_status  = $_POST['Cate_status'];

// 4. เขียนคำสั่ง SQL INSERT
$sql = "INSERT INTO category (Cate_id, Cate_status) 
        VALUES (:Cate_id, :Cate_status)";

// 5. ทำการ Execute คำสั่ง SQL
$stmt = $conn->prepare($sql);
$stmt->bindParam(':Cate_id', $Cate_id, PDO::PARAM_INT);
$stmt->bindParam(':Cate_status', $Cate_status, PDO::PARAM_STR);

$result = $stmt->execute();

if ($result) {
    echo "เพิ่มข้อมูลสำเร็จ";
    header("Location: category.php");
} else {
    echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . $stmt->errorInfo()[2];
}

// ปิดการเชื่อมต่อ
$conn = null;
?>



