<?php include('testmenu.php'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<title>Editcategory</title>

  </head>
  <body>
  <?php
if(isset($_GET['Cate_id'])){
    require_once 'connect.php';
    $stmt = $conn->prepare("SELECT * FROM category WHERE Cate_id=?");
    $stmt->execute([$_GET['Cate_id']]);
    // Check if member exists
    if($stmt->rowCount() < 1){
        header('Location: category.php');
        exit();
    }
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    
    header('Location: Main.php');
    exit();
}
?>

<div class="container">
  <div class="row">
  <div class="col-md-3"></div>
    <div class="col-md-6"> <br />
    
      <h4>ฟอร์มแก้ไขข้อมูล</h4>

      <form name="edit" action="Editcategory_DB.php" method="post" enctype="multipart/form-data"  class="form-horizontal">
	  <div class="form-group">
      <div class="mb-1">
	  <p>เลขหมวดหมู่ :</p>
          <div class="col-sm-10">
            <input type="text" name="Cate_id" class="form-control" required value="<?= isset($row['Cate_id']) ? $row['Cate_id'] : ''; ?>" minlength="3">
          </div>
        </div>
		</div>

		<div class="form-group">
        <div class="mb-1">
		<p>ชื่อหมวดหมู๋ :</p>
          <div class="col-sm-10">
            <input type="text" name="Cate_status" class="form-control" required value="<?= isset($row['Cate_status']) ? $row['Cate_status'] : ''; ?>" minlength="3">
          </div>
        </div>
		</div>
	
        <div class="form-group">
          <div class="col-sm-12">
        <button type="submit" class="btn btn-primary" onclick="return confirmEdit()">แก้ไขข้อมูล</button>
		</div>
        </div>
  <script>
    function confirmEdit() {
        // สร้าง confirm dialog เพื่อให้ผู้ใช้ยืนยันการแก้ไขข้อมูล
        var confirmation = confirm('แก้ไขข้อมูลทั้งหมดแล้วใช่ไหม?');
        
        if (confirmation) {
            // หากผู้ใช้กด "ตกลง" ให้ส่งค่าเป็น true และทำการแก้ไข
            return true;
        } else {
            // หากผู้ใช้กด "ยกเลิก" ให้ส่งค่าเป็น false และไม่ทำการแก้ไข
            alert('ไม่มีการเปลี่ยนแปลงข้อมูล');
            return false;
        }
    }
</script>

</form>
      
    </div>
  </div>
</div>
