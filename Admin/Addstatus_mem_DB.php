<?php
// 1. เชื่อมต่อกับฐานข้อมูล
require_once 'connect.php';

// 2. รับค่าจากฟอร์ม HTML
$status_name = $_POST['status_name'];

// 3. เขียนคำสั่ง SQL INSERT
$sql = "INSERT INTO tbl_statusmember (status_name) VALUES (:status_name)";

// 4. ทำการ Prepare และ Execute คำสั่ง SQL
$stmt = $conn->prepare($sql);
$stmt->bindParam(':status_name', $status_name, PDO::PARAM_STR);
$result = $stmt->execute();

// 5. ตรวจสอบผลลัพธ์และทำการ Redirect
if ($result) {
    echo "เพิ่มข้อมูลสำเร็จ";
    header("Location: statusmember.php");
    exit(); // คำสั่ง exit() ทำให้โปรแกรมหยุดทำงานทันที
} else {
    echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . $stmt->errorInfo()[2];
}

?>




