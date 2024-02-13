<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('connect.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้านี้

$item_id = $_REQUEST["item_id"];

//ลบข้อมูลออกจาก database ตาม Cate_id ที่ส่งมา

$sql = "DELETE FROM item WHERE item_id='$item_id' ";
$result = $conn->query($sql) or die ("Error in query: $sql " . $conn->errorInfo()[2]);

//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('delete Succesfuly');";
	echo "window.location = 'product.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to delete again');";
	echo "</script>";
}
?> 
