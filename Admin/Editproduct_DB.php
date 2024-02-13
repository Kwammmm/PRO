<?php
// ตรวจสอบว่ามีการส่งข้อมูลมาจากฟอร์มแก้ไขหรือไม่
if(isset($_POST['item_name']) && isset($_POST['item_detail']) && isset($_POST['item_category'])&& isset($_POST['item_serial']) && isset($_POST['item_owner']) && isset($_POST['item_status'])) {
    // เชื่อมต่อกับฐานข้อมูล
    require_once 'connect.php';

    // รับค่าที่ส่งมาจากฟอร์มแก้ไข
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_detail = $_POST['item_detail'];
    $item_category = $_POST['item_category'];
    $item_serial = $_POST['item_serial'];
    $item_owner = $_POST['item_owner'];
    $item_status = $_POST['item_status'];

    // ทำการอัพเดทข้อมูลในฐานข้อมูล
    $stmt = $conn->prepare("UPDATE item SET item_name=:item_name, item_detail=:item_detail,item_category =:item_category, item_serial=:item_serial, item_owner=:item_owner, item_status=:item_status WHERE item_id=:item_id");
    $stmt->bindParam(':item_id', $item_id , PDO::PARAM_INT);
    $stmt->bindParam(':item_name', $item_name , PDO::PARAM_STR);
    $stmt->bindParam(':item_detail', $item_detail , PDO::PARAM_STR);
    $stmt->bindParam(':item_category', $item_category  , PDO::PARAM_STR);
    $stmt->bindParam(':item_serial', $item_serial , PDO::PARAM_STR);
    $stmt->bindParam(':item_owner', $item_owner , PDO::PARAM_STR);
    $stmt->bindParam(':item_status', $item_status , PDO::PARAM_STR);
    $stmt->execute();

    // ตรวจสอบว่าอัพเดทข้อมูลสำเร็จหรือไม่
    if($stmt->rowCount() > 0){
        // หากสำเร็จ ให้แสดงข้อความแจ้งเตือนและเปลี่ยนเส้นทางไปยังหน้าหลัก
        echo '<script>
             alert("แก้ไขข้อมูลสำเร็จ");
             window.location = "product.php";
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