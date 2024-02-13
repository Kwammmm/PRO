<?php
require_once 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่า item_serial ที่ส่งมาจากฟอร์ม
    $item_serial = $_POST['re_studentname'];

    // ดึงข้อมูลจากตาราง item โดยใช้ item_serial
    $stmt = $conn->prepare("SELECT * FROM item WHERE item_serial = ?");
    $stmt->execute([$item_serial]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    // ตรวจสอบว่ามีข้อมูลหรือไม่
    if ($stmt->rowCount() > 0) {
        // Assign the value of item_serial input field to re_serial
        $re_serial = $item['item_serial'];

        // ทำการเพิ่มข้อมูลในตาราง report
        $stmt = $conn->prepare("INSERT INTO report (re_studentid, re_studentname, re_borrow, re_return, re_serial, re_status) VALUES (?, ?, ?, ?, ?, ?)");
        $re_studentid = $_SESSION['re_studentid']; // สมมติว่าใช้ session เก็บ ID ของสมาชิก
        $re_studentname = $_POST['re_studentname'];
        $re_borrow = $_POST['re_borrow'];
        $re_return = $_POST['re_return'];
        $re_status = $_POST['re_status'];
        $stmt->execute([$re_studentid, $re_studentname, $re_borrow, $re_return, $re_serial, $re_status]);

        // ทำการ redirect หลังจากทำการเพิ่มข้อมูลเรียบร้อย
        header("Location: หน้าที่ต้องการไปหลังเพิ่มข้อมูลเรียบร้อย");
        exit();
    } 
}
?>