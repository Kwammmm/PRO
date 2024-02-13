<?php
require_once 'connect.php';

$member_id = $_POST['member_id'];
$member_classS = $_POST['member_classS'];
$member_name = $_POST['member_name'];
$member_sername = $_POST['member_sername'];
$username = $_POST['username'];
$password = $_POST['password']; 
$member_status = $_POST['member_status'];  

$sql = "INSERT INTO tbl_member (member_id, member_classS, member_name, member_sername, username, password, member_status) 
        VALUES (:member_id, :member_classS, :member_name, :member_sername, :username, :password, :member_status)";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':member_id', $member_id, PDO::PARAM_STR);
$stmt->bindParam(':member_classS', $member_classS, PDO::PARAM_STR);
$stmt->bindParam(':member_name', $member_name, PDO::PARAM_STR);
$stmt->bindParam(':member_sername', $member_sername, PDO::PARAM_STR);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->bindParam(':password', $password, PDO::PARAM_STR);
$stmt->bindParam(':member_status', $member_status, PDO::PARAM_STR);

try {
    $result = $stmt->execute();

    // ตรวจสอบผลลัพธ์
    if ($result) {
        echo "เพิ่มข้อมูลสำเร็จ";
        header("Location: member.php");
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
