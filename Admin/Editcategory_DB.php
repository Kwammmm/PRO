<?php
// ตรวจสอบว่ามีการส่งข้อมูลมาจากฟอร์มแก้ไขหรือไม่
if(isset($_POST['Cate_id']) && isset($_POST['Cate_status']) ) {
    // เชื่อมต่อกับฐานข้อมูล
    require_once 'connect.php';

    // รับค่าที่ส่งมาจากฟอร์มแก้ไข
    $Cate_id = $_POST['Cate_id'];
    $Cate_status = $_POST['Cate_status'];
    

    // ทำการอัพเดทข้อมูลในฐานข้อมูล
    $stmt = $conn->prepare("UPDATE category SET Cate_status=:Cate_status WHERE Cate_id=:Cate_id");
    $stmt->bindParam(':Cate_id', $Cate_id , PDO::PARAM_INT);
    $stmt->bindParam(':Cate_status', $Cate_status , PDO::PARAM_STR);
    
    $stmt->execute();

    // ตรวจสอบว่าอัพเดทข้อมูลสำเร็จหรือไม่
    if($stmt->rowCount() > 0){
        // หากสำเร็จ ให้แสดงข้อความแจ้งเตือนและเปลี่ยนเส้นทางไปยังหน้าหลัก
        echo '<script>
             alert("แก้ไขข้อมูลสำเร็จ");
             window.location = "category.php";
        </script>';
    } else {
        // หากไม่สำเร็จ ให้แสดงข้อความแจ้งเตือนและไม่เปลี่ยนเส้นทาง
        echo '<script>
             alert("ไม่สามารถแก้ไขข้อมูลได้");
        </script>';
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn = null;
}
?>
