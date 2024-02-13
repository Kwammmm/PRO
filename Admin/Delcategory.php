<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('connect.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้านี้
//สร้างตัวแปรสำหรับรับค่า Cate_id จากไฟล์แสดงข้อมูล
$Cate_id = $_REQUEST["Cate_id"];

//ลบข้อมูลออกจาก database ตาม Cate_id ที่ส่งมา

$sql = "DELETE FROM category WHERE Cate_id='$Cate_id' ";
$result = $conn->query($sql) or die ("Error in query: $sql " . $conn->errorInfo()[2]);

//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('delete Succesfuly');";
	echo "window.location = 'category.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to delete again');";
	echo "</script>";
}
?> 
