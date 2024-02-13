<?php
// 1. เชื่อมต่อกับฐานข้อมูล
require_once 'connect.php';

// 2. รับค่าจากฟอร์ม HTML
$member_name = $_POST['member_name'];
$member_sername = $_POST['member_sername'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
$member_status = $_POST['member_status'];

// 3. ทำความสะอาดข้อมูล (ไม่ต้องทำการสะอาดข้อมูลที่นี้ ในกรณีนี้ความปลอดภัยถูกป้องกันด้วย PDO)

// 4. เขียนคำสั่ง SQL INSERT
$sql = "INSERT INTO tbl_member (member_name, member_sername, username, password, member_status) 
        VALUES (:member_name, :member_sername, :username, :password, :member_status)";

// 5. ทำการ Execute คำสั่ง SQL
$stmt = $conn->prepare($sql);
$stmt->bindParam(':member_name', $member_name, PDO::PARAM_STR);
$stmt->bindParam(':member_sername', $member_sername, PDO::PARAM_STR);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->bindParam(':password', $password, PDO::PARAM_STR);
$stmt->bindParam(':member_status', $member_status, PDO::PARAM_STR);

$result = $stmt->execute();

// ตรวจสอบผลลัพธ์
if ($result) {
    echo "เพิ่มข้อมูลสำเร็จ";
} else {
    echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . $stmt->errorInfo()[2];
}

// ปิดการเชื่อมต่อ
$conn = null;
?>
