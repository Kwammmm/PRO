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


<?php include('menu_user.php'); ?>
<?php
// Include database connection
require_once 'connect.php';

// ตรวจสอบว่ามีการส่งค่ามาจากฟอร์มหรือไม่
if(isset($_POST['filter_item'])){
    $filterItem = $_POST['filter_item'];

    // ถ้าเลือก "ทั้งหมด" ให้ดึงข้อมูลทั้งหมด
    if($filterItem === "ทั้งหมด"){
        $stmt = $conn->prepare("SELECT * FROM item");
    } else {
        // ถ้าไม่ใช่ "ทั้งหมด" ให้ใช้ WHERE clause ใน SQL เพื่อกรองข้อมูลตามหมวดหมู่ที่ถูกเลือก
        $stmt = $conn->prepare("SELECT item_id, item_name, item_detail, item_category, item_serial, item_owner, item_status FROM item WHERE item_status = :filterItem");
        $stmt->bindParam(':filterItem', $filterItem, PDO::PARAM_STR);
    }

    $stmt->execute();

    $filterItemResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // ถ้าไม่มีการกรอง ดึงข้อมูลทั้งหมด
    $stmt = $conn->prepare("SELECT * FROM item");
    $stmt->execute();

    $filterItemResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ดึงข้อมูลหมวดหมู่ทั้งหมด
$stmtCategories = $conn->prepare("SELECT DISTINCT item_status FROM item");
$stmtCategories->execute();
$categories = $stmtCategories->fetchAll(PDO::FETCH_COLUMN);

if(isset($_POST['clear_filter'])){
    header("Location: .php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property management system</title>
    <style>
        body {
            font-family: 'Tahoma', Arial, sans-serif;
        }
        table {
            width: 1100px;
            margin-left: 5%;
            margin-right: auto;
            margin-top: 1.3%;
            padding-top: 10%;
            border-collapse: collapse;
            background-color: #f2f2f2;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th{
            background-color: #A4A4A4;
            font-size: 20px;
            text-align: center;
        }
        h1{
            margin-top: 7%;
            color: white;
            text-align: center;
            padding: 0.6%
        }
    
        form{
            padding: 15px;
            margin-left: 5%;
        }

        
        .btn {
    display: inline-block;
    padding: 10px 20px;
    font-size: 15px;
    cursor: pointer;
    text-align: center;	
    text-decoration: none;
    outline: none;
    color: #fff;
    background-color: #4CAF50;
    border: none;
    border-radius: 15px;
    box-shadow: 0 9px #999;
}

.button:hover {background-color: #3e8e41}

.button:active {
  background-color: #3e8e41;
  box-shadow: 0 5px #666;
  transform: translateY(4px);
}
    </style>
</head>
<body>
<div style="width: 1217px; height: 60px; background: #1B692C; border-radius: 4px ; margin-left: 19%;">
<div style="color: black; font-size: 20px; font-family: Inter; font-weight: 600; word-wrap: break-word ;">
    <h1>Product</h1>
</div></div>
    <!-- ส่วนของฟอร์มสำหรับกรองข้อมูล -->
<div style="width: 1217px; height: auto; background: #FFFFFF; border: 1px solid black; border-radius: 4px;margin-left: 19%;">
<br>
<form method="post" >
    <label for="filter_item">Filter by status:</label>
    <select name="filter_item" id="filter_item">
    <button type="submit">Filter</button>
    <form method="post" style="display: inline;">
    <button type="submit" name="clear_filter">Clear Filter</button>
</form>
        <?php
        require_once 'connect.php';

        // Query to get distinct categories
        $stmt = $conn->prepare("SELECT DISTINCT item_status FROM item");
        $stmt->execute();

        // Loop through the result and create options
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = $row['item_status'];
            echo "<option value='$item'>$item</option>";
        }
        ?>
    </select>
<form method="post"><button type="submit">Filter</button>   <button type="submit" name="clear_filter">Clear Filter</button></form>
</form>

    <table>
        <thead>
            <tr>
                <th width="7%">ID</th>
                <th width="15%">name</th>
                <th width="15%">Detail</th>
                <th width="15%">category</th>
                <th width="20%">serialnumber</th>
                <th width="10%">owner</th>
                <th width="10%">status</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($filterItemResults as $item): ?>
                <tr>
                    <td><?= $item['item_id']; ?></td>
                    <td><?= $item['item_name']; ?></td>
                    <td><?= $item['item_detail']; ?></td>
                    <td><?= $item['item_category']; ?></td>
                    <td><?= $item['item_serial']; ?></td>
                    <td><?= $item['item_owner'];?></td>
                    <td><?= $item['item_status'];?></td>
                    </tr>
                </tr>
            <?php endforeach; ?>
        </tbody>
            </dlv>
    </table>

</body>
</html>