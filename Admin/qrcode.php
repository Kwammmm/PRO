<?php
session_start();
echo '
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
//เช็คว่ามีตัวแปร session อะไรบ้าง
//print_r($_SESSION);
//exit();
//สร้างเงื่อนไขตรวจสอบสิทธิ์การเข้าใช้งานจาก session
if(empty($_SESSION['member_id']) && empty($_SESSION['member_name']) && empty($_SESSION['member_sername'])){
            echo '<script>
                setTimeout(function() {
                swal({
                title: "คุณไม่มีสิทธิ์ใช้งานหน้านี้",
                type: "error"
                }, function() {
                window.location = "login.php"; //หน้าที่ต้องการให้กระโดดไป
                });
                }, 1000);
                </script>';
            exit();
}

?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BJsBarcode by devbanban.com 2023</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
 
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
 
  </head>
  <body>
  	<div class="container">
  		<div class="row">
  			<div class="col-sm-6">
  				<h4>JsBarcode</h4>
  			<table class="table table-bordered">
				<thead>
				<tr>
				  <th width="5%">id</th>
				  <th width="65%">Book name</th>
				  <th width="30%">BARCODE</th>
				</tr>
				</thead>
				<tbody>
  			<?php foreach ($rsb as $row) { ?>
  			<tr>
  				<td><?=$row['book_id'];?></td>
  				<td> <?=$row['book_name'];?> </td>
  				<td align="center">
  				<?=$row['book_name'];?> <br> 
				<svg class="barcode"
				  jsbarcode-format="CODE128"
				  jsbarcode-value="<?=$row['book_id'];?>"
				  jsbarcode-textmargin="0"
				  jsbarcode-fontoptions="normal">
				</svg>
			</td>
  			</tr>
  		<?php } ?>
		  	</tbody>
		  </table>
		</div>
  		</div>
  	</div>
<script type="text/javascript">
	JsBarcode(".barcode").init();
</script>
  </body>
</html>
doc : https://lindell.me/JsBarcode/
<br>
code by devbanban.com 2023